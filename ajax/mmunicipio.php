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
  //llamo al modelo Categorías
  require_once("../modelos/Municipio.php");

  $municipio = new Municipio();

  _POST(); 
    switch($_GET["op"]){

      case "guardaryeditar":

        $codmunicipio = $_POST["codmunicipio"];
        $nombre       = $_POST["nombre"];
        $codestado    = $_POST["codestado"];

        if(empty($codmunicipio)){
          $datos = $municipio->get_nombre_municipio($nombre,$codestado);

          if(is_array($datos)==true && count($datos)==0){

            $municipio->registrar_municipio($nombre,$codestado);
            $messages[]="El se registró correctamente";

          } else {

            $errors[]="El municipio ya existe";

          }

        } else {
          
          $datos = $municipio->get_nombre_municipio_edit($nombre,$codestado,$codmunicipio);

          if(is_array($datos)==true && count($datos)==0){

              $municipio->editar_municipio($nombre,$codestado,$codmunicipio);
              $messages[]="El municipio se editó correctamente";  

          }else{
             $errors[]="El municipio ya existe";
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

        $datos=$municipio->get_municipio_por_id($_POST["codmunicipio"]);

        if(is_array($datos)==true && count($datos)>0){

          foreach($datos as $row){
            $output["codmunicipio"] = $row["codmunicipio"];
            $output["nombre"] = $row["nombre"];
            $output["codpais"] = $row["codpais"];
            $output["codestado"] = $row["codestado"];
            $output["estado"] = $row["estatus"];
          }
          echo json_encode($output);

        } else {
          $errors[]="El municipio no existe";

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
 
        $datos=$municipio->get_municipio_por_id($_POST["codmunicipio"]);

        if(is_array($datos)==true && count($datos)>0){

          $municipio->editar_estado($_POST["codmunicipio"],$_POST["est"]);
        } 
        break;
      
      case "listar":

        $datos=$municipio->get_municipio();

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
          $sub_array[] = $row["nombre_estado"];
          $sub_array[] = $row["nombre_pais"];

          $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["codmunicipio"].','.$row["estatus"].');" name="estatus" id="'.$row["codmunicipio"].'" class="'.$atrib.'">'.$est.'</button>';
          $sub_array[] = '<button type="button" onClick="mostrar('.$row["codmunicipio"].');"  id="'.$row["codmunicipio"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> EDITAR</button>';
            
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