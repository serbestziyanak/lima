<?php

$SQL_yapisal_birimler = <<< SQL
SELECT
  *
FROM 
  tb_birim_agaci
WHERE
  ust_id = ? 
ORDER BY adi
SQL;

@$yapisal_birimler  = $vt->select($SQL_yapisal_birimler, array( 3 ) )[ 2 ];

?>

<?php if( count($yapisal_birimler) > 0 ){ ?>
<div class="course-details-content">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <?php foreach( $yapisal_birimler as $key => $yapisal_birim ){ ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?php if ($key === array_key_first($yapisal_birimler)) echo "active"; ?>" id="<?php echo "tablar-".$yapisal_birim['id'] ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo "tablar-".$yapisal_birim['id'] ?>" type="button" role="tab" aria-controls="<?php echo "tablar-".$yapisal_birim['id'] ?>" aria-selected="true">
                <?php echo $yapisal_birim['adi'.$dil] ?>
            </button>
        </li>
        <?php } ?>

    </ul>

    <div class="tab-content" id="myTabContent" style="border:1px solid #e5e5e5; border-bottom-left-radius:20px; border-bottom-right-radius:20px;">
        <?php foreach( $yapisal_birimler as $key => $yapisal_birim ){ ?>
        <div class="tab-pane fade <?php if ($key === array_key_first($yapisal_birimler)) echo "show active"; ?>" id="<?php echo "tablar-".$yapisal_birim['id'] ?>" role="tabpanel" aria-labelledby="<?php echo "tablar-".$yapisal_birim['id'] ?>-tab">
            <div class="course-tab-content" style="padding-left:20px;padding-right:20px;padding-bottom:30px;">
                <div class="course-curriculam" style="padding: 0 50px 0 50px;">
                    <div class="course-lesson" style="border:0px;padding : 0px;">
                        <ul>
                        <?php 
                        @$yapisal_alt_birimler  = $vt->select($SQL_yapisal_birimler, array( $yapisal_birim['id'] ) )[ 2 ];
                        foreach( $yapisal_alt_birimler as $key => $yapisal_alt_birim ){ 
                            if( trim($yapisal_alt_birim['link_url']) == "" ){
                                $link =  "birimler/$_REQUEST[dil]/$yapisal_alt_birim[kisa_ad]";
                            }else{
                                $link =  $yapisal_alt_birim['link_url'];
                            }
                        ?>
                            <li>
                                <div class="text"><i class="fa-solid fa-building-columns" style="color:#2A8DA3"></i> <a target="_blank" href="<?php echo $link; ?>"><?php echo $yapisal_alt_birim['adi'.$dil] ?></a></div>
                            </li>

                        <?php } ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <?php } ?>

    </div>




</div>
<?php } ?>
