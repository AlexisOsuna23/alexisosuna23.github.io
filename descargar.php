<?php
// Conecta a la base de datos
$conn = new mysqli('containers-us-west-135.railway.app', 'root', 'o4PRDDpNH05b7olFh2PR', 'railway');

// Obtiene el ID del respaldo a descargar
$id_respaldo = $_GET['id'];

// Obtiene la información del respaldo
$stmt = $conn->prepare('SELECT nombre_archivo, archivo_zip FROM respaldos WHERE id = ?');
$stmt->bind_param('i', $id_respaldo);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($nombre_archivo, $archivo_zip);
$stmt->fetch();

// Crea el archivo ZIP de descarga
$nombre_zip = $nombre_archivo;
file_put_contents($nombre_zip, $archivo_zip);

// Descarga el archivo ZIP
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $nombre_zip . '"');
header('Content-Length: ' . filesize($nombre_zip));
readfile($nombre_zip);

// Elimina el archivo ZIP de descarga
unlink($nombre_zip);
$stmt->close();
$conn->close();
