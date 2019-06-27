<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){

  $objeto_bd = new Conectar();
  $conectar = $objeto_bd->conexion_public();
  $objeto_bd->set_names();

  $sql_estatus = "SELECT 
                    de.* 
                    ,e.nombre
                    ,e.codestatus
                    FROM dptoestatus de
                    INNER JOIN estatus e ON e.codestatus = de.idestatus
                    WHERE de.estatus = '1' AND de.coddpto = '{$_SESSION['coddpto']}' AND e.estatus = '1' ORDER BY id";


  $sql_estatus = $conectar->prepare($sql_estatus);
  $sql_estatus->execute();
  $result_estatus = $sql_estatus->fetchAll();

  $sql_ciudadano = $conectar->prepare("SELECT * FROM ciudadano WHERE estatus = 1 ORDER BY primernombre,primerapellido");
  $sql_ciudadano->execute();
  $result_ciudadano = $sql_ciudadano->fetchAll();

  $sql_tramite = $conectar->prepare("SELECT * FROM maestrotramite WHERE estatus = 1 ORDER BY nombre");
  $sql_tramite->execute();
  $result_tramite = $sql_tramite->fetchAll();

  $sql_pais = $conectar->prepare("SELECT * FROM pais WHERE estatus = 1");
  $sql_pais->execute();
  $result_pais = $sql_pais->fetchAll();
  
    /*
    [0] => Array
        (
          [nombre] => ADMINISTRADOR
        )
    */

  $variables = explode("?", $_SERVER['REQUEST_URI']);
    if (isset($variables[1])){
      eval('$'.$variables[1].';'); // Crear Variable

      if(isset($estatus)){
        //print_r($estatus);
      }else{
        // echo 'No existe variable estatus';
        $estatus = $result_estatus[0]['codestatus']; // BORRADOR
      }
      
  }else{
    // echo 'No existe variables $_GET';
    $estatus = $result_estatus[0]['codestatus']; // BORRADOR
  }


   //print_r($_SESSION['coddpto']);
  //print_r($resultado);
    /*
       
    <select class="form-control" required disabled name='codpais' id='codpais' class='selecs controlDisabled cursor-bloqueado' >
        <option value="">Seleccione una opcion</option>
        <?php $seleccionado = isset($obj->idest)&&($obj->idest !="")?$obj->idest:$obj_row[2]; $ob_bd->crearOpcionesCombo($sqlCombo,"idest","nom",$seleccionado); ?>
    </select>


	$ob_bd = new bd;
	$sqlCombo = "SELECT * FROM testado WHERE est=1";
	$botonera = $obj_row[1]; //para saber si hay datos buscados
  $status = $obj_row['est']; //para activar y desactivar
  */
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
              <h1>Gestionar Trámite</h1>
            </div>
          </div>
        </div>
      </section>
      <!-- Main content -->
      <section class="content">
        <div id="resultados_ajax_session">
          <?php
          if (isset($_SESSION["messages"])){

          echo "<div class='alert alert-success' role='alert'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>¡Bien hecho!</strong> 
                {$_SESSION["messages"]}
                </div>
                "; unset($_SESSION["messages"]);

            
          }

          if (isset($_SESSION["error"])){

          echo "<div class='alert alert-danger' role='alert'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>¡Error!</strong> 
                {$_SESSION["error"]}
                </div>
                "; unset($_SESSION["error"]);
          }
          ?>
          </div>
        <div id="resultados_ajax"></div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-success card-outline p-2">
                <div class="card-header with-border">
                  <h1 class="box-title">

                  <?php  if( $_SESSION['coddpto'] == 1 ){

                  
                  ?>

                  <button class="btn btn-success" id="add_button" onclick="" data-toggle="modal" data-target="#tramiteModal"> Agregar </button></h1>

                <?php } else { ?>

                  <button class="btn btn-success"  disabled id="" onclick=""> Agregar </button></h1>

                  <?php } ?>

                
                  <div class="box-tools pull-right">
                  </div>
                </div>

                <div class="card-body table-responsive">
                  <div class="form-row">
                    <div class="col-md-2 mb-3">
                      <label>Estatus</label>
                        <select class="form-control" required name='codestatus' id='codestatus' class='selecs controlDisabled cursor-bloqueado' onchange="cambiarEstatus(this.value)" >
                          <option value="" disabled>Seleccione un estatus</option>
                          <?php 
                          
                          $opciones= ""; 
                          foreach ( $result_estatus as $key => $value ) {
                            $seleccionado = ($value['codestatus']==$estatus) ? "selected" : "" ; 
                            $opciones    .= "<option value='".$result_estatus[$key]['codestatus']."' ".$seleccionado."> ".utf8_encode($result_estatus[$key]['nombre'])." </option>";
                          } echo $opciones;

                          ?>
                        </select>
                    </div>
                  </div>
                  <table id="tramite_data" class="table table-sm table-bordered table-striped">
                    <thead>                              
                      <tr>
                        <th>#</th>                           
                        <th>Ciudadano</th>
                        <th>Trámite</th>
                        <th>Fecha</th>
                        <th>Sector</th>
                        <th width="10%">Estatus</th>
                        <th width="15%" nowrap>Acción</th>
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
    


    <form method="post" id="tramite_form" name="tramite_form">
<!-- agregar-->
<div class="modal fade bd-example-modal-lg" id="tramiteModal" role="dialog" aria-labelledby="myModalLabel"
      aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    

            <div class="modal-header">
            <h4 class="modal-title">Registrar Trámite</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            
            <div class="form-row">
                <div class="col-md-4 mb-4">
                <label>Trámite</label>
                    <select class="form-control" required name='codtramite' id='codtramite' class='selecs controlDisabled cursor-bloqueado' onchange="" >
                    <option value="" >Seleccione un trámite</option>
                    <?php 
                    
                    $opciones= "";
                    foreach ( $result_tramite as $key => $value ) {
                        $seleccionado = ""; //($result_tramite[$codigo]==$buscado)?"selected":""; 
                        $opciones    .= "<option value='".$result_tramite[$key]['codtramite']."' ".$seleccionado."> ".utf8_encode($result_tramite[$key]['nombre'])." </option>";
                    } echo $opciones;

                    ?>
                    </select>
                </div>

                <div class="col-md-4 mb-4">
                <label>Fecha Trámite</label>
                <input type="text" readonly name="fechainicio" id="fechainicio" class="form-control datepicker" placeholder="" required onKeyPress="" />
                </div>

                <div class="col-md-4 mb-4">
                <label>Ciudadano</label>
                    <select style="width:100%;" class="form-control js-example-basic-multiple" required name='cedulasolicitante' id='cedulasolicitante' class='selecs controlDisabled cursor-bloqueado' onchange="" >
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

            </div>


            <div class="form-row">
                <div class="col-md-4 mb-4">
                <label>Lote Terreno</label>
                <input type="text" name="loteterreno" id="nombrloteterrenoe" class="form-control" placeholder="" required  />
                </div>

                <div class="col-md-4 mb-4">
                <label>Superficie</label>
                <input type="text" name="superficie" id="superficie" class="form-control" placeholder="" required  />
                </div>

                <div class="col-md-4 mb-4">
                <label>País</label>
                    <select class="form-control" required name='codpais' id='codpais' class='selecs controlDisabled cursor-bloqueado' onchange="cargarCombo(this.value,this.name,'estado','codestado','nombre','')" >
                    <option value="" >Seleccione una opcion</option>
                    <?php 
                    
                    $opciones= "";
                    foreach ( $result_pais as $key => $value ) {
                        $seleccionado = ($value['codpais']=="")?"selected":""; 
                        $opciones    .= "<option value='".$result_pais[$key]['codpais']."' ".$seleccionado."> ".utf8_encode($result_pais[$key]['nombre'])." </option>";
                    } echo $opciones;

                    ?>
                    </select>
                </div>

            </div>

            <div class="form-row">
                <div class="col-md-4 mb-4">
                <label>Estado</label>
                <select class="form-control" id="codestado" name="codestado" required onchange="cargarCombo(this.value,this.name,'municipio','codmunicipio','nombre','')">
                    <option value="" >Seleccione una opcion</option>
                </select>
                </div>

                <div class="col-md-4 mb-4">
                <label>Municipio</label>
                <select class="form-control" id="codmunicipio" name="codmunicipio" required onchange="cargarCombo(this.value,this.name,'parroquia','codparroquia','nombre','')">
                    <option value="" >Seleccione una opcion</option>
                </select>
                </div>

                <div class="col-md-4 mb-4">
                <label>Parroquia</label>
                <select class="form-control" id="codparroquia" name="codparroquia" required onchange="cargarCombo(this.value,this.name,'sector','codsector','nombre','')">
                    <option value="" >Seleccione una opcion</option>
                </select>
                </div>
            </div>

            <div class="form-row">

                <div class="col-md-4 mb-4">
                <label>Sector</label>
                <select class="form-control" id="codsector" name="codsector" required>
                    <option value="" >Seleccione una opcion</option>
                </select>
                </div>

                <div class="col-md-8 mb-8">
                <label>Observación</label>
                <input type="text" name="observacion" id="observacion" class="form-control" placeholder=""  />
                </div>
            </div>
                
            </div>

            <div class="modal-footer">
            <input type="hidden" name="idtramite" id="idtramite"/>
            <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add">Guardar <i class="fas fa-user-check"></i></button>         
            <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>  
            </div>
      
        
          
    </div>
  </div>
</div>

</form>



<!-- MODAL DE MENSAJES ASOCIAR RECAUDOS-->
<form name="tramite_asociar_recaudo_form" action="post" id="tramite_asociar_recaudo_form" action="#" autocomplete="off">
<div class="modal fade bd-example-modal-lg" id="tramiteRecaudoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Asociar Recaudo Trámite</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
          
                <div class="form-row">
                    <div class="col-md-6 mb-6">

                        <ul style="font-size: 14px;">
                        <li>Ciudadano: <strong> <span id="spanciudadano"> </span> </strong> </li>
                        <li>Trámite:   <strong> <span id="spantramite">   </span> </strong> </li>
                        </ul>

                    </div>
                    
                    <div class="col-md-6 mb-6">

                        <ul style="font-size: 14px;">
                        <li>Fecha:  <strong> <span id="spanfecha">  </span> </strong> </li>
                        <li>Sector: <strong> <span id="spansector"> </span> </strong> </li>
                        </ul>

                    </div>

                    <div class="col-md-12 mb-12">

                        <ul style="font-size: 14px;">
                        <li>Observación:  <strong> <span id="spanobservacion">  </span> </strong> </li>
                        </ul>

                    </div>

                    <div class="col-md-12 mb-12">

                        <table id="tramite_data" class="table table-sm table-bordered table-striped">
                          <thead>                              
                              <tr>
                              <th style='text-align: center;' >#</th>                           
                              <th style='text-align: center;'>Trámite</th>
                              <th style='text-align: center;' width="10%">Cantidad</th>
                              <th style='text-align: center;' width="15%">Acción</th>
                              </tr>
                          </thead>
                          <tbody id="tramite_data_tbody">

                          </tbody>
                        </table>
                    </div>

                  </div><!-- fin form-row-->
            
              </div>
        </div>
    </div>
</div>
</form>
<!-- /MODAL DE MENSAJES ASOCIAR RECAUDOS -->



<!-- MODAL DE MENSAJES ANULAR-->
<form name="tramite_anular_recaudo_form" action="post" id="tramite_anular_recaudo_form" action="#" autocomplete="off">
<div class="modal fade bd-example-modal-lg" id="tramiteAnularModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Anular Trámite</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                
            <div class="form-row">
                <div class="col-md-6 mb-6">

                    <ul style="font-size: 14px;">
                    <li>Ciudadano: <strong> <span id="spanciudadano_2"> </span> </strong> </li>
                    <li>Trámite:   <strong> <span id="spantramite_2">   </span> </strong> </li>
                    </ul>

                </div>
                <div class="col-md-6 mb-6">

                    <ul style="font-size: 14px;">
                    <li>Fecha:  <strong> <span id="spanfecha_2">  </span> </strong> </li>
                    <li>Sector: <strong> <span id="spansector_2"> </span> </strong> </li>
                    </ul>

                </div>

                <div class="col-md-12 mb-12">

                    <ul style="font-size: 14px;">
                    <li>Observación:  <strong> <span id="spanobservacion_2">  </span> </strong> </li>
                    </ul>

                </div>

                <div class="col-md-12 mb-12" style="text-align: center;">

                    <h4>¿Esta seguro de anular este trámite?</h4>

                </div>

            </div>

            <div class="form-row">

                <div class="col-md-12 mb-12">
                    <label>Motivo:</label>
                    <input type="text" placeholder="Ingrese un motivo" required name="motivo" id="motivo" class="form-control" placeholder="" />
                </div>
            </div>

            </div>
            <div class="modal-footer">
                <input type="hidden" name="idtramite" id="idtramiteanular"/>
                <button type="submit" name="action" class="btn btn-success pull-left" value="Add">Guardar <i class="fas fa-user-check"></i></button>         
                <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>  
             </div>

        </div>
    </div>
</div>
</form>
<!-- /MODAL DE MENSAJES ANULAR -->



<!-- MODAL DE MENSAJES PROCESAR-->
<form name="tramite_procesar_tramite_form" action="post" id="tramite_procesar_tramite_form" action="#" autocomplete="off">
  <div class="modal fade bd-example-modal-lg" id="tramiteProcesarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Procesar Trámite</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">


              <div class="form-row">
                <div class="col-md-6 mb-6">

                    <ul style="font-size: 14px;">
                    <li>Ciudadano: <strong> <span id="spanciudadano_3"> </span> </strong> </li>
                    <li>Trámite:   <strong> <span id="spantramite_3">   </span> </strong> </li>
                    </ul>

                </div>
                <div class="col-md-6 mb-6">

                    <ul style="font-size: 14px;">
                    <li>Fecha:  <strong> <span id="spanfecha_3">  </span> </strong> </li>
                    <li>Sector: <strong> <span id="spansector_3"> </span> </strong> </li>
                    </ul>

                </div>

                <div class="col-md-12 mb-12">

                    <ul style="font-size: 14px;">
                    <li>Observación:  <strong> <span id="spanobservacion_3">  </span> </strong> </li>
                    </ul>

                </div>

                <div class="col-md-12 mb-12" style="text-align: center;">

                    <h4>¿Esta seguro de procesar este trámite?</h4>

                </div>

            </div>

            <div class="form-row">

                <div class="col-md-12 mb-12">
                    <label>Observación:</label>
                    <input type="text" placeholder="Ingrese una observación" name="observacion" id="observacion" class="form-control" placeholder="" onKeyPress="" />
                </div>
            </div>


              </div>
              <div class="modal-footer">
                  <input type="hidden" name="idtramite" id="idtramiteprocesar"/>
                  <input type="hidden" name="estatus"   id="codestatusprocesar"/>
                  <button type="submit" name="action" class="btn btn-success pull-left" value="Add">Guardar <i class="fas fa-user-check"></i></button>         
                  <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>  
                </div>
          </div>
      </div>
  </div>
</form>
<!-- /MODAL DE MENSAJES PROCESAR -->



    <?php
      require_once("footer.php");
    ?> 


<link rel="stylesheet" href="../public/plugins/select2/select2.min.css">
<link rel="stylesheet" href="../public/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="../public/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="../public/plugins/iCheck/all.css">

<script type="text/javascript" src="js/bandeja.js"></script>
<script type="text/javascript" src="../public/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../public/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../public/plugins/iCheck/icheck.min.js"></script>

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


<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>