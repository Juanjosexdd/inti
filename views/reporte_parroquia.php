<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){
?>

<?php
  require_once("header.php");
?>


<form method="post" id="">
    <!--___________________________CONTENIDO______________________________-->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Reporte Parroquia</h1>
            </div>
          </div>
        </div>
      </section>
      <!-- Main content -->
      <section class="content">
        <div id="resultados_ajax4"></div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10 offset-md-1">
              <div class="card card-success card-outline p-2">
                <div class="modal-body">
                  <div class="form-row">
                    <div class="col-md-5 my-4 offset-md-1">
                      <label>Nombre</label>
                      <input type="text" name="dato" id="dato" class="form-control" placeholder="Ej: PAEZ" required onKeyPress="return soloLetrasConEspacio(event)" />
                    </div>

                    <div class="col-md-5 my-4">
                      <label>Estatus</label>
                      <select class="form-control" id="estatus" name="estatus" required>
                        <option value="" selected> Selecciona </option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                      </select>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                  <input type="button" onClick="generarpdf()" value="Generar PDF" class="btn btn-success pull-left" />
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>


    </form>

<?php
  require_once("footer.php");


?>



<link rel="stylesheet" href="../public/plugins/datepicker/datepicker3.css">
<script type="text/javascript" src="../public/plugins/datepicker/bootstrap-datepicker.js"></script>
<script>
  function generarpdf(){
      var dato   = $("#dato").val(); 
      var estatus  = $("#estatus").val();
     
      window.open("http://localhost/inti/reportes/control/c_rptparroquia.php?dato=" + dato + "&estatus=" + estatus);
    }




    $(document).ready(function() {
     

      $('.datepicker').datepicker({
        format: 'yy/mm/yyyy',
        startDate: '-1m',
        autoclose: true,
        endDate: new Date()
      });
    });                   

</script>

<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>