<?php

// get_form.php

header('Content-Type: application/json');

require_once './controllers/FormController.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $FormController = new FormController();
    $formData = $FormController->getAllForms();

    if ($formData) {
        http_response_code(200);
        echo json_encode(['success' => true, 'data' => $formData]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to get data']);
    }
}