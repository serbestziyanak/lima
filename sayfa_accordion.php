<!--
                        <?php if( count($sayfa_sssler) > 0 ){ ?>
                            <style>
                            .accordion-button:not(.collapsed) {
                                color: #fff;
                                background-color:#2A8DA3;
                                font-size: 16px;
                            }
                            .accordion-button.collapsed {
                                color: #2A8DA3;
                                background-color: #fff;
                                font-size: 16px;
                            }
                            .accordion-button:not(.collapsed) .simge-plus {
                                display: none;
                            }
                            .accordion-button.collapsed .simge-minus {
                                display: block;
                            }
                            .accordion-button.collapsed .simge-plus {
                                display: block;
                            }
                            .accordion-button.collapsed .simge-minus {
                                display: none;
                            }
                            </style>
                        
                            <?php $sira=0; foreach( $sayfa_sssler as $key => $sayfa_sss ){  ?>

                                <?php if( $sayfa_sss['baslik'.$dil] != "" ){ $sira++; ?>
                                    <?php if( $sira == 1 ){ ?>
                                        <div class="accordion" id="accordionExample" >
                                    <?php } ?>
                                    <div class="accordion-item" style="border-radius: 30px;box-shadow: 5px 5px 5px rgba(195, 195, 195, .3);;">
                                        <h2 class="accordion-header" style="border-radius: 30px;border: 1px solid #d7d7d7" id="headingOne-<?php echo $sayfa_sss['id']; ?>">
                                            <button style="border-radius: 30px;padding:30px;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-<?php echo $sayfa_sss['id']; ?>" aria-expanded="<?php if( $sira == 1 ) echo "true"; else echo "false"; ?>" aria-controls="collapseOne-<?php echo $sayfa_sss['id']; ?>">
                                                <i class="fa-solid fa-square-plus simge-plus" style="font-size:18px;"></i> <i class="fa-solid fa-square-minus simge-minus"  style="font-size:18px;"></i>&nbsp;&nbsp;&nbsp; <b><?php echo $sayfa_sss['baslik'.$dil]; ?></b>
                                            </button>
                                        </h2>
                                        <div id="collapseOne-<?php echo $sayfa_sss['id']; ?>" class="accordion-collapse collapse" aria-labelledby="headingOne-<?php echo $sayfa_sss['id']; ?>" data-bs-parent="#accordionExample">
                                            <div class="accordion-body"  style="padding-left:30px;padding-right:30px;">
                                                <?php echo $sayfa_sss['icerik'.$dil]; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                <?php } ?>



                            <?php } ?>
                            <?php if( $sira > 0 ){ ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
-->                        

                    <?php 
                        if( count($sayfa_sssler) > 0 ){ 
                            $ilk_acik_mi = 1;
                    ?>
                        <div class="edu-faq-content">
                            <div class="faq-accordion" id="faq-accordion">
                                <div class="accordion">
                                <?php $sira=0; foreach( $sayfa_sssler as $key => $sayfa_sss ){  ?>
                                <?php 
                                    if( $sayfa_sss['baslik'.$dil] != "" ){ $sira++; 
                                        if( $ilk_acik_mi == 1 and $sira == 1 ){
                                            $class1 = "";
                                            $class2 = "true";
                                            $class3 = "show";
                                        }else{
                                            $class1 = "collapsed";
                                            $class2 = "false";
                                            $class3 = "";
                                        }
                                ?>

                                    <div class="accordion-item">
                                        <h5 class="accordion-header">
                                            <button class="accordion-button <?php echo $class1; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $sayfa_sss['id']; ?>" aria-expanded="<?php echo $class2; ?>">
                                                <?php echo $sayfa_sss['baslik'.$dil]; ?>
                                            </button>
                                        </h5>
                                        <div id="collapseOne<?php echo $sayfa_sss['id']; ?>" class="accordion-collapse collapse <?php echo $class3; ?>" data-bs-parent="#faq-accordion">
                                            <div class="accordion-body">
                                                <p>
                                                    <?php echo $sayfa_sss['icerik'.$dil]; ?>                                                
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php } ?>
                                </div>
                            </div>
                            <ul class="shape-group">
                                <li class="shape-1 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                                    <img data-depth="1.5" src="assets/images/about/shape-02.png" alt="Shape Images">
                                </li>
                                <li class="shape-2 scene" data-sal-delay="500" data-sal="fade" data-sal-duration="200">
                                    <span data-depth="-2.2"></span>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
