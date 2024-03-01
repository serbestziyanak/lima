<?php
$fn	= new Fonksiyonlar();
$vt = new VeriTabani();

/* SEG dosyalarından gelen mesaj */
if( array_key_exists( 'sonuclar', $_SESSION ) ) {
	$mesaj			= $_SESSION[ 'sonuclar' ][ 'mesaj' ];
	$mesaj_turu		= $_SESSION[ 'sonuclar' ][ 'hata' ] ? 'kirmizi' : 'yesil';
	$_REQUEST[ 'sistem_kullanici_id' ] = $_SESSION[ 'sonuclar' ][ 'sistem_kullanici_id' ];
	unset( $_SESSION[ 'sonuclar' ] );
	echo "<script>mesajVer('$mesaj', '$mesaj_turu')</script>";
}
$id	= array_key_exists( 'id', $_REQUEST ) ? $_REQUEST[ 'id' ] : 0;
$islem	= array_key_exists( 'islem', $_REQUEST ) ? $_REQUEST[ 'islem' ] : 'ekle';



$SQL_firmalar = <<< SQL
SELECT
	*
FROM
	tb_firmalar
SQL;

$SQL_firma_personelleri = <<< SQL
SELECT
	 p.*
	,f.adi AS firma_adi
FROM
	tb_firma_personelleri AS p
LEFT JOIN
	tb_firmalar AS f ON f.id = p.firma_id
ORDER BY adi 
SQL;

$SQL_firma_personel_tek = <<< SQL
SELECT
	 *
FROM
	tb_firma_personelleri
WHERE
	id = ?
SQL;

//$roller	= $vt->select( $SQL_roller, array( $_SESSION[ 'rol_id' ] ) );
$firmalar				            = $vt->select( $SQL_firmalar, array(  ) )[2];
$tek_personel   			        = $vt->selectSingle( $SQL_firma_personel_tek, array( $id ) )[2];
$firma_personelleri	                = $vt->select( $SQL_firma_personelleri, array(  ) )[2];

$satir_renk				= $id > 0	? 'table-warning'						: '';
$kaydet_buton_yazi		= $id > 0	? 'Güncelle'							: 'Kaydet';
$kaydet_buton_cls		= $id > 0	? 'btn btn-warning btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';
?>

<!-- UYARI MESAJI VE BUTONU-->
<div class="modal fade" id="kullanici_sil_onay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Lütfen Dikkat!</h4>
			</div>
			<div class="modal-body">
				Bu kullanıcıyı <b>Silmek</b> istediğinize emin misiniz?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
				<a class="btn btn-danger btn-evet">Evet</a>
			</div>
		</div>
	</div>
</div>

<script>
	$( '#kullanici_sil_onay' ).on( 'show.bs.modal', function( e ) {
		$( this ).find( '.btn-evet' ).attr( 'href', $( e.relatedTarget ).data( 'href' ) );
	} );
