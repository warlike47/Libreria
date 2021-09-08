

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TuMercado</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="preload" href="css/normalize.css" as="style">
    <link rel="stylesheet" href="css/normalize.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="preload" href="styles.css" as="style">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="stripe.css">

    <?php
        session_start();
        $accion=$_REQUEST['accion']??'';
        if($accion=='cerrar'){
            session_destroy();
            header("Refresh:0");
        }
    ?>

</head>
<body>
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
<?php
  include_once "dbtumercado.php";
  $con=mysqli_connect($host, $user, $pass, $db);
  
?>
    <div class="container fondo">
        <div class="row">
            <div class="col-12">
                <?php
                include_once "menu.php";
                $modulo=$_REQUEST['modulo']??'';
                if($modulo=="productos" || $modulo=="" ){
                    include_once "productosDetalles.php";
                }
                if( $modulo=="detalleproducto" ){
                    include_once "detalleProducto.php";
                }
                if( $modulo=="carrito" ){
                    include_once "carrito.php";
                }
                if( $modulo=="envio" ){
                    include_once "envio.php";
                }
                if( $modulo=="pasarela" ){
                    include_once "pasarela.php";
                }
                if( $modulo=="factura" ){
                    include_once "factura.php";
                }
                ?>
                <main class="contenedor">
        <h1>Nuestros Productos</h1>

        <div class="grid">

        <?php
                                    
            $query="SELECT  id,nombre,precio,existencia,foto from productos;";
            $res=mysqli_query($con, $query);
                                    
                                    
            while($row=mysqli_fetch_assoc($res)){
        ?>
        <tr>
            <div class="producto">
                <a href="tienda.php?modulo=detalleproducto&id=<?php echo $row['id'] ?>">
                <td><?php echo '<img height="80" width="80" src="data:image/jpeg;base64,'.base64_encode($row['foto']).'"/>'; ?></td>

                    <div class="producto__informacion">
                        <p class="producto__nombre"><?php echo $row['nombre'] ?></p>
                        <p class="producto__precio"><?php echo $row['precio'] ?></p>
                        <p class="producto__existencia"><?php echo $row['existencia'] ?> Unidades</p>
                    </div>
                </a>
            </div>
        </tr>
        <?php
            }
        ?>

              <!--Fin de producto-->
            

            <!--<div class="grafico grafico--camisas"></div>
            <div class="grafico grafico--node"></div>-->
            
        </div>
        </main>
            </div>
        </div>
    </div>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="stripe.js"></script>
    <script src="ecommerce.js"></script>
</body>
</html> 