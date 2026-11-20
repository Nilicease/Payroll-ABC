<?php

Route('POST', '/success', function () {

    echo json_encode([
        'success' => true,
        'message' => 'Welcome to the Payroll API'
    ]);

});