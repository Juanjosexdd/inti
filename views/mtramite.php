<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){

  $objeto_bd = new Conectar();
  $conectar = $objeto_bd->conexion_public();
  $objeto_bd->set_names();


  $sql_recaudo = $conectar->prepare("SELECT * FROM recaudos WHERE estatus = 1");
  $sql_recaudo->execute();
  $result_recaudo = $sql_recaudo->fetchAll();



?>

<?php
  require_once("header.php");
?>
    <!--___________________________CONTENIDO______________________________-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Trámite</h1>
            </div>
          </div>
        </div>
      </section>
      <!-- Main content -->
      <section class="content">
        <div id="resultados_ajax4"></div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-success card-outline p-2">
                <div class="card-header with-border">
                  <h1 class="box-title">
                  <button class="btn btn-success" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#tramiteModal"> Agregar </button></h1>
                  <div class="box-tools pull-right">
                  </div>
                </div>
                <div class="card-body table-responsive">
                  <table id="tramite_data" class="table table-sm table-bordered table-striped">
                    <thead>                              
                      <tr>
                        <th>#</th>                           
                        <th>Nombre</th>
						<th>Descripcion</th>
                        <th width="5%">Estatus</th>
                        <th width="10%">Acción</th>
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
    
    <!--FORMULARIO VENTANA MODAL-->
    <div  id="tramiteModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="post" id="tramite_form">
            <div class="modal-content card-success card-outline">
              <div class="modal-header">
                <h4 class="modal-title">Agregar Trámite</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="form-row">
                  <div class="col-md-10 offset-md-1 mb-3">
                    <label>Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="" required onKeyPress="return soloLetrasConEspacio(event)" />
                  </div>
                </div>

				        <div class="form-row">
                  <div class="col-md-10 offset-md-1 mb-3">
                    <label>Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="" required onKeyPress="return soloLetrasConEspacio(event)" />
                  </div>
                </div>
                 
              </div>
              <div class="modal-footer">
                <input type="hidden" name="codtramite" id="codtramite"/>
                <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add">Guardar <i class="fas fa-user-check"></i></button>         
                <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>  
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>




<!-- MODAL DE MENSAJES  ASOCIAR RECAUDOS-->
<form name="tramite_asociar_recaudo_tramite_form" action="post" id="tramite_asociar_recaudo_tramite_form" action="#" autocomplete="off">
  <div class="modal fade bd-example-modal-lg" id="tramiteAsociarRecaudoModal" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Asociar Recaudo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

              <div id="resultados_ajax_msj"></div>
              
              <div class="form-row">
                <div class="col-md-6 mb-6">

                    <ul style="font-size: 14px;">
                    <li>Nombre: <strong> <span id="spannombre"> </span> </strong> </li>
                    </ul>

                </div>

                <div class="col-md-6 mb-6">

                    <ul style="font-size: 14px;">
                    <li>Descripción:   <strong> <span id="spandescripcion">   </span> </strong> </li>
                    </ul>

                </div>
            </div>

            <div class="form-row">

                <div class="col-md-6 mb-6">
                    <label>Recaudo:</label>
                    <select style="width:100%;" class="form-control js-example-basic-multiple" required name='idrecaudos' id='idrecaudos' class='selecs controlDisabled cursor-bloqueado' onchange="" >
                        <option value="" >Seleccione un recaudo</option>
                        <?php 
                        
                        $opciones= "";
                        foreach ( $result_recaudo as $key => $value ) {
                          $seleccionado = ""; // ($value['idrecaudos']==$estatus) ? "selected" : "" ; 
                          $opciones    .= "<option value='".$result_recaudo[$key]['idrecaudos']."' ".$seleccionado."> ".($result_recaudo[$key]['nombre'])." </option>";
                        } echo $opciones;

                        ?>
                      </select>
                </div>

                <div class="col-md-5 mb-5">
                  <label>Cantidad</label>
                  <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="" required onKeyPress="return fnv_soloNumeros(event)" />
                </div>

                <div class="col-md-1 mb-1">
                <label>&nbsp; &nbsp;</label>
                  <button type="submit" onClick=""  title="Agregar Recaudos" id="" class="btn btn-success btn-md update"><i class="glyphicon glyphicon-edit"></i><i class="fas fa-plus"></i></button>
                </div>
    
            </div>

            
            <div class="form-row">
                <div class="col-md-12 mb-12">
                  <table id="tramite_data" class="table table-sm table-bordered table-striped">
                    <thead>                              
                        <tr>
                        <th style='text-align: center;' >#</th>                           
                        <th style='text-align: center;'>Recaudo</th>
                        <th style='text-align: center;' width="30%">Cantidad</th>
                        <th style='text-align: center;' width="15%">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="recaudo_data_tbody">

                    </tbody>
                  </table>
                </div>
            </div>


              </div>
              <div class="modal-footer">
                <input type="hidden" name="codtramite" id="codtramiteAsociarRecaudos"/>
                      
                <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>  
              </div>
          </div>
      </div>
  </div>
</form>
<!-- /MODAL DE MENSAJES ASOCIAR RECAUDOS -->



<?php
  require_once("footer.php");
?>


<link rel="stylesheet" href="../public/plugins/select2/select2.min.css">
<link rel="stylesheet" href="../public/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="../public/plugins/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css" />

<script type="text/javascript" src="js/mtramite.js"></script>
<script type="text/javascript" src="../public/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../public/plugins/x-editable/dist/bootstrap3-editable/js/bootstrap-editable2.min.js"></script>


<script>

  $(document).ready(function() {
    $('.js-example-basic-multiple').select2({
          language: "es"
        , theme: "bootstrap"
        , width: null
        , tokenSeparators: [',', ' ']
        , minimumInputLength: 0
    });


  });

</script>


<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>