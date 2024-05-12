<?php
require_once __DIR__ . '/../../config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dynamic Form Builder</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo Config::GOOGLE_RECAPTCHA_SITE_KEY; ?>"></script>
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>