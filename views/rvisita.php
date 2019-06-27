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
              <h1>Reporte Visita</h1>
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
                    <div class="col-md-4 my-3">
                      <label>Nombre</label>
                      <input type="text" name="dato" id="dato" class="form-control" placeholder="Ej: Juan / Informatica" required onKeyPress="return soloLetrasConEspacio(event)" />
                    </div>

                    <div class="col-md-4 my-3">
                      <label>Fecha Inicio</label>
                      <input type="date" name="fechainicio" id="fechainicio" class="form-control datepicker" placeholder="" required onKeyPress="" />
                    </div>
                    <div class="col-md-4 my-3">
                      <label>Fecha Fin</label>
                      <input type="date" name="fechafin" id="fechafin" class="form-control datepicker" placeholder="" required onKeyPress="" />
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                  <input type="button" onClick="generarpdf()" value="Generar PDF" class="btn btn-success pull-left" />       
                </div>
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


<script>
  function generarpdf(){
      var dato   = $("#dato").val(); 
      var fechainicio  = $("#fechainicio").val();
      var fechafin  = $("#fechafin").val();
     
      window.open("http://localhost/inti/reportes/control/c_rptvisita.php?dato=" + dato + "&fechainicio=" + fechainicio + "&fechafin=" fechafin);
    }




    // $(document).ready(function() {
    //   $('.datepicker').datepicker({
    //     format: 'dd/mm/yyyy',
    //     startDate: '-1m',
    //     autoclose: true,
    //     endDate: new Date()
    //   });
    // });                  

</script>
<!-- 
<link rel="stylesheet" href="../public/plugins/datepicker/datepicker3.css">
<script type="text/javascript" src="../public/plugins/datepicker/bootstrap-datepicker.js"></script> -->

<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>