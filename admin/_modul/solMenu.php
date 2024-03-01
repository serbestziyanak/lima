<?php
$URL = $_SERVER[ 'REQUEST_URI' ];
$parametreler = parse_url( $URL );
parse_str( $parametreler[ 'query' ], $parametre );
$url_modul = $parametre[ 'modul' ];

$SQL_modul = <<<SQL
SELECT * FROM tb_modul  WHERE menude_goster = 1 AND ust_id = 0  ORDER BY sira
SQL;

$SQL_alt_modul = <<<SQL
SELECT * FROM tb_modul WHERE ust_id = ? AND menude_goster = 1 ORDER BY sira
SQL;

$SQL_modul_detay = <<<SQL
SELECT * FROM tb_modul WHERE modul = ?
SQL;

$SQL_ceviriler = <<< SQL
SELECT
  *
FROM 
  tb_ceviriler
SQL;

$SQL_tek_personel = <<< SQL
SELECT
  *
FROM 
  tb_personeller
WHERE 
    id = ?
SQL;

$moduller = $vt->select( $SQL_modul );
$modul_kisa_ad = $vt->selectSingle( $SQL_modul_detay, array( $_REQUEST['modul'] ) )[2]['modul'];
$modul_adi = $vt->selectSingle( $SQL_modul_detay, array( $_REQUEST['modul'] ) )[2]['adi'];

@$ceviriler = $vt->select($SQL_ceviriler, array(  ) )[ 2 ];
@$tek_personel = $vt->selectSingle($SQL_tek_personel, array( $_SESSION[ 'kullanici_id' ] ) )[ 2 ];

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
<style>
body {
    background-image:none;
}
</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-olive elevation-4">
	<!-- Brand Logo -->
	<a href="index.php?home" class="brand-link">
	<img src="img/favicon.png" alt="Fuar Takip Sistemi" class="brand-image img-circle elevation-3" style="">
	<!--span class="brand-text font-weight-light">EYPS - Van YYÜ</span-->
	<span class="brand-text"><?php echo dil_cevir( "Fuar Takip Sistemi", $dizi_dil, $sistem_dil ); ?></span>
	</a>
	<!--
	<a href="index.php" class="brand-link" >
	<img src="img/logo_kucuk.jfif" alt="AdminLTE Docs Logo Small" class="brand-image-xl logo-xs">
	<img src="img/wowlogo.jfif" alt="AdminLTE Docs Logo Large" class="" style="width:93%">
	</a>
	-->
	<!--a href="/docs/3.0/index.html" class="brand-link logo-switch">
	<img src="/docs/3.0/assets/img/logo-xs.png" alt="AdminLTE Docs Logo Small" class="brand-image-xl logo-xs">
	<img src="img/otowow.png" alt="AdminLTE Docs Logo Large" class="brand-image-xl logo-xl" style="left: 12px;width:93%">
	</a-->
	<!-- Sidebar -->
<?php
if( $tek_personel[ "foto" ] == "resim_yok.png" or $tek_personel[ "foto" ] == "" )
    $personel_foto = $tek_personel[ "cinsiyet" ]."resim_yok.png";
else
    $personel_foto = $tek_personel[ "foto" ];
