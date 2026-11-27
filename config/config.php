<?php
/**
 * Configuración general de la aplicación.
 * Cambie estos valores según su servidor (XAMPP / WAMP / Laragon).
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'lista_tareas');
define('DB_USER', 'root');
define('DB_PASS', '');          // En XAMPP la contraseña de root suele estar vacía
define('DB_CHARSET', 'utf8mb4');

define('APP_NOMBRE', 'Lista de Tareas Personal');

// Valores permitidos para los campos de una tarea
define('PRIORIDADES', ['Alta', 'Media', 'Baja']);
define('ESTADOS', ['Pendiente', 'En progreso', 'Completada']);

date_default_timezone_set('America/Panama');
