                        <?php if( count($sayfa_tabs) > 0 ){ 
                            $goster = 0;
                            foreach( $sayfa_tabs as $key => $sayfa_tab ){
                                if( $sayfa_tab['baslik'.$dil] != "" )
                                    $goster = 1;
                            }
                            if( $goster == 1 ){
                        ?>
                        <div class="course-details-content">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <?php foreach( $sayfa_tabs as $key => $sayfa_tab ){ ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?php if ($key === array_key_first($sayfa_tabs)) echo "active"; ?>" id="<?php echo "tablar-".$sayfa_tab['id'] ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo "tablar-".$sayfa_tab['id'] ?>" type="button" role="tab" aria-controls="<?php echo "tablar-".$sayfa_tab['id'] ?>" aria-selected="true">
                                    <?php echo $sayfa_tab['baslik'.$dil] ?>
                                    </button>
                                </li>
                                <?php } ?>

                            </ul>

                            <div class="tab-content" id="myTabContent" style="border:1px solid #e5e5e5; border-bottom-left-radius:20px; border-bottom-right-radius:20px;">
                                <?php foreach( $sayfa_tabs as $key => $sayfa_tab ){ ?>
                                <div class="tab-pane fade <?php if ($key === array_key_first($sayfa_tabs)) echo "show active"; ?>" id="<?php echo "tablar-".$sayfa_tab['id'] ?>" role="tabpanel" aria-labelledby="<?php echo "tablar-".$sayfa_tab['id'] ?>-tab">
                                    <div class="course-tab-content" style="padding-left:20px;padding-right:20px;">
                                        <div class="course-overview">
                                            <?php if( $sayfa_tab['baslik'.$dil] != "" ){ ?>
                                            <!-- <h3 class="heading-title"><?php echo $sayfa_tab['baslik'.$dil]; ?></h3> -->
                                            <?php } ?>
                                            <p>
                                                <?php echo $sayfa_tab['icerik'.$dil]; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                            </div>
                        </div>
                        <?php }} ?>
