<?php

  function _POST($excepcion = array() ){ // sanitizar
    $i=0;
    $array_post = array_keys($_POST); 
    $array_excepcion = array_values($excepcion);

      foreach ($_POST as $key => $value) {

      if( !is_array($_POST[$key]) ){

        $descartar = array_search( $key , $array_excepcion );

        if( $descartar === false  ){
          $_POST[$key] = mb_strtoupper(trim($_POST[$key]),'UTF-8');
        }

        $i++; // autoincrementamos
      }

    }
  } // cierre función _POST


 //llamo a la conexion de la base de datos 
  require_once("../config/conexion.php");
  //llamo al modelo
  require_once("../modelos/Roles.php");

  $roles = new Roles();

  _POST(); 
  
    switch($_GET["op"]){

      case "guardaryeditar":

        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $idroles = $_POST["idroles"];        

        if(empty($idroles)){
          $datos = $roles->get_nombre_roles($nombre);

          if(is_array($datos)==true && count($datos)==0){
            
            $roles->registrar_roles($nombre,$descripcion);
            $messages[]="El rol se registró correctamente";

          } else {

            $errors[]="El rol ya existe";

          }

        } else {
          
          $datos = $roles->get_nombre_roles_edit($idroles,$nombre,$descripcion);

          if(is_array($datos)==true && count($datos)==0){

            $roles->editar_roles($idroles,$nombre,$descripcion);
            $messages[]="El rol se editó correctamente";  

          }else{
             $errors[]="El rol ya existe";
          }
        }

        if (isset($messages)){
          ?>
          <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>¡Bien hecho!</strong>
              <?php
                foreach ($messages as $message) {
                    echo $message;
                  }
                ?>
          </div>
          <?php
        }
        if (isset($errors)){
          ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong> 
                <?php
                  foreach ($errors as $error) {
                      echo $error;
                    }
                  ?>
            </div>
          <?php
        }

        break;

      case 'mostrar':

        $datos=$roles->get_roles_por_id($_POST["idroles"]);

        if(is_array($datos)==true && count($datos)>0){

          foreach($datos as $row){
            $output["idroles"] = $row["idroles"];
            $output["nombre"] = $row["nombre"];
            $output["descripcion"] = $row["descripcion"];
            $output["fechainicio"] = $row["fechainicio"];
            $output["estado"] = $row["estatus"];
          }
          echo json_encode($output);

        } else {
          $errors[]="El rol no existe";
        }

        if(isset($errors)){
      
          ?>
          <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Error!</strong> 
              <?php
                foreach ($errors as $error) {
                    echo $error;
                  }
                ?>
          </div>
          <?php
        }

        break;

      case "activarydesactivar":
 
        $datos=$roles->get_roles_por_id($_POST["idroles"]);

        if(is_array($datos)==true && count($datos)>0){

          $roles->editar_estado($_POST["idroles"],$_POST["est"]);
        } 
        break;
      
      case "listar":

        $datos=$roles->get_roles();

        $data= Array();
        $count = 0;
        foreach($datos as $row){
          $sub_array = array();
    
          $est = '';
          $atrib = "btn btn-success btn-md estado";
          if($row["estatus"] == 0){
            $est = 'INACTIVO';
            $atrib = "btn btn-warning btn-md estado";
          }else{
            if($row["estatus"] == 1){
              $est = 'ACTIVO';
            } 
          }

          $count++;
          $sub_array[] =  $count;
          $sub_array[] = $row["nombre"];
          $sub_array[] = $row["descripcion"];
          $sub_array[] = $row["fechainicio"];

          $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["idroles"].','.$row["estatus"].');" name="estatus" id="'.$row["idroles"].'" class="'.$atrib.'">'.$est.'</button>';
          $sub_array[] = '<button type="button" onClick="mostrar('.$row["idroles"].');"  id="'.$row["idroles"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> EDITAR</button>';
            
          $data[] = $sub_array;
        }

        $results = array(
          "sEcho"=>1, //Información para el datatables
          "iTotalRecords"=>count($data), //enviamos el total registros al datatable
          "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
          "aaData"=>$data);
        echo json_encode($results);
        break;
    }



?>