<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){

  // $objeto_bd = new Conectar();
  // $conectar = $objeto_bd->conexion_public();
  // $objeto_bd->set_names();



  // $sql_usuario = $conectar->prepare("SELECT * FROM usuario WHERE estatus = 1 ORDER BY nombre,apellido");
  // $sql_usuario->execute();
  // $result_usuario = $sql_usuario->fetchAll();

  require_once("../modelos/Usuarios.php");
  $usuario = new Usuario();
  $datosusuario = $usuario->get_usuario();

  require_once("../modelos/Roles.php");
  $roles = new Roles();
  $datosroles = $roles->get_roles();











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
            <h1>Asignar rol a usuario</h1>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div id="resultados_ajax10"></div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-10 offset-md-1">
            <div class="card card-success card-outline">
              <div class="card-header">
                <button class="btn btn-success" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#usersrolesModal"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button></h1>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="card-body table-responsive">
                  <table id="usersroles_data" class="table table-sm table-bordered table-striped">
                    <thead>                              
                      <tr>                           
                        <th width="6%">#</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Fecha</th>
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
  <div id="usersrolesModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="post" id="usersroles_form">
          <div class="modal-content card-success card-outline">
            <div class="modal-header">
              <h4 class="modal-title">Registrar Cargo</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-row">
                <div class="col-md-10 offset-md-1 my-3">
                  <label>Usuario</label>
                  <select style="width:100%;" class="form-control js-example-basic-multiple" required name='idusuario' id='idusuario' class='selecs controlDisabled cursor-bloqueado' onchange="" >
                  <option value="" >Seleccione un Usuario</option>
                    <?php
                       for($i=0; $i<sizeof($datosusuario);$i++){
                         ?>
                          <option value="<?php echo $datosusuario[$i]["idusuario"]?>"><?php echo $datosusuario[$i]["nombre"];?></option>
                         <?php
                       }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-10 offset-md-1 my-3">
                  <label>Roles</label>
                  <select id="idroles" name="idroles" class="form-control">
                    <option value="" selected> Selecciona </option>
                    <?php
                       for($i=0; $i<sizeof($datosroles);$i++){
                         ?>
                          <option value="<?php echo $datosroles[$i]["idroles"]?>"><?php echo $datosroles[$i]["nombre"];?></option>
                         <?php
                       }
                    ?>
                  </select>
                </div>
              </div>
              <br>
              <code>&nbsp; &nbsp; &nbsp;(*) Campos Obligatorios</code>
            </div>
            <div class="modal-footer">
              <br>
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
<script type="text/javascript" src="js/usersroles.js"></script>
<!-- 
<link rel="stylesheet" href="../public/plugins/select2/select2.min.css">
<link rel="stylesheet" href="../public/plugins/select2/select2-bootstrap.min.css">
<link rel="stylesheet" href="../public/plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="../public/plugins/iCheck/all.css">
<script type="text/javascript" src="../public/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../public/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../public/plugins/iCheck/icheck.min.js"></script> 
 -->

<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>