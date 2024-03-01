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
if( array_key_exists( 'sonuclar_toplu', $_SESSION ) ) {
	$sonuclar = $_SESSION[ 'sonuclar_toplu' ];
	unset( $_SESSION[ 'sonuclar_toplu' ] );
}
?>
            <div class="row">
                <div class="col-md-6">
                    <form class="form-horizontal" action = "_modul/topluPersonel/topluPersonelSEG.php" method = "POST" enctype="multipart/form-data">
                        <input type="hidden" name="islem" value="excel_epvo_ile_ekle">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class='card-title'><?php echo dil_cevir( "Toplu Personel Ekle (Epvo ID)", $dizi_dil, $sistem_dil ); ?></h3>
                            </div>
                            <div class="card-body">
                                    <div class="form-group sabit card p-3">
                                        <a href="_modul/topluPersonel/toplu_personel.xlsx">Örnek Excel Dosyası</a>
                                    </div>
                                    <div class="form-group sabit card p-3">
                                        <label class="control-label"><?php echo dil_cevir( "Excel Dosyası", $dizi_dil, $sistem_dil ); ?>: </label>
                                        <br>
                                        <input  required type="file" class="" name ="excel" accept=".xlsx, .xls"  >
                                    </div>
                            </div>
                            <div class="card-footer">
                                <button modul= 'topluPersonel' yetki_islem="kaydet" type="submit" class="btn btn-success"><span class="fa fa-save"></span>Yükle</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form class="form-horizontal" action = "_modul/topluPersonel/topluPersonelSEG.php" method = "POST" enctype="multipart/form-data">
                        <input type="hidden" name="islem" value="excel_birim_ile_ekle">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class='card-title'><?php echo dil_cevir( "Toplu Personel Ekle (Birim ID)", $dizi_dil, $sistem_dil ); ?></h3>
                            </div>
                            <div class="card-body">
                                    <div class="form-group sabit card p-3">
                                        <a href="_modul/topluPersonel/toplu_personel_birim.xlsx">Örnek Excel Dosyası</a>
                                    </div>
                                    <div class="form-group sabit card p-3">
                                        <label class="control-label"><?php echo dil_cevir( "Excel Dosyası", $dizi_dil, $sistem_dil ); ?>: </label>
                                        <br>
                                        <input  required type="file" class="" name ="excel" accept=".xlsx, .xls"  >
                                    </div>
                            </div>
                            <div class="card-footer">
                                <button modul= 'topluPersonel' yetki_islem="kaydet" type="submit" class="btn btn-success"><span class="fa fa-save"></span>Yükle</button>
                            </div>
                        </div>
                    </form>
                </div>
			</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class='card-title'><?php echo dil_cevir( "Sonuçlar", $dizi_dil, $sistem_dil ); ?></h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                <tr>
                                    <th>IIn No</th>
                                    <th>Adı Soyadı</th>
                                    <th>Durum</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach( $sonuclar as $key=>$sonuc ){
                                            if( $sonuc['hata'] )
                                                $class = "bg-danger";
                                            else
                                                $class = "bg-success";
                                    ?>
                                        <tr class="<?php echo $class; ?>">
                                            <td><?php echo $key; ?></td>
                                            <td><?php echo $sonuc['adi']; ?></td>
                                            <td><?php echo $sonuc['mesaj']; ?></td>
                                        </tr>
                                    <?php
                                        } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
			</div>
