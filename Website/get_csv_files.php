<?php
// Obtiene la ruta de la carpeta desde la consulta GET
$folderPath = isset($_GET['folder']) ? $_GET['folder'] : '';
$folderPath = 'NMSMappings/' . $folderPath;

// Verifica que la carpeta exista y sea un directorio
if (is_dir($folderPath)) {
    // Escanea la carpeta en busca de archivos CSV
    $files = scandir($folderPath);

    // Filtra solo los archivos CSV
    $csvFiles = array_filter($files, function ($file) {
        return pathinfo($file, PATHINFO_EXTENSION) === 'csv';
    });

    // Lee el contenido de cada archivo CSV y almacena la información en un array
    $csvData = array();
    foreach ($csvFiles as $csvFile) {
        $filePath = $folderPath . '/' . $csvFile;
        $content = file_get_contents($filePath);

        // Agrega información del archivo al array
        $csvData[] = array(
            'name' => $csvFile,
            'content' => $content
        );
    }

    // Devuelve la lista de archivos CSV como JSON
    header('Content-Type: application/json');
    echo json_encode($csvData);
} else {
    // Si la carpeta no existe o no es un directorio, devuelve un mensaje de error
    echo 'Error: La carpeta no existe o no es un directorio.';
}
?>
