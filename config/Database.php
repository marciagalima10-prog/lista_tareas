<?php
/**
 * Clase Database
 * Se encarga de crear UNA sola conexión PDO a MySQL (patrón Singleton)
 * para que todos los modelos la reutilicen.
 */
class Database
{
    private static ?PDO $conexion = null;

    public static function conectar(): PDO
    {
        if (self::$conexion === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

            // Permite usar otra conexión (por ejemplo SQLite para pruebas) sin tocar el código
            if (getenv('DB_DSN')) {
                $dsn = getenv('DB_DSN');
            }

            try {
                self::$conexion = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                die('Error de conexión a la base de datos: ' . $e->getMessage());
            }
        }
        return self::$conexion;
    }
}
