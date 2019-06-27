<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){

  $objeto_bd = new Conectar();
  $conectar = $objeto_bd->conexion_public();
  $objeto_bd->set_names();


  $sql_pais = $conectar->prepare("SELECT * FROM pais WHERE estatus = 1");
  $sql_pais->execute();
  $result_pais = $sql_pais->fetchAll();

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
              <h1>Estado</h1>
            </div>
          </div>
        </div>
      </section>
      <!-- Main content -->
      <section class="content">
        <div id="resultados_ajax"></div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10 offset-md-1">
              <div class="card card-success card-outline p-2">
                <div class="card-header with-border">
                  <h1 class="box-title">
                  <button class="btn btn-success" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#estadoModal"> Agregar </button></h1>
                  <div class="box-tools pull-right">
                  </div>
                </div>
                <div class="card-body table-responsive">
                  <table id="estado_data" class="table table-sm table-bordered table-striped">
                    <thead>                              
                      <tr>
                        <th width="5%">#</th>                           
                        <th>Estado</th>
                        <th>Pais</th>
                        <th width="8%">Estatus</th>
                        <th width="8%">Editar</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    
    <!--FORMULARIO VENTANA MODAL-->
    <div  id="estadoModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="post" id="estado_form">
            <div class="modal-content card-success card-outline">
              <div class="modal-header">
                <h4 class="modal-title">Registrar Estado</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="form-row my-3">
                  <div class="col-md-10 offset-md-1 mb-3">
                    <label><code>*</code>&nbsp;País</label>
                      <select class="form-control" required name='codpais' id='codpais' class='selecs controlDisabled cursor-bloqueado' onchange="cargarCombo(this.value,this.name,'estado','codestado','nombre','')" >
                        <option value="">Seleccione una opcion</option>
                        <?php 
                        
                        $opciones= "";
                        foreach ( $result_pais as $key => $value ) {
                          $seleccionado = ""; //($result_pais[$codigo]==$buscado)?"selected":""; 
                          $opciones    .= "<option value='".$result_pais[$key]['codpais']."' ".$seleccionado."> ".utf8_encode($result_pais[$key]['nombre'])." </option>";
                        } echo $opciones;

                        ?>
                      </select>
                  </div>
                </div>

                <div class="form-row my-3">
                  <div class="col-md-10 offset-md-1 mb-3">
                    <label><code>*</code>&nbsp;Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Portuguesa" required onKeyPress="return soloLetrasConEspacio(event)" maxlength="15" />
                  </div>
                </div>
                <code>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(*) Campos Obligatorios</code>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="codestado" id="codestado"/>
                <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add">Guardar <i class="fas fa-user-check"></i></button>         
                <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times" aria-hidden="true"></i></button>  
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/mestado.js"></script>

<script>

 

</script>


<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>