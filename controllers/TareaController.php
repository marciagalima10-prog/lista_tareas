<?php
/**
 * Controlador de Tareas
 * Recibe las peticiones del usuario, llama al modelo y elige qué vista mostrar.
 */
class TareaController
{
    private Tarea $modelo;
    private int $usuarioId;

    public function __construct()
    {
        $this->modelo    = new Tarea();
        $this->usuarioId = (int) $_SESSION['usuario_id'];
    }

    /** Muestra el listado con filtros */
    public function index(): void
    {
        $prioridad = $_GET['prioridad'] ?? '';
        $estado    = $_GET['estado'] ?? '';

        // Solo se aceptan valores válidos en los filtros
        if (!in_array($prioridad, PRIORIDADES, true)) $prioridad = '';
        if (!in_array($estado, ESTADOS, true))        $estado = '';

        $tareas  = $this->modelo->listar($this->usuarioId, $prioridad, $estado);
        $resumen = $this->modelo->resumen($this->usuarioId);
        $mensaje = $this->tomarMensaje();

        require __DIR__ . '/../views/tareas/index.php';
    }

    /** Muestra el formulario vacío y guarda la tarea nueva */
    public function crear(): void
    {
        $tarea   = ['titulo' => '', 'descripcion' => '', 'prioridad' => 'Media', 'estado' => 'Pendiente'];
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tarea   = $this->leerFormulario();
            $errores = $this->validar($tarea);

            if (!$errores) {
                $this->modelo->crear($tarea, $this->usuarioId);
                $this->redirigir('Tarea creada correctamente.');
            }
        }

        $titulo = 'Nueva tarea';
        require __DIR__ . '/../views/tareas/form.php';
    }

    /** Muestra el formulario con los datos actuales y guarda los cambios */
    public function editar(): void
    {
        $id    = (int) ($_GET['id'] ?? 0);
        $tarea = $this->modelo->obtener($id, $this->usuarioId);
        if (!$tarea) {
            $this->redirigir('La tarea no existe.');
        }
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tarea   = array_merge($tarea, $this->leerFormulario());
            $errores = $this->validar($tarea);

            if (!$errores) {
                $this->modelo->actualizar($id, $tarea, $this->usuarioId);
                $this->redirigir('Tarea actualizada correctamente.');
            }
        }

        $titulo = 'Editar tarea';
        require __DIR__ . '/../views/tareas/form.php';
    }

    /** Marca una tarea como completada (solo por POST) */
    public function completar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->completar((int) ($_POST['id'] ?? 0), $this->usuarioId);
            $this->redirigir('Tarea marcada como completada.');
        }
        $this->redirigir();
    }

    /** Elimina una tarea (solo por POST) */
    public function eliminar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->modelo->eliminar((int) ($_POST['id'] ?? 0), $this->usuarioId);
            $this->redirigir('Tarea eliminada.');
        }
        $this->redirigir();
    }

    // ----------------- Métodos de apoyo -----------------

    private function leerFormulario(): array
    {
        return [
            'titulo'      => trim($_POST['titulo'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'prioridad'   => $_POST['prioridad'] ?? '',
            'estado'      => $_POST['estado'] ?? '',
        ];
    }

    private function validar(array $t): array
    {
        $errores = [];
        if ($t['titulo'] === '')                         $errores[] = 'El título es obligatorio.';
        if (mb_strlen($t['titulo']) > 100)               $errores[] = 'El título no puede pasar de 100 caracteres.';
        if (!in_array($t['prioridad'], PRIORIDADES, true)) $errores[] = 'Seleccione una prioridad válida.';
        if (!in_array($t['estado'], ESTADOS, true))        $errores[] = 'Seleccione un estado válido.';
        return $errores;
    }

    private function redirigir(string $mensaje = ''): void
    {
        if ($mensaje !== '') {
            $_SESSION['mensaje'] = $mensaje;
        }
        header('Location: index.php');
        exit;
    }

    private function tomarMensaje(): string
    {
        $m = $_SESSION['mensaje'] ?? '';
        unset($_SESSION['mensaje']);
        return $m;
    }
}
