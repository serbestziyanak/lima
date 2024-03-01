<?php 
if( $_SESSION[ 'rol_id' ] == 1 AND $_SESSION[ 'super' ] != 1 ){
  include "_modul/personelDetay/personelDetay.php";

}else{
$fn	= new Fonksiyonlar();
$vt = new VeriTabani();


$SQL_tum_personel_sayisi = <<< SQL
SELECT count(*) AS sayi FROM tb_personeller WHERE aktif = 1 
SQL;

$SQL_erkek_personel_sayisi = <<< SQL
SELECT count(*) AS sayi FROM tb_personeller WHERE aktif = 1 AND cinsiyet = 2
SQL;

$SQL_kadin_personel_sayisi = <<< SQL
SELECT count(*) AS sayi FROM tb_personeller WHERE aktif = 1 AND cinsiyet = 1
SQL;

$SQL_akademik_personel_sayisi = <<< SQL
SELECT 
	count(*) As sayi
FROM 
	tb_personeller AS p
LEFT JOIN tb_personel_calisma_yeri_bilgileri AS pcy ON p.id = pcy.personel_id AND pcy.aktif_calisma_yeri=1
WHERE 
    aktif = 1 AND pcy.personel_nitelik_id = 1
SQL;

$SQL_idari_personel_sayisi = <<< SQL
SELECT 
	count(*) As sayi
FROM 
	tb_personeller AS p
LEFT JOIN tb_personel_calisma_yeri_bilgileri AS pcy ON p.id = pcy.personel_id AND pcy.aktif_calisma_yeri=1
WHERE 
    aktif = 1 AND pcy.personel_nitelik_id = 2
SQL;

$SQL_enstitu_personel_sayisi = <<< SQL
SELECT 
	count(*) As sayi
FROM 
	tb_personeller AS p
LEFT JOIN tb_personel_calisma_yeri_bilgileri AS pcy ON p.id = pcy.personel_id AND pcy.aktif_calisma_yeri=1
WHERE 
    aktif = 1 AND pcy.personel_nitelik_id = 3
SQL;

$SQL_akademik_dereceler = <<< SQL
SELECT 
	count(*) as sayi 
	,ad.adi     AS adi
	,ad.adi_kz  AS adi_kz
	,ad.adi_en  AS adi_en
	,ad.adi_ru  AS adi_ru
FROM 
	tb_personel_calisma_yeri_bilgileri AS pcy
LEFT JOIN tb_akademik_dereceler AS ad ON ad.id = pcy.akademik_derece_id
LEFT JOIN tb_personeller AS p ON p.id = pcy.personel_id
WHERE 
	pcy.aktif_calisma_yeri = 1 and pcy.akademik_derece_id>0 and p.aktif=1
GROUP BY pcy.akademik_derece_id
SQL;

$SQL_akademik_unvanlar = <<< SQL
SELECT 
	count(*) as sayi 
	,ad.adi     AS adi
	,ad.adi_kz  AS adi_kz
	,ad.adi_en  AS adi_en
	,ad.adi_ru  AS adi_ru
FROM 
	tb_personel_calisma_yeri_bilgileri AS pcy
LEFT JOIN tb_akademik_unvanlar AS ad ON ad.id = pcy.akademik_unvan_id
LEFT JOIN tb_personeller AS p ON p.id = pcy.personel_id
WHERE 
	pcy.aktif_calisma_yeri = 1 and pcy.akademik_unvan_id>0 and p.aktif=1
GROUP BY pcy.akademik_unvan_id
SQL;

$SQL_personel_turleri = <<< SQL
SELECT 
	count(*) as sayi 
	,ad.adi     AS adi
	,ad.adi_kz  AS adi_kz
	,ad.adi_en  AS adi_en
	,ad.adi_ru  AS adi_ru
FROM 
	tb_personel_calisma_yeri_bilgileri AS pcy
LEFT JOIN tb_personel_nitelikleri AS ad ON ad.id = pcy.personel_nitelik_id
LEFT JOIN tb_personeller AS p ON p.id = pcy.personel_id
WHERE 
	pcy.aktif_calisma_yeri = 1 and pcy.personel_nitelik_id>0 and p.aktif=1
GROUP BY pcy.personel_nitelik_id
SQL;


$SQL_fakulte_personelleri = <<< SQL
SELECT 
	sum( case when pcy.personel_nitelik_id = 1 then 1 else 0 end ) as akademik
	,sum( case when pcy.personel_nitelik_id = 2 then 1 else 0 end ) as idari
	,b2.adi     AS adi
	,b2.adi_kz  AS adi_kz
	,b2.adi_en  AS adi_en
	,b2.adi_ru  AS adi_ru
FROM 
	tb_personel_calisma_yeri_bilgileri AS pcy
LEFT JOIN tb_birim_agaci AS b1 ON b1.id = pcy.birim_id
LEFT JOIN tb_birim_agaci AS b2 ON b2.id = b1.ust_id
LEFT JOIN tb_personeller AS p ON p.id = pcy.personel_id
WHERE 
	pcy.aktif_calisma_yeri = 1 and pcy.birim_id > 0 and b2.birim_turu=2 and p.aktif=1
GROUP BY b2.id ORDER BY adi$dil
SQL;

$SQL_birim_sayilari = <<< SQL
SELECT 
	 bt.adi     AS birim_turu_adi
	,bt.adi_kz  AS birim_turu_adi_kz
	,bt.adi_en  AS birim_turu_adi_en
	,bt.adi_ru  AS birim_turu_adi_ru
	,count(*) as sayi
	,ba.* 
FROM 
	tb_birim_agaci AS ba 
LEFT JOIN tb_birim_turleri AS bt ON bt.id = ba.birim_turu
WHERE ba.birim_turu > 0 AND ba.birim_turu != 1
GROUP BY ba.birim_turu
SQL;


$personel_sayisi 	                    = $vt->selectSingle( $SQL_tum_personel_sayisi, array(  ) )[ 2 ]['sayi'];
$akademik_personel_sayisi 	            = $vt->selectSingle( $SQL_akademik_personel_sayisi, array(  ) )[ 2 ]['sayi'];
$idari_personel_sayisi 	                = $vt->selectSingle( $SQL_idari_personel_sayisi, array(  ) )[ 2 ]['sayi'];
$enstitu_personel_sayisi 	            = $vt->selectSingle( $SQL_enstitu_personel_sayisi, array(  ) )[ 2 ]['sayi'];
$erkek_personel_sayisi 	                = $vt->selectSingle( $SQL_erkek_personel_sayisi, array(  ) )[ 2 ]['sayi'];
$kadin_personel_sayisi 	                = $vt->selectSingle( $SQL_kadin_personel_sayisi, array(  ) )[ 2 ]['sayi'];
$akademik_dereceler     	            = $vt->select( $SQL_akademik_dereceler, array(  ) )[ 2 ];
$akademik_unvanlar       	            = $vt->select( $SQL_akademik_unvanlar, array(  ) )[ 2 ];
$personel_turleri       	            = $vt->select( $SQL_personel_turleri, array(  ) )[ 2 ];
$fakulte_personelleri      	            = $vt->select( $SQL_fakulte_personelleri, array(  ) )[ 2 ];
$birim_sayilari         	            = $vt->select( $SQL_birim_sayilari, array(  ) )[ 2 ];


?>
<style>
    .renk1{ background-color:#581659 !important;}
    .renk2{ background-color:#284F47 !important;}
    .renk3{ background-color:#4FB99F !important;}
    .renk4{ background-color:#F2B134 !important;}
    .renk5{ background-color:#ED553B !important;}
    .renk6{ background-color:#355B8C !important;}
    .renk7{ background-color:#FE5F1B !important;}
    .renk8{ background-color:#33ABB1 !important;}
    .renk9{ background-color:#CC9612 !important;}
    .renk10{background-color:#103754 !important;}
    .renk11{background-color:#284F47 !important;}
    .renk12{background-color:#334F70 !important;}
    .renk13{background-color:#D53D13 !important;}
    .renk14{background-color:#F76A24 !important;}
    .renk15{background-color:#0080D1 !important;}
    .renk16{background-color:#581659 !important;}
    .renk17{background-color:#008773 !important;}
    .renk18{background-color:#6BB983 !important;}
    .renk19{background-color:#F2C975 !important;}
    .renk20{background-color:#ED6353 !important;}  
</style>
        <div class="row">
            <?php $sayi=1; foreach( $birim_sayilari as $result ){ ?>
            <div class="col-lg-2 col-6">
                <!-- small box -->
                <div class="small-box bg-info renk<?php echo $sayi; ?>">
                    <div class="inner">
                        <h3><?php echo $result['sayi']; ?></h3>

                        <p><?php echo $result["birim_turu_adi".$dil]; ?></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-university"></i>
                    </div>
                </div>
            </div>
            <?php $sayi++; } ?>
        </div>
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $personel_sayisi; ?></h3>

                <p><?php echo dil_cevir( "Personel", $dizi_dil, $sistem_dil ); ?></p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="?modul=personeller" class="small-box-footer"><?php echo dil_cevir( "Daha Fazla", $dizi_dil, $sistem_dil ); ?> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $akademik_personel_sayisi; ?></h3>

                <p><?php echo dil_cevir( "Akademik Personel", $dizi_dil, $sistem_dil ); ?></p>
              </div>
              <div class="icon">
                <i class="fas fa-user-tie"></i>
              </div>
              <a href="?modul=personeller&personel_nitelik_id=1&filtre" class="small-box-footer"><?php echo dil_cevir( "Daha Fazla", $dizi_dil, $sistem_dil ); ?> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-orange text-white">
              <div class="inner">
                <h3 class="text-white"><?php echo $idari_personel_sayisi; ?></h3>

                <p class="text-white"><?php echo dil_cevir( "İdari Personel", $dizi_dil, $sistem_dil ); ?></p>
              </div>
              <div class="icon">
                <i class="fas fa-user-cog"></i>
              </div>
              <a href="?modul=personeller&personel_nitelik_id=2&filtre" class="small-box-footer" style="color:#ffffff !important;"><?php echo dil_cevir( "Daha Fazla", $dizi_dil, $sistem_dil ); ?> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $enstitu_personel_sayisi; ?></h3>

                <p><?php echo dil_cevir( "Enstitü Personeli", $dizi_dil, $sistem_dil ); ?></p>
              </div>
              <div class="icon">
                <i class="fas fa-user-tag"></i>
              </div>
              <a href="?modul=personeller&personel_nitelik_id=3&filtre" class="small-box-footer"><?php echo dil_cevir( "Daha Fazla", $dizi_dil, $sistem_dil ); ?> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-md-3">
            <div class="card card-maroon">
              <div class="card-header">
                <h3 class="card-title"><?php echo dil_cevir( "Cinsiyet", $dizi_dil, $sistem_dil ); ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="cinsiyet_pie" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
          </div>

          <div class="col-md-3">
            <div class="card card-olive">
              <div class="card-header">
                <h3 class="card-title"><?php echo dil_cevir( "Akademik Dereceler", $dizi_dil, $sistem_dil ); ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="akademik_derece_pie" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
          </div>

          <div class="col-md-3">
            <div class="card card-purple">
              <div class="card-header">
                <h3 class="card-title"><?php echo dil_cevir( "Doçent / Profesör", $dizi_dil, $sistem_dil ); ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="docent_profesor_pie" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
          </div>

          <div class="col-md-3">
            <div class="card card-danger">
              <div class="card-header" style="background-color:#CC9612">
                <h3 class="card-title"><?php echo dil_cevir( "Personel Türleri", $dizi_dil, $sistem_dil ); ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="personel_turleri_pie" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-md-8">
            <div class="card card-success">
              <div class="card-header" style="background-color:#284F47;">
                <h3 class="card-title">Fakülte Personelleri</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>

          <div class="col-md-4">
            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <!-- tools card -->
                <!-- <div class="card-tools">
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
                    <!-- sparkline silinince takvim çalışmıyor-->
                    <div id="sparkline-1" class="d-none"></div>
                    <div id="sparkline-2" class="d-none"></div>
                    <div id="sparkline-3" class="d-none"></div>
              </div>
              <!-- /.card-body -->
            </div>

          </div>
          



          <!-- /.col (RIGHT) -->
        </div>

        <!-- Main row -->

          <!-- Silinince takvim gelmiyor-->



<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------





    var fakultePersonelData = {
      labels  : [
        <?php foreach( $fakulte_personelleri AS $result ){ 
            echo "'".$result['adi'.$dil]."',";
         } ?>
      ],
      datasets: [
        {
          label               : 'Akademik Personel',
          backgroundColor     : '#355B8C',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [
            <?php foreach( $fakulte_personelleri AS $result ){ 
                echo $result['akademik'].",";
            } ?>
          ]
        },
        {
          label               : 'İdari Personel',
          backgroundColor     : '#F76A24',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [
            <?php foreach( $fakulte_personelleri AS $result ){ 
                echo $result['idari'].",";
            } ?>
          ]
        },
      ]
    }


    //-------------
    //- LINE CHART -
    //--------------

    //-------------
    //- DONUT CHART -
    //-------------

    var erkek_kadin_data        = {
      labels: [
          '<?php echo dil_cevir( "Kadın", $dizi_dil, $sistem_dil ); ?> (<?php echo $kadin_personel_sayisi; ?>)',
          '<?php echo dil_cevir( "Erkek", $dizi_dil, $sistem_dil ); ?> (<?php echo $erkek_personel_sayisi; ?>)',
      ],
      datasets: [
        {
          data: [<?php echo $kadin_personel_sayisi; ?>,<?php echo $erkek_personel_sayisi; ?>],
          backgroundColor : ['#f56954', '#3c8dbc', '#00a65a', '#f39c12', '#00c0ef', '#d2d6de'],
        }
      ]
    }
    new Chart($('#cinsiyet_pie').get(0).getContext('2d'), {
        type: 'pie',
        data: erkek_kadin_data,
        options: {
            maintainAspectRatio : false,
            responsive : true,
            plugins: {
                labels: {
                render: 'percentage', // render 'label', 'value', 'percentage', 'image' or custom function, default is 'percentage'
                fontColor: '#fff',
                }
            }
        }
    })


    var akademikDerecelerData = {
      labels: [
        <?php foreach( $akademik_dereceler AS $result ){ 
            echo "'".$result['adi'.$dil]." (".$result['sayi'].")',";
         } ?>
      ],
      datasets: [
        {
          data: [
        <?php foreach( $akademik_dereceler AS $result ){ 
            echo $result['sayi'].",";
         } ?>
          ],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    new Chart($('#akademik_derece_pie').get(0).getContext('2d'), {
        type: 'doughnut',
        data: akademikDerecelerData,
        options: {
            maintainAspectRatio : false,
            responsive : true,
            plugins: {
                labels: {
                render: 'percentage', // render 'label', 'value', 'percentage', 'image' or custom function, default is 'percentage'
                fontColor: '#fff',
                }
            }
        }
    })

    var docentProfesorData = {
      labels: [
        <?php foreach( $akademik_unvanlar AS $result ){ 
            echo "'".$result['adi'.$dil]." (".$result['sayi'].")',";
         } ?>
      ],
      datasets: [
        {
          data: [
        <?php foreach( $akademik_unvanlar AS $result ){ 
            echo $result['sayi'].",";
         } ?>
          ],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    new Chart($('#docent_profesor_pie').get(0).getContext('2d'), {
        type: 'pie',
        data: docentProfesorData,
        options: {
            maintainAspectRatio : false,
            responsive : true,
            plugins: {
                labels: {
                render: 'percentage', // render 'label', 'value', 'percentage', 'image' or custom function, default is 'percentage'
                fontColor: '#fff',
                }
            }
        }
    })

    var personelTurleriData = {
      labels: [
        <?php foreach( $personel_turleri AS $result ){ 
            echo "'".$result['adi'.$dil]." (".$result['sayi'].")',";
         } ?>
      ],
      datasets: [
        {
          data: [
        <?php foreach( $personel_turleri AS $result ){ 
            echo $result['sayi'].",";
         } ?>
          ],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    new Chart($('#personel_turleri_pie').get(0).getContext('2d'), {
        type: 'doughnut',
        data: personelTurleriData,
        options: {
            maintainAspectRatio : false,
            responsive : true,
            plugins: {
                labels: {
                render: 'percentage', // render 'label', 'value', 'percentage', 'image' or custom function, default is 'percentage'
                fontColor: '#fff',
                }
            }
        }
    })



    var donutData        = {
      labels: [
          'Chrome',
          'IE',
          'FireFox',
          'Safari',
          'Opera',
          'Navigator',
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }



    //-------------
    //- PIE CHART -
    //-------------
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.





    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, fakultePersonelData)
    var temp0 = fakultePersonelData.datasets[0]
    var temp1 = fakultePersonelData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>


<?php } ?>