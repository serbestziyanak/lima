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

$where = " WHERE s.personel_idler like '$_REQUEST[personel_id]' or s.personel_idler like '%,$_REQUEST[personel_id]' or s.personel_idler like '$_REQUEST[personel_id],%' or s.personel_idler like '%,$_REQUEST[personel_id],%'";
$SQL_buyruk_turleri = <<< SQL
SELECT
	*
FROM 
	tb_buyruk_turleri
SQL;

$SQL_tum_personel_buyruk_bilgileri = <<< SQL
SELECT 
	s.*
    ,eoy.adi    AS egitim_ogretim_yili
	,st.adi     AS buyruk_turu
	,st.adi_kz  AS buyruk_turu_kz
	,st.adi_en  AS buyruk_turu_en
	,st.adi_ru  AS buyruk_turu_ru
FROM 
	tb_personel_buyruklar as s
LEFT JOIN tb_egitim_ogretim_yillari AS eoy ON eoy.id = s.egitim_ogretim_yili_id
LEFT JOIN tb_buyruk_turleri AS st ON st.id = s.buyruk_turu_id
$where
ORDER BY s.buyruk_tarihi DESC
SQL;

$SQL_personeller = <<< SQL
SELECT 
	*
FROM 
	tb_personeller
WHERE aktif = 1
order by adi$dil
SQL;

$personeller 		            = $vt->select($SQL_personeller, array(  ) )[ 2 ];
$buyruk_turleri 	            = $vt->select($SQL_buyruk_turleri, array(  ) )[ 2 ];
$personel_buyruk_bilgileri	    = $vt->select( $SQL_tum_personel_buyruk_bilgileri, array( $personel_id ) )[ 2 ];

?>

<div class="modal fade" id="buyruk_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="buyruk_form" class="form-horizontal" action = "_modul/buyruklar/buyruklarSEG.php" method = "POST" enctype="multipart/form-data">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo dil_cevir( "Yeni Buyruk Ekle", $dizi_dil, $sistem_dil ); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                                <div id="buyruk_var_mesaj">
                                </div>
								<input type = "hidden" name = "islem" value = "ekle" >
								<input type = "hidden" name = "gelen_yer" value = "buyruk_modal" >
								<input type = "hidden" name = "personel_id" value = "<?php echo $personel_id; ?>">
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Eğitim Öğretim Yılı", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" name = "egitim_ogretim_yili_id" required  >
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $egitim_ogretim_yillari AS $egitim_ogretim_yili ){ ?>
                                            <option value="<?php echo $egitim_ogretim_yili[ "id" ]; ?>" ><?php echo $egitim_ogretim_yili[ "adi" ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Buyruk Türü", $dizi_dil, $sistem_dil ); ?></label>
                                    <select class="form-control form-control-sm select2" name = "buyruk_turu_id"  required>
                                        <option value=""><?php echo dil_cevir( "Seçiniz", $dizi_dil, $sistem_dil ); ?>...</option>
                                        <?php foreach( $buyruk_turleri AS $result ){ ?>
                                            <option value="<?php echo $result[ "id" ]; ?>" ><?php echo $result[ "adi".$dil ]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo dil_cevir( "Buyruk No", $dizi_dil, $sistem_dil ); ?></label>
                                <input type="text" placeholder="Buyruk No" class="form-control form-control-sm" name ="buyruk_no" value = ""  required>
                            </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo dil_cevir( "Buyruk Tarihi", $dizi_dil, $sistem_dil ); ?></label>
                                    <div class="input-group date" id="buyruk_tarihi" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#buyruk_tarihi" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input required autocomplete="off" type="text" data-target="#buyruk_tarihi" data-toggle="datetimepicker" name="buyruk_tarihi" value="" class="form-control form-control-sm datetimepicker-input" data-target="#datetimepicker1" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="control-label"><?php echo dil_cevir( "Personeller", $dizi_dil, $sistem_dil ); ?></label>
                                    <select   class="form-control select2"  multiple="multiple" name = "personel_idler[]" data-close-on-select="false">
                                        <?php foreach( $personeller AS $result ) { 
                                                $personeller2 = explode(",", $tek_personel_buyruk_bilgi[ 'personel_idler' ]);
                                        ?>
                                            <option value = "<?php echo $result[ 'id' ]; ?>" <?php if( in_array($result[ 'id' ], $personeller2) ) echo 'selected'?>><?php echo $result[ 'adi'.$dil ]." ".$result[ 'soyadi'.$dil ]?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group sabit card p-3">
                                    <label class="control-label"><?php echo dil_cevir( "Belge", $dizi_dil, $sistem_dil ); ?>: </label>
                                    <br>
                                    <input type="file" class="" id ="belge" name ="belge"   required >
                                </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><?php echo dil_cevir( "Kaydet", $dizi_dil, $sistem_dil ); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){	
	$("#buyruk_form").submit(function(event){
		submitForm();
		return false;
	});
});
function submitForm(){

    var data = new FormData();

    //Form data
    var form_data = $('#buyruk_form').serializeArray();
    $.each(form_data, function (key, input) {
        data.append(input.name, input.value);
    });

    //File data
    var file_data = $('input[name="belge"]')[0].files[0];
    data.append("belge", file_data);

    //File data multiple
    // var file_data = $('input[name="belge"]')[0].files;
    // for (var i = 0; i < file_data.length; i++) {
    //     data.append("belge[]", file_data[i]);
    // }

    //Custom data
    // data.append('key', 'value');

    $.ajax({
        url: "_modul/buyruklar/buyruklarSEG.php",
        method: "post",
        processData: false,
        contentType: false,
        data: data,
        success: function (data) {
            if( data == 'buyruk_var' ){
                $("#buyruk_var_mesaj").html("<div class='alert alert-danger' role='alert'><?php echo dil_cevir( "Buyruk no zaten kayıtlı.", $dizi_dil, $sistem_dil ) ?></div>");
            }else{
                $("#buyruk_id").html(data);
                $('#buyruk_form').trigger("reset"); 
                $("#buyruk_modal").modal('hide');
            }
        },
        error: function (e) {
                alert("Error");
        }
    });
}
</script>
<script type="text/javascript">
	$(function () {
		$('#buyruk_tarihi').datetimepicker({
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