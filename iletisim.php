<?php  

?>

    <div class="edu-breadcrumb-area breadcrumb-style-3 bg-image" style="background-image: url(assets/images/bg/bg-image-37.webp);">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="edu-breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $_REQUEST['dil']; ?>/"><?php echo dil_cevir( "Anasayfa", $dizi_dil, $_REQUEST["dil"] ); ?></a></li>
                    <li class="separator"><i class="icon-angle-right"></i></li>
                    <li class="breadcrumb-item active"><?php echo dil_cevir( "İletişim", $dizi_dil, $_REQUEST["dil"] ); ?></li>
                </ul>
                <div class="page-title">
                    <h1 class="title"><?php echo dil_cevir( "İletişim", $dizi_dil, $_REQUEST["dil"] ); ?></h1>
                </div>
                <ul class="course-meta">
                    <li><i class="icon-58"></i><?php echo $birim_bilgileri['adi'.$dil]; ?></li>
                    <li><i class="icon-59"></i><?php echo strtoupper($_REQUEST['dil']); ?></li>
                    <li class="course-rating">
                        <div class="rating">
                            <i class="icon-23"></i>
                            <i class="icon-23"></i>
                            <i class="icon-23"></i>
                            <i class="icon-23"></i>
                            <i class="icon-23"></i>
                        </div>
                        <span class="rating-count"></span>
                    </li>
                </ul>
            </div>
        </div>
        <ul class="shape-group">
            <li class="shape-1">
                <span></span>
            </li>
            <li class="shape-2 scene"><img data-depth="2" src="assets/images/about/shape-13.png" alt="shape"></li>
            <li class="shape-3 scene"><img data-depth="-2" src="assets/images/about/shape-15.png" alt="shape"></li>
            <li class="shape-4">
                <span></span>
            </li>
            <li class="shape-5 scene"><img data-depth="2" src="assets/images/about/shape-07.png" alt="shape"></li>
        </ul>
    </div>

        <!--=====================================-->
        <!--=       Contact Me Area Start       =-->
        <!--=====================================-->
        <section class="contact-us-area">
            <div class="container">
                <div class="row g-5">
                    <div class="col-xl-4 col-lg-6">
                        <div class="contact-us-info">
                            <h3 class="heading-title"><?php echo dil_cevir( "İletişim Bilgileri", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                            <ul class="address-list">
                                <li>
                                    <h5 class="title"><?php echo dil_cevir( "Adres", $dizi_dil, $_REQUEST["dil"] ); ?></h5>
                                    <p><?php echo nl2br($genel_ayarlar['adres'.$dil]); ?></p>
                                </li>
                                <li>
                                    <h5 class="title"><?php echo dil_cevir( "E - Posta", $dizi_dil, $_REQUEST["dil"] ); ?></h5>
                                    <p><a href="mailto:<?php echo $genel_ayarlar['email']; ?>"><?php echo $genel_ayarlar['email']; ?></a></p>
                                </li>
                                <li>
                                    <h5 class="title"><?php echo dil_cevir( "Telefon", $dizi_dil, $_REQUEST["dil"] ); ?></h5>
                                    <p><a href="tel:<?php echo $genel_ayarlar['tel']; ?>"><?php echo $genel_ayarlar['tel']; ?></a></p>
                                </li>
                            </ul>
                            <ul class="social-share">
                                <li><a target="_blank" href="<?php echo $genel_ayarlar['instagram']; ?>"><i class="icon-instagram"></i></a></li>
                                <li><a target="_blank" href="<?php echo $genel_ayarlar['facebook']; ?>"><i class="icon-facebook"></i></a></li>
                                <li><a target="_blank" href="<?php echo $genel_ayarlar['twitter']; ?>"><i class="icon-twitter"></i></a></li>
                                <li><a target="_blank" href="<?php echo $genel_ayarlar['linkedin']; ?>"><i class="icon-linkedin2"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="offset-xl-2 col-lg-6">
                        <div class="contact-form form-style-2">
                            <div class="section-title">
                                <h4 class="title"><?php echo dil_cevir( "Bize Yazın", $dizi_dil, $_REQUEST["dil"] ); ?></h4>
                                <p><?php echo dil_cevir( "Aşağıdaki formu doldurarak bize mesaj gönderebilirsiniz.", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                            </div>
                            <form class="rnt-contact-form " id="contact-form" method="POST" >
                                <input type="hidden" name="to_email" value="<?php echo $genel_ayarlar['email']; ?>">
                                <div class="row row--10">
                                    <div class="form-group col-12">
                                        <input type="text" name="name" id="contact-name" placeholder="<?php echo dil_cevir( "Adı Soyadı", $dizi_dil, $_REQUEST["dil"] ); ?>">
                                    </div>
                                    <div class="form-group col-12">
                                        <input type="email" name="email" id="contact-email" placeholder="<?php echo dil_cevir( "E - Posta", $dizi_dil, $_REQUEST["dil"] ); ?>">
                                    </div>
                                    <div class="form-group col-12">
                                        <input type="tel" name="number" id="contact-phone" placeholder="<?php echo dil_cevir( "Telefon", $dizi_dil, $_REQUEST["dil"] ); ?>">
                                    </div>
                                    <div class="form-group col-12">
                                        <input type="text" name="subject" id="contact-subject" placeholder="<?php echo dil_cevir( "Konu", $dizi_dil, $_REQUEST["dil"] ); ?>">
                                    </div>
                                    <div class="form-group col-12">
                                        <textarea name="message" id="contact-message" cols="30" rows="4" placeholder="<?php echo dil_cevir( "Mesaj", $dizi_dil, $_REQUEST["dil"] ); ?>"></textarea>
                                    </div>
                                    <div class="form-group col-12">
                                        <button class="rn-btn edu-btn btn-medium submit-btn" name="submit" onclick="gonder();" type="button"><?php echo dil_cevir( "Mesaj Gönder", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="icon-4"></i></button>
                                    </div>
                                    <div id="mesaj" class="text-success pt-4"></mesaj>
                                </div>
                            </form>
                            <ul class="shape-group">
                                <li class="shape-1 scene"><img data-depth="1" src="assets/images/about/shape-13.png" alt="Shape"></li>
                                <li class="shape-2 scene"><img data-depth="-1" src="assets/images/counterup/shape-02.png" alt="Shape"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--=====================================-->
        <!--=      Google Map Area Start        =-->
        <!--=====================================-->
        <div class="google-map-area">
            <div class="mapouter">
                <div class="gmap_canvas">
                    <iframe id="gmap_canvas" src="<?php echo $genel_ayarlar['map']; ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>

<div class="rn-progress-parent">
    <svg class="rn-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>

<script>
	function gonder() {
		$.ajax( {
			 url	: "mail.php"
			,type	: "POST"
			,data	: $('form').serialize()
			,success	: function( sonuc ) {
				$( "#mesaj" ).html( sonuc );
			}
			,error		: function() {
				$( "#mesaj" ).html( "Mesaj Gönderilemedi" ); 
			}
		} );
	}
</script>