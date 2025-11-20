<?php
// Archivo de conexión a la base de datos
// NOTA: Deberás modificar estos valores con tus credenciales reales
 $servername = "mysql.inf.uct.cl";
 $username = "joaquin_carrasco";
 $password = "Strict0-Promptly5";
 $dbname = "A2025_joaquin_carrasco";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Establecer charset
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>