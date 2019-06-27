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
  require_once("../modelos/Msector.php");

  $sector = new Sector();

  _POST(); 
    switch($_GET["op"]){

      case "guardaryeditar":

        $codparroquia = $_POST["codparroquia"];
        $nombre       = $_POST["nombre"];
        $codsector    = $_POST["codsector"];

        if(empty($codsector)){
          $datos = $sector->get_nombre_sector($nombre,$codparroquia);

          if(is_array($datos)==true && count($datos)==0){

            $sector->registrar_sector($nombre,$codparroquia);
            $messages[]="El sector se registró correctamente";

          } else {

            $errors[]="El sector ya existe";

          }

        } else {

          $datos = $sector->get_nombre_sector_edit($nombre,$codparroquia,$codsector);

          if(is_array($datos)==true && count($datos)==0){

              $sector->editar_sector($nombre,$codparroquia,$codsector);
              $messages[]="El Sector se editó correctamente";  

          }else{
             $errors[]="El Sector ya existe";
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

        $datos=$sector->get_sector_por_id($_POST["codsector"]);

        if(is_array($datos)==true && count($datos)>0){

          foreach($datos as $row){
            $output["nombre"] = $row["nombre"];
            $output["codpais"] = $row["codpais"];
            $output["codestado"] = $row["codestado"];
            $output["codmunicipio"] = $row["codmunicipio"];
            $output["codparroquia"] = $row["codparroquia"];
            $output["codsector"] = $row["codsector"];
            $output["estado"] = $row["estatus"];
          }
          echo json_encode($output);

        } else {
          $errors[]="El Sector no existe";

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
 
        $datos=$sector->get_sector_por_id($_POST["codsector"]);

        if(is_array($datos)==true && count($datos)>0){

          $sector->editar_estado($_POST["codsector"],$_POST["est"]);
        } 
        break;
      
      case "listar":

        $datos=$sector->get_sector();

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
          $sub_array[] = $row["nombre_parroquia"];
          $sub_array[] = $row["nombre_municipio"];
          $sub_array[] = $row["nombre_estado"];
          $sub_array[] = $row["nombre_pais"];

          $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["codsector"].','.$row["estatus"].');" name="estatus" id="'.$row["codsector"].'" class="'.$atrib.'">'.$est.'</button>';
          $sub_array[] = '<button type="button" onClick="mostrar('.$row["codsector"].');"  id="'.$row["codsector"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> EDITAR</button>';
            
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