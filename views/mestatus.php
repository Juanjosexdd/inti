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
            <h1>Estatus</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div id="resultados_ajax"></div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-10 offset-md-1">
            <div class="card card-success card-outline">
              <div class="card-header">
                <button class="btn btn-success" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#estatusModal"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button></h1>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="card-body table-responsive">
                  <table id="estatus_data" class="table table-sm table-bordered table-striped">
                    <thead>                              
                      <tr>                           
                        <th width="6%">#</th>
                        <th>Cod Estatus</th>
                        <th>Descripcion</th>
                        <th>Estatus</th>
                        <th width="7%">Editar</th>
                        <th width="7%">Borrar</th>
                      </tr>
                    </thead>
                    <tbody>
                            
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
	</div>

  <div id="estatusModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="post" id="estatus_form">
          <div class="modal-content card-success card-outline">
            <div class="modal-header">
              <h4 class="modal-title">Registrar Estatus</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-row">
                <div class="col-md-10 offset-md-1 mb-3">
                  <label> <code>*</code> &nbsp; Cod Estatus</label>
                  <input type="text" name="codestatus" id="codestatus" onkeypress=" return fnv_soloNumeros(event)" class="form-control" placeholder="Ej: 9" maxlength="2" required />
                </div>
              </div>
              <div class="form-row">
              	<div class="col-md-10 offset-md-1 mb-3">
  	              <div class="form-group">
  	                <label> <code>*</code> &nbsp; Nombre </label>
                      <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Borrador" required maxlength="25" onKeyPress="return soloLetrasConEspacio(event)"/>
  	              </div>
  	            </div>
              </div>
              <div class="form-row">
                <div class="col-md-10 offset-md-1 mb-3">
                  <div class="form-group">
                    <label> <code>*</code> &nbsp; Descripción </label>
                      <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Ej: Borrador" maxlength="60" required onKeyPress="return soloLetrasConEspacio(event)"/>
                  </div>
                </div>
              </div>  
              <br>
              <code>&nbsp; &nbsp; &nbsp;(*) Campos Obligatorios</code>                
            </div>
            <div class="modal-footer">
              <input type="hidden" name="idestatus" id="idestatus"/>
              <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add">Guardar <i class="fas fa-user-check"></i></button>         
              <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"> Cancelar <i class="fa fa-times" aria-hidden="true"></i></button>  
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--___________________________CONTENIDO______________________________-->



<?php
	
	require_once("footer.php");

?>
<script type="text/javascript" src="js/mestatus.js"></script>


<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>