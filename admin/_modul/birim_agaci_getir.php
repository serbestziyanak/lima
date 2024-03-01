<?php


$SQL_ust_id_getir = <<< SQL
WITH RECURSIVE ust_kategoriler AS (
    SELECT id, ust_id, adi
    FROM tb_birim_agaci
    WHERE id = ? -- burası istediğiniz başlangıç ID'si
    UNION ALL
    SELECT k.id, k.ust_id, k.adi
    FROM tb_birim_agaci k
    JOIN ust_kategoriler uk ON k.id = uk.ust_id
)
SELECT * FROM ust_kategoriler;
SQL;

$where="";
if( $_SESSION['super'] == 1 ){
	$where = "";
	$birim_idler = array();
}else{
	$birim_idler = explode(",",$_SESSION[ 'birim_idler' ]);
	foreach( $birim_idler as $birim_id2 ){
		$ust_idler	= $vt->select( $SQL_ust_id_getir, array( $birim_id2 ) )[ 2 ];
		foreach($ust_idler as $ust_id) 
			$ust_id_dizi[] = $ust_id['id'];
	}
	$ust_id_dizi = array_unique($ust_id_dizi);
	sort($ust_id_dizi);
	$birim_idler2 = implode(",",$ust_id_dizi);
	$where = "WHERE id IN (".$birim_idler2.")";
}

$SQL_birim_agaci_getir = <<< SQL
SELECT
	*
FROM 
	tb_birim_agaci
$where
SQL;

@$birim_agaclari 		= $vt->select($SQL_birim_agaci_getir, array(  ) )[ 2 ];


function kategoriListele3( $url_modul, $kategoriler, $parent = 0, $renk = 0,$vt, $ogrenci_id, $sistem_dil, $birim_idler){
	$sistem_dil2 = $sistem_dil == "_tr" ? "" : $sistem_dil ;
	$adi = "adi".$sistem_dil2;

	$html = "<tr class='expandable-body'>
					<td>
						<div class='p-0'>
							<table class='table table-hover'>
								<tbody>";

	foreach ($kategoriler as $kategori){
		if( $kategori['ust_id'] == $parent ){
			if( $parent == 0 ) {
				$renk = 1;
			} 

			if( $kategori['kategori'] == 0){
				$html .= "
						<tr>
							<td class=' bg-renk7 p-1' >
								$kategori[$adi]
								<a modul= '$url_modul' yetki_islem='birim_sec' href='index.php?modul=$url_modul&birim_id=$kategori[id]&birim_adi=$kategori[$adi]' onclick='event.stopPropagation();'  class='btn btn-dark float-right btn-xs ml-1' >Seç</a>
							</td>
						</tr>";									

			}
			if( $kategori['kategori'] == 1 ){

				if( $kategori['ust_id'] <= 2   ){
					$agac_acik = "true";
				}else{
					// if( strlen($_SESSION['birim_idler']) > 0  )
					// 	$agac_acik = "true";
					// else
					// 	$agac_acik = "false";
                    
					$agac_acik = "false";

				}

				if( $kategori['grup'] == 1 ){
					$birim_sec_butonu = "";
				}else{
					if( ( strlen($_SESSION['birim_idler']) > 0 and in_array($kategori['id'], $birim_idler) ) or $_SESSION['super'] > 0 ){
						$birim_sec_butonu = "<a modul= '$url_modul' yetki_islem='birim_sec' href='index.php?modul=$url_modul&birim_id=$kategori[id]&birim_adi=$kategori[$adi]' onclick='event.stopPropagation();'  class='btn btn-dark float-right btn-xs ml-1' >Seç</a>";
					}
				}
					$html .= "
							<tr data-widget='expandable-table' aria-expanded='$agac_acik' class='border-0'>
								<td class='bg-renk$renk p-1'>																
									$kategori[$adi]
									$birim_sec_butonu
								<i class='expandable-table-caret fas fa-caret-right fa-fw'></i>
								</td>
							</tr>
						";								
					$renk++;
					$html .= kategoriListele3($url_modul,$kategoriler, $kategori['id'],$renk, $vt, $ogrenci_id, $sistem_dil, $birim_idler);
					
					$renk--;
				
			}
		}

	}
	$html .= '
							</tbody>
						</table>
					</div>
				</td>
			</tr>';
	return $html;
}
?>