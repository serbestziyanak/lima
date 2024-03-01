<?php
$SQL_birim_sayfa_tabs = <<< SQL
SELECT
  *
FROM 
  tb_birim_sayfa_icerikleri_tabs
WHERE
  sayfa_id = ? 
ORDER BY sira
SQL;

@$sayfa_tabs         = $vt->select($SQL_birim_sayfa_tabs, array( $sayfa_id ) )[ 2 ];

?>
    <?php if( count($sayfa_tabs) > 0 ){ ?>
    <div class="course-single-bottom">
        <ul class="nav course-tab" id="courseTab" role="tablist">
            <?php
            $sira = 0;
            $icon = array( "fa-regular fa-bookmark","fa-regular fa-star-sharp","fa-regular fa-book","fa-regular fa-user" );
            foreach( $sayfa_tabs as $sayfa_tab ){
                $sira++;
            ?>
            <li class="nav-item " role="presentation">
                <a style="" class="nav-link <?php if( $sira == 1 ) echo "active"; ?>" id="tab-<?php echo $sayfa_tab['id']; ?>" data-bs-toggle="tab" href="#Coursedescription<?php echo $sayfa_tab['id']; ?>" role="tab" aria-controls="Coursedescription" aria-selected="true">
                    <i class="<?php echo $icon[$sira-1]; ?>"></i>
                    <?php echo $sayfa_tab['baslik'.$dil]; ?>
                </a>
            </li>
            <?php 
            }
            ?>
        </ul>
        <div class="tab-content" id="productTabContent">
            <?php
            $sira = 0;
            foreach( $sayfa_tabs as $sayfa_tab ){
                $sira++;
            ?>
            <div class="tab-pane fade <?php if( $sira == 1 ) echo "show active"; ?>" id="Coursedescription<?php echo $sayfa_tab['id']; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $sayfa_tab['id']; ?>">
                <div class="course-description">
                    <h5 class="h5"><?php echo $sayfa_tab['baslik'.$dil]; ?></h5>
                    <div class="ck-content">
                        <?php echo $sayfa_tab['icerik'.$dil]; ?>
                    </div>
                </div>
            </div>
            <?php 
            }
            ?>
        </div>
    </div>
    <?php } ?>
