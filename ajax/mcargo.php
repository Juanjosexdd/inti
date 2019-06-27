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
  require_once("../modelos/Mcargo.php");

  $cargo = new Cargo();

  _POST(); 
  
    switch($_GET["op"]){

      case "guardaryeditar":

        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $idcargo = $_POST["idcargo"];        

        if(empty($idcargo)){
          $datos = $cargo->get_nombre_cargo($nombre);

          if(is_array($datos)==true && count($datos)==0){
            
            $cargo->registrar_cargo($nombre,$descripcion);
            $messages[]="El Cargo se registró correctamente";

          } else {

            $errors[]="El Cargo ya existe";

          }

        } else {
          
          $datos = $cargo->get_nombre_cargo_edit($idcargo,$nombre,$descripcion);

          if(is_array($datos)==true && count($datos)==0){

            $cargo->editar_cargo($idcargo,$nombre,$descripcion);
            $messages[]="El cargo se editó correctamente";  

          }else{
             $errors[]="El cargo ya existe";
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

        $datos=$cargo->get_cargo_por_id($_POST["idcargo"]);

        if(is_array($datos)==true && count($datos)>0){

          foreach($datos as $row){
            $output["idcargo"] = $row["idcargo"];
            $output["nombre"] = $row["nombre"];
            $output["descripcion"] = $row["descripcion"];
            $output["estado"] = $row["estatus"];
          }
          echo json_encode($output);

        } else {
          $errors[]="El cargo no existe";
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
 
        $datos=$cargo->get_cargo_por_id($_POST["idcargo"]);

        if(is_array($datos)==true && count($datos)>0){

          $cargo->editar_estado($_POST["idcargo"],$_POST["est"]);
        } 
        break;
      
      case "listar":

        $datos=$cargo->get_cargo();

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

          $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["idcargo"].','.$row["estatus"].');" name="estatus" id="'.$row["idcargo"].'" class="'.$atrib.'">'.$est.'</button>';
          $sub_array[] = '<button type="button" onClick="mostrar('.$row["idcargo"].');"  id="'.$row["idcargo"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> EDITAR</button>';
            
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