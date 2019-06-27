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
  require_once("../modelos/Mestatus.php");

  $estatus = new Mestatus();

  _POST(); 
  
    switch($_GET["op"]){

      case "guardaryeditar":

        $nombre      = $_POST["nombre"];
        $codestatus  = $_POST["codestatus"];
        $descripcion = $_POST["descripcion"];
        $idestatus   = $_POST["idestatus"];

        if(empty($idestatus)){
          $datos = $estatus->get_nombre_estatus($nombre);

          if(is_array($datos)==true && count($datos)==0){
            
            $estatus->registrar_estatus($codestatus,$nombre,$descripcion);
            $messages[]="El estatus se registró correctamente";

          } else {

            $errors[]="El estatus ya existe";

          }

        } else {
          
          $datos = $estatus->get_nombre_estatus_edit($nombre);

          if(is_array($datos)==true && count($datos)==0){

            $estatus->editar_estatus($codestatus,$nombre,$descripcion);
            $messages[]="El estatus se editó correctamente";  

          }else{
             $errors[]="La estatus ya existe";
          }
        }

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

      case 'mostrar':

        $datos=$estatus->get_estatus_por_id($_POST["idestatus"]);

        if(is_array($datos)==true && count($datos)>0){

          foreach($datos as $row){
            $output["idestatus"] = $row["idestatus"];
            $output["codestatus"] = $row["codestatus"];
            $output["nombre"] = $row["nombre"];
            $output["descripcion"] = $row["descripcion"];
            $output["estado"] = $row["estatus"];
          }
          echo json_encode($output);

        } else {
          $errors[]="El estatus no existe";

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

        $datos=$estatus->get_estatus_por_id($_POST["idestatus"]);

        if(is_array($datos)==true && count($datos)>0){

          $estatus->editar_estado($_POST["idestatus"],$_POST["est"]);

        } 
        break;
      
      case "listar":

        $datos=$estatus->get_estatus();

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
          $sub_array[] = $row["codestatus"];
          $sub_array[] = $row["nombre"];
          $sub_array[] = $row["descripcion"];

          $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["idestatus"].','.$row["estatus"].');" name="estatus" id="'.$row["idestatus"].'" class="'.$atrib.'">'.$est.'</button>';
          $sub_array[] = '<button type="button" onClick="mostrar('.$row["idestatus"].');"  id="'.$row["idestatus"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> EDITAR</button>';
            
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