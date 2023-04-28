<?php

function validateName($name, int $min_char = 0, int $max_char = 1000): string
{
    // Remove whitespace
    $name = trim($name);

    $name_length = strlen($name);

    if ($min_char > $max_char) {
        throw new Exception("Exception: Minimum character > Maximum character");
    }

    switch (true) {
        case (!$name_length):
            return "Name is required";

            // Name contains numbers
        case (!preg_match("/^[a-zA-Z-' ]*$/", $name)):
            return "Only letters and white space allowed";

        case ($name_length < $min_char || $name_length > $max_char):
            return "Name must be $min_char-$max_char characters";

        default:
            return "";
    }
}

function validateEmail($email): string
{
    // Remove whitespace
    $email = trim($email);

    $email_length = strlen($email);

    switch (true) {
        case (!$email_length):
            return "Email is required";

            // ex. someone@email.com
        case (!filter_var($email, FILTER_VALIDATE_EMAIL)):
            return "Invalid Email";

        default:
            return "";
    }
}

function validateMessage($message, int $min_char = 0, int $max_char = 1000): string
{
    // Remove whitespace
    $message = trim($message);

    $message_length = strlen($message);

    if ($min_char > $max_char) {
        throw new Exception("Exception: Minimum character > Maximum character");
    }

    switch (true) {
        case (!$message_length):
            return "Message is required";

        case ($message_length < $min_char || $message_length > $max_char):
            return "Message must be $min_char-$max_char characters";

        default:
            return "";
    }
}

function validateZIPCode($zip_code, int $min_num = 0, int $max_num = 1000): string
{
    // Remove whitespace
    $zip_code = trim($zip_code);

    $zip_code_length = strlen($zip_code);

    switch (true) {
        case (!$zip_code_length):
            return "ZIP Code is required";

            // ZIP code is invalid (ex. 12345)
        case (!preg_match("/^[0-9]{5}(?:-[0-9]{4})?$/", $zip_code)):
            return "Invalid ZIP code";

        case ($zip_code_length < $min_num && $zip_code_length > $max_num):
            return "...";

        default:
            return "";
    }
}

function validateService($service): string
{
    // Service options
    $available_services = ["VIDEOGRAPHY", "PHOTOGRAPHY"];

    // Remove whitespace and make uppercase
    $service = strtoupper(trim($service));

    switch (true) {
        case (!$service):
            return "Service is required";

        case (!in_array($service, $available_services)):
            return "Invalid Service";

        default:
            return "";
    }
}

function displayErrorMessage($error_message)
{
    if ($error_message) {
        echo <<<HTML
        <div class="error-message">
            <i class="fa-solid fa-circle-exclamation" style="color: red;"></i>
            <p class='error-text'>$error_message</p>
        </div>
        HTML;
    }
}

function is_text($text, int $min = 0, int $max = 1000): bool
{
    return strlen($text) >= $min and strlen($text) <= $max;
}


function is_number($number, int $min = 0, int $max = 100): bool
{
    return $number >= $min and $number <= $max;
}
