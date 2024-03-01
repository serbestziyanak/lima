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

$dil = $sistem_dil == "_tr" ? "" : $sistem_dil ;
$islem			= array_key_exists( 'islem'		,$_REQUEST )  ? $_REQUEST[ 'islem' ]	 : 'ekle';
$id    	= array_key_exists( 'id'	,$_REQUEST )  ? $_REQUEST[ 'id' ]	 : 0;
$birim_id		= array_key_exists( 'birim_id' ,$_REQUEST ) ? $_REQUEST[ 'birim_id' ]	: 0;
$birim_adi		= array_key_exists( 'birim_adi' ,$_REQUEST ) ? $_REQUEST[ 'birim_adi' ]	: "";
$birim_id = 1;
$_REQUEST['birim_id'] = 1;

$satir_renk				= $id > 0	? 'table-warning'						: '';
$kaydet_buton_yazi		= $id > 0	? 'Güncelle'							: 'Kaydet';
$kaydet_buton_cls		= $id > 0	? 'btn btn-warning btn-sm pull-right'	: 'btn btn-success btn-sm pull-right';

include "_modul/birim_agaci_getir.php";

$SQL_tum_slaytlar = <<< SQL
SELECT 
	*
FROM 
	tb_slaytlar
WHERE 
    birim_id = ?
SQL;

$SQL_tek_slayt_oku = <<< SQL
SELECT 
	*
FROM 
	tb_slaytlar
WHERE 
	id = ? 
SQL;




$slaytlar			= $vt->select( $SQL_tum_slaytlar, 	array( $birim_id ) )[ 2 ];
@$tek_slayt 		= $vt->select( $SQL_tek_slayt_oku, array( $id ) )[ 2 ][ 0 ];

?>

<div class="modal fade" id="sil_onay">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo dil_cevir( "Lütfen Dikkat", $dizi_dil, $sistem_dil ); ?></h4>
			</div>
			<div class="modal-body">
				<p><?php echo dil_cevir( "Bu kaydı silmek istediğinize emin misiniz?", $dizi_dil, $sistem_dil ); ?></p>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dil_cevir( "Hayır", $dizi_dil, $sistem_dil ); ?></button>
				<a class="btn btn-danger btn-evet"><?php echo dil_cevir( "Evet", $dizi_dil, $sistem_dil ); ?></a>
			</div>
		</div>
	</div>
</div>


<script>
	/* Kayıt silme onay modal açar. */
	$( '#sil_onay' ).on( 'show.bs.modal', function( e ) {
		$( this ).find( '.btn-evet' ).attr( 'href', $( e.relatedTarget ).data( 'href' ) );
	} );
</script>


