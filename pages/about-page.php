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
    <title>About Us - Computer Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/media.css">
    <link rel="stylesheet" href="../css/pages/about-page.css">
   
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
                                            <a class="nav-link mx-lg-2 active" aria-current="page" href="#">About</a>
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
    <section class="container-fluid about-us-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <!-- Image removed as requested -->
                </div>
                <div class="col-lg-6">
                    <div class="about-content">
                        <h2>About Our Computer Classes</h2>
                        <p>Welcome to our computer class, where we are dedicated to providing high-quality education and
                            training in the field of technology. Our mission is to empower students with the skills and
                            knowledge needed to succeed in today's digital world. We believe that everyone should have
                            access to quality tech education, and we have designed our curriculum to be accessible and
                            impactful.</p>
                        <ul class="about-list text-start">
                            <li><i class="fa-solid fa-circle-check"></i> Expert-led courses by industry professionals.
                            </li>
                            <li><i class="fa-solid fa-circle-check"></i> Practical, hands-on training with real-world
                                projects.</li>
                            <li><i class="fa-solid fa-circle-check"></i> A structured curriculum that covers the latest
                                technologies.</li>
                            <li><i class="fa-solid fa-circle-check"></i> Career guidance and job assistance to help you
                                get placed.</li>
                            <li><i class="fa-solid fa-circle-check"></i> Flexible learning options, including online and
                                in-person classes.</li>
                        </ul>
                        <button class="btn cerbutton mt-3" data-bs-toggle="modal" data-bs-target="#enmodal">Book A Free
                            Demo</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid stats-section text-center">
        <div class="container">
            <div class="row row-cols-lg-4 row-cols-sm-2 row-cols-1 g-4">
                <div class="col">
                    <div class="stats-item">
                        <h2 class="counter">1000+</h2>
                        <p>Students Trained</p>
                    </div>
                </div>
                <div class="col">
                    <div class="stats-item">
                        <h2 class="counter">50+</h2>
                        <p>Expert Instructors</p>
                    </div>
                </div>
                <div class="col">
                    <div class="stats-item">
                        <h2 class="counter">95%</h2>
                        <p>Placement Rate</p>
                    </div>
                </div>
                <div class="col">
                    <div class="stats-item">
                        <h2 class="counter">10+</h2>
                        <p>Years in Industry</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid our-story-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="story-content">
                        <h3>Our Journey to Excellence</h3>
                        <p>Our story began over a decade ago with a simple goal: to bridge the gap between academic knowledge and industry demands. We saw a need for practical, job-oriented computer education that goes beyond theory. Since then, we have evolved into a leading institution, training thousands of students and helping them achieve their dream careers.</p>
                        <p>From our first small classroom to a state-of-the-art learning center, our commitment to our students has remained our top priority. We are proud of the community we have built and the success stories our students have created.</p>
                        <button class="btn cerbutton mt-3" data-bs-toggle="modal" data-bs-target="#demomodal">Join Our Community</button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- Image removed as requested -->
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid our-mission-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <div class="mission-content">
                        <h3>Our Mission & Values</h3>
                        <p>We believe in fostering a learning environment that is both challenging and supportive. Our
                            core values guide us in everything we do, ensuring that our students receive the best
                            possible education.</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                <div class="col-lg-4 col-sm-6">
                    <div class="mission-item">
                        <i class="fa-solid fa-lightbulb"></i>
                        <h5>Innovation</h5>
                        <p>We are committed to staying at the forefront of technology, constantly updating our courses
                            to reflect the latest industry trends and provide a cutting-edge curriculum.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="mission-item">
                        <i class="fa-solid fa-handshake"></i>
                        <h5>Excellence</h5>
                        <p>Our goal is to deliver excellence in every aspect of our training, from the quality of our
                            instructors to the effectiveness of our curriculum.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="mission-item">
                        <i class="fa-solid fa-user-gear"></i>
                        <h5>Empowerment</h5>
                        <p>We strive to empower our students, giving them the confidence and skills they need to achieve
                            their professional aspirations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid meet-team-section text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-5">
                    <h3 class="dg-col">Meet Our Expert Instructors</h3>
                    <p class="dg-col">Our team of experienced professionals is dedicated to your success. Learn from the best in the industry.</p>
                </div>
            </div>
            <div class="row gy-4">
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <img src="../photo/man.png" alt="Name 1">
                        <h5>Name 1</h5>
                        <p>Lead Instructor, AI</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <img src="../photo/man.png" alt="Name 2">
                        <h5>Name 2</h5>
                        <p>Web Development Expert</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <img src="../photo/man.png" alt="Name 3">
                        <h5>Name3</h5>
                        <p>Cybersecurity Specialist</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <img src="../photo/man.png" alt="Name 4">
                        <h5>Name 4</h5>
                        <p>Data Science Professional</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid py-lg-5 py-sm-4 py-3">
        <div class="container">
            <div class="row mt-5 poppup">
                <div class="col-12 pop-1 pop-2">
                    <div class="text-center my-5">
                        <h4>Are You Ready To Start <br />Your Course?</h4>
                        <p>Take the first step towards a rewarding career in technology. We're here to help you succeed.</p>
                    </div>
                    <div class="poppup-button text-center mb-4">
                        <button data-bs-toggle="modal" data-bs-target="#enmodal">Download Curriculum</button>
                    </div>
                </div>
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
                            <li><a href="../pages/rules.php" class="text-light"><i class="fa-li fa fa-angle-right"></i>Rules & Regulations</a></li>
                            <li><a href="../pages/about-page.php" class="text-light"><i class="fa-li fa fa-angle-right"></i>About Us</a></li>
                            <li><a href="../pages/services-page.php" class="text-light"><i class="fa-li fa fa-angle-right "></i>Services</a></li>
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
    

</body>
<script >
    

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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
    integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK"
    crossorigin="anonymous"></script>

</html>


