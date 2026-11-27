<?php
/**
 * Modelo Usuario
 * Se usa para el login básico con sesiones.
 */
class Usuario
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    /** Devuelve el usuario si el nombre y la contraseña son correctos; si no, null */
    public function autenticar(string $usuario, string $clave): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM usuarios WHERE usuario = :usuario');
        $stmt->execute([':usuario' => $usuario]);
        $fila = $stmt->fetch();

        if ($fila && password_verify($clave, $fila['clave'])) {
            return $fila;
        }
        return null;
    }
}
