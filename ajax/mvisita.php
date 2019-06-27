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
  require_once("../modelos/Mvisita.php");

  $mvisita = new Mvisita();

  _POST(); 
  
    switch($_GET["op"]){

      case "guardaryeditar":

        $codvisita    = $_POST["codvisita"];
        $nombre       = $_POST["nombre"];
        $descripcion  = $_POST["descripcion"];

        if(empty($codvisita)){
          $datos = $mvisita->get_nombre_maestrovisita($nombre);

          if(is_array($datos)==true && count($datos)==0){
            
            $mvisita->registrar_maestrovisita($nombre,$descripcion);
            $messages[]="El Tipo de visita se registró correctamente";

          } else {

            $errors[]="El tipo de visita ya existe";

          }

        } else {
          
          $datos = $mvisita->get_nombre_maestrovisita_edit($nombre,$descripcion,$codvisita);

          if(is_array($datos)==true && count($datos)==0){

            $mvisita->editar_maestrovisita($codvisita,$nombre,$descripcion);
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

        $datos=$mvisita->get_maestrovisita_por_id($_POST["codvisita"]);

        if(is_array($datos)==true && count($datos)>0){

          foreach($datos as $row){
            $output["codvisita"] = $row["codvisita"];
            $output["nombre"] = $row["nombre"];
            $output["descripcion"] = $row["descripcion"];
            $output["estado"] = $row["estatus"];
          }
          echo json_encode($output);

        } else {
          $errors[]="El tipo de visita no existe";

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
 
        $datos=$mvisita->get_maestrovisita_por_id($_POST["codvisita"]);

        if(is_array($datos)==true && count($datos)>0){

          $mvisita->editar_estado($_POST["codvisita"],$_POST["est"]);
        } 
        break;
      
      case "listar":

        $datos=$mvisita->get_maestrovisita();

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

          $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["codvisita"].','.$row["estatus"].');" name="estatus" id="'.$row["codvisita"].'" class="'.$atrib.'">'.$est.'</button>';
          $sub_array[] = '<button type="button" onClick="mostrar('.$row["codvisita"].');"  id="'.$row["codvisita"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> EDITAR</button>';
            
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