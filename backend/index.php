<?php 

// Set the content type to JSON for API responses

header('Access-Control-Allow-Origin: http://127.0.0.1:5500');

header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');

header('Access-Control-Allow-Headers: Content-Type, Authorization');

header('content-type: application/json');
//$employeeController = new EmployeeController($pdo);
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
// This will get the request method (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];
// This will get the path from the URL (e.g., /employees, /employees/1)
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);



// This function will handle routing based on the request method and path
function Route( $serverMethod, $pathURL, $callback ) {
    global $method, $path;
    if ( $path == $pathURL && $method == $serverMethod ) {
        $callback();
        exit;
    }
}

require_once __DIR__ . '/api/routes.php';

// No route matched.
http_response_code(404);

echo json_encode([
    'success' => false,
    'message' => 'Endpoint not found.'
]);