<section class="content">
	<div class="container-fluid">
		<div class="row">
			<?php if( !isset($_REQUEST['birim_id']) ){ ?>
			<div class="col-md-6 p-0">
				<div class="card card-secondary">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Birimler", $dizi_dil, $sistem_dil ); ?></h3>
					</div>
					<div class="card-body p-0">
						<div class="overflow-auto" style="height:600px;">
							<table class="table table-sm table-hover text-sm">
							<tbody>
								<?php
								//var_dump($birim_sayfalari);
									if( count( $birim_agaclari ) ) 
										echo kategoriListele3($url_modul, $birim_agaclari,0,0, $vt, $ogrenci_id, $sistem_dil, $birim_idler);
									

								?>
							</tbody>
							</table>
						</div>

					</div>

				</div>
			</div>
			<?php }else{ ?>

			<div class="col-md-8">
				<div class="card card-secondary" id = "card_slaytlar">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Manşetler", $dizi_dil, $sistem_dil ); ?></h3>
						<div class = "card-tools">
							<button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
							<a id = "yeni_slayt" data-toggle = "tooltip" title = "Yeni slayt Ekle" href = "?modul=slaytlar&islem=ekle&birim_id=<?php echo $birim_id; ?>&birim_adi=<?php echo $birim_adi; ?>" class="btn btn-tool" ><i class="fas fa-plus fa-lg"></i></a>
						</div>
					</div>
					<div class="card-body">
						<table id="tbl_slaytlar" class="table table-bordered table-hover table-sm" width = "100%" >
							<thead>
								<tr>
									<th style="width: 15px">#</th>
									<th><?php echo dil_cevir( "Foto", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?> 1</th>
									<th><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?> 2</th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $sayi = 1; foreach( $slaytlar AS $slayt ) { ?>
								<tr oncontextmenu="fun();" class ="slayt-Tr <?php if( $slayt[ 'id' ] == $id ) echo $satir_renk; ?>" data-id="<?php echo $slayt[ 'id' ]; ?>">
									<td><?php echo $sayi++; ?></td>
									<td><img src="resimler/slaytlar/<?php echo $slayt[ 'foto' ]; ?>" height="100"></td>
									<td><?php echo $slayt[ 'baslik1'.$dil ]; ?></td>
									<td><?php echo $slayt[ 'baslik2'.$dil ]; ?></td>
									<td align = "center">
										<a modul = 'slaytlar' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=slaytlar&islem=guncelle&id=<?php echo $slayt[ 'id' ]; ?>&birim_id=<?php echo $birim_id; ?>&birim_adi=<?php echo $birim_adi; ?>" >
											<?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
										</a>
									</td>
									<td align = "center">
										<button modul= 'slaytlar' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/slaytlar/slaytlarSEG.php?islem=sil&id=<?php echo $slayt[ 'id' ]; ?>&foto=<?php echo $slayt[ 'foto' ]; ?>&birim_id=<?php echo $birim_id; ?>&birim_adi=<?php echo $birim_adi; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php } ?>
            
			<div class="col-md-4">
				<div class="card <?php if( $id == 0 ) echo 'card-secondary' ?>">
					<div class="card-header p-2">
						<ul class="nav nav-pills tab-container">
							<h6 style = 'font-size: 1rem;'><?php echo dil_cevir( "Manşet Ekle", $dizi_dil, $sistem_dil ); ?></h6>
							
						</ul>
					</div>
					<div class="card-body"  >
                        <?php if( $birim_id > 0 ){ ?>
						<div class="tab-content">
							<!-- GENEL BİLGİLER -->
							<div class="tab-pane active" id="_genel">

								<form class="form-horizontal" action = "_modul/slaytlar/slaytlarSEG.php" method = "POST" enctype="multipart/form-data">
									<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
									<input type = "hidden" name = "id" value = "<?php echo $id; ?>">
									<input type = "hidden" name = "birim_id" value = "<?php echo $birim_id; ?>">
									<input type = "hidden" name = "birim_adi" value = "<?php echo $birim_adi; ?>">
							        <br><h5 class="float-left text-olive"><?php echo dil_cevir( "Foto", $dizi_dil, $sistem_dil ); ?></h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
									<div class="form-group">
										<label class="control-label"><?php echo dil_cevir( "Foto", $dizi_dil, $sistem_dil ); ?></label>
										<input type="file" name="foto" class="" required><br>
                                        <?php if( $birim_id != 1 ){ ?>
										<small class="text-muted"><?php echo dil_cevir( "Eklediğiniz görsel 1000x600 boyutlarında olmalıdır.", $dizi_dil, $sistem_dil ); ?> </small>
                                        <?php }else{ ?>
										<small class="text-muted"><?php echo dil_cevir( "Eklediğiniz görsel 1920x800 boyutlarında olmalıdır.", $dizi_dil, $sistem_dil ); ?> </small>
                                        <?php } ?>
                                    </div>
									<?php if( $islem == "guncelle" ){ ?>
									<div class="form-group">
										<label class="control-label"><?php echo dil_cevir( "Var olan görsel", $dizi_dil, $sistem_dil ); ?></label><br>
										<img src="resimler/slaytlar/<?php echo $tek_slayt[ 'foto' ]; ?>" width="200">
									</div>
									<?php } ?>
							        <br><h5 class="float-right text-olive"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?> 1</h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?> 1 (TR)</label>
                                        <input  type="text" class="form-control" name ="baslik1" value = "<?php echo $tek_slayt[ "baslik1" ]; ?>"  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?> 1 (KZ)</label>
                                        <input  type="text" class="form-control" name ="baslik1_kz" value = "<?php echo $tek_slayt[ "baslik1_kz" ]; ?>"  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?> 1 (EN)</label>
                                        <input  type="text" class="form-control" name ="baslik1_en" value = "<?php echo $tek_slayt[ "baslik1_en" ]; ?>"  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?> 1 (RU)</label>
                                        <input  type="text" class="form-control" name ="baslik1_ru" value = "<?php echo $tek_slayt[ "baslik1_ru" ]; ?>"  autocomplete="off">
                                    </div>

							        <br><h5 class="float-left text-olive"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?> 2</h5><br><hr style="border: 2px solid green; border-radius: 5px; width:100%;" >
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?> 2 (TR)</label>
                                        <input  type="text" class="form-control" name ="baslik2" value = "<?php echo $tek_slayt[ "baslik2" ]; ?>"  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?> 2 (KZ)</label>
                                        <input  type="text" class="form-control" name ="baslik2_kz" value = "<?php echo $tek_slayt[ "baslik2_kz" ]; ?>"  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?> 2 (EN)</label>
                                        <input  type="text" class="form-control" name ="baslik2_en" value = "<?php echo $tek_slayt[ "baslik2_en" ]; ?>"  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><?php echo dil_cevir( "Başlık", $dizi_dil, $sistem_dil ); ?> 2 (RU)</label>
                                        <input  type="text" class="form-control" name ="baslik2_ru" value = "<?php echo $tek_slayt[ "baslik2_ru" ]; ?>"  autocomplete="off">
                                    </div>

									<div class="card-footer">
										<button modul= 'slaytlar' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span><?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
									</div>
								</form>
							</div>
						</div>
                        <?php }else{ ?>
                            <div class="text-center" style="height:600px;">
                                <h2> <?php echo dil_cevir( "Lütfen Birim Seçiniz", $dizi_dil, $sistem_dil ); ?></h2>
                                <br>
                                <div class="spinner-grow text-primary " role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-secondary" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-success" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-danger" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-warning" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-info" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-dark" role="status">
                                <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        <?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	var simdi = new Date(); 
	$(function () {
		$('#tarih').datetimepicker({
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

var tbl_slaytlar = $( "#tbl_slaytlar" ).DataTable( {
	"responsive": true, "lengthChange": true, "autoWidth": true,
	"stateSave": true,
	"pageLength" : 25,
	//"buttons": ["excel", "pdf", "print","colvis"],

	"language": {
		"decimal"			: "",
		"emptyTable"		: "Gösterilecek kayıt yok!",
		"info"				: "Toplam _TOTAL_ kayıttan _START_ ve _END_ arası gösteriliyor",
		"infoEmpty"			: "Toplam 0 kayıttan 0 ve 0 arası gösteriliyor",
		"infoFiltered"		: "",
		"infoPostFix"		: "",
		"thousands"			: ",",
		"lengthMenu"		: "Show _MENU_ entries",
		"loadingRecords"	: "Yükleniyor...",
		"processing"		: "İşleniyor...",
		"search"			: "Ara:",
		"zeroRecords"		: "Eşleşen kayıt bulunamadı!",
		"paginate"			: {
			"first"		: "İlk",
			"last"		: "Son",
			"next"		: "Sonraki",
			"previous"	: "Önceki"
		}
	}
} ).buttons().container().appendTo('#tbl_slaytlar_wrapper .col-md-6:eq(0)');



$('#card_slaytlar').on('maximized.lte.cardwidget', function() {
	var tbl_slaytlar = $( "#tbl_slaytlar" ).DataTable();
	var column = tbl_slaytlar.column(  tbl_slaytlar.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_slaytlar.column(  tbl_slaytlar.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_slaytlar').on('minimized.lte.cardwidget', function() {
	var tbl_slaytlar = $( "#tbl_slaytlar" ).DataTable();
	var column = tbl_slaytlar.column(  tbl_slaytlar.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_slaytlar.column(  tbl_slaytlar.column.length - 2 );
	column.visible( ! column.visible() );
} );



</script>
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("editor2"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
				ckfinder: {
					uploadUrl: '/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
				},
                toolbar: {
                    items: [
                        'exportPDF','exportWord', '|',
						'ckfinder', 'imageUpload',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'İçeriği buraya giriniz.',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                // The "super-build" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'CKBox',
                    //'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                    'MathType',
                    // The following features are part of the Productivity Pack and require additional license.
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents',
                    'PasteFromOfficeEnhanced'
                ]
            });
        </script>