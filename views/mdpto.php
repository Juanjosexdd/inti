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
            <h1>Departamento</h1>
          </div>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div id="resultados_ajax5"></div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-10 offset-md-1">
            <div class="card card-success card-outline">
              <div class="card-header my-3">
                <button class="btn btn-success" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#dptoModal"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button></h1>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="card-body table-responsive">
                  <table id="dpto_data" class="table table-sm table-bordered table-striped">
                    <thead>                              
                      <tr>                           
                        <th width="5%">#</th>
                        <th>Cod Dpto</th>
                        <th>Nombre</th>
                        <th width="7%">Estatus</th>
                        <th width="7%">Editar</th>
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
  
  <!--FORMULARIO VENTANA MODAL-->
  <div id="dptoModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="post" id="dpto_form">
          <div class="modal-content card-success card-outline">
            <div class="modal-header">
              <h4 class="modal-title">Registrar Departamento</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            	<div class="form-row">
                <div class="col-md-10 offset-md-1 my-3">
                  <label> <code>*</code> &nbsp; Codigo Departamento</label>
                  <input type="text" name="coddpto" id="coddpto" class="form-control" placeholder="Ej: 001" required onkeypress=" return fnv_soloNumeros(event)" maxlength="2" />
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-10 offset-md-1 my-3">
                  <label> <code>*</code> &nbsp; Nombre</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Recursos naturales" required onKeyPress="return soloLetrasConEspacio(event)" maxlength="20"/>
                </div>
              </div>
              <br>
              <code>&nbsp; &nbsp; &nbsp;(*) Campos Obligatorios</code>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="id" id="id"/>
              <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"> Guardar <i class="fas fa-user-check"></i></button>         
              <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"> Cancelar <i class="fa fa-times" aria-hidden="true"></i></button>  
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--___________________________CONTENIDO______________________________-->

<!-- <script type="text/javascript" src="js/usuarios.js"></script> -->


<?php
	require_once("footer.php");
?>
<script type="text/javascript" src="js/mdpto.js"></script>

<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>