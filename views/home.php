<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){

  require_once("../modelos/Ciudadanos.php");
  $ciudadano = new Ciudadano();

  require_once("../modelos/Pvisita.php");
  $visita = new Pvisita();

  require_once("../modelos/Tramite.php");
  $tramite = new Tramite();

  require_once("../modelos/Usuarios.php");
  $usuario = new Usuario();

?>

  <?php 
    require_once("header.php");
  ?>
    <!--___________________________CONTENIDO______________________________-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Inicio</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?php echo $ciudadano->get_filas_ciudadano(); ?></h3>
              <h5>Ciudadanos Registrados</h5>
            </div>
            <div class="icon">
              <i class="fas fa-user-plus"></i>
            </div>
            <a href="" class="small-box-footer">  &nbsp;  </i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?php echo $visita->get_filas_visita(); ?></h3>
              <h5>Visitas Registradas</h5>
            </div>
            <div class="icon">
              <i class="nav-icon fa fa-clipboard"></i>
            </div>
            <a href="pvisita.php" class="small-box-footer">  &nbsp;  </a>
          </div>
        </div>
        
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?php echo $usuario->get_filas_usuario(); ?></h3>
              <h5>Usuarios Registrados</h5>
            </div>
            <div class="icon">
              <i class="fas fa-user-edit"></i>
            </div>
            <a href="" class="small-box-footer">  &nbsp; </i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?php echo $tramite->get_filas_tramite(); ?></h3>
              <h5>Total Tramites</h5>
            </div>
            <div class="icon">
              <i class="fas fa-chart-pie"></i>
            </div>
            <a href="" class="small-box-footer">   &nbsp;  </i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
    <!-- /.content-wrapper -->
    <!--___________________________CONTENIDO______________________________-->

    


  <?php 
    require_once("footer.php");
  ?>

<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>
