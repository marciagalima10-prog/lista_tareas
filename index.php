<?php
/**
 * index.php - Punto de entrada único (Front Controller)
 * Todas las peticiones pasan por aquí. Según el parámetro "accion"
 * se llama al método correspondiente del controlador.
 *
 * Ejemplos:
 *   index.php                      -> listado de tareas
 *   index.php?accion=crear         -> formulario de nueva tarea
 *   index.php?accion=editar&id=3   -> editar la tarea 3
 */
session_start();

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/models/Tarea.php';
require_once __DIR__ . '/models/Usuario.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/TareaController.php';

/** Función auxiliar para imprimir texto de forma segura (evita XSS) */
function e(?string $texto): string
{
    return htmlspecialchars($texto ?? '', ENT_QUOTES, 'UTF-8');
}

$accion = $_GET['accion'] ?? 'index';

// Rutas que no necesitan sesión
if ($accion === 'login') {
    (new AuthController())->login();
    exit;
}
if ($accion === 'logout') {
    (new AuthController())->logout();
    exit;
}

// A partir de aquí se requiere haber iniciado sesión
AuthController::verificarSesion();

$controlador = new TareaController();
$permitidas  = ['index', 'crear', 'editar', 'completar', 'eliminar'];

if (!in_array($accion, $permitidas, true)) {
    $accion = 'index';
}
$controlador->$accion();
