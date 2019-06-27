<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){


  $objeto_bd = new Conectar();
  $conectar = $objeto_bd->conexion_public();
  $objeto_bd->set_names();



  $sql_ciudadano = $conectar->prepare("SELECT * FROM ciudadano WHERE estatus = 1 ORDER BY primernombre,primerapellido");
  $sql_ciudadano->execute();
  $result_ciudadano = $sql_ciudadano->fetchAll();

  require_once("../modelos/Mvisita.php");
  $visita = new Mvisita();
  $datosvisita = $visita->get_maestrovisita();

  require_once("../modelos/Dpto.php");
  $dpto = new Dpto();
  $datosdpto = $dpto->get_dpto();

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
            <h1>Visita</h1>
          </div>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div id="resultados_ajax"></div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-success card-outline p-2">
              <div class="card-header with-border">
                <h1 class="box-title">
                <button class="btn btn-success" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#visitaModal"> Agregar </button></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <div class="card-body table-responsive">
                <table id="visita_data" class="table table-sm table-bordered table-striped">
                  <thead>                              
                    <tr>
                      <th>#</th>                           
                      <th>Ciudadano</th>
                      <th>Fecha</th>
                      <th>Tipo visita</th>
                      <th>Motivo</th>
                      <th>Dpto</th>
                      <th width="10%">Editar</th>
                    </tr>
                  </thead>
                  <tbody>
                          
                  </tbody>
                </table>
              </div><!--Fin centro -->
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
    
  <form method="post" id="visita_form" name="visita_form">
    <div class="modal fade bd-example-modal-lg" id="visitaModal"  role="dialog" aria-labelledby="myModalLabel"
      aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Registrar Trámite</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-row">
                <div class="col-md-4">
                  <label>Ciudadano</label>
                  <select style="width:100%;" class="form-control js-example-basic-multiple" required name='cedulaciudadano' id='cedulaciudadano' class='selecs controlDisabled cursor-bloqueado' onchange="" >
                  <option value="" >Seleccione un ciudadano</option>
                  <?php 
                  
                  $opciones= "";
                  foreach ( $result_ciudadano as $key => $value ) {
                      $seleccionado = ""; //($result_ciudadano[$codigo]==$buscado)?"selected":""; 
                      $opciones    .= "<option value='".$result_ciudadano[$key]['cedula']."' ".$seleccionado."> CI: "
                      .utf8_encode($result_ciudadano[$key]['cedula'])." - "
                      .utf8_encode($result_ciudadano[$key]['primernombre'])." "
                      .utf8_encode($result_ciudadano[$key]['primerapellido'])." </option>";
                  } echo $opciones;

                  ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <label>Tipo Visita</label>
                  <select class="form-control" required name='codvisita' id='codvisita' class='selecs controlDisabled cursor-bloqueado' onchange="" >
                  <?php
                     for($i=0; $i<sizeof($datosvisita);$i++){
                       ?>
                        <option value="<?php echo $datosvisita[$i]["codvisita"]?>"><?php echo $datosvisita[$i]["nombre"];?></option>
                       <?php
                     }
                  ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <label>Departamento</label>
                  <select id="coddpto" name="coddpto" class="form-control"  >
                    <?php
                       for($i=0; $i<sizeof($datosdpto);$i++){
                         ?>
                          <option value="<?php echo $datosdpto[$i]["id"]?>"><?php echo $datosdpto[$i]["nombre"];?></option>
                         <?php
                       }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-10 offset-md-1">
                  <label>Observación</label>
                  <input type="text" name="motivo" id="motivo" class="form-control" placeholder=""  />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="idvista" id="idvista"/>
              <input type="hidden" name="idusuario" id="idusuario"/>
              <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add">Guardar <i class="fas fa-user-check"></i></button>         
              <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>  
            </div>
          </div>
        </div>
    </div>
  </form>



<?php
  require_once("footer.php");
?>
<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2({
          language: "es"
        , theme: "bootstrap"
        , width: null
        , tokenSeparators: [',', ' ']
        , minimumInputLength: 1
    });


    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      startDate: '-1m',
      autoclose: true,
      endDate: new Date()
    });
  });
</script>



<link rel="stylesheet" href="../public/plugins/select2/select2.min.css">
<link rel="stylesheet" href="../public/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="../public/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="../public/plugins/iCheck/all.css">

<script type="text/javascript" src="js/pvisita.js"></script>
<script type="text/javascript" src="../public/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../public/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../public/plugins/iCheck/icheck.min.js"></script>


<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>