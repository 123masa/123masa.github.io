<?php 
 $pdo=new PDO('mysql:host=localhost;dbname=city_events;charset=utf8mb4','root', ''); 
session_start();

 ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل فعاليات المدينة</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
   
</head>

<body>
    <!-- Header Section -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="../index.html">
                    <img src="../img/logo.png" alt="شعار دليل فعاليات المدينة" width="40" height="40" class="d-inline-block align-text-top me-2"> دليل فعاليات المدينة
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="../index.html">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../events.html">الفعاليات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../about.html">عن الدليل</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../contact.html">اتصل بنا</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <!-- Hero Section -->
        <section class="hero-section mb-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold text-primary">اكتشف الفعاليات القادمة في مدينتك</h1>
                    <p class="lead">دليلك الشامل لأهم الفعاليات الثقافية، الرياضية، الفنية والترفيهية في المدينة</p>
                    <a href="events.html" class="btn btn-primary btn-lg mt-3">استعرض جميع الفعاليات</a>
                </div>
                <div class="col-md-6">
                    <div id="eventsCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="../img/event1.jpg" class="d-block w-100 rounded" alt="فعالية ثقافية">
                            </div>
                            <div class="carousel-item">
                                <img src="../img/event2.jpg" class="d-block w-100 rounded" alt="فعالية رياضية">
                            </div>
                            <div class="carousel-item">
                                <img src="../img/event3.jpg" class="d-block w-100 rounded" alt="فعالية فنية">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

            <?php 

 


    $sql = "DELETE FROM evente WHERE id = :zip"; 
    $stmt = $pdo->prepare($sql); 
    $stmt->execute(array(':zip' => $_GET['id'])); 
    $_SESSION['success'] = 'Record deleted'; 
    header( 'Location: lang.php' ) ; 
    

 ?>
    </main>

    <!-- Footer Section -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>دليل فعاليات المدينة</h5>
                    <p>منصة شاملة للتعريف بجميع الفعاليات والأنشطة في المدينة.</p>
                </div>
                <div class="col-md-4">
                    <h5>روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="../index.html" class="text-white">الرئيسية</a></li>
                        <li><a href="../events.html" class="text-white">الفعاليات</a></li>
                        <li><a href="../about.html" class="text-white">عن الدليل</a></li>
                        <li><a href="../contact.html" class="text-white">اتصل بنا</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>تواصل معنا</h5>
                    <p>البريد الإلكتروني: info@cityevents.com</p>
                    <p>الهاتف: 0123456789</p>
                    <div class="social-links">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">© 2025 دليل فعاليات المدينة. جميع الحقوق محفوظة.</p>
                <p>تم إنشاء هذا الموقع كجزء من مشروع مقرر BWP401</p>
                <p>فريق العمل: [أسماء الطلاب]</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Custom JS -->
    <script src="../js/main.js"></script>
</body>

</html>