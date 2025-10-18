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

// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=city_events;charset=utf8mb4','root', ''); 
?>
<!DOCTYPE html>
<html lang="<?php echo $lang['html_lang']; ?>" dir="<?php echo $lang['html_dir']; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['add_new_event']; ?> - <?php echo $lang['page_title']; ?></title>
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
                <a class="navbar-brand" href="../index.php">
                    <img src="../img/logo.png" alt="<?php echo $lang['navbar_brand']; ?>" width="40" height="40" class="d-inline-block align-text-top me-2"> <?php echo $lang['navbar_brand']; ?>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                       <li class="nav-item">
                            <a class="nav-link" href="../index.php"><?php echo $lang['nav_home']; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../events.php"><?php echo $lang['nav_events']; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../about.php"><?php echo $lang['nav_about']; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../contact.php"><?php echo $lang['nav_contact']; ?></a>
                        </li>
                        <li class="nav-item d-flex align-items-center lang-switcher ms-lg-3">
                            <a href="add.php?lang=ar" class="nav-link p-1 mx-1"><img src="https://flagcdn.com/w40/sy.png" alt="العربية" width="25"></a>
                            <a href="add.php?lang=en" class="nav-link p-1 mx-1"><img src="https://flagcdn.com/w40/us.png" alt="English" width="25"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <!-- Add Event Form Section -->
        <section class="mb-5">
            <h1 class="text-center mb-4"><?php echo $lang['add_new_event']; ?></h1>
            
            <?php 
            if ( isset($_POST['title']) && isset($_POST['description']) 
                 && isset($_POST['category'])&& isset($_POST['location'])&& isset($_POST['event_date'])&& isset($_POST['image'])) { 
                // Data validation 
                $sql = "INSERT INTO evente (title, description, category,location,event_date,image) 
                          VALUES (:title, :description, :category, :location, :event_date, :image)"; 
                $stmt = $pdo->prepare($sql); 
                $stmt->execute(array( 
                    ':title' => $_POST['title'], 
                    ':description' => $_POST['description'], 
                    ':category' => $_POST['category'],
                    ':location' => $_POST['location'], 
                    ':event_date' => $_POST['event_date'], 
                    ':image' => $_POST['image'])); 
                
                $_SESSION['success'] = 'Record Added'; 
                header( 'Location: lang.php' ) ; 
                return; 
            } 
             
            // Flash pattern 
            if ( isset($_SESSION['error']) ) { 
                echo '<div class="alert alert-danger">'.$_SESSION['error']."</div>\n"; 
                unset($_SESSION['error']); 
            } 
            ?> 
            
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><?php echo $lang['add_new_event']; ?></h5>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label for="title" class="form-label"><?php echo $lang['event_title']; ?></label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label"><?php echo $lang['event_description']; ?></label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="category" class="form-label"><?php echo $lang['event_category']; ?></label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value=""><?php echo ($_SESSION['lang'] == 'en') ? 'Select Category' : 'اختر التصنيف'; ?></option>
                                        <option value="ثقافة"><?php echo $lang['category_culture']; ?></option>
                                        <option value="رياضة"><?php echo $lang['category_sports']; ?></option>
                                        <option value="موسيقى"><?php echo $lang['category_music']; ?></option>
                                        <option value="تعليم"><?php echo $lang['category_education']; ?></option>
                                        <option value="ترفيه"><?php echo $lang['category_entertainment']; ?></option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="location" class="form-label"><?php echo $lang['event_location']; ?></label>
                                    <input type="text" class="form-control" id="location" name="location" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="event_date" class="form-label"><?php echo $lang['event_date']; ?></label>
                                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="image" class="form-label"><?php echo $lang['event_image']; ?></label>
                                    <input type="text" class="form-control" id="image" name="image" placeholder="<?php echo ($_SESSION['lang'] == 'en') ? 'Enter image URL' : 'أدخل رابط الصورة'; ?>" required>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary"><?php echo $lang['add_button']; ?></button>
                                    <a href="index.php" class="btn btn-secondary"><?php echo $lang['cancel_button']; ?></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>   
 


   
    </main>

    <!-- Footer Section -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><?php echo $lang['navbar_brand']; ?></h5>
                    <p><?php echo $lang['footer_platform_desc']; ?></p>
                </div>
                <div class="col-md-4">
                    <h5><?php echo $lang['footer_quick_links']; ?></h5>
                    <ul class="list-unstyled">
                        <li><a href="../index.php" class="text-white"><?php echo $lang['nav_home']; ?></a></li>
                        <li><a href="../events.php" class="text-white"><?php echo $lang['nav_events']; ?></a></li>
                        <li><a href="../about.php" class="text-white"><?php echo $lang['nav_about']; ?></a></li>
                        <li><a href="../contact.php" class="text-white"><?php echo $lang['nav_contact']; ?></a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5><?php echo $lang['footer_contact_us']; ?></h5>
                    <p><?php echo $lang['footer_email']; ?></p>
                    <p><?php echo $lang['footer_phone']; ?></p>
                    <div class="social-links">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0"><?php echo $lang['footer_copyright']; ?></p>
                <p><?php echo $lang['footer_project_info']; ?></p>
                <p><?php echo $lang['footer_team_members']; ?></p>
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