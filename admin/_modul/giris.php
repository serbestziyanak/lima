<?php
include "_cekirdek/fonksiyonlar.php";
$fn	= new Fonksiyonlar();
$vt = new VeriTabani();

if( array_key_exists( 'sonuclar', $_SESSION ) ) {
	$mesaj								= $_SESSION[ 'sonuclar' ][ 'mesaj' ];
	$mesaj_turu							= $_SESSION[ 'sonuclar' ][ 'hata' ] ? 'kirmizi' 	: 'yesil';
	$mesaj_turu2							= $_SESSION[ 'sonuclar' ][ 'hata' ] ? 'danger' 	: 'success';
	unset( $_SESSION[ 'sonuclar' ] );
	echo "<script>mesajVer('$mesaj', '$mesaj_turu')</script>";
}



$SQL_ceviriler = <<< SQL
SELECT
  *
FROM 
  tb_ceviriler
SQL;

@$ceviriler = $vt->select($SQL_ceviriler, array(  ) )[ 2 ];

foreach( $ceviriler as $ceviri ){
    $dizi_dil[$ceviri['adi']]['_tr'] = $ceviri['adi']; 
    $dizi_dil[$ceviri['adi']]['_kz'] = $ceviri['adi_kz']; 
    $dizi_dil[$ceviri['adi']]['_en'] = $ceviri['adi_en']; 
    $dizi_dil[$ceviri['adi']]['_ru'] = $ceviri['adi_ru']; 
}

function dil_cevir( $metin, $dizi, $dil ){
// $myfile = fopen("ceviriler.txt", "a") or die("Unable to open file!");
// $txt = $metin."\n";
// fwrite($myfile, $txt);
// fclose($myfile);
	if( array_key_exists( $metin, $dizi ) and $dizi[$metin][$dil] != "" )
		return $dizi[$metin][$dil];
	else
		return $metin;

}

?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<body class="hold-transition login-page" style="background-image: url('img/bg.jpg');background-size: cover;">
<div class="login-box ">
		<?php
			if( array_key_exists( 'giris_var', $_SESSION ) ) {
				if( $_SESSION[ 'giris_var' ] == 'hayir' ) {
			?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-ban"></i> <?php echo dil_cevir( "Hata!", $dizi_dil, $sistem_dil ); ?></h4>
				<?php 
                    echo dil_cevir( $_SESSION[ 'giris_hata_mesaj' ], $dizi_dil, $sistem_dil ); 
                    unset( $_SESSION[ 'giris_var' ] );
                    unset( $_SESSION[ 'giris_hata_mesaj' ] );
                ?>
			</div>
		<?php 
			} }
		?>
  <!-- /.login-logo -->
  <div class="card card-dark">
    <div class="card-header text-center">
      <div class="row">
        <div class="col-md-9 my-auto">
          <h2><b><?php echo dil_cevir( "Fuar Yönetim Sistemi", $dizi_dil, $sistem_dil ); ?></b></h2>
          <h6><?php echo dil_cevir( "Lima Lojistics", $dizi_dil, $sistem_dil ); ?></h6>
        </div>
        <div class="col-md-3 my-auto">
          <img src="img/logo-a.png" class="img-fluid" style="width:300px">
        </div>
      </div>
    </div>
    <div class="card-body">
        <!-- <div class="row">
            <?php if( count($_GET)>0 ) $isaret="&"; else $isaret = "?"; ?>
        <a class="nav-link col-3 text-center" href="<?php echo $_SERVER['REQUEST_URI'].$isaret; ?>sistem_dil=_tr" >
          <img src="img/tr.svg" style="height:20px; <?php if($_SESSION['sistem_dil'] == '_tr') echo ' border: 2px solid #0000ff;' ?>">
        </a>
        <a class="nav-link col-3 text-center" href="<?php echo $_SERVER['REQUEST_URI'].$isaret; ?>sistem_dil=_kz" >
          <img src="img/kz.svg" style="height:20px; <?php if($_SESSION['sistem_dil'] == '_kz') echo ' border: 2px solid #0000ff;' ?>">
        </a>
        <a class="nav-link col-3 text-center" href="<?php echo $_SERVER['REQUEST_URI'].$isaret; ?>sistem_dil=_en" >
          <img src="img/en.svg" style="height:20px; <?php if($_SESSION['sistem_dil'] == '_en') echo ' border: 2px solid #0000ff;' ?>">
        </a>
        <a class="nav-link col-3 text-center" href="<?php echo $_SERVER['REQUEST_URI'].$isaret; ?>sistem_dil=_ru" >
          <img src="img/ru.svg" style="height:20px; <?php if($_SESSION['sistem_dil'] == '_ru') echo ' border: 2px solid #0000ff;' ?>">
        </a>
        </div> -->
        <br>

      <p class="login-box-msg"><?php echo dil_cevir( "Kullanıcı adı ve şifrenizle giriş yapınız.", $dizi_dil, $sistem_dil ); ?></p>

      <form action="_modul/girisKontrol.php" method="post"  id = "kayit_formu">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="kulad" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="sifre" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6Lf3xW4pAAAAAMghl2JDwwmj5kwsX8XSOv3Xbj20"></div>
        </div>

        <!-- <div class="input-group mb-3">
          <select class="form-control select2" name = "sistem_dil" required>
            <option value="_tr">Türkçe</option>
            <option value="_kz">қазақ</option>
            <option value="_en">English</option>
            <option value="_ru">Россия</option>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="fas fa-globe"></i>
            </div>
          </div>
        </div> -->
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
				        <?php echo dil_cevir( "Beni Hatırla", $dizi_dil, $sistem_dil ); ?>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" id="submit" disabled  class="btn btn-success btn-block"><?php echo dil_cevir( "Giriş", $dizi_dil, $sistem_dil ); ?></button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!--div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Facebook ile giriş yap
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google mr-2"></i> Google ile giriş yap
        </a>
      </div-->
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="index.php?modul=sifremiUnuttum"><?php echo dil_cevir( "Şifremi unuttum", $dizi_dil, $sistem_dil ); ?></a>
      </p>
      <!--p class="mb-0">
        <a href="register.html" class="text-center">Sisteme kayıt ol</a>
      </p-->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

</body>
<script>
    function recaptchaCallback() {
        $('#submit').removeAttr('disabled');
    };
</script>