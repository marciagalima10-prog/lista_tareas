<?php
/**
 * Modelo Tarea
 * Contiene todas las operaciones CRUD sobre la tabla "tareas".
 * Todas las consultas usan sentencias preparadas para evitar inyección SQL.
 */
class Tarea
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    /** READ: lista las tareas de un usuario, con filtros opcionales */
    public function listar(int $usuarioId, string $prioridad = '', string $estado = ''): array
    {
        $sql = 'SELECT * FROM tareas WHERE usuario_id = :usuario_id';
        $params = [':usuario_id' => $usuarioId];

        if ($prioridad !== '') {
            $sql .= ' AND prioridad = :prioridad';
            $params[':prioridad'] = $prioridad;
        }
        if ($estado !== '') {
            $sql .= ' AND estado = :estado';
            $params[':estado'] = $estado;
        }

        // Ordena: primero las no completadas, luego por prioridad (Alta > Media > Baja)
        $sql .= " ORDER BY CASE WHEN estado = 'Completada' THEN 1 ELSE 0 END,
                  CASE prioridad WHEN 'Alta' THEN 1 WHEN 'Media' THEN 2 ELSE 3 END,
                  fecha_creacion DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /** READ: obtiene una sola tarea */
    public function obtener(int $id, int $usuarioId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM tareas WHERE id = :id AND usuario_id = :usuario_id');
        $stmt->execute([':id' => $id, ':usuario_id' => $usuarioId]);
        $tarea = $stmt->fetch();
        return $tarea ?: null;
    }

    /** CREATE: inserta una tarea nueva */
    public function crear(array $datos, int $usuarioId): bool
    {
        $ahora = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare(
            'INSERT INTO tareas (usuario_id, titulo, descripcion, prioridad, estado, fecha_creacion, fecha_actualizacion)
             VALUES (:usuario_id, :titulo, :descripcion, :prioridad, :estado, :creada, :actualizada)'
        );
        return $stmt->execute([
            ':usuario_id'  => $usuarioId,
            ':titulo'      => $datos['titulo'],
            ':descripcion' => $datos['descripcion'],
            ':prioridad'   => $datos['prioridad'],
            ':estado'      => $datos['estado'],
            ':creada'      => $ahora,
            ':actualizada' => $ahora,
        ]);
    }

    /** UPDATE: modifica una tarea existente */
    public function actualizar(int $id, array $datos, int $usuarioId): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE tareas SET titulo = :titulo, descripcion = :descripcion, prioridad = :prioridad,
                    estado = :estado, fecha_actualizacion = :actualizada
             WHERE id = :id AND usuario_id = :usuario_id'
        );
        return $stmt->execute([
            ':titulo'      => $datos['titulo'],
            ':descripcion' => $datos['descripcion'],
            ':prioridad'   => $datos['prioridad'],
            ':estado'      => $datos['estado'],
            ':actualizada' => date('Y-m-d H:i:s'),
            ':id'          => $id,
            ':usuario_id'  => $usuarioId,
        ]);
    }

    /** UPDATE rápido: marca una tarea como completada */
    public function completar(int $id, int $usuarioId): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE tareas SET estado = 'Completada', fecha_actualizacion = :actualizada
             WHERE id = :id AND usuario_id = :usuario_id"
        );
        return $stmt->execute([':actualizada' => date('Y-m-d H:i:s'), ':id' => $id, ':usuario_id' => $usuarioId]);
    }

    /** DELETE: elimina una tarea */
    public function eliminar(int $id, int $usuarioId): bool
    {
        $stmt = $this->db->prepare('DELETE FROM tareas WHERE id = :id AND usuario_id = :usuario_id');
        return $stmt->execute([':id' => $id, ':usuario_id' => $usuarioId]);
    }

    /** Cuenta las tareas por estado (para el resumen superior) */
    public function resumen(int $usuarioId): array
    {
        $stmt = $this->db->prepare('SELECT estado, COUNT(*) AS total FROM tareas WHERE usuario_id = :u GROUP BY estado');
        $stmt->execute([':u' => $usuarioId]);
        $resumen = array_fill_keys(ESTADOS, 0);
        foreach ($stmt->fetchAll() as $fila) {
            $resumen[$fila['estado']] = (int) $fila['total'];
        }
        return $resumen;
    }
}
