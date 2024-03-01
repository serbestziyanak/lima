                        <?php if( count( $yorumlar ) > 0 ){ ?>
                            <link rel="stylesheet" href="admin/plugins/toastr/toastr.min.css">
                            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                            <script src="admin/plugins/toastr/toastr.min.js"></script>
                            <script>
                            $(document).ready(function(){
                                $("form").on("submit", function(event){
                                    event.preventDefault();
                            
                                    var formValues= $(this).serialize();
                            
                                    $.post("yorum_gonder.php", formValues, function(data){
                                        // Display the returned data in browser
                                        toastr.success(data);
                                    });
                                });
                            });
                            </script>
                        <!-- Start Comment Area  -->
                        <div class="comment-area" style="margin-top:50px;">
                            <h3 class="heading-title"><?php echo dil_cevir( "Yorumlar", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                            <div class="comment-list-wrapper">
                                <?php $sira = 0; foreach( $yorumlar as $yorum ){?>
                                <!-- Start Single Comment  -->
                                <div class="comment">
                                    <div class="thumbnail">
                                        <img src="admin/resimler/personel_resimler/resim_yok.png" alt="Comment Images">
                                    </div>
                                    <div class="comment-content">
                                        <h5 class="title"><?php echo $yorum['adi_soyadi']; ?></h5>
                                        <span class="date"><?php echo $fn->tarihSaatVer($yorum[ 'mesaj_tarihi' ]); ?></span>
                                        <p>
                                            <?php echo nl2br( $yorum['mesaj'] ); ?>
                                        </p>
                                        <!--div class="reply-btn-wrapper">
                                            <a class="reply-btn" href="#">Reply</a>
                                        </div-->
                                    </div>
                                </div>
                                <!-- End Single Comment  -->
                                <!-- Start Single Comment  -->
                                <div class="comment comment-reply">
                                    <div class="thumbnail">
                                        <img src="admin/resimler/personel_resimler/<?php echo $yorum['foto']; ?>" alt="Comment Images">
                                    </div>
                                    <div class="comment-content">
                                        <h5 class="title"><?php echo $yorum['rektor']; ?></h5>
                                        <span class="date"><?php echo $fn->tarihSaatVer($yorum[ 'cevap_tarihi' ]); ?></span>
                                        <p><?php echo $yorum['cevap']; ?></p>
                                        <!--div class="reply-btn-wrapper">
                                            <a class="reply-btn" href="#">Reply</a>
                                        </div-->
                                    </div>
                                </div>
                                <!-- End Single Comment  -->
                                <?php } ?>
                            </div>
                        </div>
                        <!-- End Comment Area  -->
                        <?php } ?>
                        <div class="comment-form-area">
                            <h3 class="heading-title"><?php echo dil_cevir( "Buradan yorum yazabilirsiniz.", $dizi_dil, $_REQUEST["dil"] ); ?></h3>
                            <form class="comment-form">
                                <div class="row g-5">
                                    <div class="form-group col-lg-6">
                                        <input type="hidden" name="dil" value="<?php echo $_REQUEST["dil"]; ?>">
                                        <input required type="text" name="adi_soyadi" id="comm-name" placeholder="<?php echo dil_cevir( "Adınız", $dizi_dil, $_REQUEST["dil"] ); ?> *">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input required type="email" name="email" id="comm-email" placeholder="<?php echo dil_cevir( "Email", $dizi_dil, $_REQUEST["dil"] ); ?> *">
                                    </div>
                                    <div class="form-group col-12">
                                        <textarea required name="mesaj" id="comm-message" cols="30" rows="5" placeholder="<?php echo dil_cevir( "Mesajınız", $dizi_dil, $_REQUEST["dil"] ); ?>  *"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="edu-form-check">
                                            <input required type="checkbox" id="save-info" class="form-check-input">
                                            <label for="save-info">
                                                <?php echo dil_cevir( "Ceza Kanununun 419. Maddesi 'Bilerek Yanlış İhbar' uyarınca cezai sorumluluğun bilincindeyim.", $dizi_dil, $_REQUEST["dil"] ); ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="edu-form-check">
                                            <input required type="checkbox" id="save-info2" class="form-check-input">
                                            <label for="save-info2">
                                                <?php echo dil_cevir( "Kazakistan Cumhuriyeti Ceza Kanununun 'Yalan beyanda bulunmak' 419. Maddesi kapsamında cezai sorumluluğun bilincindeyim.", $dizi_dil, $_REQUEST["dil"] ); ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="edu-btn submit-btn"><?php echo dil_cevir( "Mesaj Gönder", $dizi_dil, $_REQUEST["dil"] ); ?> <i class="icon-4"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
