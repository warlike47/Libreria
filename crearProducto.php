<?php
    if(isset($_REQUEST['guardar'])){
        include_once "dbtumercado.php";
        $con=mysqli_connect($host, $user, $pass, $db);
        

        $nombre= mysqli_real_escape_string($con, $_REQUEST['nombre']??'');
        $precio=mysqli_real_escape_string($con, $_REQUEST['precio']??'');
        $existencia= mysqli_real_escape_string($con, $_REQUEST['existencia']??'');
        $foto= mysqli_real_escape_string($con, $_REQUEST['foto']??'');
        $descripcion= mysqli_real_escape_string($con, $_REQUEST['descripcion']??'');
        /*if(isset($_FILES['foto']['name'])){
          
            $tipoArchivo=$_FILES['foto']['type'];
            $nombreArchivo=$_FILES['foto']['name'];
            $tamanoArchivo=$_FILES['foto']['size'];
            $imagenSubida=fopen($_FILES['foto']['tmp_name'], 'r');
            $binariosImagen=fread($imagenSubida, $tamanoArchivo);
            $binariosImagen=mysqli_escape_string($con, $binariosImagen);
            $query="INSERT INTO imagenesproductos (nombre,imagen,tipo) values ('".$nombreArchivo."', '".$binariosImagen."', '".$tipoArchivo."')";
            $res=mysqli_query($con, $query);
            if($res){
              echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=productos&mensaje=Producto creado exitosamente" />';
            }else{
              ?>
                  <div class="alert alert-danger" role="alert">
                      Error al guardar imagen <?php echo mysqli_error($con); ?>
                  </div>
              <?php
            }
        }*/
        $query="INSERT INTO productos 
        (nombre, precio, existencia, foto, descripcion) VALUES
        ('".$nombre."', '".$precio."', '".$existencia."', '".$foto."', '".$descripcion."');
        ";
        $res=mysqli_query($con, $query);
        if($res){
            echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=productos&mensaje=Producto creado exitosamente" />';
        }else{
            ?>
                <div class="alert alert-danger" role="alert">
                    Error al crear producto <?php echo mysqli_error($con); ?>
                </div>
            <?php
        }
    }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Crear Producto</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              
              <!-- /.card-header -->
              <div class="card-body">
                <form action="panel.php?modulo=crearProducto" method="post">
                    <div class="form-group">
                        <label> Nombre </label>
                        <input type="text" name="nombre" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label> Precio </label>
                        <input type="number" name="precio" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label> Existencia </label>
                        <input type="number" name="existencia" class="form-control" required="required">
                    </div>
                    
                    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <?php
                if (isset($_REQUEST['guardar'])) {
                    if (isset($_FILES['foto']['name'])) {
                        $tipoArchivo = $_FILES['foto']['type'];
                        $nombreArchivo = $_FILES['foto']['name'];
                        $tamanoArchivo = $_FILES['foto']['size'];
                        $imagenSubida = fopen($_FILES['foto']['tmp_name'], 'r');
                        $binariosImagen = fread($imagenSubida, $tamanoArchivo);
                        include_once "dbtumercado.php";
                        $con=mysqli_connect($host, $user, $pass, $db);
                        $binariosImagen = mysqli_escape_string($con, $binariosImagen);
                        $query = "INSERT INTO imagenesproductos (nombre            ,imagen                 ,tipo) values 
                                                         ('" . $nombreArchivo . "','" . $binariosImagen . "','" . $tipoArchivo . "');
                            ";
                        $res = mysqli_query($con, $query);
                        if ($res) {
                ?>
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                Registro insertado exitosamente
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                Error <?php echo mysqli_error($con); ?>
                            </div>
                <?php

                        }
                    }
                }
                ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label> Descripcion </label>
                        <input type="text" name="descripcion" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label> Foto </label>
                        <input type="file" class="form-control-file" name="foto">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                    
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>