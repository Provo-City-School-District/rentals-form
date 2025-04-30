<?php
require_once 'forms/form-handler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = $_POST;
    $result = handleFormSubmission($formData, $connection);
}

include 'views/form.php';
