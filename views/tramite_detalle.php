<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){



  	require_once("../modelos/Mtramite.php");
    $tramite = new Tramite();
    $datotramite = $tramite->get_tramite();
?>

<?php
  require_once("header.php");
?>


    <!--___________________________CONTENIDO______________________________-->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Detalles del Tramite</h1>
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
                    <div class="form-group col-md-3 offset-md-1 my-4">
                      <label>Tramite</label>
                      <input type="text" class="form-control" name="idtramite" id="idtramite" placeholder="">
                    </div>
                    <div class="form-group col-md-4 my-4">
                      <label>Cédula</label>
                      <input type="text" class="form-control" name="cedula" id="cedula" placeholder="Ej: 15346789">
                    </div>
                    <div class="form-group col-md-3 my-4">
                      <label>Estatus</label>
                      <input type="text" class="form-control" name="estatus" id="estatus" placeholder="Ej: Pendiente">
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
    
<?php
  require_once("footer.php");
?>


<script>

    function generarpdf(){
      var tramite   = $("#idtramite").val(); 
      var cedula    = $("#cedula").val();
      var estatus   = $("#estatus").val();
      window.open("http://localhost/inti/reportes/control/c_rpttramitedetalle.php?tramite=" + tramite + "&cedula=" + cedula + "&estatus=" + estatus);
    }

</script>               


<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>