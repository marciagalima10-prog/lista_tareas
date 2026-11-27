# Lista de Tareas Personal con Prioridades

Proyecto final en PHP (POO + PDO + MySQL) con estructura MVC simplificada.

## Instalación (XAMPP)

1. Copiar la carpeta `lista_tareas` dentro de `C:\xampp\htdocs\`.
2. Iniciar **Apache** y **MySQL** en el panel de XAMPP.
3. Abrir `http://localhost/phpmyadmin`, ir a **Importar** y cargar `database/lista_tareas.sql`.
4. Si su MySQL tiene contraseña, cambiarla en `config/config.php`.
5. Abrir `http://localhost/lista_tareas/`.

Usuario de prueba: **admin** · Contraseña: **admin123**

## Estructura

```
lista_tareas/
├── index.php                  Punto de entrada (enrutador)
├── config/
│   ├── config.php             Datos de conexión y constantes
│   └── Database.php           Conexión PDO (Singleton)
├── models/
│   ├── Tarea.php              CRUD de tareas
│   └── Usuario.php            Validación del login
├── controllers/
│   ├── TareaController.php    Listar, crear, editar, completar, eliminar
│   └── AuthController.php     Login y logout con sesiones
├── views/
│   ├── layout/                Encabezado y pie comunes
│   ├── auth/login.php         Pantalla de login
│   └── tareas/                Listado y formulario
├── public/css/estilos.css     Estilos
└── database/lista_tareas.sql  Base de datos con 10 tareas de prueba
```
