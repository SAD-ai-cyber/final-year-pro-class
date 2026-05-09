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
    <title>Our Services - [Your Company Name]</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/media.css">
    <link rel="stylesheet" href="../css/pages/services-page.css">
</head>

<body>

    <!-- pop-pup form 1 -->
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

    <!-- pop-pup form 2 -->
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
                                <img src="../photo/logo.jpg">
                            </a>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">
                                <div class="offcanvas-header brand-logo">
                                    <h5 class="offcanvas-title"><img src="../photo/logo.jpg"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="../index.php">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="about-page.php">About</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2 active" aria-current="page" href="services-page.php">Services</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="features-page.php">Feature</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="../pages/course-page.php">Course</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="../pages/contact-page.php">Contact</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="login-button">
                                <select name="role" id="role" class="login-button" onchange="handleRedirect(this)">
                                    <option value="">Login-Option</option>
                                    <option value="Admin">Institute-Login</option>
                                    <option value="Users">Users-login</option>
                                </select>
                            </div>
                            <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasNavbar">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <main>
        <section class="container-fluid page-banner">
            <div class="container">
                <div class="row ">
                    <div class="col-12 text-center">
                        <h1 class="display-4 fw-bold">Our Services</h1>
                        <p class="lead text-muted">Explore our comprehensive range of courses designed to launch your career in technology.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="container-fluid py-5" style="background-color: #F7FAFF;">
            <div class="container">
                <div class="row text-center mb-5">
                    <div class="col-12">
                        <h2 class="fw-bold">Explore Our Offerings</h2>
                        <p class="text-muted">We provide world-class training in a variety of high-demand tech fields.</p>
                    </div>
                </div>
                <div class="row gy-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card text-center">
                            <div class="icon-container mb-3">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                            <h4 class="fw-semibold">Web Development</h4>
                            <p class="text-muted">Master front-end and back-end technologies to build modern, responsive websites and applications from scratch.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card text-center">
                            <div class="icon-container mb-3">
                                <i class="fa-solid fa-brain"></i>
                            </div>
                            <h4 class="fw-semibold">Artificial Intelligence</h4>
                            <p class="text-muted">Dive into machine learning, deep learning, and data science to create intelligent systems and solve complex problems.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card text-center">
                            <div class="icon-container mb-3">
                                <i class="fa-solid fa-bullhorn"></i>
                            </div>
                            <h4 class="fw-semibold">Digital Marketing</h4>
                            <p class="text-muted">Learn SEO, SEM, social media marketing, and content strategy to grow online businesses and drive engagement.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card text-center">
                            <div class="icon-container mb-3">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <h4 class="fw-semibold">Cyber Security</h4>
                            <p class="text-muted">Understand network security, ethical hacking, and threat analysis to protect digital assets from cyber attacks.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card text-center">
                            <div class="icon-container mb-3">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <h4 class="fw-semibold">Cloud Computing</h4>
                            <p class="text-muted">Get hands-on experience with AWS, Azure, and Google Cloud to deploy and manage scalable applications.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card text-center">
                            <div class="icon-container mb-3">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                            </div>
                            <h4 class="fw-semibold">App Development</h4>
                            <p class="text-muted">Build beautiful and functional native applications for both Android and iOS platforms using the latest frameworks.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container-fluid py-5">
            <div class="container">
                <div class="row text-center mb-5">
                    <div class="col-12">
                        <h2 class="fw-bold">Our Simple 4-Step Process</h2>
                        <p class="text-muted">From consultation to placement, we make your journey seamless and effective.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="process-step">
                            <div class="step-number-container">
                                <div class="step-number">01</div>
                            </div>
                            <h5 class="fw-semibold mt-3">Free Consultation</h5>
                            <p class="text-muted">We discuss your career goals to find the perfect course for you.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="process-step">
                            <div class="step-number-container">
                                <div class="step-number">02</div>
                            </div>
                            <h5 class="fw-semibold mt-3">Live Training</h5>
                            <p class="text-muted">Join interactive live classes led by industry experts.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="process-step">
                            <div class="step-number-container">
                                <div class="step-number">03</div>
                            </div>
                            <h5 class="fw-semibold mt-3">Real-World Projects</h5>
                            <p class="text-muted">Apply your skills by building projects for your portfolio.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="process-step">
                            <div class="step-number-container">
                                <div class="step-number">04</div>
                            </div>
                            <h5 class="fw-semibold mt-3">Job Assistance</h5>
                            <p class="text-muted">We help with your resume, interviews, and job placement.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="container-fluid py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 poppup">
                        <div class="text-center my-5">
                            <h2 class="text-white fw-bold">Ready To Start Your Tech Career?</h2>
                            <p class="text-white-50">Join thousands of successful students who launched their careers with us.</p>
                            <div class="poppup-button text-center mt-4">
                                <button class="btn btn-light fs-5 fw-bold px-5 py-2" data-bs-toggle="modal" data-bs-target="#enmodal">Enquire Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <footer style="background:url(../photo/still-life-851328_1280.jpg) center/cover no-repeat">
        <div class="py-lg-5 py-sm-4 py-3 text-white" style="background: #000000d2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <h5>Useful links</h5>
                        <ul class="fa-ul ms-4">
                            <li><a href="../pages/rules.php" class="text-light text-decoration-none"><i class="fa-li fa fa-angle-right"></i>Rules & Regulations</a></li>
                            <li><a href="../pages/about-page.php" class="text-light text-decoration-none"><i class="fa-li fa fa-angle-right"></i>About Us</a></li>
                            <li><a href="../pages/services-page.php" class="text-light text-decoration-none"><i class="fa-li fa fa-angle-right"></i>Services</a></li>
                            <li><a href="../pages/contact-page.php" class="text-light text-decoration-none"><i class="fa-li fa fa-angle-right"></i>Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <h5>Social Presence</h5>
                        <div>
                            <span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa-brands fa-facebook-f fa-stack-1x fa-inverse text-dark"></i></span>
                            <span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa-brands fa-instagram fa-stack-1x fa-inverse text-dark"></i></span>
                            <span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa-brands fa-twitter fa-stack-1x fa-inverse text-dark"></i></span>
                            <span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa-brands fa-github fa-stack-1x fa-inverse text-dark"></i></span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5>Subscribe Now</h5>
                        <form action="#">
                            <div class="mb-3">
                                <input type="email" placeholder="Your Email" class="form-control">
                            </div>
                            <button class="btn btn-info">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
</body>
<script>
    
function handleRedirect(select) {
    if (select.value === "Admin") {
        window.location.href = "../admin_login.php";
    } 
    else if (select.value === "Users") {
        window.location.href = "../login.php";
    }
}

// Page load hone per dropdown reset hoga
window.addEventListener("load", resetDropdown);
window.addEventListener("pageshow", resetDropdown);
window.addEventListener("focus", resetDropdown);

function resetDropdown() {
    const roleDropdown = document.getElementById("role");
    if (roleDropdown) {
        roleDropdown.selectedIndex = 0; // First option select karegaa
    }
}

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</html>



