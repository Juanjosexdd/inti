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
  require_once("../modelos/Usersroles.php");

  $usersroles = new Usersroles();

  _POST(); 
  
    switch($_GET["op"]){

      case "guardaryeditar":

        $idusuario = $_POST["idusuario"];
        $idroles = $_POST["idroles"];
        $id = $_POST["id"];        

        if(empty($id)){
          $datos = $usersroles->get_idusuario_usersroles($idusuario);

          if(is_array($datos)==true && count($datos)==0){
            
            $usersroles->registrar_usersroles($idusuario,$idroles);
            $messages[]="El Rol a usuario se registró correctamente";

          } else {

            $errors[]="El Cargo ya existe";

          }

        } else {
          
          $datos = $usersroles->get_idusuario_usersroles_edit($id,$idusuario,$idroles);

          if(is_array($datos)==true && count($datos)==0){

            $usersroles->editar_usersroles($idcargo,$idusuario,$idroles);
            $messages[]="El Rol a usuario se editó correctamente";  

          }else{
             $errors[]="El Rol a usuario ya existe";
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

        $datos=$usersroles->get_usersroles_por_id($_POST["id"]);

        if(is_array($datos)==true && count($datos)>0){

          foreach($datos as $row){
            $output["id"] = $row["id"];
            $output["idusuario"] = $row["idusuario"];
            $output["idroles"] = $row["idroles"];
            $output["estado"] = $row["estatus"];
          }
          echo json_encode($output);

        } else {
          $errors[]="El Rol a usuario no existe";
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
 
        $datos=$usersroles->get_usersroles_por_id($_POST["id"]);

        if(is_array($datos)==true && count($datos)>0){

          $usersroles->editar_estado($_POST["id"],$_POST["est"]);
        } 
        break;
      
      case "listar":

        $datos=$usersroles->get_usersroles();

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
          $sub_array[] = $row["nombre_ciudadano"];
          $sub_array[] = $row["nombre_rol"];
          $sub_array[] = $row["fechainicio"];

          $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["id"].','.$row["estatus"].');" name="estatus" id="'.$row["id"].'" class="'.$atrib.'">'.$est.'</button>';
          $sub_array[] = '<button type="button" onClick="mostrar('.$row["id"].');"  id="'.$row["id"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> EDITAR</button>';
            
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