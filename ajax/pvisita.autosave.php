<?php

  //llamar a la conexion de la base de datos
  require_once("../config/conexion.php");
  //llamar a el modelo Pvisita
  require_once("../modelos/Pvisita.php");

  $visita = new Pvisita();


  switch($_GET["op"]){
    case "guardaryeditar":
      $idvisita          = $_POST["idvisita"];
      $cedulaciudadano   = $_POST["cedulaciudadano"];
      $codvisita         = $_POST["codvisita"];
      $coddpto           = $_POST["coddpto"];
      $motivo            = $_POST["motivo"];
      $idusuario         = $_POST["idusuario"];

        if(empty($idvisita)){
          $datos = $visita->get_visita_por_id($idvisita);

          if(is_array($datos)==true && count($datos)==0){

            $visita->registrar_visita($cedulaciudadano,$codvisita,$motivo,$coddpto,$idusuario);
            $messages[]="La visita se registro correctamente";

          } else {

            $errors[]="La visita ya existe";

          }

        } else {
          $datos = $visita->get_visita_por_id($idvisita);
          
          if(is_array($datos)==true && count($datos)==1){

            $visita->editar_visita($idvisita,$cedulaciudadano,$codvisita,$motivo,$coddpto,$idusuario);
            $messages[]="La visita se editó correctamente";  
          }else{
             $errors[]="La visita no existe";
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

    case "mostrar":
      
      $datos = $visita->get_visita_por_id($_POST["idvisita"]);
        //validacion del id del usuario  
      if(is_array($datos)==true and count($datos)>0){
        foreach($datos as $row){
          $output["cedulaciudadano"] = $row["cedulaciudadano"];
          $output["fechainicio"] = $row["fechainicio"];
          $output["codvisita"] = $row["codvisita"];
          $output["motivo"] = $row["motivo"];
          $output["coddpto"] = $row["coddpto"];
          }
          echo json_encode($output);

      } else {
      
        $errors[]="La visita no existe";
      }
      //inicio de mensaje de error
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
      }//fin de mensaje de error

      break;
    case "listar":
      $datos = $visita->get_visita();
      //declaramos el array
      $data = Array();
      foreach($datos as $row){
        $sub_array= array();
        $count = 0;
        $count++;
        
        $sub_array[] =  $count;
        $sub_array[] = $row["cedulaciudadano"];
        $sub_array[] = $row["fechainicio"];
        $sub_array[] = $row["codvisita"];
        $sub_array[] = $row["motivo"];
        $sub_array[] = $row["coddpto"];
   
        // $sub_array[] = '<button type="button" onClick="cambiarEstatus('.$row["idvisita"].','.$row["estatus"].');" name="estatus" id="'.$row["idvisita"].'" class="btn-sm '.$atrib.'">'.$est.'</button>';

        $sub_array[] = '<button type="button" onClick="mostrar('.$row["idvisita"].');"  id="'.$row["idvisita"].'" class="btn btn-warning btn-sm update"> EDITAR</button>';
        
        $data[]=$sub_array;    
      }

      $results= array( 

        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
        echo json_encode($results);
      break;
  }
?>