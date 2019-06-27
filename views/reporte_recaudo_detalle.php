reporte_recaudo_detalle.php<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){



  	require_once("../modelos/Mtramite.php");
    $tramite = new Tramite();
    $datotramite = $tramite->get_tramite();

    require_once("../modelos/Msector.php");
    $sector = new Sector();
    $datossector = $sector->get_sector();

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
            <div class="col-md-8 offset-md-2">
              <div class="card card-success card-outline p-2">
                <div class="modal-body">
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label>Tramite</label>
                      <select id="codtramite" name="codtramite" class="form-control" required >
                      	<option value="">Seleccione...</option>
                       <?php
                           for($i=0; $i<sizeof($datotramite);$i++){
                             ?>
                              <option value="<?php echo $datotramite[$i]["codtramite"]?>"><?php echo $datotramite[$i]["nombre"];?></option>
                             <?php
                           }
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <label>Cédula</label>
                      <input type="text" class="form-control" name="cedula" id="cedula" placeholder="Cédula">
                    </div>
                    <div class="form-group col-md-3">
	                  	<label>Estatus</label>
	                  	<select class="form-control" id="estatus" name="estatus" required>
	                    	<option value="">-- Selecciona estado --</option>
	                    	<option value="1" selected>Activo</option>
	                    	<option value="0">Inactivo</option>
	                  	</select>
	                </div>
	                <div class="form-group col-md-3">
	                	<label>Sector</label>
	                	<select id="codsector" name="codsector" class="form-control" required>
                      		<option value="">Seleccione...</option>
	                       <?php
	                           for($i=0; $i<sizeof($datossector);$i++){
	                             ?>
	                              <option value="<?php echo $datossector[$i]["codsector"]?>"><?php echo $datossector[$i]["nombre"];?></option>
	                             <?php
	                           }
	                        ?>
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
    
<?php
  require_once("footer.php");


?>



<link rel="stylesheet" href="../public/plugins/datepicker/datepicker3.css">
<script type="text/javascript" src="../public/plugins/datepicker/bootstrap-datepicker.js"></script>

<script>

    function generarpdf(){
      var tramite   = $("#codtramite").val(); 
      var cedula    = $("#cedula").val();
      var estatus   = $("#estatus").val();
      var sector    = $("codsector").val();
     
      window.open("http://localhost/inti/reportes/control/c_rpttramitedetalle.php?tramite=" + tramite + "&cedula=" + cedula + "&estatus=" + estatus + "&sector=" + sector );
    }

    function fnv_soloNumeros(e){
      var keynum = window.event ? window.event.keyCode : e.which;
    
      if ((keynum == 8) || (keynum == 46))
      return true;
      
      return /\d/.test(String.fromCharCode(keynum));
    }
    function soloLetrasConEspacio(e) { 
      tecla = (document.all) ? e.keyCode : e.which;
      if (tecla==8) return true; // backspace
      if (tecla==32) return true; // espacio
   
      patron = /[a-zA-Z]/; //patron
   
      te = String.fromCharCode(tecla);
      return patron.test(te); // prueba de patron
    } 
    $(document).ready(function() {
      $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
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