<?php
// Incluir archivo de conexión
include 'conex.php'; // reemplaza con el nombre de tu archivo

// Probar la conexión
if ($conn) {
    echo "¡Conexión exitosa a la base de datos!";
} else {
    echo "Error en la conexión.";
}
?>
