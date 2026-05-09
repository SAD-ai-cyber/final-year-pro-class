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
    <title>Rules & Regulations - Computer Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/media.css">
    <style>
        .rules-section {
            padding: 100px 0 60px;
            background-color: #f7faff;
        }
        .rule-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            transition: transform 0.3s ease;
        }
        .rule-card:hover {
            transform: translateY(-5px);
        }
        .rule-card h3 {
            color: #009970;
            margin-bottom: 15px;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .rule-card p, .rule-card li {
            color: #555;
            line-height: 1.6;
        }
        .rule-card ul {
            padding-left: 20px;
        }
        .page-header {
            text-align: center;
            margin-bottom: 50px;
        }
        .page-header h1 {
            font-weight: 800;
            color: #0A2134;
            font-size: 42px;
        }
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 32px;
            }
            .rules-section {
                padding: 80px 0 40px;
            }
            .rule-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
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
                                            <a class="nav-link mx-lg-2" href="../pages/contact-page.php">Contact</a>
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

    <section class="rules-section">
        <div class="container">
            <div class="page-header">
                <h1>Rules & Regulations</h1>
                <p class="text-muted">Guidelines for a better learning environment</p>
            </div>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="rule-card">
                        <h3><i class="fa-solid fa-graduation-cap"></i> 1. Academic Integrity</h3>
                        <p>Students are expected to maintain the highest standards of academic honesty. Plagiarism, cheating, or any form of unauthorized assistance on assignments or exams is strictly prohibited.</p>
                    </div>

                    <div class="rule-card">
                        <h3><i class="fa-solid fa-clock"></i> 2. Attendance & Punctuality</h3>
                        <p>Regular attendance is crucial for success. Students must maintain at least 75% attendance to be eligible for certification. Please inform the instructor in advance if you need to be absent.</p>
                    </div>

                    <div class="rule-card">
                        <h3><i class="fa-solid fa-user-shield"></i> 3. Code of Conduct</h3>
                        <ul>
                            <li>Respect your instructors and fellow students.</li>
                            <li>Maintain cleanliness in the laboratory and classrooms.</li>
                            <li>Electronic devices should be used only for educational purposes during class hours.</li>
                            <li>Any form of harassment or bullying will lead to immediate disciplinary action.</li>
                        </ul>
                    </div>

                    <div class="rule-card">
                        <h3><i class="fa-solid fa-credit-card"></i> 4. Fees & Payments</h3>
                        <p>Fees should be paid on or before the due date. A late fee may be applicable for delayed payments. Fees once paid are non-refundable under normal circumstances.</p>
                    </div>

                    <div class="rule-card">
                        <h3><i class="fa-solid fa-computer"></i> 5. Lab Usage</h3>
                        <p>Handle computer equipment with care. Do not change system settings or install unauthorized software. Any damage to equipment due to negligence will be the student's responsibility.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer style="background:url(../photo/still-life-851328_1280.jpg) center/cover no-repeat">
        <div class="py-lg-5 py-sm-4 py-3 text-white" style="background: #000000d2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <h5>Useful links</h5>
                        <ul class="fa-ul ms-4">
                            <li><a href="../pages/rules.php" class="text-light"><i class="fa-li fa fa-angle-right"></i>Rules & Regulations</a></li>
                            <li><a href="../pages/about-page.php" class="text-light"><i class="fa-li fa fa-angle-right"></i>About Us</a></li>
                            <li><a href="../pages/services-page.php" class="text-light"><i class="fa-li fa fa-angle-right"></i>Services</a></li>
                            <li><a href="../pages/contact-page.php" class="text-light"><i class="fa-li fa fa-angle-right"></i>Contact Us</a></li>
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
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <h5>Subscribe Now</h5>
                        <form action="">
                            <div class="mb-3">
                                <input type="email" id="email-s" class="form-control">
                                <label for="email-s">Your Email </label>
                            </div>
                            <button class="btn btn-block" style="width: 100%; background-color: aqua;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function handleRedirect(select) {
            if (select.value === "Admin") {
                window.location.href = "../admin_login.php";
            } else if (select.value === "Users") {
                window.location.href = "../login.php";
            }
        }

        window.addEventListener("load", resetDropdown);
        window.addEventListener("pageshow", resetDropdown);

        function resetDropdown() {
            const roleDropdown = document.getElementById("role");
            if (roleDropdown) {
                roleDropdown.selectedIndex = 0;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK"
        crossorigin="anonymous"></script>
</body>

</html>

