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
  require_once("../modelos/Dpto.php");

  $dpto = new Dpto();

  _POST(); 
  
    switch($_GET["op"]){

      case "guardaryeditar":

        $id = $_POST["id"];
        $nombre  = $_POST["nombre"];
        $coddpto  = $_POST["coddpto"];

        if(empty($id)){
          $datos = $dpto->get_nombre_dpto($nombre);

          if(is_array($datos)==true && count($datos)==0){
            
            $dpto->registrar_dpto($coddpto,$nombre);
            $messages[]="El Departamento se registró correctamente";

          } else {

            $errors[]="El Departamento ya existe";

          }

        } else {
          
          $datos = $dpto->get_nombre_dpto_edit($coddpto,$nombre,$id);

          if(is_array($datos)==true && count($datos)==0){

            $dpto->editar_dpto($id,$coddpto,$nombre);
            $messages[]="El Departamento se editó correctamente";  

          }else{
             $errors[]="El Departamento ya existe";
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

        $datos=$dpto->get_dpto_por_id($_POST["id"]);

        if(is_array($datos)==true && count($datos)>0){

          foreach($datos as $row){
            $output["id"] = $row["id"];
            $output["coddpto"] = $row["coddpto"];
            $output["nombre"] = $row["nombre"];
            $output["estado"] = $row["estatus"];
          }
          echo json_encode($output);

        } else {
          $errors[]="El dpto no existe";

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
 
        $datos=$dpto->get_dpto_por_id($_POST["id"]);

        if(is_array($datos)==true && count($datos)>0){

          $dpto->editar_estado($_POST["id"],$_POST["est"]);
        } 
        break;
      
      case "listar":

        $datos=$dpto->get_dpto();

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
          $sub_array[] = $row["coddpto"];
          $sub_array[] = $row["nombre"];

          $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["id"].','.$row["estatus"].');" name="estatus" id="'.$row["id"].'" class="'.$atrib.'">'.$est.'</button>';
          $sub_array[] = '<button type="button" onClick="mostrar('.$row["id"].');"  id="'.$row["id"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> EDITAR </button>';
            
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