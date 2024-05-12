<?php

require_once __DIR__ . '/../../config.php';

trait mailer
{
    public function sendFormattedEmail($data) {
        $to = Config::TO_EMAIL;
        $subject = 'Form Submission';
    
        $body = '';
        foreach ($data as $key => $value) {
            $body .= "{$key}: {$value}\n";
        }
        try{
            mail($to, $subject, $body);
        }catch (Exception $ex) {
            "An error occurred: " . $ex->getMessage();
        }
        return true;
    }
}