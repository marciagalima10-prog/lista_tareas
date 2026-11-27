<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="tarjeta formulario-tarea">
    <h1><?= e($titulo) ?></h1>

    <?php if ($errores): ?>
        <div class="alerta alerta-error">
            <?php foreach ($errores as $err): ?>
                <div><?= e($err) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="formulario">
        <label for="titulo">Título *</label>
        <input type="text" id="titulo" name="titulo" maxlength="100" required value="<?= e($tarea['titulo']) ?>">

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="4"><?= e($tarea['descripcion']) ?></textarea>

        <div class="fila-doble">
            <div>
                <label for="prioridad">Prioridad</label>
                <select id="prioridad" name="prioridad">
                    <?php foreach (PRIORIDADES as $p): ?>
                        <option value="<?= e($p) ?>" <?= $tarea['prioridad'] === $p ? 'selected' : '' ?>><?= e($p) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="estado">Estado</label>
                <select id="estado" name="estado">
                    <?php foreach (ESTADOS as $s): ?>
                        <option value="<?= e($s) ?>" <?= $tarea['estado'] === $s ? 'selected' : '' ?>><?= e($s) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="botones">
            <button type="submit" class="btn btn-primario">Guardar</button>
            <a href="index.php" class="btn btn-claro">Cancelar</a>
        </div>
    </form>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
