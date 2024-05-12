<?php

require_once 'Database.php';

class Form {
    public function storeFormInDatabase($form) {
        $db = Database::getInstance()->getConnection();
        // Insert form definition into the database
        $query = "INSERT INTO forms (name) VALUES (?)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $form[0]['form']);
        $stmt->execute();
        
        $formId = $db->lastInsertId();

        // Insert fields for the form
        foreach ($form as $field) {
            $fieldName = $field['name'];
            $fieldType = $field['type'];
            $InputType = $field['input_type'];
            $order = $field['order'];
            $options = json_encode($field['options']);
            $emailFlag = $field['send_email'] ? 1 : 0;
            $validationRules = json_encode($field['validation']);

            $query = "INSERT INTO form_fields (form_id, name, type, send_email, validation, options, order_by, input_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bindValue(1, $formId);
            $stmt->bindValue(2, $fieldName);
            $stmt->bindValue(3, $fieldType);
            $stmt->bindValue(4, $emailFlag);
            $stmt->bindValue(5, $validationRules);
            $stmt->bindValue(6, $options);
            $stmt->bindValue(7, $order);
            $stmt->bindValue(8, $InputType);

            $stmt->execute();
        }

        return $formId;
    }

    public function saveSubmissionToDatabase($form) {
        $db = Database::getInstance()->getConnection();
        // Save form submission to the database
        $query = "INSERT INTO form_submissions (form_id, data) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $form['form_id']);
        $stmt->bindValue(2, json_encode($form));
        $stmt->execute();
        
        $submissionId = $db->lastInsertId();
        return $submissionId;
    }

    public function getFormInDatabase() {
        $db = Database::getInstance()->getConnection();
        // Retrieve all forms from the database
        $query = "SELECT id, name, DATE_FORMAT(created_at, '%d-%m-%Y %h:%i %p') AS created_at FROM forms order by created_at desc";
        $stmt = $db->query($query);
        $forms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $forms;
    }

    public function getSingleFormInDatabase($data) {
        $db = Database::getInstance()->getConnection();
        // Retrieve a single form from the database by ID
        $query = "SELECT ff.*,f.name as form_name 
        FROM form_fields ff left join forms f on ff.form_id = f.id 
        where f.id = (?) order by order_by";
        
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $data['formId']);
        $stmt->execute();
        $form = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $form;
    }
}
?>
