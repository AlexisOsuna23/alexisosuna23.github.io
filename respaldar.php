<?php
// Conecta a la base de datos
$conn = new mysqli('containers-us-west-135.railway.app', 'containers-us-west-135.railway.app', 'o4PRDDpNH05b7olFh2PR', 'railway');

// Obtiene la ruta de la carpeta a respaldar
$ruta_carpeta = $_POST['ruta_carpeta'];

// Obtiene la fecha y hora actual
$fecha_hora = date('Y-m-d H:i:s');

// Crea el archivo ZIP de respaldo
$nombre_zip = 'respaldo_' . date('YmdHis') . '.zip';
$zip = new ZipArchive();
$zip->open($nombre_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE);

$archivos = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($ruta_carpeta),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($archivos as $archivo) {
    if (!$archivo->isDir()) {
        $nombre_archivo = $archivo->getFilename();
        $ruta_archivo = $archivo->getRealPath();
        $zip->addFile($ruta_archivo, $nombre_archivo);
    }
}

$zip->close();

// Sube el archivo ZIP a la base de datos
$stmt = $conn->prepare('INSERT INTO respaldos (fecha_hora, nombre_archivo, archivo_zip) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $fecha_hora, $nombre_zip, $archivo_zip);
$archivo_zip = file_get_contents($nombre_zip);
$stmt->send_long_data(2, $archivo_zip);
$stmt->execute();

$stmt->close();
$conn->close();

// Devuelve la respuesta al cliente
echo 'Respaldo creado con éxito.';
