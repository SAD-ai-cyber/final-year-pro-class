<?php
require __DIR__ . '/includes/security.php';

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
    <meta name="csrf-token" content="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
    <script>const userName = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>";</script>


    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <!-- font awesome link -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Mozilla+Headline:wght@200..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
</head>

<body>

    <!-- Enquire modal -->
    <div class="modal fade" id="enmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Enquire Now</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./includes/add_online_student.php" method="post" class="bannerForm p-3 ">
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

                        <div class="mb-3 ">
                            <button name="Register_Now" class="btn formbtn">Register Now</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Enquiry modal close -->

    <!-- Book demo modal -->
    <div class="modal fade" id="demomodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Book Demo Class Register Now</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./includes/add_demo_student.php" method="post" class="bannerForm p-3">
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
    <!-- Book demo modal close -->

    <!-- navbar -->
    <header class="container-fluid shadow-lg">
        <div class="container ">
            <div class="row">
                <div class="col-12">
                    <!-- logo part -->
                    <nav class="navbar navbar-expand-lg fixed-top">
                        <div class="container-fluid">
                            <a class="navbar-brand me-auto brand-logo" href="index.php">
                                <img src="./photo/logo.jpg">
                            </a>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                                aria-labelledby="offcanvasNavbarLabel">
                                <div class="offcanvas-header brand-logo">
                                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="./photo/logo.jpg">
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2 active" aria-current="page" href="#">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2"
                                                href="./pages/about-page.php">About</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="./pages/services-page.php">Services</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="./pages/features-page.php">Feature</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2"
                                                href="./pages/course-page.php">Course</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2"
                                                href="./pages/contact-page.php">Contact</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- notification button -->
                            <!-- <div class="dropdown">
                                <a href="#" class="notification-bell" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-solid fa-bell"></i>
                                    <span class="notification-badge"></span>
                                </a>

                                <div class="dropdown-menu notification-dropdown shadow-lg">
                                    <div class="notification-header">
                                        <h6 class="mb-0">Notifications</h6>
                                        <a href="#" id="mark-all-read">Mark all read</a>
                                    </div>

                                    <div class="notification-list">
                                        <a href="#" class="notification-item">
                                            <div class="notification-icon icon-success">
                                                <i class="fa-solid fa-user-plus"></i>
                                            </div>
                                            <div class="notification-text">
                                                <p class="mb-0">New student registration received from Priya Sharma</p>
                                                <span class="text-muted">2 minutes ago</span>
                                            </div>
                                        </a>

                                        <a href="#" class="notification-item">
                                            <div class="notification-icon icon-warning">
                                                <i class="fa-solid fa-file-invoice"></i>
                                            </div>
                                            <div class="notification-text">
                                                <p class="mb-0">Class 10 Mathematics exam results have been updated</p>
                                                <span class="text-muted">1 hour ago</span>
                                            </div>
                                        </a>

                                        <a href="#" class="notification-item">
                                            <div class="notification-icon icon-info">
                                                <i class="fa-solid fa-money-bill"></i>
                                            </div>
                                            <div class="notification-text">
                                                <p class="mb-0">Fee payment reminder: 25 students pending</p>
                                                <span class="text-muted">3 hours ago</span>
                                            </div>
                                        </a>

                                        <a href="#" class="notification-item">
                                            <div class="notification-icon icon-danger">
                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                            </div>
                                            <div class="notification-text">
                                                <p class="mb-0">Server maintenance scheduled for tonight at 11 PM</p>
                                                <span class="text-muted">1 day ago</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="notification-footer">
                                        <a href="#">View all notifications</a>
                                    </div>
                                </div>
                            </div> -->
                            <div class="login-button">
                                <select name="role" id="role" class="login-button" required autocomplete="off"
                                    onchange="handleRedirect(this)">
                                    <option value="">Login-Option</option>
                                    <option data-page="admin_login" value="Admin">Institute-Login</option>
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

    <!-- navbar end -->

    <!-- second box -->
    <section class="container-fluid mt-5 pt-4 py-lg-5 py-sm-4 py-3">
        <div class="container ">
            <div class="row justify-content-between gy-4 align-items-center">
                <!-- ye pata chalega ki ek side 6 ratio  he or 2ri side 5 ka ratio  -->
                <div class="col-lg-6">
                    <div class="bannercontent">
                        <h1>Career Opportunities<br /> in <span>Artificial Intelligence </span></h1>
                        <p>Artificial Intelligence course so good,you only pay-after-placement</p>

                        <ul class="m-0 p-0">
                            <li class="mb-3"><i class="fa-solid fa-circle-check"></i>Specialization: Performance
                             Artificial Intelligence  </li>
                            <li class="mb-3"><i class="fa-solid fa-circle-check"></i>Min salary of Rs 4.5 LPA</li>
                            <li class="mb-3"><i class="fa-solid fa-circle-check"></i>50 seats only</li>
                        </ul>
                        <div class="bannercontenbtn d-flex gap-3">
                            <button data-bs-toggle="modal" data-bs-target="#demomodal">Book 2 Days Demo</button>
                            <!-- <button data-bs-toggle="modal" data-bs-target="#enmodal"><i
                                    class="fa-solid fa-download"></i>Download Curriculum</button> -->
                        </div>
                    </div>

                </div>
                <div class="col-lg-5 ab">
                    <form action="./includes/add_online_student.php" method="post" class="bannerForm shadow-lg "> <!--yaha pe bannerform me mene 40px padding de he -->
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                        <h3>Book Your Free Class Now!</h3>
                        <p>2 days of free demo classes without paying in advance!</p>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="student_name" class="form-control">
                            <!-- form-control class apne parent ka 100% width leta he or m and p or gap deta he automatically -->
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

                        <div class="mb-3 ">
                            <button name="Register_Now" class="btn formbtn">Register Now</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="container shadow-lg mt-5 counterSection">
            <div class="row  row-cols-lg-5 row-cols-sm-3 row-cols-1 p-4">
                <div class="col">
                    <h2>1000+</h2>
                    <p>Students Trained</p>
                </div>
                <div class="col">
                    <h2>₹4.5 LPA</h2>
                    <p>Min salary</p>
                </div>
                <div class="col">
                    <h2>320+</h2>
                    <p>Recruiting Partners</p>
                </div>
                <div class="col">
                    <h2>10:00 am</h2>
                    <p>Program Timings</p>
                </div>
                <div class="col ">
                    <h2>11th May</h2>
                    <p>Next Batch Starts </p>
                </div>
            </div>
        </div>
    </section>

    <!-- third box -->
    <section class="container-fluid highlights-sections py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 te">
                    <h2>Key Highlights of the Course</h2>
                    <p>Discover how our course structure, from live classes to industry projects, is built to help you achieve your career goals with confidence.</p>
                </div>
            </div>

            <div class="row gy-3">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="bg-white p-3 d-flex align-items-start gap-3 highlightsItems">
                        <img src="photo/highl-1.png" alt="" />
                        <div>
                            <h4>Assignments &<br /> Modules tests</h4>
                            <p>Test your knowledge</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="bg-white p-3 d-flex align-items-start gap-3 highlightsItems">
                        <img src="photo/highl-2.png" alt="" />
                        <div>
                            <h4>Industry-recognized Certification</h4>
                            <p>Stand out to your professional</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="bg-white p-3 d-flex align-items-start gap-3 highlightsItems">
                        <img src="photo/highl-3.png" alt="" />
                        <div>
                            <h4>Live classes & <br />recorded lectures</h4>
                            <p>Best of both worlds of learning</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="bg-white p-3 d-flex align-items-start gap-3 highlightsItems">
                        <img src="photo/highl-4.png" alt="" />
                        <div>
                            <h4>Downloadable<br />Content</h4>
                            <p>With lifetime access</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="bg-white p-3 d-flex align-items-start gap-3 highlightsItems">
                        <img src="photo/highl-5.png" alt="" />
                        <div>
                            <h4>6 Industry level <br /> projects</h4>
                            <p>Get practical skills</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="bg-white p-3 d-flex align-items-start gap-3 highlightsItems">
                        <img src="photo/highl-6.png" alt="" />
                        <div>
                            <h4>4 Live Doubt clearing Session</h4>
                            <p>Gain a clear understanding</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-4 ">
                <div class="col-12 highlg-button  d-flex justify-content-center ">
                    <button class="btn " data-bs-toggle="modal" data-bs-target="#enmodal">Book Free Class</button>
                </div>
            </div>
        </div>
    </section>

    <!-- fourth box -->
    <section class="container-fluid py-lg-5 py-sm-4 py-3">
        <div class="container">
            <div class="row ">
                <div class="col-12 careersec text-center">
                    <h3>Top Career Options In <br /> Computer Field</h3>
                    <p>The computer field offers a vast landscape of rewarding and future-proof career paths. Explore some of the top specializations you can pursue to build a successful career.</p>
                </div>
            </div>
            <div class="row mt-4 gy-4 ">
                <div class="col-lg-3 col-sm-6 col-12 ">
                    <div class="bg-wheat p-4 careersec-item shadow">
                        <img src="photo/csec-1.png" alt="" />
                        <div class="mt-4">
                            <h3>Software Development</h3>
                            <p class="pt-2">Build the applications and digital platforms that power our world, from mobile apps to enterprise software.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 col-12 ">
                    <div class="bg-wheat p-4 careersec-item  shadow">
                        <img src="photo/csec-1.png" alt="" />
                        <div class="mt-4">
                            <h3>Data Science</h3>
                            <p class="pt-2">Analyze large datasets to uncover hidden patterns, predict future trends, and guide intelligent strategies.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="bg-wheat p-4 careersec-item shadow">
                        <img src="photo/csec-1.png" alt="" />
                        <div class="mt-4">
                            <h3>Cybersecurity</h3>
                            <p class="pt-2">Defend critical digital infrastructure, from company networks to personal data, against evolving cyber attacks.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 col-12 ">
                    <div class="bg-wheat p-4 careersec-item shadow">
                        <img src="photo/csec-1.png" alt="" />
                        <div class="mt-4">
                            <h3>Marketing Analyst</h3>
                            <p class="pt-2">Use data analytics to measure the success of marketing campaigns and understand customer journey patterns.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- fifth box -->
    <section class="container-fluid  certificate-sec py-lg-5 py-sm-4 py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="box-1 ">
                        <h2>Get Certified</h2>
                        <p>Validate your React skills with our official certification. It serves as proof of your knowledge and dedication, putting you a step ahead in the industry.</p>
                    </div>

                    <div class="bg-white p-3 d-flex align-items-center gap-3 mb-3 cerItems ">
                        <img src="photo/cert-1.png" alt="" />
                        <div>
                            <h4>Official and verified</h4>
                            <p>Gain a credential that is trusted and recognized. Our system allows employers to instantly confirm the authenticity of your certificate, giving you a competitive edge in the job market.</p>
                        </div>
                    </div>

                    <div class="bg-white p-3 d-flex align-items-center gap-3 mb-3 cerItems ">
                        <img src="photo/cer-2.png" alt="" />
                        <div>
                            <h4>Easily shareable</h4>
                            <p>Showcase your expertise across your professional network. With just a few clicks, you can post your digital certificate on platforms like LinkedIn, enhancing your profile and attracting recruiters.</p>
                        </div>
                    </div>

                    <div class="bg-white p-3 d-flex align-items-center gap-3 mb-3 cerItems ">
                        <img src="photo/cer-3.png" alt="" />
                        <div>
                            <h4>Career shifting</h4>
                            <p>Unlock new career pathways and opportunities for growth. This certification equips you with in-demand skills, making it easier to transition into a new role or secure a promotion.</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button class="btn cerbutton " data-bs-toggle="modal" data-bs-target="#enmodal">
                            Book Free Class
                        </button>
                    </div>

                </div>

                <div class="col-lg-5 p-4">
                    <div class="certificate">

                        <img src="photo/certificate.png" alt="">
                        <!-- <div class="topleft"> <img src="photo/certi-2.png" alt=""></div> -->

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- sixth box -->
    <section class="container-fluid">
        <div class="container">
            <div class="row my-3">
                <div class="col-12 ">
                    <div class="dg-col text-center ">
                        <h2>Curriculum of <br />Our Computer Field</h2>
                        <p>Our comprehensive curriculum is designed to guide you from core fundamentals to advanced specializations, covering the essential languages, frameworks, and technologies that power the modern tech industry.</p>
                    </div>
                </div>
            </div>
            <div class="row mt-4  mb-3">
                <div class="col-12 ">
                    <div class="dg-ul ">
                        <ul class="d-flex  justify-content-center gap-5 m-0 p-0">
                            <li><a href="/">Introduction</a></li>
                            <li><a href="/">Case Studies</a></li>
                            <li><a href="/">Google AdSense</a></li>
                            <li><a href="/">Google AdSense</a></li>
                            <li><a href="/">SEO Mastery</a></li>
                            <li><a href="/">Google Analytics</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row py-lg-5 py-sm-4 py-3 bg-white shadow-lg">
                <div class="col-lg-6">
                    <div class="digtal-ul  ">
                        <ul class="m-0 p-0">
                            <li class="mb-3"><img src="photo/check.png" alt="" class="me-2">What is Computer?
                            </li>
                            <li class="mb-3"><img src="photo/check.png" alt="" class="me-2">Requirement of Computer
                                Developer</li>
                            <li class="mb-3"><img src="photo/check.png" alt="" class="me-2">Digital Marketing for
                                Working Professionals</li>
                            <li class="mb-3"><img src="photo/check.png" alt="" class="me-2">Programming Fundamentals with Python</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="digtal-ul">
                        <ul class="m-0 p-0">
                            <li class="mb-3"><img src="photo/check.png" alt="" class="me-2">Web Development Basics (HTML, CSS, JS)
                            </li>
                            <li class="mb-3"><img src="photo/check.png" alt="" class="me-2">Introduction to Software Engineering</li>
                            <li class="mb-3"><img src="photo/check.png" alt="" class="me-2">Introduction to AI & Machine Learning</li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-12">
                    <div class="dg-button text-center">
                        <button data-bs-toggle="modal" data-bs-target="#enmodal">Download Curriculum</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- seven box -->
    <section class="container-fluid certificate-sec py-lg-5 py-sm-4 py-3">
        <div class="container">
            <div class="row ">
                <div class="col-12">
                    <div class="box-1">
                        <h2>Why Learn Computer Courses</h2>
                        <p>Investing in your skills is the first step toward a rewarding, future-proof career. HereÃ¢â‚¬â„¢s why our program is the right choice to help you succeed.</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="shadow-lg p-3 cerItems">
                        <img src="photo/seven-1.png" alt="">
                        <div class="mt-3">
                            <h4>Learn From Industry Experts</h4>
                            <p>Learn practical, real-world skills from experienced industry experts who are actively working in the tech field today.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="shadow-lg p-3 cerItems">
                        <img src="photo/seven-2.png" alt="">
                        <div class="mt-3">
                            <h4>Structured & Latest Curriculum</h4>
                            <p>Master the most in-demand skills with our structured curriculum, which is always updated to match current industry trends.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="shadow-lg p-3 cerItems">
                        <img src="photo/seven-3.png" alt="">
                        <div class="mt-3">
                            <h4>Highly-Engaging Live Classes</h4>
                            <p>Participate in interactive live classes where you can ask questions, collaborate with peers, and learn in real-time.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="shadow-lg p-3 cerItems">
                        <img src="photo/seven-4.png" alt="">
                        <div class="mt-3">
                            <h4>Work on Real Projects</h4>
                            <p>Go beyond theory by working on real-world projects to build a strong portfolio that impresses potential employers.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="shadow-lg p-3 cerItems">
                        <img src="photo/seven-5.png" alt="">
                        <div class="mt-3">
                            <h4>100% Job Assistance</h4>
                            <p>Launch your career with our full job assistance,resume building, interview prep, and exclusive hiring connections.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="shadow-lg p-3 cerItems">
                        <img src="photo/seven-6.png" alt="">
                        <div class="mt-3">
                            <h4>Get Certification</h4>
                            <p>Receive an industry-recognized certificate upon completion to validate your new skills and boost your professional credibility.</p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row my-4">
                <div class="col-12">
                    <div class="dg-button text-center">
                        <button data-bs-toggle="modal" data-bs-target="#enmodal">Book Free Class</button>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- eight box -->
    <section class="container-fluid py-lg-5 py-sm-4 py-3">
        <div class="container">
            <div class="row my-3">
                <div class="col-12">
                    <div class="dg-col text-center ">
                        <h2><!--Our Head Of Branch-->OUR HEAD OF BRANCH </h2>
                        <p>Lorem ipsum dolor sit amet consectetur Imperdiet tellus ut ornare pharetra.</p>
                    </div>
                </div>
            </div>

            <div class="row gy-4">
                <div class="col-lg-6 col-12">
                    <div class="bg-white py-3 px-4  align-items-start gap-3 studentsec shadow-lg">
                        <div class="d-flex mb-3">
                            <img src="photo/man.png" alt="" />
                            <div>
                                <h4>Matt Cannon</h4>
                                <p>September 1, 2023</p>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur. Arcu nisi diam <br /> eget id turpis donec et morbi.
                            Sit eu nisl non scelerisque <br />vestibulum pulvinar. Condimentum massa bibendum <br />
                            pretium tincidunt sed vel.</p>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="bg-white p-3  align-items-start gap-3 studentsec shadow-lg">
                        <div class="d-flex mb-3">
                            <img src="photo/man.png" alt="" />
                            <div>
                                <h4>Matt Cannon</h4>
                                <p>September 1, 2023</p>
                            </div>
                        </div>
                        <p class="dg-col">Lorem ipsum dolor sit amet consectetur. Arcu nisi diam <br /> eget id turpis
                            donec et morbi. Sit eu nisl non scelerisque <br />vestibulum pulvinar. Condimentum massa
                            bibendum <br /> pretium tincidunt sed vel.</p>
                    </div>
                </div>
            </div>

            <div class="row mt-5 poppup ">
                <div class="col-12 pop-1 pop-2">
                    <div class="text-center my-5  ">
                        <h4>Are You Ready To Start <br />Your Course?</h4>
                        <p>Lorem ipsum dolor sit amet consectetur. Arcu nisi diam eget id <br /> turpis donec et morbi.
                        </p>
                    </div>


                    <div class="poppup-button text-center mb-4">
                        <button data-bs-toggle="modal" data-bs-target="#enmodal">Download Curriculum</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Courses -->

    <section class="container-fluid py-lg-5 py-sm-4 py-3 our-course">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    
                    <div class="text-center  dg-col mb-5">
                        <h2 class="font-weight-bold">Our Courses</h2>
                        <p class="text-muted">Explore our range of expert-led courses designed to help you master the most in-demand technologies in the industry.</p>
                    </div>
                </div>
            </div>
            <div class="row gy-3">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="shadow-lg list">
                        <img src="photo/bootstrap.png" alt="">
                        <div class="mt-3 p-2">
                            <h5>Bootstrap</h5>
                            <p>
                                <b>Duration: </b> 55 Hour <br>
                                <b>Price: </b> 40000/- Rs
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="shadow-lg list">
                        <img src="photo/js.png" alt="">
                        <div class="mt-3 p-2">
                            <h5>Java Script</h5>
                            <p>
                                <b>Duration: </b> 55 Hour <br>
                                <b>Price: </b> 40000/- Rs
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="shadow-lg list">
                        <img src="photo/html.png" alt="">
                        <div class="mt-3 p-2">
                            <h5> HTML</h5>
                            <p>
                                <b>Duration: </b> 55 Hour <br>
                                <b>Price: </b> 40000/- Rs
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="shadow-lg list">
                        <img src="photo/css.png" alt="">
                        <div class="mt-3 p-2">
                            <h5>CSS</h5>
                            <p>
                                <b>Duration: </b> 55 Hour <br>
                                <b>Price: </b> 40000/- Rs
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="shadow-lg list">
                        <img src="photo/webd.png" alt="">
                        <div class="mt-3 p-2">
                            <h6 style="font-weight: 650;">Web Desing & Development</h6>
                            <p>
                                <b>Duration: </b> 55 Hour <br>
                                <b>Price: </b> 40000/- Rs
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="shadow-lg list">
                        <img src="photo/digitalmarketing.jpg" alt="">
                        <div class="mt-3 p-2">
                            <h5>Digital Marketing</h5>
                            <p>
                                <b>Duration: </b> 55 Hour <br>
                                <b>Price: </b> 40000/- Rs
                            </p>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- chatbot code start-->

    <div id="chatbot-icon"><i class="fa-solid fa-robot"></i></div>
    <div id="chatbot-container" class="hidden">

        <!-- header part -->
        <div id="chatbot-header">
            <span style="font-size:25px; font-weight: 900;">ChatBot</span>
            <button id="close-btn">&times;</button><!--&times; cross icons shortcut   -->
        </div>

        <!-- body part -->
        <div id="chatbot-body">
            <div id="chatbot-messages"></div>
        </div>

        <!-- jaha pe message type hoga or send hoga -->
        <div id="chatbot-input-container">
            <div id="file-preview"></div>
            <div class="main-input-area">
                <div class="input-wrapper">
                    <div id="chatbot-input" contenteditable="true"></div>
                    <button id="attach-btn" class="input-icon-btn"><i class="fa-solid fa-paperclip"></i></button>
                    <input type="file" id="file-input" hidden accept="image/*, .txt, .md">
                </div>
                <button id="send-btn"><i class="fa-solid fa-paper-plane"></i></button>
            </div>
        </div>
    </div>

    <!-- chatbot code end-->


    <footer style="background:url(photo/still-life-851328_1280.jpg) center/cover no-repeat">
        <div class="py-lg-5 py-sm-4 py-3  text-white" style="background: #000000d2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <h5>Useful links</h5>

                        <ul class="fa-ul ms-4">
                            <li><a href="pages/rules.php" class="text-light"><i class="fa-li fa fa-angle-right"></i>Rules & Regulations</a></li>
                            <li><a href="pages/about-page.php" class="text-light"><i class="fa-li fa fa-angle-right"></i>About Us</a>
                            </li>
                            <li><a href="pages/services-page.php" class="text-light"><i class="fa-li fa fa-angle-right "></i>Services</a>
                            </li>
                            <li><a href="pages/contact-page.php" class="text-light"><i class="fa-li fa fa-angle-right"></i>Contact Us</a></li>
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

                            <button class="btn btn-block " style="width: 50%; background-color: aqua; ">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </footer>





</body>
<script src="js/home_script.js?v=<?php echo filemtime(__DIR__ . '/js/home_script.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
    integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK"
    crossorigin="anonymous"></script>

</html>


