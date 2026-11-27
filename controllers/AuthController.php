<?php
/**
 * Controlador de autenticación (login / logout con sesiones)
 */
class AuthController
{
    public function login(): void
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $clave   = $_POST['clave'] ?? '';

            $modelo = new Usuario();
            $datos  = $modelo->autenticar($usuario, $clave);

            if ($datos) {
                session_regenerate_id(true);
                $_SESSION['usuario_id'] = (int) $datos['id'];
                $_SESSION['nombre']     = $datos['nombre'];
                header('Location: index.php');
                exit;
            }
            $error = 'Usuario o contraseña incorrectos.';
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?accion=login');
        exit;
    }

    /** Si no hay sesión iniciada, envía al login */
    public static function verificarSesion(): void
    {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: index.php?accion=login');
            exit;
        }
    }
}
