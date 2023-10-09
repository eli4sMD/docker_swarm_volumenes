<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>CRUD de Alumnos</title>
</head>

<body>
    <h1>CRUD de Alumnos</h1>

    <?php
    // Conectar a la base de datos MySQL
    $mysqli = new mysqli("mysql", "root", "1234", "prueba");

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("Error en la conexión a la base de datos: " . $mysqli->connect_error);
    }

    // Query para crear la tabla si no existe
    $createTableQuery = "CREATE TABLE IF NOT EXISTS `alumnos` (
    `id` INTEGER NOT NULL auto_increment,
    `apellidos` VARCHAR(255) NOT NULL,
    `nombres` VARCHAR(255) NOT NULL,
    `dni` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB";

    if ($mysqli->query($createTableQuery) === TRUE) {
        echo "Tabla 'alumnos' creada o verificada exitosamente.";
    } else {
        echo "Error al crear o verificar la tabla 'alumnos': " . $mysqli->error;
    }

    // Procesar las operaciones CRUD
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Operación de creación de alumno
        if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["dni"])) {
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $dni = $_POST["dni"];

            // Escapar los valores para prevenir inyección SQL
            $nombre = $mysqli->real_escape_string($nombre);
            $apellido = $mysqli->real_escape_string($apellido);
            $dni = $mysqli->real_escape_string($dni);

            $query = "INSERT INTO alumnos (nombres, apellidos, dni) VALUES ('$nombre', '$apellido', '$dni')";
            if ($mysqli->query($query) === TRUE) {
                echo "Alumno creado exitosamente.";
            } else {
                echo "Error al crear el alumno: " . $mysqli->error;
            }
        }
    }

    // Listar los alumnos
    $query = "SELECT * FROM alumnos";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        echo "<h2>Alumnos</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Acciones</th></tr>"; // Agregamos una columna para acciones
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["nombres"] . "</td>";
            echo "<td>" . $row["apellidos"] . "</td>";
            echo "<td>" . $row["dni"] . "</td>";
            echo "<td><a href='eliminar.php?id=" . $row["id"] . "'>Eliminar</a></td>"; // Agregamos un enlace para eliminar
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No hay alumnos registrados.";
    }


    // Cerrar la conexión a la base de datos
    $mysqli->close();

    ?>

    <!-- Formulario para crear un alumno -->
    <<h2>Crear Alumno</h2>
        <form method="POST">
            Nombre: <input type="text" name="nombre" required><br>
            Apellido: <input type="text" name="apellido" required><br>
            DNI: <input type="text" name="dni" required><br>
            <input type="submit" name="crear" value="Crear">
        </form>
</body>

</html>