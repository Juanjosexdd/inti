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
            <h1>Rif</h1>
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
            <div class="card card-success card-outline">
              <div class="card-header">
                <button class="btn btn-success" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#rifModal"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button></h1>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="card-body table-responsive">
                  <table id="rif_data" class="table table-sm table-bordered table-striped">
                    <thead>                              
                      <tr>                           
                        <th width="6%">#</th>
                        <th>Nombre</th>
                        <th>Abreviatura</th>
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
  <div id="rifModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="post" id="rif_form">
          <div class="modal-content card-success card-outline">
            <div class="modal-header">
              <h4 class="modal-title">Registrar Rif</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-row">
                <div class="col-md-10 offset-md-1 mb-3">
                  <label> <code>*</code> &nbsp; Rif</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: JURIDICO" required onKeyPress="return soloLetrasConEspacio(event)" maxlength="35"/>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-10 offset-md-1 mb-3">
                  <label> <code>*</code> &nbsp; Abreviatura</label>
                  <input type="text" name="abreviatura" id="abreviatura" class="form-control" placeholder="Ej: J naturales" required onKeyPress="return soloLetrasConEspacio(event)" maxlength="1" />
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
<script type="text/javascript" src="js/mrif.js"></script>

<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>