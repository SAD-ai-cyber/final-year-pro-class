<?php
require '../includes/security.php';

// Start secure session and token for forms
start_secure_session();
// Apply security headers for this request.
send_security_headers();
$csrf_token = csrf_token();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Computer Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/media.css">
    <link rel="stylesheet" href="../css/pages/contact-page.css">
   
</head>

<body>
    <!-- pop-pup form  -->
    <div class="modal fade" id="enmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Enquire Now</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../includes/add_online_student.php" method="post" class="bannerForm p-3">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                        <h3>Book Your Free Class Now!</h3>
                        <p>2 days of free demo classes without paying in advance!</p>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="student_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="Email" name="student_email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone No</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">+91</span>
                                <input type="text" maxlength="10" name="mobile_number" class="form-control" placeholder="Phone" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <button name="Register_Now" class="btn formbtn">Register Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--pop-pup form 2  -->
    <div class="modal fade" id="demomodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Book Demo Class Register Now</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../includes/add_demo_student.php" method="post" class="bannerForm p-3">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="student_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone No</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">+91</span>
                                <input type="text" name="student_num" maxlength="10" class="form-control" placeholder="Phone" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <button name="Register_Now" class="btn formbtn">Register Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <header class="container-fluid shadow-lg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg fixed-top">
                        <div class="container-fluid">
                            <a class="navbar-brand me-auto brand-logo" href="../index.php">
                                <img src="../photo/logo.jpg" alt="Logo">
                            </a>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                                aria-labelledby="offcanvasNavbarLabel">
                                <div class="offcanvas-header brand-logo">
                                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="../photo/logo.jpg"
                                            alt="Logo">
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="../index.php">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="../pages/about-page.php">About</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="../pages/services-page.php">Services</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="../pages/features-page.php">Feature</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="../pages/course-page.php">Courses</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2 active" aria-current="page" href="#">Contact</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="login-button">
                                <select name="role" id="role" class="login-button" required autocomplete="off"
                                    onchange="handleRedirect(this)">
                                    <option value="">Login-Option</option>
                                    <option value="Admin">Institute-Login</option>
                                    <option value="Users">Users-login</option>
                                </select>
                            </div>
                            <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <section class="container-fluid contact-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Get In Touch With Us</h1>
                    <p>We'd love to hear from you! Whether you have questions about our courses or need assistance,
                        feel free to reach out to us. Our team is ready to help.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid contact-content-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="contact-info-card">
                        <div class="info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <div>
                                <h5>Our Location</h5>
                                <p>D-41 and 42, Hanuman mandir Lane Kandivali, Sector number 3, hanuman mandir Jaldhara CHS, plot number 341, Charkop, Charkop Gaon, Mumbai, Maharashtra 400067</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fa-solid fa-phone"></i>
                            <div>
                                <h5>Call Us</h5>
                                <p>+91 98765 43210</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fa-solid fa-envelope"></i>
                            <div>
                                <h5>Email Us</h5>
                                <p>info@computerclass.com</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fa-solid fa-clock"></i>
                            <div>
                                <h5>Office Hours</h5>
                                <p>Mon - Fri: 9:00 AM - 9:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="contact-form-card">
                        <h3>Send Us A Message</h3>
                        <form action="../includes/contact_demo_student.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="student_name" class="form-control" id="name" placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="student_email" class="form-control" id="email" placeholder="name@example.com" required>
                            </div>
                            <div class="mb-3">
                                 <label class="form-label">Phone No</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">+91</span>
                                <input type="text" name="student_num" maxlength="10" class="form-control" placeholder="Phone" />
                            </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control" id="subject" placeholder="e.g., Course Inquiry" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Your Message</label>
                                <textarea name="message" class="form-control" id="message" rows="5" required></textarea>
                            </div>
                            <button type="submit" name="Send_Message" class="btn btn-submit">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid map-section">
        <div class="container">
            <div class="map-container">
                <div class="address-overlay">
                    <h6>Our Location</h6>
                    <p>D-41 and 42, Hanuman mandir Lane Kandivali, Sector number 3, hanuman mandir Jaldhara CHS, plot number 341, Charkop, Charkop Gaon, Mumbai, Maharashtra 400067</p>
                </div>
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3767.4659660726834!2d72.829165!3d19.218513799999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7b72e0b542035%3A0xba0b11dec1763398!2sREACT%20(%20Red%20Eye%20Academy%20of%20Computer%20Technology%20)!5e0!3m2!1sen!2sin!4v1757348158765!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    <footer style="background:url(../photo/still-life-851328_1280.jpg) center/cover no-repeat">
        <div class="py-lg-5 py-sm-4 py-3  text-white" style="background: #000000d2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <h5>Useful links</h5>
                        <ul class="fa-ul ms-4">
                            <li><a href="../pages/rules.php" class="text-light text-decoration-none"><i class="fa-li fa fa-angle-right"></i>Rules & Regulations</a></li>
                            <li><a href="../pages/about-page.php" class="text-light text-decoration-none"><i class="fa-li fa fa-angle-right"></i>About Us</a></li>
                            <li><a href="../pages/services-page.php" class="text-light text-decoration-none"><i class="fa-li fa fa-angle-right"></i>Services</a></li>
                            <li><a href="../pages/contact-page.php" class="text-light text-decoration-none"><i class="fa-li fa fa-angle-right"></i>Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h5>Social Presence</h5>
                        <div>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa-brands fa-facebook-f fa-stack-1x fa-inverse text-dark"></i>
                            </span>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa-brands fa-instagram fa-stack-1x fa-inverse text-dark"></i>
                            </span>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa-brands fa-twitter fa-stack-1x fa-inverse text-dark"></i>
                            </span>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa-brands fa-github fa-stack-1x fa-inverse text-dark"></i>
                            </span>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa-brands fa-youtube fa-stack-1x fa-inverse text-dark"></i>
                            </span>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa-brands fa-linkedin fa-stack-1x fa-inverse text-dark"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <h5>Subscribe Now</h5>
                        <form action="">
                            <div class="mb-3">
                                <input type="email" id="email-s" class="form-control">
                                <label for="email-s">Your Email </label>
                            </div>
                            <button class="btn btn-block" style="width: 50%; background-color: aqua;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </footer>
  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK"
        crossorigin="anonymous"></script>
    <script>
        // Yah function dropdown se login page par redirect karta hai.
        function handleRedirect(select) {
            if (select.value === "Admin") {
                window.location.href = "../admin_login.php";
            } else if (select.value === "Users") {
                window.location.href = "../login.php";
            }
        }
        
        // Yah function page load hone par dropdown ko reset karta hai.
        window.addEventListener("load", resetDropdown);
        window.addEventListener("pageshow", resetDropdown);
        window.addEventListener("focus", resetDropdown);

        function resetDropdown() {
            const roleDropdown = document.getElementById("role");
            if (roleDropdown) {
                roleDropdown.selectedIndex = 0;}
        }
    </script>
</body>

</html>



