<?php
// Language switching logic
session_start();
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Set default language to Arabic and include the language file
$lang_file = '../lang_ar.php';
if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') {
    $lang_file = '../lang_en.php';
}
include($lang_file);

// بيانات تسجيل الدخول (يمكن تعديلها)
$admin_username = "admin";
$admin_password = "admin";

// عند إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION["admin_logged_in"] = true;
        header("Location: lang.php");
        exit();
    } else {
        $error = $lang['login_error'];
    }
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang['html_lang']; ?>" dir="<?php echo $lang['html_dir']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['admin_login']; ?> | <?php echo $lang['page_title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- شريط التنقل -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="../index.php"><?php echo $lang['navbar_brand']; ?></a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="../index.php"><?php echo $lang['nav_home']; ?></a></li>
            <li class="nav-item"><a class="nav-link" href="../events.php"><?php echo $lang['nav_events']; ?></a></li>
            <li class="nav-item"><a class="nav-link" href="../about.php"><?php echo $lang['nav_about']; ?></a></li>
            <li class="nav-item"><a class="nav-link" href="../contact.php"><?php echo $lang['nav_contact']; ?></a></li>
            <li class="nav-item d-flex align-items-center lang-switcher ms-lg-3">
                <a href="index.php?lang=ar" class="nav-link p-1 mx-1"><img src="https://flagcdn.com/w40/sy.png" alt="العربية" width="25"></a>
                <a href="index.php?lang=en" class="nav-link p-1 mx-1"><img src="https://flagcdn.com/w40/us.png" alt="English" width="25"></a>
            </li>
        </ul>
    </div>
</nav>

<!-- محتوى الصفحة -->
<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card shadow p-4" style="width: 360px; border-radius: 15px;">
        <h4 class="text-center mb-4 fw-bold"><?php echo $lang['admin_login']; ?></h4>

        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label"><?php echo $lang['username']; ?></label>
                <input type="text" name="username" class="form-control" placeholder="<?php echo ($_SESSION['lang'] == 'en') ? 'Enter username' : 'أدخل اسم المستخدم'; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label"><?php echo $lang['password']; ?></label>
                <input type="password" name="password" class="form-control" placeholder="<?php echo ($_SESSION['lang'] == 'en') ? 'Enter password' : 'أدخل كلمة المرور'; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100"><?php echo $lang['login_button']; ?></button>
        </form>
    </div>
</div>

<footer class="text-center py-3 mt-4 text-muted">
    <?php echo $lang['footer_copyright']; ?>
</footer>

</body>
</html>