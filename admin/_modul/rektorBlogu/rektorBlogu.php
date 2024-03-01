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

$SQL_tum_rektor_blogu = <<< SQL
SELECT 
	*
FROM 
	tb_rektor_blogu
SQL;

$SQL_tek_rektor_blog_oku = <<< SQL
SELECT 
	*
FROM 
	tb_rektor_blogu
WHERE 
	id = ?
SQL;

$SQL_rektor_bilgileri = <<< SQL
SELECT 
	*
FROM 
	tb_gorevler
WHERE 
	gorev_kategori_id = 1 AND birim_id = 1
SQL;

$rektor_bilgileri	= $vt->selectSingle( $SQL_rektor_bilgileri, array( ) )[ 2 ];
$rektor_blogu		= $vt->select( $SQL_tum_rektor_blogu, array( ) )[ 2 ];
@$tek_rektor_blog 	= $vt->select( $SQL_tek_rektor_blog_oku, array( $id ) )[ 2 ][ 0 ];

?>



<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-7">
				<div class="card card-secondary" id = "card_rektor_blogu">
					<div class="card-header">
						<h3 class="card-title"><?php echo dil_cevir( "Yorumlar", $dizi_dil, $sistem_dil ); ?></h3>
						<div class = "card-tools">
							<button type="button" data-toggle = "tooltip" title = "Tam sayfa göster" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand fa-lg"></i></button>
						</div>
					</div>
					<div class="card-body">
						<table id="tbl_rektor_blogu" class="table table-bordered table-hover table-sm" width = "100%" >
							<thead>
								<tr>
									<th style="width: 15px">#</th>
									<th><?php echo dil_cevir( "Adı Soyadı", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Mesaj", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Tarih", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Cevap", $dizi_dil, $sistem_dil ); ?></th>
									<th><?php echo dil_cevir( "Yayın", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?></th>
									<th data-priority="1" style="width: 20px"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php $sayi = 1; foreach( $rektor_blogu AS $rektor_blog ) { ?>
								<tr oncontextmenu="fun();" class =" <?php if( $rektor_blog[ 'id' ] == $id ) echo $satir_renk; ?>" data-id="<?php echo $rektor_blog[ 'id' ]; ?>">
									<td><?php echo $sayi++; ?></td>
									<td><?php echo $rektor_blog[ 'adi_soyadi' ]; ?></td>
									<td><?php echo $rektor_blog[ 'mesaj' ]; ?></td>
									<td><span style="display:none;"><?php echo $rektor_blog[ 'mesaj_tarihi' ]; ?></span><?php echo $fn->tarihSaatVer($rektor_blog[ 'mesaj_tarihi' ]); ?></td>
									<td>
                                        <?php if( strlen($rektor_blog[ 'cevap' ]) > 3 ) $renk_cevap = "success"; else $renk_cevap="danger";?>
                                        <div class="icheck-<?php echo $renk_cevap; ?> d-inline">
                                            <input type="radio" name="cevap-<?php echo $rektor_blog[ 'id' ]; ?>" checked="" id="cevap-<?php echo $rektor_blog[ 'id' ]; ?>">
                                            <label for="cevap-<?php echo $rektor_blog[ 'id' ]; ?>">
                                            </label>
                                        </div>
                                    </td>
									<td>
                                        <?php if( $rektor_blog[ 'yayin' ] == 1 ) $renk_yayin = "success"; else $renk_yayin="danger";?>
                                        <div class="icheck-<?php echo $renk_yayin; ?> d-inline">
                                            <input type="radio" name="yayin-<?php echo $rektor_blog[ 'id' ]; ?>" checked="" id="yayin-<?php echo $rektor_blog[ 'id' ]; ?>">
                                            <label for="yayin-<?php echo $rektor_blog[ 'id' ]; ?>">
                                            </label>
                                        </div>
                                    </td>
									<td align = "center">
										<a modul = 'rektorBlogu' yetki_islem="duzenle" class = "btn btn-sm btn-warning btn-xs" href = "?modul=rektorBlogu&islem=guncelle&id=<?php echo $rektor_blog[ 'id' ]; ?>" >
											<?php echo dil_cevir( "Düzenle", $dizi_dil, $sistem_dil ); ?>
										</a>
									</td>
									<td align = "center">
										<button modul= 'rektorBlogu' yetki_islem="sil" class="btn btn-xs btn-danger" data-href="_modul/rektorBlogu/rektorBloguSEG.php?islem=sil&id=<?php echo $rektor_blog[ 'id' ]; ?>" data-toggle="modal" data-target="#sil_onay"><?php echo dil_cevir( "Sil", $dizi_dil, $sistem_dil ); ?></button>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<form class="form-horizontal" action = "_modul/rektorBlogu/rektorBloguSEG.php" method = "POST" enctype="multipart/form-data">
					<div class="card card-secondary">
						<div class="card-header">
							<h3 class='card-title'><?php echo dil_cevir( "Cevap", $dizi_dil, $sistem_dil ); ?></h3>
						</div>
						<div class="card-body">
								<input type = "hidden" name = "islem" value = "<?php echo $islem; ?>" >
								<input type = "hidden" name = "id" value = "<?php echo $id; ?>">
								<input type = "hidden" name = "personel_id" value = "<?php echo $rektor_bilgileri['personel_id']; ?>">
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Adı Soyadı", $dizi_dil, $sistem_dil ); ?></label>
									<input disabled type="text" class="form-control" name ="adi_soyadi" value = "<?php echo $tek_rektor_blog[ "adi_soyadi" ]; ?>"  autocomplete="off">
								</div>
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Gelen Mesaj", $dizi_dil, $sistem_dil ); ?></label>
									<textarea type="text" class="form-control" name ="mesaj" rows="5"><?php echo $tek_rektor_blog[ "mesaj" ]; ?></textarea>
								</div>
								<div class="form-group">
									<label class="control-label"><?php echo dil_cevir( "Cevap", $dizi_dil, $sistem_dil ); ?></label>
                                    <style>
                                    .ck-editor__editable_inline:not(.ck-comment__input *) {
                                        height: 300px;
                                        overflow-y: auto;
                                    }
                                    </style>
									<textarea id="editor" style="display:none" name="cevap"><?php echo @$tek_rektor_blog[ "cevap" ]; ?></textarea>
								</div>
								<div class="form-group">
                                    <div class="icheck-success d-inline">
                                        <input type="checkbox" id="checkboxSuccess1" name="yayin" <?php if( $rektor_blog[ 'yayin' ] == 1 ) echo "checked";?>>
                                        <label for="checkboxSuccess1">
                                            <?php echo dil_cevir( "Yayın", $dizi_dil, $sistem_dil ); ?>
                                        </label>
                                    </div>                                    
								</div>
						</div>
						<div class="card-footer">
							<button modul= 'rektorBlogu' yetki_islem="kaydet" type="submit" class="<?php echo $kaydet_buton_cls; ?>"><span class="fa fa-save"></span><?php echo dil_cevir( $kaydet_buton_yazi, $dizi_dil, $sistem_dil ); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">


var tbl_rektor_blogu = $( "#tbl_rektor_blogu" ).DataTable( {
	"responsive": true, "lengthChange": true, "autoWidth": true,
	"stateSave": true,
	"pageLength" : 25,
	//"buttons": ["excel", "pdf", "print","colvis"],

	buttons : [
		{
			extend	: 'colvis',
			text	: "Alan Seçiniz"
			
		},
		{
			extend	: 'excel',
			text 	: 'Excel',
			exportOptions: {
				columns: ':visible'
			},
			title: function(){
				return "<?php echo dil_cevir( $modul_adi, $dizi_dil, $sistem_dil ); ?>";
			}
		},
		{
			extend	: 'print',
			text	: 'Yazdır',
			exportOptions : {
				columns : ':visible'
			},
			title: function(){
				return "<?php echo dil_cevir( $modul_adi, $dizi_dil, $sistem_dil ); ?>";
			}
		}
	],
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
} ).buttons().container().appendTo('#tbl_rektor_blogu_wrapper .col-md-6:eq(0)');



$('#card_rektor_blogu').on('maximized.lte.cardwidget', function() {
	var tbl_rektor_blogu = $( "#tbl_rektor_blogu" ).DataTable();
	var column = tbl_rektor_blogu.column(  tbl_rektor_blogu.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_rektor_blogu.column(  tbl_rektor_blogu.column.length - 2 );
	column.visible( ! column.visible() );
});

$('#card_rektor_blogu').on('minimized.lte.cardwidget', function() {
	var tbl_rektor_blogu = $( "#tbl_rektor_blogu" ).DataTable();
	var column = tbl_rektor_blogu.column(  tbl_rektor_blogu.column.length - 1 );
	column.visible( ! column.visible() );
	var column = tbl_rektor_blogu.column(  tbl_rektor_blogu.column.length - 2 );
	column.visible( ! column.visible() );
} );



</script>
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
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
            })
			.then( editor => {
				window.editor = editor;
			});
        </script>
