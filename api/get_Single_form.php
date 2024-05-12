<?php

header('Content-Type: application/json');

require_once './controllers/FormController.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
        exit;
    }

    $FormController = new FormController();
    $formData = $FormController->getSingleForm($data);

    if ($formData) {
        http_response_code(200);
        echo json_encode(['success' => true, 'data' => $formData]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to get data']);
    }
}