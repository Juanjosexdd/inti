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
  require_once("../modelos/Estado.php");

  $estados = new Estado();

  _POST(); 
  
    switch($_GET["op"]){

      case "guardaryeditar":

        $codestado = $_POST["codestado"];
        $nombre    = $_POST["nombre"];
        $codpais   = $_POST["codpais"];

        if(empty($codestado)){
          $datos = $estados->get_nombre_estado($nombre,$codpais);

          if(is_array($datos)==true && count($datos)==0){

            $estados->registrar_estado($nombre);
            $messages[]="El estado se registró correctamente";

          } else {

            $errors[]="El estado ya existe";

          }

        } else {
          
          $datos = $estados->get_nombre_estado_edit($nombre,$codpais,$codestado);

          if(is_array($datos)==true && count($datos)==0){

              $estados->editar_estados($nombre,$codpais,$codestado);
              $messages[]="El estado se editó correctamente";  

          }else{
             $errors[]="El estado ya existe";
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

        $datos=$estados->get_estado_por_id($_POST["codestado"]);

        if(is_array($datos)==true && count($datos)>0){

          foreach($datos as $row){
            $output["nombre"] = $row["nombre"];
            $output["codpais"] = $row["codpais"];
            $output["estado"] = $row["estatus"];
          }
          echo json_encode($output);

        } else {
          $errors[]="El estado no existe";

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
 
        $datos=$estados->get_estado_por_id($_POST["codestado"]);

        if(is_array($datos)==true && count($datos)>0){

          $estados->editar_estado($_POST["codestado"],$_POST["est"]);
        } 
        break;
      
      case "listar":

        $datos=$estados->get_estado();

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
          //$sub_array[] = $row["codestado"];
          $sub_array[] = $row["nombre"];
          $sub_array[] = $row["nombre_pais"];


          $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["codestado"].','.$row["estatus"].');" name="estatus" id="'.$row["codestado"].'" class="'.$atrib.'">'.$est.'</button>';
          $sub_array[] = '<button type="button" onClick="mostrar('.$row["codestado"].');"  id="'.$row["codestado"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> EDITAR </button>';
            
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