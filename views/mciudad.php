<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["email"])){
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
	            <h1>Estado</h1>
	          </div>
	        </div>
	      </div><!-- /.container-fluid -->
	    </section>
	    <section class="content">
        <div id="resultados_ajax"></div>
	      <div class="container-fluid">
	        <div class="row">
	          <div class="col-md-8 offset-md-2">
	            <div class="card card-success card-outline">
	              <div class="card-header">
	                <h3 class="card-title">Estado</h3>
	                <button class="btn btn-success" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#ciudadanoModal"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button></h1>
	              </div>
	              <!-- /.card-header -->
	              <div class="card-body">
	                <div class="card-body table-responsive">
                  <table id="pais_data" class="table table-sm table-bordered table-striped">
                    <thead>                              
                      <tr>                           
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Estatus</th>
                        <th width="10%">Editar</th>
                        <th width="10%">Borrar</th>
                      </tr>
                    </thead>
                    <tbody>
                            
                    </tbody>
                  </table>
                </div>
	              </div>
	              <!-- /.card-body -->
	              <div class="card-footer clearfix">
	                
	              </div>
	            </div>
	            <!-- /.card -->
	          </div>
	        </div>
	      </div>
	    </section>
	</div>

  <div id="ciudadanoModal" class="modal fade">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="post" id="">
        <div class="modal-content card-success card-outline">
          <div class="modal-header">
            <h4 class="modal-title">Agregar Municipio</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
          	<div class="form-row">
              <div class="col-md-10 offset-md-1 mb-3">
                <label>Estado</label>
                <select class="form-control" id="estatus" name="estatus" required>
                  <option value="" selected>-- Selecciona --</option>
                  <option value="1" >...</option>
                  
                </select>    
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-10 offset-md-1 mb-3">
                <label>Municipio</label>
                <input type="text" name="" id="" class="form-control" placeholder="Ej: Portuguesa" required />
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-10 offset-md-1 mb-3">
                <label>Estatus</label>
                <select class="form-control" id="estatus" name="estatus" required>
                  <option value="" selected>-- Selecciona --</option>
                  <option value="1" >....</option>
                </select>    
              </div>
            </div>                   
          </div>
          <div class="modal-footer">
            <input type="hidden" name="" id=""/>
            <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add">Guardar <i class="fas fa-user-check"></i></button>         
            <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fa fa-times" aria-hidden="true"></i></button>  
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--___________________________CONTENIDO______________________________-->

<!-- <script type="text/javascript" src="js/usuarios.js"></script> -->


<?php
	
	require_once("footer.php");

?>

<?php
  } else {
    header("Location:".Conectar::ruta()."views/index.php");
    exit();
  }
?>