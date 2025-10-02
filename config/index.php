<?php

/**
 * Redirect to the Laravel public directory
 */

// Obtener la ruta de la petición actual
$request_uri = $_SERVER['REQUEST_URI'] ?? ''; // Usar un valor predeterminado vacío si no está definida

// Si la URL ya contiene /public/, no hacer redirección para evitar bucles
if (strpos($request_uri, '/backend/public/') === 0) {
    return false;
}

// Si la URL empieza con /backend/, redirigir a /backend/public/
if (strpos($request_uri, '/backend/') === 0) {
    // Reemplazar /backend/ con /backend/public/
    $new_uri = str_replace('/backend/', '/backend/public/', $request_uri);

    // Obtener los parámetros de la query si existen
    $query_string = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';

    // Redireccionar a la nueva URL
    header('Location: ' . $new_uri . $query_string);
    exit;
}

// Si llegamos aquí, simplemente incluir el archivo index.php de Laravel
require_once __DIR__ . '/index.php';
// require_once __DIR__ . '/public/index.php';
