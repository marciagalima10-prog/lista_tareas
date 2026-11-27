-- ============================================================
--  Proyecto Final: Lista de Tareas Personal con Prioridades
--  Base de datos: lista_tareas (MySQL / MariaDB)
--  Autor: Jamil Marciaga
-- ============================================================

CREATE DATABASE IF NOT EXISTS lista_tareas
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE lista_tareas;

DROP TABLE IF EXISTS tareas;
DROP TABLE IF EXISTS usuarios;

-- ------------------------------------------------------------
-- Tabla: usuarios (para el login básico con sesiones)
-- ------------------------------------------------------------
CREATE TABLE usuarios (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  nombre    VARCHAR(100) NOT NULL,
  usuario   VARCHAR(50)  NOT NULL UNIQUE,
  clave     VARCHAR(255) NOT NULL          -- contraseña cifrada con password_hash()
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabla: tareas
-- ------------------------------------------------------------
CREATE TABLE tareas (
  id                  INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id          INT NOT NULL,
  titulo              VARCHAR(100) NOT NULL,
  descripcion         TEXT,
  prioridad           ENUM('Alta','Media','Baja') NOT NULL DEFAULT 'Media',
  estado              ENUM('Pendiente','En progreso','Completada') NOT NULL DEFAULT 'Pendiente',
  fecha_creacion      DATETIME NOT NULL,
  fecha_actualizacion DATETIME NOT NULL,
  CONSTRAINT fk_tareas_usuario FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Usuario de prueba  ->  usuario: admin   contraseña: admin123
-- ------------------------------------------------------------
INSERT INTO usuarios (id, nombre, usuario, clave) VALUES
(1, 'Jamil Marciaga', 'admin', '$2y$10$Krxs8fHC73YiB0KVoi8.P.VMhuFNn3nD1xJ9Vta1rf90ENbtucTka');

-- ------------------------------------------------------------
-- 10 tareas de prueba
-- ------------------------------------------------------------
INSERT INTO tareas (usuario_id, titulo, descripcion, prioridad, estado, fecha_creacion, fecha_actualizacion) VALUES
(1, 'Entregar proyecto final de PHP', 'Subir el .zip con el código, el .sql y el PDF a la plataforma.', 'Alta', 'En progreso', '2026-11-20 08:30:00', '2026-11-26 21:00:00'),
(1, 'Estudiar para el examen de Estructuras de Datos', 'Repasar listas enlazadas, pilas y colas.', 'Alta', 'Pendiente', '2026-11-21 19:00:00', '2026-11-21 19:00:00'),
(1, 'Pagar la factura de internet', 'Vence el día 30 del mes.', 'Alta', 'Pendiente', '2026-11-22 10:15:00', '2026-11-22 10:15:00'),
(1, 'Simulación del Módulo 12', 'Armar el circuito en serie en Falstad y enviar las capturas.', 'Media', 'Completada', '2026-11-18 14:00:00', '2026-11-27 00:30:00'),
(1, 'Actualizar el currículum', 'Agregar los cursos del último cuatrimestre.', 'Media', 'Pendiente', '2026-11-19 16:40:00', '2026-11-19 16:40:00'),
(1, 'Leer el capítulo 5 del libro de redes', 'Modelo OSI y TCP/IP.', 'Media', 'En progreso', '2026-11-17 20:00:00', '2026-11-24 20:30:00'),
(1, 'Hacer ejercicio 30 minutos', 'Caminar o trotar en la tarde.', 'Baja', 'Pendiente', '2026-11-23 06:00:00', '2026-11-23 06:00:00'),
(1, 'Organizar los archivos del escritorio', 'Mover documentos viejos a una carpeta de respaldo.', 'Baja', 'Pendiente', '2026-11-16 09:00:00', '2026-11-16 09:00:00'),
(1, 'Teorema de Thévenin (Módulo 10)', 'Resolver el ejercicio a mano y subir el PDF.', 'Alta', 'Completada', '2026-11-15 18:00:00', '2026-11-27 00:15:00'),
(1, 'Comprar materiales de oficina', 'Cuaderno, lapiceros y resaltadores.', 'Baja', 'Completada', '2026-11-14 11:00:00', '2026-11-20 17:45:00');
