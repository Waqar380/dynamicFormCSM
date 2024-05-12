<?php

require_once __DIR__ . '../../models/Form.php';
require_once __DIR__ . '../../traits/validator.php';
require_once __DIR__ . '../../traits/mailer.php';


class FormController {

    use validator, mailer;

    public function createForm($data) {
        $formModel = new Form();
        return $formModel->storeFormInDatabase($data);
    }

    public function submitForm($data) {
        $formModel = new Form();
        return $formModel->saveSubmissionToDatabase($data);
    }

    public function getAllForms() {
        $formModel = new Form();
        return $formModel->getFormInDatabase();
    }

    public function getSingleForm($data) {
        $formModel = new Form();
        return $formModel->getSingleFormInDatabase($data);
    }
}
?>