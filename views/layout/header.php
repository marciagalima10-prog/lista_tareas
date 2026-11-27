<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(APP_NOMBRE) ?></title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>
<header class="barra">
    <div class="contenedor barra-interior">
        <a href="index.php" class="marca">&#9745; <?= e(APP_NOMBRE) ?></a>
        <?php if (!empty($_SESSION['usuario_id'])): ?>
            <div class="usuario">
                Hola, <strong><?= e($_SESSION['nombre']) ?></strong>
                <a href="index.php?accion=logout" class="btn btn-claro">Cerrar sesión</a>
            </div>
        <?php endif; ?>
    </div>
</header>
<main class="contenedor">