?>
	<div class="sidebar">
	<!-- Sidebar user panel (optional) -->
	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
		<div class="image">
		<img src="resimler/<?php if( $_SESSION[ 'kullanici_turu' ] == "personel" ) echo "personel_resimler/"; ?><?php echo $personel_foto; ?>" class="img-circle elevation-2" alt="User Image">
		</div>
		<div class="info">
		<a href="#" class="d-block" ><?php echo $_SESSION['adi']." ".$fn->ilkHarfleriBuyut($_SESSION['soyadi']); ?></a><span style = "color:white" id = "user_label"></span>
		</div>
	</div>

	<!-- SidebarSearch Form -->
	<div class="form-inline">
		<div class="input-group" data-widget="sidebar-search">
		<input class="form-control form-control-sm form-control-sidebar" type="search" placeholder="Menüde Ara" aria-label="Search">
		<div class="input-group-append">
			<button class="btn btn-sm btn-sidebar">
			<i class="fas fa-search fa-fw"></i>
			</button>
		</div>
		</div>
	</div>
	<!-- Sidebar Menu -->
	<nav class="mt-2">
		<ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview" role="menu" data-accordion="false">
		<!-- Add icons to the links using the .nav-icon class
			   with font-awesome or any other icon font library -->
			<li class="nav-header"><?php echo dil_cevir( "MENÜ", $dizi_dil, $sistem_dil ); ?></li>
			
			<?php foreach( $moduller[ 2 ] AS $modul ) { ?>
				<?php if( $modul[ 'kategori' ] * 1 > 0 ) {
						$altModuller = $vt->select( $SQL_alt_modul, array( $modul[ 'id' ] ) );
						$mdl = array();

						/* Bir Kategori altında en az bir mdüle yetkisi var mı kontrol et.*/
						$yetki_kontrol = 0;
						foreach( $altModuller[ 2 ] AS $altModul ) {
							$mdl[] = $altModul[ 'modul' ];
							if( $fn->yetkiKontrol( $_SESSION[ 'kullanici_id' ], $altModul[ 'modul' ], 'goruntule' ) ) $yetki_kontrol = 1;
						}
						/* Bir Kategori altında en az bir mdüle yetkisi varsa kategori görünsün*/
						if( $yetki_kontrol ) {
				?>
							<li class="nav-item <?php if( in_array( $_REQUEST[ 'modul' ], $mdl ) or $modul[ 'kategori_acik' ] == 1 ) echo "menu-open"; ?>">
								<a href="#" class="nav-link <?php if( in_array( $_REQUEST[ 'modul' ], $mdl ) ) echo "active"; ?>">
									<i class="nav-icon <?php echo $modul[ 'simge' ]?> <?php if( in_array( $_REQUEST[ 'modul' ], $mdl ) ) echo "text-white"; ?>"></i>
									<p>
										<?php echo dil_cevir( $modul[ 'adi' ], $dizi_dil, $sistem_dil ); ?>
										<i class="right fas fa-angle-left"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<?php
										foreach( $altModuller[ 2 ] AS $altModul ) {
									?>
										<li class = "nav-item">
											<?php
												if( !$fn->yetkiKontrol( $_SESSION[ 'kullanici_id' ], $altModul[ 'modul' ], 'goruntule' ) ) continue;
												
												if( $altModul[ 'harici_sayfa' ] ) {
													$__url		= $altModul[ 'harici_url' ];
													$yeni_sekme	=  'target = _blank';
												} else {
													$__url		= '?modul=' . $altModul[ 'modul' ];
													$yeni_sekme	= '';
												}
											?>
											<a class="nav-link <?php if( $url_modul == $altModul[ 'modul' ] ) echo "active"; ?>" modul='<?php echo $altModul[ 'modul' ];?>' yetki_islem='goruntule' href="<?php echo $__url; ?>" <?php echo $yeni_sekme; ?>>
												<i class="nav-icon <?php echo $altModul[ 'simge' ]?>"></i> 
												<p><?php echo dil_cevir( $altModul[ 'adi' ], $dizi_dil, $sistem_dil ); ?></p>
											</a>
										</li>
									<?php } ?>
								</ul>
							</li>
							<?php 
						}
				} else {
				if( !$fn->yetkiKontrol( $_SESSION[ 'kullanici_id' ], $modul[ 'modul' ], 'goruntule' ) ) continue;
			?>
				<li modul='<?php echo $modul[ 'modul' ];?>' yetki_islem='goruntule' class = "nav-item">
					<a href="?modul=<?php echo $modul[ 'modul' ]?>" class="nav-link <?php if( $url_modul == $modul[ 'modul' ] ) echo "active"; ?>">
						<i class="nav-icon <?php echo $modul[ 'simge' ]?> <?php if( $url_modul == $modul[ 'modul' ] ) echo "text-white"; ?>"></i> 
						<p>
							<?php echo dil_cevir( $modul[ 'adi' ], $dizi_dil, $sistem_dil ); ?>
						</p>
					</a>
				</li>
			<?php }
			}
			?>
		</ul>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
	</nav>
	</div>

</aside>
<?php include "sil_onay.php"; ?>
