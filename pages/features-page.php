
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Features - [Your Company Name]</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/media.css">
    <link rel="stylesheet" href="../css/pages/features-page.css">
</head>

<body>

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
                                            <a class="nav-link mx-lg-2" href="services-page.php">Services</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2 active" aria-current="page" href="features-page.php">Feature</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="course-page.php">Course</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-lg-2" href="contact-page.php">Contact</a>
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
            <div class="container mt-5 pt-4">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="display-4 fw-bold">Powerful Features for Your Success</h1>
                        <p class="lead text-muted">Discover the unique advantages that make our learning experience exceptional.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="container-fluid py-5" style="background-color: #F7FAFF;">
            <div class="container">
                <div class="row text-center mb-5">
                    <div class="col-12">
                        <h2 class="fw-bold">Why Choose Us?</h2>
                        <p class="text-muted">We offer features designed to ensure you not only learn but also succeed in your career.</p>
                    </div>
                </div>
                <div class="row gy-4 text-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="icon-container mb-3 ">
                                <i class="fa-solid fa-chalkboard-user "></i>
                            </div>
                            <h4 class="fw-semibold">Live Interactive Classes</h4>
                            <p class="text-muted">Engage in real-time with expert instructors, ask questions, and collaborate with peers for a dynamic learning experience.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="icon-container mb-3">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                            <h4 class="fw-semibold">100% Job Assistance</h4>
                            <p class="text-muted">Our dedicated placement team provides resume building, mock interviews, and connects you with top companies.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="icon-container mb-3">
                                <i class="fa-solid fa-laptop-file"></i>
                            </div>
                            <h4 class="fw-semibold">Hands-On Projects</h4>
                            <p class="text-muted">Build a strong portfolio by working on real-world projects that showcase your skills to potential employers.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="icon-container mb-3">
                                <i class="fa-solid fa-certificate"></i>
                            </div>
                            <h4 class="fw-semibold">Industry Certification</h4>
                            <p class="text-muted">Receive a globally recognized certificate upon course completion, validating your skills and knowledge.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="icon-container mb-3">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <h4 class="fw-semibold">Dedicated Mentorship</h4>
                            <p class="text-muted">Get one-on-one guidance and support from experienced mentors to resolve doubts and stay on track.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="icon-container mb-3">
                                <i class="fa-solid fa-infinity"></i>
                            </div>
                            <h4 class="fw-semibold">Lifetime Access</h4>
                            <p class="text-muted">Enjoy lifetime access to all course materials, including recorded lectures and resources, for continuous learning.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container-fluid py-5">
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-6 text-center">
                        <img src="../photo/guarantee.png" class="img-fluid rounded shadow" alt="Placement Support">
                    </div>
                    <div class="col-lg-6 text-center text-lg-start ">
                        <h2 class="fw-bold">Your Career, Our Commitment</h2>
                        <p class="text-muted mb-4">We are dedicated to your success beyond the classroom. Our comprehensive job assistance program is designed to bridge the gap between training and employment, ensuring you are fully prepared to enter the tech industry.</p>
                        
                        <ul class="feature-list list-unstyled d-inline-block text-start">
                            <li class="mb-3"><i class="fa-solid fa-circle-check text-primary me-2"></i><strong>Resume Building:</strong> Craft a professional resume that stands out to recruiters.</li>
                            <li class="mb-3"><i class="fa-solid fa-circle-check text-primary me-2"></i><strong>Mock Interviews:</strong> Practice with mock interviews to build your confidence.</li>
                            <li class="mb-3"><i class="fa-solid fa-circle-check text-primary me-2"></i><strong>Company Connections:</strong> Get access to our network of 320+ hiring partners.</li>
                            <li><i class="fa-solid fa-circle-check text-primary me-2"></i><strong>Career Guidance:</strong> Receive expert advice on your career path and opportunities.</li>
                        </ul>
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



