<?php
if (isset($_SESSION['idCliente'])) {
    if(isset($_REQUEST['guardar'])){
        $nombreCli=$_REQUEST['nombreCli']??'';
        $emailCli=$_REQUEST['emailCli']??'';
        $direccionCli=$_REQUEST['direccionCli']??'';
        $queryCli="UPDATE clientes set nombre='$nombreCli',correo='$emailCli',direccion='$direccionCli' where id='".$_SESSION['idCliente']."' ";
        $resCli=mysqli_query($con,$queryCli);

        $nombreRec=$_REQUEST['nombreRec']??'';
        $emailRec=$_REQUEST['emailRec']??'';
        $direccionRec=$_REQUEST['direccionRec']??'';
        $queryRec="INSERT INTO recibe (nombre,correo,direccion,idCli) VALUES ('$nombreRec','$emailRec','$direccionRec','".$_SESSION['idCliente']."')
        ON DUPLICATE KEY UPDATE
        nombre='$nombreRec',correo='$emailRec',direccion='$direccionRec'; ";
        $resRec=mysqli_query($con,$queryRec);
        if($resCli && $resRec){
            echo '<meta http-equiv="refresh" content="0; url=tienda.php?modulo=pasarela" />';
        }
        else{
        ?>
            <div class="alert alert-danger" role="alert">
                Error
            </div>
        <?php
        }
    }
    $queryCli="SELECT nombre,correo,direccion from clientes where id='".$_SESSION['idCliente']."';";
    $resCli=mysqli_query($con,$queryCli);
    $rowCli=mysqli_fetch_assoc($resCli);

    $queryRec="SELECT nombre,correo,direccion from recibe where idCli='".$_SESSION['idCliente']."';";
    $resRec=mysqli_query($con,$queryRec);
    $rowRec=mysqli_fetch_assoc($resRec);

?>
    <form method="post">
        <div class="container mt-3">
            <div class="row">
                <div class="col-6">
                    <h3>Datos del cliente</h3>
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input type="text" name="nombreCli" id="nombreCli" class="form-control" value="<?php echo $rowCli['nombre'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="emailCli" id="emailCli" class="form-control" readonly="readonly" value="<?php echo $rowCli['correo'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Direccion</label>
                        <textarea name="direccionCli" id="direccionCli" class="form-control" row="3"><?php echo $rowCli['direccion'] ?></textarea>
                    </div>
                </div>
                <div class="col-6">
                    <h3>Datos de quien recibe</h3>
                    <div class="form-group">
                        <label for="">Nombre</label>
                        <input type="text" name="nombreRec" id="nombreRec" class="form-control" value="<?php echo $rowRec['nombre']??'' ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="emailRec" id="emailRec" class="form-control" value="<?php echo $rowRec['correo']??''  ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Direccion</label>
                        <textarea name="direccionRec" id="direccionRec" class="form-control" row="3"><?php echo $rowRec['direccion']??''  ?></textarea>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" id="jalar">
                            Obtener datos del cliente
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn btn-warning" href="tienda.php?modulo=carrito" role="button">Regresar al carrito</a>
        <button type="submit" class="btn btn-primary float-right" name="guardar" value="guardar">Ir a pagar</button>
    </form>
<?php
} else {
?>
    <div class="mt-5 text-center">
        Debe <a href="login.php">loguearse</a> o <a href="registro.php">registrarse</a>
    </div>
<?php
}
?>