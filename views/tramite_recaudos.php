<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){

?>

<?php
  require_once("header.php");
?>

  <form action="">
    <!--___________________________CONTENIDO______________________________-->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Reporte Recaudos por tramite</h1>
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
                    <div class="form-group col-md-5 offset-md-1 my-4">
                      <label> Nombre Tramite</label>
                      <input type="text" class="form-control" name="dato" id="dato" placeholder="Ej: Denuncia Tierra Ociosa">
                    </div>
                    <div class="form-group col-md-5 my-4">
                      <label>Estatus</label>
                      <select class="form-control" id="estatus" name="estatus" required>
                        <option value="" selected> Seleccione </option>
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
        </div>
      </section>
    </div>
  </form>


<script>

  function generarpdf(){
    var estatus   = $("#estatus").val();
    var dato = $("#dato").val();

    window.open("http://localhost/inti/reportes/control/c_rpttramiterecaudos.php?estatus=" + estatus + "&dato=" + dato );
  }
</script>




<?php
  require_once("footer.php");
?>


<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>