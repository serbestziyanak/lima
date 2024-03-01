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
<body class="hold-transition login-page" style="background-image: url('img/bg.jpg');background-size: cover;">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <div class="row">
        <div class="col-md-9 my-auto">
          <h2><b><?php echo dil_cevir( "İnsan Kaynakları", $dizi_dil, $sistem_dil ); ?></b></h2>
          <h6><?php echo dil_cevir( "Ahmet Yesevi Üniversitesi", $dizi_dil, $sistem_dil ); ?></h6>
        </div>
        <div class="col-md-3 my-auto">
          <img src="img/ayu_logo.png" class="img-fluid" style="width:300px">
        </div>
      </div>
    </div>



    <div class="card-body">
        <div class="row">
        <a class="nav-link col-3 text-center" href="<?php echo $_SERVER['REQUEST_URI']; ?>&sistem_dil=_tr" >
          <img src="img/tr.svg" style="height:20px; <?php if($_SESSION['sistem_dil'] == '_tr') echo ' border: 2px solid #0000ff;' ?>">
        </a>
        <a class="nav-link col-3 text-center" href="<?php echo $_SERVER['REQUEST_URI']; ?>&sistem_dil=_kz" >
          <img src="img/kz.svg" style="height:20px; <?php if($_SESSION['sistem_dil'] == '_kz') echo ' border: 2px solid #0000ff;' ?>">
        </a>
        <a class="nav-link col-3 text-center" href="<?php echo $_SERVER['REQUEST_URI']; ?>&sistem_dil=_en" >
          <img src="img/en.svg" style="height:20px; <?php if($_SESSION['sistem_dil'] == '_en') echo ' border: 2px solid #0000ff;' ?>">
        </a>
        <a class="nav-link col-3 text-center" href="<?php echo $_SERVER['REQUEST_URI']; ?>&sistem_dil=_ru" >
          <img src="img/ru.svg" style="height:20px; <?php if($_SESSION['sistem_dil'] == '_ru') echo ' border: 2px solid #0000ff;' ?>">
        </a>
        </div>
        <br>
            <?php if( $mesaj != "" ){ ?>
            <div class="col-12">
                <div class="alert alert-<?php echo $mesaj_turu2; ?> alert-dismissible fade show" role="alert">
                <?php echo dil_cevir( $mesaj, $dizi_dil, $sistem_dil ); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>          
            </div>
            <?php } ?>

      <p class="login-box-msg"><?php echo dil_cevir( "Şifrenizi sıfırlamak için aşağıdaki bilgileri doldurun.", $dizi_dil, $sistem_dil ); ?></p>
      <form action="_modul/sifremiUnuttum/sifremiUnuttumSEG.php" method="post">
        <input type="hidden" name="islem" value="sifre_guncelle">
        <div class="input-group mb-3">
          <input required type="email" class="form-control" placeholder="Email" name="email" pattern="^[\w.+\-]+@ayu\.edu.kz$" title="@ayu.edu.kz uzantılı mail girilmelidir.">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span> 
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input required type="number" class="form-control" placeholder="IIN No" name="in_no">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-id-card"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block"><?php echo dil_cevir( "Gönder", $dizi_dil, $sistem_dil ); ?></button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="index.php"><?php echo dil_cevir( "Giriş", $dizi_dil, $sistem_dil ); ?></a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

</body>
