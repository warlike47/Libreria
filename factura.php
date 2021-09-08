<?php
    $total=$_REQUEST['total']??'';
    include_once "stripe/init.php";

    \Stripe\Stripe::setApiKey("sk_test_51IyTodIvLbty7MKlm0tW3cALxq8FehM3W01pGAOdLiy6yAfqroxRbRnsUQLJREH0YmrbvUxmLQMYDVJI8ruvmHh7009c92Tk7K");
    $token=$_POST['stripeToken'];

    $charge=\Stripe\Charge::create([
        'amount'=>$total,
        'currency'=>'usd',
        'description'=>'Pago a TuMercado',
        'source'=>$token
    ]);
    if($charge['captured']){
        $queryVenta="INSERT INTO ventas 
        (idCli                       ,idPago             ,fecha) values
        ('".$_SESSION['idCliente']."','".$charge['id']."',now());
        ";
        $resVenta=mysqli_query($con,$queryVenta);
        $id=mysqli_insert_id($con);
        /*
        if($resVenta){
            echo "La venta fue exitosa con el id=".$id;
        } */
        $insertaDetalle="";
        $cantProd=count($_REQUEST['id']);
        for($i=0;$i<$cantProd;$i++){
            $subTotal=$_REQUEST['precio'][$i]*$_REQUEST['cantidad'][$i];
            $insertaDetalle=$insertaDetalle."('".$_REQUEST['id'][$i]."','$id','".$_REQUEST['cantidad'][$i]."','".$_REQUEST['precio'][$i]."','$subTotal'),";
        }
        $insertaDetalle=rtrim($insertaDetalle,",");
        $queryDetalle="INSERT INTO detalleVentas 
        (idProducto, idVenta, cantidad, precio, subtotal) values 
        $insertaDetalle;";
        echo  $queryDetalle;
        $resDetalle=mysqli_query($con,$queryDetalle);
        if($resVenta && $resDetalle){
            ?>
            <div class="row">
                <div class="col-6">
                    <?php muestraRecibe($id); ?>
                </div>
                <div class="col-6">
                    <?php muestraDetalle($id); ?>
                </div>
            </div>
            <?php
            borrarCarrito();
        }
    }
    function borrarCarrito(){
        ?>
            <script>
                $.ajax({
                    type: "post",
                    url: "borrarCarrito.php",
                    dataType: "json",
                    success: function (response) {
                        $("#badgeProducto").text("");
                        $("#listaCarrito").text("");
                    }
                });
            </script>
        <?php
    }
    function muestraRecibe($idVenta){
    ?>
    <table class="table">
        <thead>
            <tr>
                <th colspan="3" class="text-center">Persona que recibe</th>
            </tr>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Direccion</th>
            </tr>
        </thead>
        <tbody>
            <?php
                global $con;
                $queryRecibe="SELECT nombre,correo,direccion 
                from recibe 
                where idCli='".$_SESSION['idCliente']."';";
                $resRecibe=mysqli_query($con,$queryRecibe);
                $row=mysqli_fetch_assoc($resRecibe);
            ?>
            <tr>
                <td><?php echo $row['nombre'] ?></td>
                <td><?php echo $row['correo'] ?></td>
                <td><?php echo $row['direccion'] ?></td>
            </tr>
        </tbody>
    </table>
    <?php
    }
    function muestraDetalle($idVenta){
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="3" class="text-center">Detalle de venta</th>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>SubTotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    global $con;
                    $queryDetalle="SELECT
                    p.nombre,
                    dv.cantidad,
                    dv.precio,
                    dv.subtotal
                    FROM
                    ventas AS v
                    INNER JOIN detalleVentas AS dv ON dv.idVenta = v.id
                    INNER JOIN productos AS p ON p.id = dv.idProducto
                    WHERE
                    v.id = '$idVenta'";
                    $resDetalle=mysqli_query($con,$queryDetalle);
                    $total=0;
                    while($row=mysqli_fetch_assoc($resDetalle)){
                        $total=$total+$row['subtotal'];
                ?>
                <tr>
                    <td><?php echo $row['nombre'] ?></td>
                    <td><?php echo $row['cantidad'] ?></td>
                    <td><?php echo $row['precio'] ?></td>
                    <td><?php echo $row['subtotal'] ?></td>
                </tr>
                <?php
                    }
                ?>
                <tr>
                    <td colspan="3" class="text-right">Total:</td>
                    <td><?php echo $total; ?></td>
                </tr>

            </tbody>
        </table>
        <a class="btn btn-secondary float-right" target="_blank" href="imprimirFactura.php?idVenta=<?php echo $idVenta; ?>" role="button">Imprimir factura <i class="fas fa-file-pdf"></i> </a>
        <?php
        }

?>