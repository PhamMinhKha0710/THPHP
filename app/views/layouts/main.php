<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo isset($title) ? $title : 'Lumia'; ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="/project1/public/assets/img/favicon.png" rel="icon">
  <link href="/project1/public/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/project1/public/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/project1/public/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/project1/public/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/project1/public/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/project1/public/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="/project1/public/assets/css/style.css" rel="stylesheet">
  
  <!-- Custom CSS -->
  <link href="/project1/app/views/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <div class="logo me-auto">
        <h1><a href="/project1/">Lumia</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="/project1/"><img src="/project1/public/assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <?php
            $current_page = $_SERVER['REQUEST_URI'];
            $home_active = (strpos($current_page, '/project1/') !== false && strlen($current_page) <= 10) ? 'active' : '';
            $product_list_active = (strpos($current_page, '/project1/Product/list') !== false) ? 'active' : '';
            $product_add_active = (strpos($current_page, '/project1/Product/add') !== false) ? 'active' : '';
            $about_active = (strpos($current_page, '#about') !== false) ? 'active' : '';
            $services_active = (strpos($current_page, '#services') !== false) ? 'active' : '';
            $portfolio_active = (strpos($current_page, '#portfolio') !== false) ? 'active' : '';
            $contact_active = (strpos($current_page, '#contact') !== false) ? 'active' : '';
          ?>
          <li><a class="nav-link scrollto <?php echo $home_active; ?>" href="/project1/"><i class="bx bx-home-alt"></i> Trang Chủ</a></li>
          <li><a class="nav-link scrollto <?php echo $product_list_active; ?>" href="/project1/Product/list"><i class="bx bx-list-ul"></i> Sản Phẩm</a></li>
          <li><a class="nav-link scrollto <?php echo $product_add_active; ?>" href="/project1/Product/add"><i class="bx bx-plus-circle"></i> Thêm Sản Phẩm</a></li>
          <li><a class="nav-link scrollto <?php echo $about_active; ?>" href="#about"><i class="bx bx-info-circle"></i> Giới Thiệu</a></li>
          <li><a class="nav-link scrollto <?php echo $services_active; ?>" href="#services"><i class="bx bx-server"></i> Dịch Vụ</a></li>
          <li><a class="nav-link scrollto <?php echo $portfolio_active; ?>" href="#portfolio"><i class="bx bx-image"></i> Dự Án</a></li>
          <li><a class="nav-link scrollto <?php echo $contact_active; ?>" href="#contact"><i class="bx bx-envelope"></i> Liên Hệ</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <div class="header-social-links d-flex align-items-center">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
      </div>

    </div>
  </header><!-- End Header -->

  <?php if(isset($showHero) && $showHero): ?>
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
    <div class="container text-center text-md-left" data-aos="fade-up">
      <h1>Chào mừng đến với <span>Lumia</span></h1>
      <h2>Chúng tôi là đội ngũ thiết kế tài năng tạo ra các trang web với Bootstrap</h2>
      <a href="#about" class="btn-get-started scrollto">Bắt Đầu</a>
    </div>
  </section><!-- End Hero -->
  <?php endif; ?>

  <main id="main" <?php echo !isset($showHero) || !$showHero ? 'style="margin-top: 100px;"' : ''; ?>>
    <?php echo $content; ?>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>Lumia</h3>
            <p>
              Đường A123 <br>
              Hà Nội, HN 123456<br>
              Việt Nam <br><br>
              <strong>Điện thoại:</strong> +84 123 456 789<br>
              <strong>Email:</strong> info@example.com<br>
            </p>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Đường Dẫn</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="/project1/">Trang Chủ</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#about">Giới Thiệu</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#services">Dịch Vụ</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="/project1/Product/list">Sản Phẩm</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#contact">Liên Hệ</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Dịch Vụ Của Chúng Tôi</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Thiết Kế Web</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Phát Triển Web</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Quản Lý Sản Phẩm</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Thiết Kế Đồ Họa</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Đăng Ký Nhận Tin</h4>
            <p>Đăng ký để nhận những thông tin mới nhất về sản phẩm và dịch vụ của chúng tôi</p>
            <form action="" method="post">
              <input type="email" name="email" placeholder="Email của bạn"><input type="submit" value="Đăng ký">
            </form>
          </div>

        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">
      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>Lumia</span></strong>. All Rights Reserved
        </div>
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/project1/public/assets/vendor/purecounter/purecounter.js"></script>
  <script src="/project1/public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/project1/public/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="/project1/public/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="/project1/public/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="/project1/public/assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="/project1/public/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="/project1/public/assets/js/main.js"></script>
  
  <!-- Custom JS -->
  <script src="/project1/public/assets/js/validation.js"></script>

</body>

</html> 