<?php
// @$genel_ayarlar_ust = $vt->selectSingle($SQL_genel_ayarlar, array( $birim_ust_id ) )[ 2 ];
// if( $genel_ayarlar['map'] == "" ){
//     $map = $genel_ayarlar_ust['map'];
// }else{
//     $map = $genel_ayarlar['map'];
// }
// if( $genel_ayarlar['adres'.$dil] == "" ){
//     $adres = $genel_ayarlar_ust['adres'.$dil];
// }else{
//     $adres = $genel_ayarlar['adres'.$dil];
// }
?>
<!--==============================
Contact Area  
==============================-->
    <div class="space" id="contact-sec">
        <div class="container">
            <div class="map-sec">
                <div class="map">
                    <iframe src="<?php echo $map; ?>" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-5 mb-30 mb-xl-0">
                    <div class="me-xxl-5 mt-60">
                        <div class="title-area mb-25">
                            <h2 class="border-title h3"><?php echo dil_cevir( "İletişim Bilgileri", $dizi_dil, $_REQUEST["dil"] ); ?></h2>
                        </div>
                        <p class="mt-n2 mb-25"><?php echo dil_cevir( "İletişim bilgilerimiz aşağıdaki gibidir.", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                        <div class="contact-feature">
                            <div class="contact-feature-icon">
                                <i class="fal fa-location-dot"></i>
                            </div>
                            <div class="media-body">
                                <p class="contact-feature_label"><?php echo dil_cevir( "Adres", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                                <?php echo $adres; ?>
                            </div>
                        </div>
                        <div class="contact-feature">
                            <div class="contact-feature-icon">
                                <i class="fal fa-phone"></i>
                            </div>
                            <div class="media-body">
                                <p class="contact-feature_label"><?php echo dil_cevir( "Telefon Numarası", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                                <a href="tel:<?php echo $tel; ?>" class="contact-feature_link">Phone: <span><?php echo $tel; ?></span></a>
                            </div>
                        </div>
                        <div class="contact-feature">
                            <div class="contact-feature-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="media-body">
                                <p class="contact-feature_label"><?php echo dil_cevir( "Email", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                                <a href="mailto:<?php echo $email; ?>" class="contact-feature_link"><span><?php echo $email; ?></span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div class="contact-form-wrap" data-bg-src="assets/img/bg/contact_bg_1.png">
                        <span class="sub-title"><?php echo dil_cevir( "Bizimle İletişime Geç", $dizi_dil, $_REQUEST["dil"] ); ?></span>
                        <h2 class="border-title"><?php echo dil_cevir( "Bize Yazın", $dizi_dil, $_REQUEST["dil"] ); ?></h2>
                        <p class="mt-n1 mb-30 sec-text"><?php echo dil_cevir( "Aşağıdaki formu doldurarak bize mesaj gönderebilirsin.", $dizi_dil, $_REQUEST["dil"] ); ?></p>
                        <form action="mail.php" method="POST" class="contact-form ajax-contact">
                            <input type="hidden" name="to_email" value="<?php echo $email; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control style-white" name="name" id="name" placeholder="<?php echo dil_cevir( "Adınız Soyadınız*", $dizi_dil, $_REQUEST["dil"] ); ?>">
                                        <i class="fal fa-user"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control style-white" name="email" id="email" placeholder="<?php echo dil_cevir( "Email*", $dizi_dil, $_REQUEST["dil"] ); ?>">
                                        <i class="fal fa-envelope"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control style-white" name="subject" id="subject" placeholder="<?php echo dil_cevir( "Konu*", $dizi_dil, $_REQUEST["dil"] ); ?>">
                                        <i class="fa-solid fa-list"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="tel" class="form-control style-white" name="number" id="number" placeholder="<?php echo dil_cevir( "Telefon Numarası*", $dizi_dil, $_REQUEST["dil"] ); ?>">
                                        <i class="fal fa-phone"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group ">
                                        <textarea name="message" id="message" cols="30" rows="3" class="form-control style-white" placeholder="<?php echo dil_cevir( "Mesajınızı yazınız*", $dizi_dil, $_REQUEST["dil"] ); ?>"></textarea>
                                        <i class="fal fa-pen"></i>
                                    </div>
                                </div>
                                <div class="form-btn col-12 mt-10">
                                    <button class="th-btn"><?php echo dil_cevir( "Mesaj Gönder", $dizi_dil, $_REQUEST["dil"] ); ?><i class="fas fa-long-arrow-right ms-2"></i></button>
                                </div>
                            </div>
                            <p class="form-messages mb-0 mt-3"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>