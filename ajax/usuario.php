<?php

  //llamar a la conexion de la base de datos
  require_once("../config/conexion.php");
  //llamar a el modelo Usuarios 
  require_once("../modelos/Usuarios.php");

  $usuarios = new Usuario();
  
  $idusuario = isset($_POST["idusuario"]);
  $nombre=isset($_POST["nombre"]);
  $apellido=isset($_POST["apellido"]);
  $nacionalidad=isset($_POST["nacionalidad"]);
  $cedula=isset($_POST["cedula"]);
  $fechanacimiento=isset($_POST["fechanacimiento"]);
  $telefono=isset($_POST["telefono"]);
  $email=isset($_POST["email"]);
  $direccion=isset($_POST["direccion"]); 
  $coddpto=isset($_POST["coddpto"]);
  $cargo=isset($_POST["cargo"]);
  $usuario=isset($_POST["usuario"]);
  $password=isset($_POST["password"]);
  $password2=isset($_POST["password2"]);
  //este es el que se envia del formulario
  // $estatus=isset($_POST["estatus"]);


  switch($_GET["op"]){
    case "guardaryeditar":

      if($password == $password2){

        if(empty($_POST["idusuario"])){

          $datos = $usuarios->get_cedula_email_del_usuario($_POST["cedula"],$_POST["email"]);
            if(is_array($datos)==true and count($datos)==0){
              //no existe el usuario por lo tanto hacemos el registros
              $usuarios->registrar_usuario($nombre,$apellido,$nacionalidad,$cedula,$fechanacimiento,$telefono,$email,$direccion,$coddpto,$cargo,$usuario,$password,$password2);
              $messages[]="El usuario se registró correctamente";
            } else {
              $messages[]="La cédula o el correo ya existe";
            }                     
        } else {
            $usuarios->editar_usuario($idusuario,$nombre,$apellido,$nacionalidad,$cedula,$fechanacimiento,$telefono,$email,$direccion,$coddpto,$cargo,$usuario,$password,$password2);
            $messages[]="El usuario se editó correctamente";
        }                
      } else {
        $errors[]="El password no coincide";
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
      
      $datos = $usuarios->get_usuario_por_id($_POST["idusuario"]);
        //validacion del id del usuario  
      if(is_array($datos)==true and count($datos)>0){
        foreach($datos as $row){
          $output["nacionalidad"] = $row["nacionalidad"];
          $output["cedula"] = $row["cedula"];
          $output["nombre"] = $row["nombre"];
          $output["apellido"] = $row["apellido"];
          $output["fechanacimiento"] = $row["fechanacimiento"];
          $output["telefono"] = $row["telefono"];
          $output["email"] = $row["email"];
          $output["direccion"] = $row["direccion"];
          $output["fechaingreso"] = $row["fechaingreso"];
          $output["coddpto"] = $row["coddpto"];
          $output["cargo"] = $row["cargo"];
          $output["usuario"] = $row["usuario"];
          $output["password"] = $row["password"];
          $output["password2"] = $row["password2"];
          $output["estatus"] = $row["estatus"];
          }
          echo json_encode($output);

      } else {
      
        $errors[]="El usuario no existe";
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

      $datos = $usuarios->get_usuario_por_id($_POST["idusuario"]);          
        
      if(is_array($datos)==true and count($datos)>0){              
        
        $usuarios->editar_estatus($_POST["idusuario"],$_POST["estatus"]);
      }
      break;

    case "listar":
      $datos = $usuarios->get_usuario();
      //declaramos el array
      $data = Array();
      foreach($datos as $row){
        $sub_array= array();
        //estatus
        $estatus = '';
        $atrib = "btn btn-success btn-md estatus";
        if($row["estatus"] == 0){
          $estatus = 'INACTIVO';
          $atrib = "btn btn-warning btn-md estatus";
        } else{
          if($row["estatus"] == 1){
            $estatus = 'ACTIVO';
          } 
        }
        $sub_array[] = $row["nacionalidad"];
        $sub_array[] = $row["cedula"];
        $sub_array[] = $row["nombre"];
        $sub_array[] = $row["apellido"];
        $sub_array[] = $row["fechanacimiento"];
        $sub_array[] = $row["telefono"];
        $sub_array[] = $row["email"];
        $sub_array[] = $row["direccion"];
        $sub_array[] = $row["fechaingreso"];
        $sub_array[] = $row["coddpto"];
        $sub_array[] = $row["cargo"];
        $sub_array[] = $row["usuario"];
   
        $sub_array[] = '<button type="button" onClick="cambiarEstatus('.$row["idusuario"].','.$row["estatus"].');" name="estatus" id="'.$row["idusuario"].'" class="btn-sm '.$atrib.'">'.$estatus.'</button>';

        $sub_array[] = '<button type="button" onClick="mostrar('.$row["idusuario"].');"  id="'.$row["idusuario"].'" class="btn btn-warning btn-sm update"> EDITAR </button>';
        
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