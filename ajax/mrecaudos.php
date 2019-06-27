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
  require_once("../modelos/Recaudos.php");

  $recaudos = new Recaudos();


  _POST(); 
  
    switch($_GET["op"]){

      case "guardaryeditar":
        
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $idrecaudos = $_POST["idrecaudos"];        

        if(empty($idrecaudos)){
          $datos = $recaudos->get_nombre_recaudos($nombre);

          if(is_array($datos)==true && count($datos)==0){
            
            $recaudos->registrar_recaudos($nombre,$descripcion);
            $messages[]="El recaudo se registró correctamente";

          } else {

            $errors[]="El recaudo ya existe";

          }

        } else {
          
          $datos = $recaudos->get_nombre_recaudos_edit($idrecaudos,$nombre,$descripcion);

          if(is_array($datos)==true && count($datos)==0){

            $recaudos->editar_recaudos($idrecaudos,$nombre,$descripcion);
            $messages[]="El recaudo se editó correctamente";  

          }else{
             $errors[]="El recaudo ya existe";
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

        $datos=$recaudos->get_recaudos_por_id($_POST["idrecaudos"]);

        if(is_array($datos)==true && count($datos)>0){

          foreach($datos as $row){
            $output["idrecaudos"] = $row["idrecaudos"];
            $output["nombre"] = $row["nombre"];
            $output["descripcion"] = $row["descripcion"];
            $output["estado"] = $row["estatus"];
          }
          echo json_encode($output);

        } else {
          $errors[]="El recaudo no existe";

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

        $datos=$recaudos->get_recaudos_por_id($_POST["idrecaudos"]);

        if(is_array($datos)==true && count($datos)>0){

          $recaudos->editar_estado($_POST["idrecaudos"],$_POST["est"]);

        } 
        break;
      
      case "listar":

        $datos=$recaudos->get_recaudos();

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

          $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["idrecaudos"].','.$row["estatus"].');" name="estatus" id="'.$row["idrecaudos"].'" class="'.$atrib.'">'.$est.'</button>';
          $sub_array[] = '<button type="button" onClick="mostrar('.$row["idrecaudos"].');"  id="'.$row["idrecaudos"].'" class="btn btn-warning btn-md update"> EDITAR</button>';
          
            
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