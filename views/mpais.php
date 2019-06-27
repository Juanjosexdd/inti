<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){
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
              <h1>País</h1>
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
                <div class="card-header mb-3">
                  <h1 class="box-title">
                  <button class="btn btn-success" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#paisModal"> Agregar </button></h1>
                  <div class="box-tools pull-right">
                  </div>
                </div>
                <div class="card-body table-responsive">
                  <table id="pais_data" class="table table-sm table-bordered table-striped">
                    <thead>                              
                      <tr>
                        <th width="5%">#</th>                           
                        <th>Nombre</th>
                        <th width="5%">Estatus</th>
                        <th width="5%">Editar</th>
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
    <div  id="paisModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="post" id="pais_form">
            <div class="modal-content card-success card-outline">
              <div class="modal-header">
                <h4 class="modal-title">Registrar País</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="form-row">
                  <div class="col-md-10 offset-md-1 my-4">
                    <label>&nbsp;<code>*</code>&nbsp; Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: VENEZUELA" required onKeyPress="return soloLetrasConEspacio(event)" maxlength="15" />
                  </div>
                </div>
                <code>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(*) Campo Obligatorio</code>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="codpais" id="codpais"/>
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
<script type="text/javascript" src="js/mpais.js"></script>

<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>