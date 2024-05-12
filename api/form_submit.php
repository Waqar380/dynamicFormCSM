<?php

require_once './controllers/FormController.php';
require_once '../config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = $_POST;

    if (!isset($data)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
        exit;
    }

    $FormController = new FormController();

    $edata = $FormController->validateSubmission($data);

    $submission = $FormController->submitForm($data);

    if($edata){
        $FormController->sendFormattedEmail($edata);
    }

    if ($submission) {
        http_response_code(201);
        echo json_encode(['message' => 'From submission successful']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save form']);
    }
}