</script>

        <div class="row">
          <div class="col-md-8">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title"><?php echo dil_cevir( "Firma Personelleri", $dizi_dil, $sistem_dil ); ?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
				<table id="example2" class="table table-sm table-bordered table-hover">
					<thead>
						<tr class="">
							<th style="width: 15px">#</th>
							<th><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></th>
							<th><?php echo dil_cevir( "Soyadı", $dizi_dil, $sistem_dil ); ?></th>
                            <th><?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?></th>
                            <th><?php echo dil_cevir( "GSM", $dizi_dil, $sistem_dil ); ?></th>
                            <th><?php echo dil_cevir( "Firma", $dizi_dil, $sistem_dil ); ?></th>
							<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
							<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $sayi = 1; foreach( $firma_personelleri AS $result ) { ?>
						<tr <?php if( $result[ 'id' ] == $id ) echo "class = '$satir_renk'"; ?>>
							<td><?php echo $sayi++; ?></td>
							<td><?php echo $result[ 'adi' ]; ?></td>
							<td><?php echo $result[ 'soyadi' ]; ?></td>
							<td><?php echo $result[ 'email' ]; ?></td>
							<td><?php echo $result[ 'gsm' ]; ?></td>
							<td><?php echo $result[ 'firma_adi' ]; ?></td>
							<td align = "center">
								<a modul= 'firmaPersonelleri' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs " href = "?modul=firmaPersonelleri&islem=guncelle&id=<?php echo $result[ 'id' ]; ?>" >
									<?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
								</a>
							</td>
							<td align = "center">
								<button modul= 'firmaPersonelleri' yetki_islem="sil" class="btn btn-sm btn-danger btn-xs" data-href="_modul/firmaPersonelleri/firmaPersonelleriSEG.php?islem=sil&id=<?php echo $kul[ 'id' ]; ?>" data-toggle="modal" data-target="#kullanici_sil_onay" ><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
              </div>
            </div>
            <!-- /.card -->

          </div>
          <!-- left column -->
          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title"><?php echo dil_cevir( "Firma Personeli Ekle / Güncelle", $dizi_dil, $sistem_dil ); ?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

				<form class="form-horizontal" id = "kayit_formu" action = "_modul/firmaPersonelleri/firmaPersonelleriSEG.php" method = "POST" enctype="multipart/form-data">
					<div class="card-body">
					<div class="text-center">
					  <img class="img-fluid img-circle img-thumbnail mw-100"
						   style="width:120px;"
						   src="resimler/personel_resimler/<?php echo $tek_personel[ 'foto' ] ? $tek_personel[ 'foto' ] : 'resim_yok.png'; ?>" id = "sistem_kullanici_resim" 
						   alt="User profile picture"
						   id = "sistem_kullanici_resim">
					</div>

					<h3 class="profile-username text-center"><?php echo $tek_personel[ 'adi' ]." ".$tek_personel[ 'soyadi' ]; ?></h3>
				
					<input type="file" id="gizli_input_file" name = "input_sistem_kullanici_resim" style = "display:none;" name = "resim" accept="image/gif, image/jpeg, image/png"  onchange="resimOnizle(this)"; />
					<input type = "hidden" name = "id" value = "<?php echo $tek_personel[ 'id' ]; ?>">
					<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>">
					<div class="form-group">
						<label  class="control-label"><?php echo dil_cevir( "Firma", $dizi_dil, $sistem_dil ); ?></label>
							<select  class="form-control select2" name = "firma_id" required>
                                <option value="">Seçiniz...</option>
								<?php foreach( $firmalar AS $firma ) { ?>
									<option value = "<?php echo $firma[ 'id' ]; ?>" <?php if( $firma[ 'id' ] ==  $tek_personel[ 'firma_id' ] ) echo 'selected'?>><?php echo $firma[ 'adi' ]?></option>
								<?php } ?>
							</select>
					</div>
					<div class="form-group">
						<label  class="control-label"><?php echo dil_cevir( "Adı", $dizi_dil, $sistem_dil ); ?></label>
						<input required type="text" class="form-control form-control-sm" name ="adi" value = "<?php echo $tek_personel[ 'adi' ]; ?>">
					</div>
					<div class="form-group">
						<label  class="control-label"><?php echo dil_cevir( "Soyadı", $dizi_dil, $sistem_dil ); ?></label>
						<input required type="text" class="form-control form-control-sm" name ="soyadi" value = "<?php echo $tek_personel[ 'soyadi' ]; ?>">
					</div>
					<div class="form-group">
						<label  class="control-label"><?php echo dil_cevir( "Unvan", $dizi_dil, $sistem_dil ); ?></label>
						<input  type="text" class="form-control form-control-sm" name ="unvan" value = "<?php echo $tek_personel[ 'unvan' ]; ?>">
					</div>
					<div class="form-group">
					  <label><?php echo dil_cevir( "GSM", $dizi_dil, $sistem_dil ); ?></label>

					  <div class="input-group">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-phone"></i></span>
						</div>
						<input  type="text" name ="gsm" value = "<?php echo $tek_personel[ 'gsm' ]; ?>" class="form-control form-control-sm" data-inputmask='"mask": "0(999) 999-9999"' data-mask>
					  </div>
					  <!-- /.input group -->
					</div>
					<div class="form-group">
					  <label><?php echo dil_cevir( "Sabit Telefon", $dizi_dil, $sistem_dil ); ?></label>

					  <div class="input-group">
						<div class="input-group-prepend">
						  <span class="input-group-text"><i class="fas fa-phone"></i></span>
						</div>
						<input  type="text" name ="sabit_tel" value = "<?php echo $tek_personel[ 'sabit_tel' ]; ?>" class="form-control form-control-sm" data-inputmask='"mask": "0(999) 999-9999"' data-mask>
					  </div>
					  <!-- /.input group -->
					</div>
					<div class="form-group">
						<label  class="control-label"><?php echo dil_cevir( "Email", $dizi_dil, $sistem_dil ); ?></label>
							<input  type="email" class="form-control" name ="email" value = "<?php echo $tek_personel[ 'email' ]; ?>" placeholder="Eposta">
					</div>
                        <div class="col-12">
                            <div class="card card-olive" >
                                <div class="card-header renk1">
                                    <h3 class="card-title"><?php echo dil_cevir( "Notlar", $dizi_dil, $sistem_dil ); ?></h3>
                                    <div class = "card-tools">
                                        <button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Notlar", $dizi_dil, $sistem_dil ); ?></label>
                                        <style>
                                        .ck-editor__editable_inline:not(.ck-comment__input *) {
                                            height: 400px;
                                            overflow-y: auto;
                                        }
                                        </style>

                                        <textarea id="editor" style="display:none" name="notlar">
                                        <?php echo @$tek_personel[ "notlar" ]; ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include "editor.php"; ?>

				</div>
				<div class="card-footer">
						<button modul= 'firmaPersonelleri' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span> <?php echo $kaydet_buton_yazi; ?></button>
						<a modul= 'firmaPersonelleri' yetki_islem="ekle" type="reset" class="btn btn-primary btn-sm pull-right" href = "?modul=firmaPersonelleri&islem=ekle" ><span class="fa fa-plus"></span> Temizle / Yeni Kullanıcı</a>
				</div>
				</form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
          <!-- right column -->

        </div>
        <!-- /.row -->

<script>


	
/* Kullanıcı resmine tıklayınca file nesnesini tetikle*/
$( function() {
	$( "#sistem_kullanici_resim" ).click( function() {
		$( "#gizli_input_file" ).trigger( 'click' );
	});
});

/* Seçilen resim önizle */
function resimOnizle( input ) {
	if ( input.files && input.files[ 0 ] ) {
		var reader = new FileReader();
		reader.onload = function ( e ) {
			$( '#sistem_kullanici_resim' ).attr( 'src', e.target.result );
		};
		reader.readAsDataURL( input.files[ 0 ] );
	}
}
</script>
<script type="text/javascript">
	var simdi = new Date(); 
	//var simdi="11/25/2015 15:58";
	$(function () {
		$('#datetimepicker1').datetimepicker({
			//defaultDate: simdi,
			format: 'DD.MM.yyyy',
			icons: {
			time: "far fa-clock",
			date: "fa fa-calendar",
			up: "fa fa-arrow-up",
			down: "fa fa-arrow-down"
			}
		});
	});
	
</script>
