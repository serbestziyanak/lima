<?php
$fn	= new Fonksiyonlar();
$vt = new VeriTabani();


/* SEG dosyalarından gelen mesaj */
if( array_key_exists( 'sonuclar', $_SESSION ) ) {
	$mesaj								= $_SESSION[ 'sonuclar' ][ 'mesaj' ];
	$mesaj_turu							= $_SESSION[ 'sonuclar' ][ 'hata' ] ? 'kirmizi' : 'yesil';
	unset( $_SESSION[ 'sonuclar' ] );
	echo "<script>mesajVer('$mesaj', '$mesaj_turu')</script>";
}


$islem	= array_key_exists( 'islem', $_REQUEST ) ? $_REQUEST[ 'islem' ]	 : 'ekle';
$id    	= array_key_exists( 'id'	,$_REQUEST ) ? $_REQUEST[ 'id' ]	 : 0;


$satir_renk				= $id > 0	? 'table-warning'						: '';
$kaydet_buton_yazi		= $id > 0	? 'Güncelle'							: 'Kaydet';
$kaydet_buton_cls		= $id > 0	? 'btn btn-warning btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';

$SQL_tum_stat_sayilari = <<< SQL
SELECT 
	 *
FROM 
	tb_stat_sayilari
SQL;

$SQL_tek_stat_sayi_oku = <<< SQL
SELECT 
	*
FROM 
	tb_stat_sayilari
WHERE 
	id = ?
SQL;

$stat_sayilari		= $vt->select( $SQL_tum_stat_sayilari, array( ) )[ 2 ];
@$tek_stat_sayi 	= $vt->select( $SQL_tek_stat_sayi_oku, array( $id ) )[ 2 ][ 0 ];

?>



<section class="content">
	<div class="container-fluid">
		<div class="row d-flex align-items-center justify-content-center">
			<div class="col-md-4 ">
            <form class="form-horizontal was-validated " action = "_modul/sifreDegistir/sifreDegistirSEG.php" method = "POST" enctype="multipart/form-data" oninput='sifre_tekrar.setCustomValidity(sifre_tekrar.value != sifre.value ? "<?php echo dil_cevir( "Şifreler eşleşmiyor.", $dizi_dil, $sistem_dil ); ?>" : "")'>
            <div class="card card-purple" >
              <div class="card-header">
                <h3 class="card-title"><?php echo dil_cevir( "Şifre Değiştir", $dizi_dil, $sistem_dil ); ?></h3>
              </div>
              <!-- /.card-header renk1 -->
              <!-- form start -->
                    <div class="card-body">
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Yeni Şifre", $dizi_dil, $sistem_dil ); ?></label>
                                <input type="hidden" name="islem" value="guncelle">
                                <input type="hidden" name="personel_id" value="<?php echo $_SESSION['kullanici_id']; ?>">
                                <input required type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="<?php echo dil_cevir( "Şifre en az 8 karakterden oluşmalı ve içinde en az bir rakam, bir büyük, bir küçük karakter içermelidir.", $dizi_dil, $sistem_dil ); ?>" placeholder="" class="form-control form-control-sm" name ="sifre"  autocomplete="off">
                                <div class="invalid-feedback">
                                    <?php echo dil_cevir( "Şifre en az 8 karakterden oluşmalı ve içinde en az bir rakam, bir büyük, bir küçük karakter içermelidir.", $dizi_dil, $sistem_dil ); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Yeni Şifre Tekrar", $dizi_dil, $sistem_dil ); ?></label>
                                <input required type="password" placeholder="" class="form-control form-control-sm" name ="sifre_tekrar"  autocomplete="off">
                                <div class="invalid-feedback">
                                    <?php echo dil_cevir( "Şifreler eşleşmiyor.", $dizi_dil, $sistem_dil ); ?>
                                </div>                            
                            </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button modul= 'personelSifreIslemleri' yetki_islem="kaydet" type="submit" class="btn bg-purple btn-sm"><span class="fa fa-save"></span> <?php echo dil_cevir( "Kaydet", $dizi_dil, $sistem_dil ); ?></button>
                    </div>
            </div>
            </form>
			</div>
		</div>
	</div>
</section>
