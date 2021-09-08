<?php
include_once "dbtumercado.php";
//include_once "regresionLineal.php";
$con = mysqli_connect($host, $user, $pass, $db);

$queryNumVentas="SELECT COUNT(id) AS num from ventas 
where fecha BETWEEN DATE( DATE_SUB(NOW(),INTERVAL 7 DAY) ) AND NOW(); ";
$resNumVentas=mysqli_query($con,$queryNumVentas);
$rowNumVentas=mysqli_fetch_assoc($resNumVentas);

$queryNumClientes="SELECT COUNT(id) AS num from clientes; ";
$resNumClientes=mysqli_query($con,$queryNumClientes);
$rowNumClientes=mysqli_fetch_assoc($resNumClientes);



$queryVentasDia="SELECT
sum(detalleventas.subtotal) as total,
ventas.fecha
FROM
ventas
INNER JOIN detalleventas ON detalleventas.idVenta = ventas.id
GROUP BY DAY(ventas.fecha);";

$resVentasDia=mysqli_query($con,$queryVentasDia);
$labelVentas="";
$datosVentas="";

$x=array();
$y=array();
$dia=1;
while($rowVentasDia=mysqli_fetch_assoc($resVentasDia)){
  $labelVentas=$labelVentas."'". date_format(date_create($rowVentasDia['fecha']),"Y-m-d")."',";
  $datosVentas=$datosVentas.$rowVentasDia['total'].",";
  array_push($x,$dia);
  array_push($y,$rowVentasDia['total']);
  $dia++;
}
//$ia=new IAphp();
//$prediccionVentas=$ia->regresionLineal($x,$y);
/*$w=$prediccionVentas['w'];
$b=$prediccionVentas['b'];
$datosPrediccion="";
for ($i=0; $i < count($x)+2; $i++) { 
  $venta=$w*($i+1)+$b;
  $datosPrediccion=$datosPrediccion."'".$venta."',";
}
//echo $datosPrediccion;
$datosPrediccion=rtrim($datosPrediccion,",");*/
$labelVentas=rtrim($labelVentas,",");
$datosVentas=rtrim($datosVentas,",");

echo $labelVentas."<br>";
echo $datosVentas;

?>    

<html>
  <head>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <link rel="stylesheet" href="morris/morris.css">
    <script src="morris/morris.min.js"></script>
  </head>

  <body>
  <script>
  var labelVentas=[<?php echo $labelVentas; ?>,'2020-02-01','2020-02-02'];
  var datosVentas=[<?php echo $datosVentas; ?>];
  var datosPrediccion=[<?php echo $datosPrediccion; ?>];
</script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?php echo $rowNumVentas['num']; ?></h3>
                  <p>Ventas en los ultimos 7 dias</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?php echo $rowNumClientes['num'] ?></h3>
                  <p>Clientes</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-12 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Ventas por dia
                  </h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content p-0">
                    <!-- Morris chart - Sales -->
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 500px;">
                      <canvas id="revenue-chart-canvas" height="500" style="height: 500px;"></canvas>
                    </div>
                    <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 500px;">
                      <canvas id="sales-chart-canvas" height="500" style="height: 500px;"></canvas>
                    </div>
                  </div>
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
            <div id="sparkline-1">
            </div>
            <div id="sparkline-2">
            </div>
            <div id="sparkline-3">
            </div>

            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            
            <!-- right col -->

          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <div id="myfirstchart" style="height: 200px;"></div>
    <script>
        new Morris.Line({
        // ID of the element in which to draw the chart.
        element: 'myfirstchart',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: [
          { year: <?php echo $labelVentas; ?>, value: <?php echo $datosVentas; ?> },
          { year: '2009', value: 10 },
          { year: '2010', value: 5 },
          { year: '2011', value: 5 },
          { year: '2012', value: 20 }
        ],
        // The name of the data record attribute that contains x-values.
        xkey: 'year',
        // A list of names of data record attributes that contain y-values.
        ykeys: ['value'],
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['Value']
      });
    </script>

  </body>

</html>


