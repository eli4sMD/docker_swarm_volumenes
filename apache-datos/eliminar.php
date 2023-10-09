<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Conectar a la base de datos MySQL
    $mysqli = new mysqli("mysql", "root", "1234", "prueba");

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("Error en la conexión a la base de datos: " . $mysqli->connect_error);
    }

    // Eliminar el registro del alumno
    $query = "DELETE FROM alumnos WHERE id = $id";
    if ($mysqli->query($query) === TRUE) {
        // Redirigir después de la eliminación
        header("Location: index.php");
        exit(); // Asegurarse de salir después de redirigir
    } else {
        echo "Error al eliminar el alumno: " . $mysqli->error;
    }

    // Cerrar la conexión a la base de datos
    $mysqli->close();
}
?>
