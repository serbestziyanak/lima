
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">AnaSayfa</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- <li class="nav-item" >
        <a class="nav-link" href="<?php echo $_SERVER['REQUEST_URI']; ?>&sistem_dil=_tr" role="button">
          <img src="img/tr.svg" style="height:20px; <?php if($_SESSION['sistem_dil'] == '_tr') echo ' border: 2px solid #0000ff;' ?>">
        </a>
      </li>
      <li class="nav-item" >
        <a class="nav-link" href="<?php echo $_SERVER['REQUEST_URI']; ?>&sistem_dil=_kz" role="button">
          <img src="img/kz.svg" style="height:20px; <?php if($_SESSION['sistem_dil'] == '_kz') echo ' border: 2px solid #0000ff;' ?>">
        </a>
      </li>
      <li class="nav-item" >
        <a class="nav-link" href="<?php echo $_SERVER['REQUEST_URI']; ?>&sistem_dil=_en" role="button">
          <img src="img/en.svg" style="height:20px; <?php if($_SESSION['sistem_dil'] == '_en') echo ' border: 2px solid #0000ff;' ?>">
        </a>
      </li>
      <li class="nav-item" >
        <a class="nav-link" href="<?php echo $_SERVER['REQUEST_URI']; ?>&sistem_dil=_ru" role="button">
          <img src="img/ru.svg" style="height:20px; <?php if($_SESSION['sistem_dil'] == '_ru') echo ' border: 2px solid #0000ff;' ?>">
        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link active" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!--li class="nav-item">
        <a class="nav-link" id="sagSidebar" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li-->
      <li class="nav-item">
        <a class="nav-link" href="_modul/cikis.php" role="button">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
