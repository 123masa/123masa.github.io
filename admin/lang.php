<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=City_events;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    die("فشل الاتصال بقاعدة البيانات: " . htmlentities($e->getMessage()));
}

session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل فعاليات المدينة - لوحة المدير</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: "Cairo", sans-serif;
            background: url('../img/bg.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        img.event-thumb {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
        }
        .table-wrap {
            overflow-x: auto;
            background: rgba(255,255,255,0.9);
            padding: 15px;
            border-radius: 10px;
        }
        .navbar {
            background-color: #8d128bff !important;
        }
        h2, h5 {
            color: #ff00eaff;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="/myproject/index.html">
                    <img src="../img/logo.png" alt="شعار" width="40" height="40" class="d-inline-block align-text-top me-2">
                    دليل فعاليات المدينة
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                       <li class="nav-item"><a class="nav-link active" href="/myproject/admin/manager.php">لوحة المدير</a></li>
                       <li class="nav-item"><a class="nav-link" href="/myproject/index.php">الرئيسية</a></li>
                       <li class="nav-item"><a class="nav-link" href="/myproject/events.php">الفعاليات</a></li>
                       <li class="nav-item"><a class="nav-link" href="/myproject/about.php">عن الدليل</a></li>
                       <li class="nav-item"><a class="nav-link" href="/myproject/contact.php">اتصل بنا</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <section class="mb-4 text-center">
            <h2 class="fw-bold">إدارة الفعاليات</h2>
            <p class="text-muted">هنا يمكنك عرض، تعديل أو حذف الفعاليات الموجودة في قاعدة البيانات.</p>
        </section>

        <div class="card p-3 mb-4 shadow">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">قائمة الفعاليات</h5>
                <a href="add.php" class="btn btn-success">➕ إضافة فعالية جديدة</a>
            </div>

            <div class="table-wrap">
                <?php
                // استعلام آمن لجلب جميع الفعاليات
                try {
                    $stmt = $pdo->query("SELECT * FROM evente ORDER BY id DESC");
                } catch (PDOException $e) {
                    echo '<div class="alert alert-danger">خطأ في جلب البيانات: ' . htmlentities($e->getMessage()) . '</div>';
                    $stmt = false;
                }

                if ($stmt && $stmt->rowCount() > 0) {
                    echo '<table class="table table-bordered table-striped text-center align-middle">';
                    echo '<thead class="table-primary"><tr>';
                    echo '<th>الرقم</th><th>العنوان</th><th>الوصف</th><th>التصنيف</th><th>الموقع</th><th>التاريخ</th><th>الصورة</th><th>إجراءات</th>';
                    echo '</tr></thead><tbody>';

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = (int)$row['id'];
                        $title = htmlentities($row['title']);
                        $desc = htmlentities($row['description']);
                        $cat = htmlentities($row['category']);
                        $loc = htmlentities($row['location']);
                        $date = htmlentities($row['event_date']);
                        $imagePath = htmlentities($row['image']);
                        $imgSrc = '../' . ltrim($imagePath, '/');

                        echo '<tr>';
                        echo "<td>{$id}</td>";
                        echo "<td>{$title}</td>";
                        echo "<td>{$desc}</td>";
                        echo "<td>{$cat}</td>";
                        echo "<td>{$loc}</td>";
                        echo "<td>{$date}</td>";
                        echo "<td><img src=\"" . $imgSrc . "\" alt=\"{$title}\" class=\"event-thumb\"></td>";
                        echo '<td>';
                        echo '<a class="btn btn-sm btn-warning me-1" href="edit.php?id=' . $id . '">تعديل</a>';
                        echo '<a class="btn btn-sm btn-danger" href="delete.php?id=' . $id . '" onclick="return confirm(\'هل تريد حذف هذه الفعالية؟\')">حذف</a>';
                        echo '</td>';
                        echo '</tr>';
                    }

                    echo '</tbody></table>';
                } else {
                    echo '<div class="alert alert-info">لا توجد فعاليات حالياً.</div>';
                }
                ?>
            </div>
        </div>
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
                        <li><a href="/myproject/index.php" class="text-white">الرئيسية</a></li>
                        <li><a href="/myproject/events.php" class="text-white">الفعاليات</a></li>
                        <li><a href="/myproject/about.php" class="text-white">عن الدليل</a></li>
                        <li><a href="/myproject/contact.php" class="text-white">اتصل بنا</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>تواصل معنا</h5>
                    <p>البريد الإلكتروني:esraaaj45@gmailcom</p>
                    <p>الهاتف: 0875435686
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">© 2025 دليل فعاليات المدينة. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>