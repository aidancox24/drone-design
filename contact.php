<?php
require "includes/validate.php";

class ContactForm
{
    private string $name;
    private string $email;
    private string $message;
    private string $zip_code;

    public function __construct(string $name, string $email, string $message, string $zip_code)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
        $this->zip_code = $zip_code;
    }

    public function sendEmail(): bool
    {
        $to = "aidan_cox@uri.edu";
        $subject = "New Message";
        $body = "Name: $this->name \n\nEmail: $this->email \n\nZIP Code: $this->zip_code \n\nMessage: $this->message";
        // Return status of email
        return mail($to, $subject, $body);
    }
}

$user = [
    "name" => "",
    "email" => "",
    "message" => "",
    "zip_code" => "",
    "service" => "",
    "terms" => "",
];

$errors = [
    "name" => "",
    "email" => "",
    "message" => "",
    "zip_code" => "",
    "service" => "",
    "terms" => "",
];


$emailSuccess = isset($_COOKIE["displayContactForm"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user["name"] = $_POST["name"];
    $user["email"] = $_POST["email"];
    $user["message"] = $_POST["message"];
    $user["zip_code"] = $_POST["zip_code"];
    $user["service"] = $_POST["service"];
    $user["terms"] = (isset($_POST["terms"]) and $_POST["terms"]) ? true : false;

    // Form validation
    $errors["name"] = validateName($user["name"], 2, 20);
    $errors["email"] = validateEmail($user["email"]);
    $errors["message"] = validateMessage($user["message"], 10);
    $errors["zip_code"] = validateZIPCode($user["zip_code"]);
    $errors["service"] = validateService($user["service"]);
    $errors["terms"] = $user["terms"] ? "" : "You must agree to the terms and conditions";

    $invalid = implode($errors);

    // Check if form is valid
    if (!$invalid) {
        $form = new ContactForm($user["name"], $user["email"], $user["message"], $user["zip_code"]);

        $emailSuccess = $form->sendEmail();

        setcookie("displayContactForm", $user["name"], time() + 60 * 60 * 48);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drone Design</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css" />
    <link rel="stylesheet" type="text/css" href="styles/custom-elements.css" />
    <script src="https://kit.fontawesome.com/626b14f90d.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav id="navbar"></nav>
    <div id="contact-us">
        <h1 id="contact-header">Contact</h1>

        <?php if (!$emailSuccess) { ?>
            <form id="contact-form" method="post" action="">
                <input class="contact-form-input" name="name" placeholder="Name" value="<?= htmlspecialchars($user["name"]) ?>">
                <?= displayErrorMessage($errors["name"]) ?>

                <input class="contact-form-input" name="email" placeholder="Email" value="<?= htmlspecialchars($user["email"]) ?>">
                <?= displayErrorMessage($errors["email"]) ?>

                <input class="contact-form-input" name="zip_code" placeholder="ZIP Code" value="<?= htmlspecialchars($user["zip_code"]) ?>">
                <?= displayErrorMessage($errors["zip_code"]) ?>

                <input class="contact-form-input" name="service" placeholder="Service (Photography or Videography)" value="<?= htmlspecialchars($user["service"]) ?>">
                <?= displayErrorMessage($errors["service"]) ?>

                <textarea class="contact-form-input message" name="message" placeholder="Message"><?= htmlspecialchars($user["message"]) ?></textarea>
                <?= displayErrorMessage($errors["message"]) ?>

                <input type="checkbox" class="contact-form-checkbox" name="terms" value="true" <?= $user["terms"] ? "checked" : "" ?>> I agree to the terms and conditions</input>
                <?= displayErrorMessage($errors["terms"]) ?>

                <input type="submit" id="contact-form-submit" value="Submit">
            </form>
            <!-- Display successfully submited form message -->
        <?php } else { ?>
            <div class="contact-sent-message">
                Hi <?= !empty($_COOKIE["displayContactForm"]) ? htmlspecialchars($_COOKIE["displayContactForm"]) : $user["name"]; ?>, thank you for contacting us! Your message has been successfully sent.
            </div>
        <?php } ?>
    </div>

    <footer id="footer"></footer>

    <nav id="sidenav"></nav>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        Window.jQuery || document.write('<script src="scripts/jquery-3.6.3.js"><\/script>');
    </script>
    <script src="scripts/custom-elements.js"></script>
</body>

</html>