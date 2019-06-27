<?php

  //llamar a la conexion de la base de datos
  require_once("../config/conexion.php");
  //llamar a el modelo Ciudadano
  require_once("../modelos/Ciudadanos.php");

  $ciudadano = new Ciudadano();

  //Estas variables son de los valores que se envian atravez del formulario y que se reciben por ajax

  $idciudadano = isset($_POST["idciudadano"]);
  $nacionalidad=isset($_POST["nacionalidad"]);
  $cedula=isset($_POST["cedula"]);
  $tiporif=isset($_POST["tiporif"]);
  $rif=isset($_POST["rif"]);
  $primernombre=isset($_POST["primernombre"]);
  $segundonombre=isset($_POST["segundonombre"]);
  $primerapellido=isset($_POST["primerapellido"]);
  $segundoapellido=isset($_POST["segundoapellido"]);
  $direccion=isset($_POST["direccion"]);
  $telefono=isset($_POST["telefono"]);
  $email=isset($_POST["email"]);
  //este es el que se envia del formulario
  //$estatus=isset($_POST["estatus"]);

  switch($_GET["op"]){
    case "guardaryeditar":

      $datos = $ciudadano->get_cedula_rif_del_ciudadano($_POST["cedula"],$_POST["rif"]);
      //si el id no existe entonces lo registra.
      if(empty($_POST["idciudadano"])){

        if(is_array($datos)==true and count($datos)==0){
          $ciudadano->registrar_ciudadano($nacionalidad,$cedula,$tiporif,$rif,$primernombre,$segundonombre,$primerapellido,$segundoapellido,$direccion,$telefono,$email);
          $messages[]="El ciudadano se registró correctamente";

        } else {
          $errors[]="La cédula o el rif ya existe";
        }                     
      } else {
        /*si ya existe entonces editamos el ciudadano*/
        $ciudadano->editar_ciudadano($idciudadano,$nacionalidad,$cedula,$tiporif,$rif,$primernombre,$segundonombre,$primerapellido,$segundoapellido,$direccion,$telefono,$email);
        $messages[]="El ciudadano se editó correctamente";
      }                
      //mensaje success
      if(isset($messages)){
  			?>
  			<div class="alert alert-success" role="alert">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>¡Bien hecho!</strong>
  				<?php
  					foreach($messages as $message) {
  						echo $message;
  					}
  					?>
  			</div>
  			<?php
  		}//fin success

      //mensaje error
      if(isset($errors)){
  			?>
  			<div class="alert alert-danger" role="alert">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>Error!</strong> 
  				<?php
  					foreach($errors as $error) {
  						echo $error;
  					}
  				?>
  			</div>
  			<?php
  			}//fin mensaje error
          break;

    case "mostrar":
      //selecciona el id del ciudadano
      //el parametro idciudadano se envia por AJAX cuando se edita el ciudadano
      $datos = $ciudadano->get_ciudadano_por_id($_POST["idciudadano"]);
        //validacion del id del ciudadano
      if(is_array($datos)==true and count($datos)>0){
        foreach($datos as $row){
          $output["nacionalidad"] = $row["nacionalidad"];
          $output["cedula"] = $row["cedula"];
          $output["tiporif"] = $row["tiporif"];
          $output["rif"] = $row["rif"];
          $output["primernombre"] = $row["primernombre"];
          $output["segundonombre"] = $row["segundonombre"];
          $output["primerapellido"] = $row["primerapellido"];
          $output["segundoapellido"] = $row["segundoapellido"];
          $output["direccion"] = $row["direccion"];
          $output["telefono"] = $row["telefono"];
          $output["email"] = $row["email"];
        }
        echo json_encode($output);
      } else {
        //si no existe el registro entonces no recorre el array
        $errors[]="El ciudadano no existe";
      }
	    //inicio de mensaje de error
			if(isset($errors)){
				?>
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach($errors as $error) {
							echo $error;
						}
					?>
				</div>
				<?php
			}//fin de mensaje de error

      break;

    case "activarydesactivar":
      //los parametros idciudadano y est vienen por via ajax
      $datos = $ciudadano->get_ciudadano_por_id($_POST["idciudadano"]);          
        //valida el id del ciudadano
      if(is_array($datos)==true and count($datos)>0){              
        //edita el estado del ciudadano 
        $ciudadano->editar_estatus($_POST["idciudadano"],$_POST["estatus"]);
      }
      break;

    case "listar":
      $datos = $ciudadano->get_ciudadano();
      //declaramos el array
      $data = Array();
      $count = 0;

      foreach($datos as $row){
        $sub_array= array();
        //ESTATUS
        $est = '';
        $atrib = "btn btn-success btn-md estatus";
        if($row["estatus"] == 0){
          $est = 'INACTIVO';
          $atrib = "btn btn-warning btn-md estatus";
        } else{
          if($row["estatus"] == 1){
            $est = 'ACTIVO';
          } 
        }


        $count++;
        $sub_array[] =  $count;
        $sub_array[] = $row["nacionalidad"];
        $sub_array[] = $row["cedula"];
        $sub_array[] = $row["tiporif"];
        $sub_array[] = $row["rif"];
        $sub_array[] = $row["primernombre"];
        $sub_array[] = $row["segundonombre"];
        $sub_array[] = $row["primerapellido"];
        $sub_array[] = $row["segundoapellido"];
        $sub_array[] = $row["direccion"];
        $sub_array[] = $row["telefono"];
        $sub_array[] = $row["email"];
        //$sub_array[] = $row["estatus"];
        // $sub_array[] = date("d-m-Y",strtotime($row["fecha_ingreso"]));
   
        $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["idciudadano"].','.$row["estatus"].');" name="estatus" id="'.$row["idciudadano"].'" class="btn-sm '.$atrib.'">'.$est.'</button>';

        $sub_array[] = '<button type="button" onClick="mostrar('.$row["idciudadano"].');"  id="'.$row["idciudadano"].'" class="btn btn-warning btn-sm update">EDITAR</button>';
        
        $data[]=$sub_array;    
      }

      $results= array( 

        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
        echo json_encode($results);
      break;

  }
?>