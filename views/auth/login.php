<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="tarjeta login">
    <h1>Iniciar sesión</h1>
    <p class="sutil">Ingrese sus datos para ver su lista de tareas.</p>

    <?php if ($error): ?>
        <div class="alerta alerta-error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?accion=login" class="formulario">
        <label for="usuario">Usuario</label>
        <input type="text" id="usuario" name="usuario" required autofocus>

        <label for="clave">Contraseña</label>
        <input type="password" id="clave" name="clave" required>

        <button type="submit" class="btn btn-primario btn-ancho">Entrar</button>
    </form>
    <p class="sutil centro">Usuario de prueba: <strong>admin</strong> &middot; Contraseña: <strong>admin123</strong></p>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
