                        <?php if( count($sayfa_sssler) > 0 ){ ?>

                            <div class="accordion-area accordion" id="faqAccordion">                  
                            <?php $sira=0; foreach( $sayfa_sssler as $key => $sayfa_sss ){  ?>

                                <?php if( $sayfa_sss['baslik'.$dil] != "" ){  ?>

                                <div class="accordion-card ">
                                    <div class="accordion-header" id="collapse-item-<?php echo $sayfa_sss['id']; ?>">
                                        <button class="accordion-button baslik_renkli collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $sayfa_sss['id']; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $sayfa_sss['id']; ?>"><?php echo $sayfa_sss['baslik'.$dil]; ?></button>
                                    </div>
                                    <div id="collapse-<?php echo $sayfa_sss['id']; ?>" class="accordion-collapse collapse " aria-labelledby="collapse-item-<?php echo $sayfa_sss['id']; ?>" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text"><?php echo $sayfa_sss['icerik'.$dil]; ?></p>
                                        </div>
                                    </div>
                                </div> 

                                <?php } ?>
                            <?php } ?>
                            </div>
                        <?php } ?>
                        <!-- <div class="accordion-area accordion" id="faqAccordion">


                            <div class="accordion-card ">
                                <div class="accordion-header" id="collapse-item-1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="false" aria-controls="collapse-1">What Does It Take Excellent Author?</button>
                                </div>
                                <div id="collapse-1" class="accordion-collapse collapse " aria-labelledby="collapse-item-1" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p class="faq-text">The time it takes to repair a roof depends on the extent of the damage. For minor repairs, it might take an hour or two. For significant repairs, a Edura or team might be at your home for half a day.</p>
                                    </div>
                                </div>
                            </div>


                            <div class="accordion-card active">
                                <div class="accordion-header" id="collapse-item-2">
                                    <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="true" aria-controls="collapse-2">Purpose of education is the integral development?</button>
                                </div>
                                <div id="collapse-2" class="accordion-collapse collapse show" aria-labelledby="collapse-item-2" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p class="faq-text">The time it takes to repair a roof depends on the extent of the damage. For minor repairs, it might take an hour or two. For significant repairs, a Edura or team might be at your home for half a day.</p>
                                    </div>
                                </div>
                            </div>


                            <div class="accordion-card ">
                                <div class="accordion-header" id="collapse-item-3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">Education can contribute to the betterment?</button>
                                </div>
                                <div id="collapse-3" class="accordion-collapse collapse " aria-labelledby="collapse-item-3" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p class="faq-text">The time it takes to repair a roof depends on the extent of the damage. For minor repairs, it might take an hour or two. For significant repairs, a Edura or team might be at your home for half a day.</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->