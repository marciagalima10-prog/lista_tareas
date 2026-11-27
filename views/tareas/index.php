<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if ($mensaje): ?>
    <div class="alerta alerta-ok"><?= e($mensaje) ?></div>
<?php endif; ?>

<!-- Resumen por estado -->
<section class="resumen">
    <div class="caja caja-pendiente"><span><?= $resumen['Pendiente'] ?></span>Pendientes</div>
    <div class="caja caja-progreso"><span><?= $resumen['En progreso'] ?></span>En progreso</div>
    <div class="caja caja-completada"><span><?= $resumen['Completada'] ?></span>Completadas</div>
</section>

<section class="tarjeta">
    <div class="encabezado">
        <h1>Mis tareas</h1>
        <a href="index.php?accion=crear" class="btn btn-primario">+ Nueva tarea</a>
    </div>

    <!-- Filtros -->
    <form method="get" action="index.php" class="filtros">
        <label>Prioridad
            <select name="prioridad">
                <option value="">Todas</option>
                <?php foreach (PRIORIDADES as $p): ?>
                    <option value="<?= e($p) ?>" <?= $prioridad === $p ? 'selected' : '' ?>><?= e($p) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Estado
            <select name="estado">
                <option value="">Todos</option>
                <?php foreach (ESTADOS as $s): ?>
                    <option value="<?= e($s) ?>" <?= $estado === $s ? 'selected' : '' ?>><?= e($s) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit" class="btn btn-secundario">Filtrar</button>
        <?php if ($prioridad || $estado): ?>
            <a href="index.php" class="btn btn-claro">Quitar filtros</a>
        <?php endif; ?>
    </form>

    <!-- Tabla de tareas -->
    <?php if (!$tareas): ?>
        <p class="vacio">No hay tareas que coincidan con el filtro.</p>
    <?php else: ?>
        <table class="tabla">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tarea</th>
                    <th>Prioridad</th>
                    <th>Estado</th>
                    <th>Creada</th>
                    <th class="acciones">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($tareas as $t): ?>
                <tr class="<?= $t['estado'] === 'Completada' ? 'fila-completada' : '' ?>">
                    <td><?= (int) $t['id'] ?></td>
                    <td>
                        <strong><?= e($t['titulo']) ?></strong>
                        <?php if ($t['descripcion']): ?>
                            <div class="descripcion"><?= e($t['descripcion']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td><span class="etiqueta prioridad-<?= strtolower(e($t['prioridad'])) ?>"><?= e($t['prioridad']) ?></span></td>
                    <td><span class="etiqueta estado-<?= str_replace(' ', '-', strtolower(e($t['estado']))) ?>"><?= e($t['estado']) ?></span></td>
                    <td class="fecha"><?= e(date('d/m/Y', strtotime($t['fecha_creacion']))) ?></td>
                    <td class="acciones">
                        <?php if ($t['estado'] !== 'Completada'): ?>
                            <form method="post" action="index.php?accion=completar" class="en-linea">
                                <input type="hidden" name="id" value="<?= (int) $t['id'] ?>">
                                <button type="submit" class="btn btn-mini btn-exito" title="Marcar como completada">&#10003; Completar</button>
                            </form>
                        <?php endif; ?>
                        <a href="index.php?accion=editar&id=<?= (int) $t['id'] ?>" class="btn btn-mini btn-secundario">Editar</a>
                        <form method="post" action="index.php?accion=eliminar" class="en-linea"
                              onsubmit="return confirm('¿Seguro que desea eliminar esta tarea?');">
                            <input type="hidden" name="id" value="<?= (int) $t['id'] ?>">
                            <button type="submit" class="btn btn-mini btn-peligro">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p class="sutil">Mostrando <?= count($tareas) ?> tarea(s).</p>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
