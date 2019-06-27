<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){
?>

<?php
  require_once("header.php");
?>


  <form method="post">
    <!--___________________________CONTENIDO______________________________-->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Reporte Trámite</h1>
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
                    <div class="col-md-6 my-3">
                      <label>Cedula</label>
                      <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Ej: 20391877" required " onkeypress=" return fnv_soloNumeros(event)" />
                    </div>

                    <div class="col-md-6 my-3">
                      <label>Nombres</label>
                      <input type="text"id="nombres" class="form-control" placeholder="Ej: Venezuela" required onKeyPress="return soloLetrasConEspacio(event)" />
                    </div>
                    <div class="col-md-3 offset-md-3 my-3">
                      <label>Fecha Inicio</label>
                      <input type="date" name="fechainicio" id="fechainicio" class="form-control datepicker" placeholder="" required onKeyPress="" />
                    </div>
                    <div class="col-md-3 my-3">
                      <label>Fecha Fin</label>
                      <input type="date" name="fechafin" id="fechafin" class="form-control datepicker" placeholder="" required onKeyPress="" />
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
      var cedula = $("#cedula").val(); // Valor de input cedula
      var nombres = $("#nombres").val(); // Valor de input estatus
      var fechainicio    = $("#fechainicio").val(); // valor de otro input dato
      var fechafin    = $("#fechafin").val(); // valor de otro input dato

      window.open("http://localhost/inti/reportes/control/c_rpttramite.php?cedula=" + cedula + "&nombres=" + nombres + "&fechainicio=" + fechainicio+ "&fechainicio=" + fechainicio inicio);
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
<link rel="stylesheet" href="../public/plugins/datepicker/datepicker3.css">

<script type="text/javascript" src="../public/plugins/datepicker/bootstrap-datepicker.js"></script>


<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>