<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){

    require_once("../modelos/Mnacionalidad.php");
    $nacionalidad = new Nacionalidad();
    $nac = $nacionalidad->get_nacionalidad();

    require_once("../modelos/Mrif.php");
    $rif = new Rif();
    $datosrif = $rif->get_rif();
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
              <h1>Registro Ciudadanos</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
        <div id="resultados_ajax2"></div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-success card-outline p-2">
                <div class="card-header with-border">
                  <h1 class="box-title">
                  <button class="btn btn-success" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#ciudadanoModal"> Agregar </button></h1>
                  <div class="box-tools pull-right">
                  </div>
                </div>
                <!-- /.box-header -->
                <!-- centro -->
                <div class="card-body table-responsive">
                  <table id="ciudadano_data" class="table table-sm table-bordered table-striped">
                    <thead>                              
                      <tr>
                        <th>#</th>
                        <th>N</th>                           
                        <th>Cédula</th>
                        <th>Tr</th>
                        <th>Rif</th>
                        <th>Primer Nombre</th>
                        <th>Segundo Nombre</th>
                        <th>Primer Apellido</th>
                        <th>Segundo Apellido</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th width="4%">Estatus</th>
                        <th width="4%">Editar</th>
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
    <div id="ciudadanoModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered">
        <form method="post" id="ciudadano_form">
          <div class="modal-content card-success card-outline">
            <div class="modal-header">
              <h4 class="modal-title">Registrar Ciudadano</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-row">
                    <div class="form-group col-md-4 mb-3">
                      <label>&nbsp;</label>
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
                    <div class="form-group col-md-8 mb-3">
                      <label>&nbsp;&nbsp;&nbsp;<code> * </code>Cédula</label>
                      <input class="form-control" id="cedula" name="cedula" placeholder="Ej: 20391877" maxlength="12" required minlength="6" onkeypress=" return fnv_soloNumeros(event)">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-row">
                    <div class="form-group col-md-4 mb-3">
                      <label>&nbsp;</label>
                      <select id="tiporif" name="tiporif" class="form-control">
                        <option value="">Selecciona..</option>
                       <?php
                           for($i=0; $i<sizeof($datosrif);$i++){
                             ?>
                              <option value="<?php echo $datosrif[$i]["id"]?>"><?php echo $datosrif[$i]["abreviatura"];?></option>
                             <?php
                           }
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-md-8 mb-3">
                      <label>&nbsp;&nbsp;&nbsp;<code> * </code>Rif</label>
                      <input class="form-control" id="rif" name="rif" placeholder="Ej: 203918778" maxlength="12" minlength="6" onkeypress=" return fnv_soloNumeros(event)"/>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-3 mb-3">
                  <label>&nbsp;<code> * </code>Primer Nombre</label>
                  <input type="text" name="primernombre" id="primernombre" class="form-control" placeholder="Ej: Andres" required onKeyPress="return soloLetrasConEspacio(event)" maxlength="50" />
                </div>
                <div class="col-md-3 mb-3">
                  <label>&nbsp;&nbsp;&nbsp;Segundo Nombre</label>
                  <input type="text" name="segundonombre" id="segundonombre" class="form-control" placeholder="Ej: Alejandro" onKeyPress="return soloLetrasConEspacio(event)" maxlength="50" />
                </div>
                <div class="col-md-3 mb-3">
                  <label><code> * </code>Primer Apellido</label>
                  <input type="text" name="primerapellido" id="primerapellido" class="form-control" placeholder="Ej: Barbosa" required onKeyPress="return soloLetrasConEspacio(event)" maxlength="50"  />
                </div>
                <div class="col-md-3 mb-3">
                  <label>&nbsp;&nbsp;&nbsp;Segundo Apellido</label>
                  <input type="text" name="segundoapellido" id="segundoapellido" class="form-control" placeholder="Ej: Peralez" onKeyPress="return soloLetrasConEspacio(event)" maxlength="50"   />
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-5 mb-3">
                  <label>&nbsp;<code> * </code>Teléfono</label>
                  <input type="text" name="telefono" id="telefono" class="form-control" placeholder="04xxxxxxxxx" required pattern="[0-9]{0,15}" onkeypress=" return fnv_soloNumeros(event)"/>
                </div>
                <div class="col-md-5 mb-3">
                  <label><code> * </code>Correo</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="Ejemplo@gmail.com" required="required"/>
                </div>
                <!-- <div class="col-md-2 mb-3">
                  <label>Estatus</label>
                  <select class="form-control" id="estatus" name="estatus" required>
                    <option value="1" selected>Activo</option>
                    <option value="0">Inactivo</option>
                  </select>
                </div> -->
              </div>       
              <div class="form-row">
                <div class="col-md-12 mb-3">
                  <label>&nbsp;<code> * </code>Dirección</label>
                  <textarea cols="90" rows="2" id="direccion" name="direccion"  placeholder="Direccion ..." required pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$"></textarea>
                  <br>
                  <code>(*) Campos Obligatorios</code>
                </div>
              </div>                     
            </div>
            <div class="modal-footer">
              <!-- <input type="hidden" name="estatus" id="estatus" value="0"/> -->
              <input type="hidden" name="idciudadano" id="idciudadano"/>
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
<script type="text/javascript" src="js/ciudadano.js"></script>

<script>
  
  function fnv_soloNumeros(){
      var keynum = window.event ? window.event.keyCode : e.which;
      
      if ((keynum == 8))
      return true;
     return /\d/.test(String.fromCharCode(keynum));
  }
</script>

<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>