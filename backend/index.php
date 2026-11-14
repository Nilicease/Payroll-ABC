<?php 

require_once __DIR__ . '/controller/EmployeeController.php';

// Set the content type to JSON for API responses
header('content-type: application/json');

//$employeeController = new EmployeeController($pdo);

// This will get the request method (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];
// This will get the path from the URL (e.g., /employees, /employees/1)
$path = parse_url($_SERVER[''], PHP_URL_PATH);

// This function will handle routing based on the request method and path
function Route( $serverMethod, $pathURL, $callback ) {
    global $method, $path;
    if ( $path == $pathURL && $method == $serverMethod ) {
        $callback();
        exit;
    }
}

// Example route for getting all employees
Route('GET', '/employees', function() {
    // $employeeController = new EmployeeController();
    // $employeeController->getAllEmployees();
});


?>
