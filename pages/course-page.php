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
    <title>Courses - Computer Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Poppins:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/media.css">
    <link rel="stylesheet" href="../css/pages/course-page.css">
    
    <style>

    </style>
</head>

<body>
    <!-- pop-pup form 1 -->
    <div class="modal fade" id="enmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h1 class="modal-title fs-5">Enquire Now</h1><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
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
                <div class="modal-header"><h1 class="modal-title fs-5">Book Demo Class Register Now</h1><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
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

    <!-- pop-pup form 3 -->
    <div class="modal fade" id="courseDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title" id="courseTitle">Course Name</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row course-info">
                        <div class="col-lg-6 text-center"><img src="" class="img-fluid rounded mb-3" alt="Course Image" id="courseImage"><div id="courseMeta"></div></div>
                        <div class="col-lg-6">
                            <h4 class="mb-3">Course Overview</h4><p id="courseOverview"></p>
                            <h4 class="mt-4 mb-3">Key Highlights</h4><ul id="courseHighlights" class="list-unstyled"></ul>
                            <div class="mt-4 text-center"><button class="btn cerbutton" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#enmodal">Book A Free Demo</button></div>
                        </div>
                    </div>
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
                            <a class="navbar-brand me-auto brand-logo" href="../index.php"><img src="../photo/logo.jpg" alt="Logo"></a>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">
                                <div class="offcanvas-header brand-logo">
                                    <h5 class="offcanvas-title"><img src="../photo/logo.jpg" alt="Logo"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                                        <li class="nav-item"><a class="nav-link mx-lg-2" href="../index.php">Home</a></li>
                                        <li class="nav-item"><a class="nav-link mx-lg-2" href="../pages/about-page.php">About</a></li>
                                        <li class="nav-item"><a class="nav-link mx-lg-2" href="../pages/services-page.php">Services</a></li>
                                        <li class="nav-item"><a class="nav-link mx-lg-2" href="../pages/features-page.php">Feature</a></li>
                                        <li class="nav-item"><a class="nav-link mx-lg-2 active" aria-current="page" href="#">Courses</a></li>
                                        <li class="nav-item"><a class="nav-link mx-lg-2" href="../pages/contact-page.php">Contact</a></li>
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
                            <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"><span class="navbar-toggler-icon"></span></button>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    
    <section class="container-fluid courses-hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Explore Our Top Computer Courses</h1>
                    <p class="lead">Discover the right path for your career with our industry-led and practical-oriented computer courses. From web development to data science, we have a course for you.</p>
                </div>
            </div>
        </div>
    </section>
    
    <section class="container courses-section text-center">
        <div class="section-title">
            <h2>Our Course Catalog</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="course-card" data-bs-toggle="modal" data-bs-target="#courseDetailModal" data-course-id="webDev">
                    <img src="../photo/webd.png" alt="Web Development Course">
                    <div class="course-card-body">
                        <h5>Web Designing & Development</h5>
                        <p>Build stunning, responsive websites and dynamic web applications from scratch.</p>
                        <div class="course-card-meta"><b>Duration:</b> 6 months | <b>Price:</b> ?40,000</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="course-card" data-bs-toggle="modal" data-bs-target="#courseDetailModal" data-course-id="digitalMarketing">
                    <img src="../photo/digitalmarketing.jpg" alt="Digital Marketing Course">
                    <div class="course-card-body">
                        <h5>Digital Marketing Professional</h5>
                        <p>Master the art of online promotion with SEO, social media, and content marketing.</p>
                        <div class="course-card-meta"><b>Duration:</b> 5 months | <b>Price:</b> ?35,000</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="course-card" data-bs-toggle="modal" data-bs-target="#courseDetailModal" data-course-id="dataScience">
                    <img src="../photo/data-science.jpeg" alt="Data Science Course">
                    <div class="course-card-body">
                        <h5>Data Science & Analytics</h5>
                        <p>Learn to analyze data, build models, and make data-driven decisions for businesses.</p>
                        <div class="course-card-meta"><b>Duration:</b> 8 months | <b>Price:</b> ?60,000</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="course-card" data-bs-toggle="modal" data-bs-target="#courseDetailModal" data-course-id="fullStack">
                    <img src="../photo/full-stack.png" alt="Full Stack Development Course">
                    <div class="course-card-body">
                        <h5>Full Stack Development</h5>
                        <p>Master both front-end and back-end development to build complete web applications.</p>
                        <div class="course-card-meta"><b>Duration:</b> 9 months | <b>Price:</b> ?75,000</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="course-card" data-bs-toggle="modal" data-bs-target="#courseDetailModal" data-course-id="uiuxDesign">
                    <img src="../photo/ul-ux-img.png" alt="UI/UX Design Course">
                    <div class="course-card-body">
                        <h5>UI/UX Design Professional</h5>
                        <p>Design user-friendly interfaces and engaging experiences.</p>
                        <div class="course-card-meta"><b>Duration:</b> 4 months | <b>Price:</b> ?30,000</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="course-card" data-bs-toggle="modal" data-bs-target="#courseDetailModal" data-course-id="pythonAI">
                    <img src="../photo/python-pro.png" alt="Python for AI & ML Course">
                    <div class="course-card-body">
                        <h5>Python for AI & ML</h5>
                        <p>Learn Python programming to build and deploy artificial intelligence and machine learning models.</p>
                        <div class="course-card-meta"><b>Duration:</b> 7 months | <b>Price:</b> ?55,000</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="course-card" data-bs-toggle="modal" data-bs-target="#courseDetailModal" data-course-id="computerBasic">
                    <img src="../photo/com-basic.jpeg" alt="Computer Basic Course">
                    <div class="course-card-body">
                        <h5>Computer Basic Course</h5>
                        <p>Learn the fundamental skills needed to use a computer effectively for daily tasks.</p>
                        <div class="course-card-meta"><b>Duration:</b> 3 months | <b>Price:</b> ?15,000</div>
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
                            <li><a href="../pages/rules.php" class="text-light text-decoration-none"><i class="fa-li fa fa-angle-right"></i>Rules & Regulations</a></li>
                            <li><a href="../pages/about-page.php" class="text-light text-decoration-none"><i class="fa-li fa fa-angle-right"></i>About Us</a></li>
                            <li><a href="../pages/services-page.php" class="text-light text-decoration-none"><i class="fa-li fa fa-angle-right"></i>Services</a></li>
                            <li><a href="../pages/contact-page.php" class="text-light text-decoration-none"><i class="fa-li fa fa-angle-right"></i>Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h5>Social Presence</h5>
                        <div>
                            <span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa-brands fa-facebook-f fa-stack-1x fa-inverse text-dark"></i></span>
                            <span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa-brands fa-instagram fa-stack-1x fa-inverse text-dark"></i></span>
                            <span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa-brands fa-twitter fa-stack-1x fa-inverse text-dark"></i></span>
                            <span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa-brands fa-github fa-stack-1x fa-inverse text-dark"></i></span>
                            <span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa-brands fa-youtube fa-stack-1x fa-inverse text-dark"></i></span>
                            <span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa-brands fa-linkedin fa-stack-1x fa-inverse text-dark"></i></span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <h5>Subscribe Now</h5>
                        <form action="">
                            <div class="mb-3"><input type="email" id="email-s" class="form-control" placeholder="Your Email"><label for="email-s" class="visually-hidden">Your Email </label></div>
                            <button class="btn btn-info">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Data for each course to be displayed in the modal
        const courses = {
            webDev: {
                title: 'Professional Web Designing & Development',
                image: '../photo/webd.png',
                meta: '<b>Duration:</b> 6 months | <b>Price:</b> ?40,000 | <b>Format:</b> Online/Offline',
                overview: 'This comprehensive course covers everything from basic HTML and CSS to advanced JavaScript frameworks like React. You will learn to create responsive, dynamic, and professional-looking websites. The curriculum includes hands-on projects to build your portfolio.',
                highlights: [
                    'Master HTML5, CSS3, and Bootstrap for modern design.',
                    'Learn JavaScript fundamentals and advanced concepts.',
                    'Build real-world projects with a focus on UX/UI.',
                    'Get career support and interview preparation.',
                    'Learn responsive design for all devices.'
                ]
            },
            digitalMarketing: {
                title: 'Professional Digital Marketing Course',
                image: '../photo/digitalmarketing.jpg',
                meta: '<b>Duration:</b> 5 months | <b>Price:</b> ?35,000 | <b>Format:</b> Online',
                overview: 'Our Digital Marketing course teaches you the skills to drive online growth. You will cover a wide range of topics, including search engine optimization (SEO), social media marketing, content creation, and analytics. Get ready to become a certified digital marketer!',
                highlights: [
                    'Comprehensive SEO and SEM training.',
                    'Social Media Strategy and Management.',
                    'Content Marketing and creation.',
                    'Email Marketing and campaign management.',
                    'Google Analytics and data interpretation.'
                ]
            },
            dataScience: {
                title: 'Data Science & Analytics Professional',
                image: '../photo/data-science.jpeg',
                meta: '<b>Duration:</b> 8 months | <b>Price:</b> ?60,000 | <b>Format:</b> Online/Offline',
                overview: 'Become a data professional with our in-depth course. This program focuses on statistical analysis, machine learning, and data visualization using Python and R. You will learn to solve complex business problems and make informed decisions using data.',
                highlights: [
                    'Python and R for data analysis.',
                    'Machine Learning algorithms and implementation.',
                    'Data cleaning, visualization, and manipulation.',
                    'Hands-on projects and case studies.',
                    'Job placement assistance and career mentorship.'
                ]
            },
            fullStack: {
                title: 'Full Stack Web Development',
                image: '../photo/full-stack.png',
                meta: '<b>Duration:</b> 9 months | <b>Price:</b> ?75,000 | <b>Format:</b> Online/Offline',
                overview: 'This course provides a complete journey into web development, teaching you both front-end (what users see) and back-end (what makes a website work) technologies. You will build and deploy a fully functional web application from start to finish.',
                highlights: [
                    'Master HTML, CSS, and JavaScript for the front-end.',
                    'Learn back-end languages like Node.js and Python.',
                    'Work with databases like MongoDB and SQL.',
                    'Build a complete project portfolio with real-world applications.',
                    'Learn deployment and server management.'
                ]
            },
            uiuxDesign: {
                title: 'UI/UX Design Professional',
                image: '../photo/ul-ux-img.png',
                meta: '<b>Duration:</b> 4 months | <b>Price:</b> ?30,000 | <b>Format:</b> Online',
                overview: 'In this course, you will focus on the principles of User Experience (UX) and User Interface (UI) design. You will learn how to create intuitive, user-friendly, and visually appealing digital products, from wireframing to high-fidelity mockups.',
                highlights: [
                    'Conduct user research and create user personas.',
                    'Master wireframing, prototyping, and user testing.',
                    'Use industry-standard tools like Figma or Adobe XD.',
                    'Learn visual design principles and color theory.',
                    'Build a strong portfolio of design projects.'
                ]
            },
            pythonAI: {
                title: 'Python for AI & ML',
                image: '../photo/python-pro.png',
                meta: '<b>Duration:</b> 7 months | <b>Price:</b> ?55,000 | <b>Format:</b> Online',
                overview: 'This course is your gateway to the world of Artificial Intelligence and Machine Learning. Using Python, you will learn to implement key algorithms, work with large datasets, and build intelligent systems that can learn and adapt.',
                highlights: [
                    'Learn Python programming and libraries like NumPy and Pandas.',
                    'Understand core AI and machine learning concepts.',
                    'Build and train your own machine learning models.',
                    'Work on hands-on projects, from chatbots to image recognition.',
                    'Explore the ethics and applications of AI.'
                ]
            },
            computerBasic: {
                title: 'Computer Basic Course',
                image: '../photo/com-basic.jpeg',
                meta: '<b>Duration:</b> 3 months | <b>Price:</b> ?15,000 | <b>Format:</b> Offline',
                overview: 'This course is perfect for beginners who want to get a solid foundation in computer fundamentals. You will learn essential skills for both personal and professional use, including working with operating systems, software applications, and basic hardware.',
                highlights: [
                    'Master Microsoft Office Suite (Word, Excel, PowerPoint).',
                    'Learn file management and organization.',
                    'Understand internet basics and email management.',
                    'Introduction to basic hardware and troubleshooting.',
                    'Develop essential typing and navigation skills.'
                ]
            }
        };

        const courseDetailModal = document.getElementById('courseDetailModal');
        courseDetailModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const courseId = button.getAttribute('data-course-id');
            const course = courses[courseId];

            if (course) {
                document.getElementById('courseTitle').innerText = course.title;
                document.getElementById('courseImage').src = course.image;
                document.getElementById('courseImage').alt = course.title;
                document.getElementById('courseMeta').innerHTML = course.meta;
                document.getElementById('courseOverview').innerText = course.overview;

                const highlightsList = document.getElementById('courseHighlights');
                highlightsList.innerHTML = '';
                course.highlights.forEach(item => {
                    const li = document.createElement('li');
                    li.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${item}`;
                    highlightsList.appendChild(li);
                });
            }
        });

        function handleRedirect(select) {
            if (select.value === "Admin") {
                window.location.href = "../admin_login.php";
            } else if (select.value === "Users") {
                window.location.href = "../login.php";
            }
        }

        // Reset dropdown on page load/show
        function resetDropdown() {
            const roleDropdown = document.getElementById("role");
            if (roleDropdown) {
                roleDropdown.selectedIndex = 0;
            }
        }
        window.addEventListener("load", resetDropdown);
        window.addEventListener("pageshow", resetDropdown);

    </script>
</body>
</html>


