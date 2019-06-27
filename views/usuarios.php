<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){

    require_once("../modelos/Mnacionalidad.php");
    $nacionalidad = new Nacionalidad();
    $nac = $nacionalidad->get_nacionalidad();

    require_once("../modelos/Mcargo.php");
    $cargo = new Cargo();
    $cargodatos = $cargo->get_cargo();

    require_once("../modelos/Dpto.php");
    $dpto = new Dpto();
    $datosdpto = $dpto->get_dpto();
?>

<?php
  require_once("header.php");
?>
    <!--___________________________CONTENIDO______________________________-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Registro Usuarios</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
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
                  <button class="btn btn-success" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#usuarioModal"> Agregar </button></h1>
                  <div class="box-tools pull-right">
                  </div>
                </div>
                <div class="card-body table-responsive">
                 <table id="usuario_data" class="table table-sm table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>N</th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Fecha Nac</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Fecha Ingreso</th>
                        <th>Dpto</th>
                        <th>Cargo</th> 
                        <th>Usuario</th>
                        <!-- <th>Fecha Ingreso</th> -->
                        <th>Estatus</th>
                        <th width="10%">Editar</th>
                      </tr>
                    </thead>
                    <tbody>
                            
                    </tbody>
                  </table>
                </div><!--Fin centro -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div>
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    
    <!--FORMULARIO VENTANA MODAL-->
    <div id="usuarioModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered">
        <form method="post" id="usuario_form">
          <div class="modal-content card-success card-outline">
            <div class="modal-header">
              <h4 class="modal-title">Registrar Usuario</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-row my-3">
                <div class="col-md-2">
                  <label>&nbsp;<code> * </code>N</label>
                  <select id="nacionalidad" name="nacionalidad" class="form-control" required>
                    <option value="">Selecciona..</option>
                    <?php
                      for($i=0; $i<sizeof($nac);$i++){
                        ?>
                        <option value="<?php echo $nac[$i]["id"]?>"><?php echo $nac[$i]["abreviatura"];?></option>
                        <?php
                      }
                    ?>
                  </select> 
                </div>
                <div class="col-md-3">
                  <label><code> * </code> Cedula</label>
                  <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Ej: Alejandro" onKeyPress="return fnv_soloNumeros(event)" maxlength="50" />
                </div>
                <div class="col-md-3">
                  <label><code> * </code> Nombre</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Andres" required onKeyPress="return soloLetrasConEspacio(event)" maxlength="50"  />
                </div>
                <div class="col-md-4">
                  <label><code> * </code> Apellido</label>
                  <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Ej: Peralez" onKeyPress="return soloLetrasConEspacio(event)" maxlength="50"   />
                </div>
              </div>
              <div class="form-row my-3">
                <div class="col-md-4">
                   <label><code> * </code> Fecha Nacimiento</label>
                  <input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" placeholder="Fecha">
                </div>
                <div class="col-md-4">
                  <label>Teléfono</label>
                  <input type="text" name="telefono" id="telefono" class="form-control" placeholder="04xx - xxxxxxx" required/>
                </div>
                <div class="col-md-4">
                  <label>Email</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="nombre@ejemplo.com" required />
                </div>
              </div>
              <div class="form-row my-3">
                <div class="col-md-6">
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
                <div class="col-md-6">
                  <label>Cargo</label>
                  <select id="cargo" name="cargo" class="form-control"  >
                    <option value="0">Seleccione...</option>
                    <?php
                      for($i=0; $i<sizeof($cargodatos);$i++){
                      ?>
                        <option value="<?php echo $cargodatos[$i]["idcargo"]?>"><?php echo $cargodatos[$i]["nombre"];?></option>
                      <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-row my-3">
                <div class="col-md-4">
                  <label>Usuario</label>
                  <div class="input-group ">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-user"></i></span>
                    </div>
                    <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario" required/>
                  </div>
                </div>
                <div class="col-md-4">
                  <label>Clave</label>
                  <input type="password" name="password" id="password" class="form-control" placeholder="Clave" required/>
                </div>
                <div class="col-md-4">
                  <label>Repita Clave</label>
                  <input type="password" name="password2" id="password2" class="form-control" placeholder="Repita Clave" required/>
                </div>
              </div>
              <div class="form-row my-3">
                <div class="col-md-12">
                  <label>&nbsp;<code> * </code>Dirección</label>
                  <textarea cols="90" rows="2" id="direccion" name="direccion"  placeholder="Direccion ..." required pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$"></textarea>
                  <br>
                  <code>(*) Campos Obligatorios</code>
                </div>
              </div>                     
            </div>
            <div class="modal-footer">
              <!-- <input type="hidden" name="estatus" id="estatus" value="0"/> -->
              <input type="hidden" name="idusuario" id="idusuario"/>
              <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add">Guardar <i class="fas fa-user-check"></i></button>
              <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal">Cancelar<i class="fa fa-times" aria-hidden="true"></i></button>  
            </div>
          </div>
        </form>
      </div>
    </div>
<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/usuarios.js"></script>


<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>