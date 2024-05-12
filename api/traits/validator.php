<?php

trait validator
{
    public function validateSubmission($form) {

        $db = Database::getInstance()->getConnection();
    
        $query = "SELECT * FROM form_fields WHERE form_id = ? order by order_by";
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $form['form_id']);
        $stmt->execute();
        $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $submissionData = [];
    
        foreach ($fields as $field) {
            $fieldName = str_replace(' ', '_', $field['name']);
            $value = isset($_POST[$fieldName]) ? $_POST[$fieldName] : '';
    
            $validationRules = json_decode($field['validation'], true);
            if(count($validationRules) > 1){
                if (!$this->validateField($value, $validationRules)) {
                    echo json_encode(['success' => false, 'error' => 'Validation failed']);
                    exit;
                }
            }
    
            $submissionData[$fieldName] = $value;
    
            if ($field['send_email'] == 1) { // add field to email data
                $emailData[$fieldName] = $value;
            }
        }
    
        return $emailData;
    }
    
    public function validateField($value, $rules) {
        foreach ($rules as $rule) {
            $parts = explode(':', $rule);
            $ruleName = $parts[0];
            $param = isset($parts[1]) ? $parts[1] : null;
    
            switch ($ruleName) {
                case 'required':
                    if (empty($value)) {
                        return false;
                    }
                    break;
                case 'min_length':
                    if (strlen($value) < $param) {
                        return false;
                    }
                    break;
                case 'max_length':
                    if (strlen($value) > $param) {
                        return false;
                    }
                    break;
                default:
                    return false;
            }
        }
        return true;
    }

}