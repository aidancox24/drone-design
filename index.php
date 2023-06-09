<?php
session_start();

$display_promotion = !isset($_COOKIE['displayPromotion']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    setcookie('displayPromotion', "closed", time() + 900); // expires in 15 minutes
    $_SESSION['display_promotion'] = false;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Drone Design</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css" />
    <link rel="stylesheet" type="text/css" href="styles/custom-elements.css" />
    <script src="https://kit.fontawesome.com/626b14f90d.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav id="navbar"></nav>

    <div class="hero-image">
        <div class="hero-image-text">
            <img src="images/logo-white.png" class="hero-logo" alt="logo">
            <p>Discover a new perspective of the world with our exceptional drone photography and videography services.
            </p>
        </div>
    </div>

    <?php if ($display_promotion) { ?>
        <div class="promotion-banner">
            <p>Get 15% off your first purchase with code <strong>DRONE15</strong></p>
            <form action="" method="post">
                <button name="close_promo" class="close-promo-button"><i class="fa-solid fa-xmark fa-lg" style="color: white"></i></button>
            </form>
        </div>
    <?php } ?>

    <section id="services">
        <div class="services-container"></div>
    </section>

    <section id="homepageAbout">
        <h4 class="homepage-about-header">Who We Are</h4>
        <p class="homepage-about-text">At Drone Design, we are dedicated to capturing the world from a unique
            perspective with
            our exceptional drone photography and videography services. As a small business, we understand the
            importance of value, which is why we aim to provide our clients with affordable rates without compromising
            on the professional quality of our work. Trust us to bring your vision to life with stunning aerial footage.
        </p>
        <h4 class="homepage-about-header">Our Commitments</h4>
        <p class="homepage-about-text">Customer satisfaction is our top priority. We take great pride in going
            above and beyond to guarantee that our clients are thrilled with the final product. Our unwavering
            commitment to delivering exceptional service and exceeding expectations is what sets us apart from the
            competition.
        </p>
    </section>

    <footer id="footer"></footer>

    <nav id="sidenav"></nav>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        Window.jQuery || document.write('<script src="scripts/jquery-3.6.3.js"><\/script>');
    </script>
    <script src="scripts/custom-elements.js"></script>
    <script src="scripts/homepage.js"></script>
</body>

</html>