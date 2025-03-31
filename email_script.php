<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $errorMessage = '';

    $name = $_POST['full_name'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if (empty($name)) {
        $errors[] = 'Name is empty';
    }

    if (empty($email)) {
        $errors[] = 'Email is empty';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }

    if (empty($subject)) {
        $errors[] = 'Subject is empty';
    }

    if (empty($message)) {
        $errors[] = 'Message is empty';
    }

    if (empty($errors)) {
        $toEmail = 'eduncate47@gmail.com';
        $emailSubject = 'New email from your contact form';
        $headers = 'From: ' . $email . "\r\n" .
                    'Reply-To: ' . $email . "\r\n" .
                    'Content-type: text/html; charset=utf-8';
        $body = "Name: $name <br>";
        $body .= "Email: $email <br>";
        $body .= "Subject: $subject <br>";
        $body .= "Message: $message";

        if (mail($toEmail, $emailSubject, $body, $headers)) {
            $successMessage = 'Email sent successfully!';
        } else {
            $errorMessage = 'Oops, something went wrong. Please try again later';
        }

        echo json_encode(array('success' => $successMessage, 'error' => $errorMessage));
    } else {
        echo json_encode(array('error' => $errors));
    }
}

?>