<?php

 /**
     *Función para limpiar las variables $_POST
      *@see public
      *@author 
      *@copyright 12-2016
  */
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
  require_once("../modelos/Mtramite.php");

  $tramite = new Tramite();

  _POST(); 
  
    switch($_GET["op"]){

      case 'removerRecaudos': 
          $id = $_POST['id'];

          if(!empty($id)){
            /*
            $where = "WHERE td.id = (SELECT MAX(id) FROM tramitedetalle WHERE idtramite = td.idtramite)
                        AND t.cedulasolicitante = '{$cedulasolicitante}' 
                        AND t.codtramite        = '{$codtramite}'
                        AND e.codestatus        NOT IN ('-1','5')";
            $datos = $tramite->get_tramite($where);*/
            $datos = Array();

            if(is_array($datos)==true && count($datos)==0){
              # $codtramite,$cedulasolicitante,$loteterreno,$superficie,$codsector,$fechainicio,$observacion

              $tramite->eliminar_tramite_recaudo();

              $messages[]="Eliminado correctamente";

            } else {

              $errors[]="Error, intente nuevamente";

            }
          } 
          
          $where = "WHERE r.estatus = '1' AND mt.estatus = '1' AND mtr.codtramite = '{$_POST['codtramite']}' ORDER BY mtr.id desc";
          $datos_recaudos = $tramite->get_recaudos($where);

          $count = count($datos_recaudos); $tbody = '';
          foreach ($datos_recaudos as $key => $value) {

            $tbody .= "
            <tr>
                <td style='text-align: center;'>{$count}</td>
                <td>{$value['recaudo']}</td>
                <td style='text-align: center;'>{$value['cantidad']}</td>
                <td style='text-align: center;'>
                <button type='button' onClick='removerRecaudos(".$value['id'].",".$_POST['codtramite'].")'  title='Agregar Recaudos' id='' class='btn btn-danger btn-md update'><i class='glyphicon glyphicon-edit'></i><i class='fas fa-trash'></i></button>
                </td>
              </tr>
            ";

            $count--;

          }


          $results = array(
             "POST"  => $_POST
            ,"tbody" => $tbody
          );

          echo json_encode($results);
      break;

      case 'AsociarRecaudos': 

        $idrecaudo  = $_POST['idrecaudos'];
        $codtramite = $_POST['codtramite'];
        $cantidad = $_POST['cantidad'];

        $tramiteactualizado = 'NO';
        $tbody = "";
        $error = "";

        if(!empty($codtramite) && !empty($idrecaudo) && !empty($cantidad)){
          
          $where = "WHERE r.estatus = '1' 
                      AND mt.estatus = '1' 
                      AND mtr.codtramite = '{$_POST['codtramite']}' 
                      AND mtr.idrecaudos = '{$_POST['idrecaudos']}'";

          $datos = $tramite->get_recaudos($where);
          #$datos = Array();
        
          if(is_array($datos)==true && count($datos)==0){
            # $codtramite,$cedulasolicitante,$loteterreno,$superficie,$codsector,$fechainicio,$observacion
            $tramite->registrar_tramite_recaudo();

            $messages[]="Agregado correctamente";

          } else {

            $errors[]="Error, intente nuevamente";
            $error = '
                  <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Error!</strong> 
                      el registro ya existe
                  </div>';

          }
        } 

        $where = "WHERE r.estatus = '1' AND mt.estatus = '1' AND mtr.codtramite = '{$_POST['codtramite']}' ORDER BY mtr.id desc";
        $datos_recaudos = $tramite->get_recaudos($where);

        $count = count($datos_recaudos); $tbody = '';
        foreach ($datos_recaudos as $key => $value) {

          $tbody .= "
          <tr>
              <td style='text-align: center;'>{$count}</td>
              <td>{$value['recaudo']}</td>
              <td style='text-align: center;'>{$value['cantidad']}</td>
              <td style='text-align: center;'>
              <button type='button' onClick='removerRecaudos(".$value['id'].",".$_POST['codtramite'].")'  title='Agregar Recaudos' id='' class='btn btn-danger btn-md update'><i class='glyphicon glyphicon-edit'></i><i class='fas fa-trash'></i></button>
              </td>
            </tr>
          ";

          $count--;

        }

        $results = array(
          "POST" => $_POST
          ,"tramiteactualizado" => $tramiteactualizado
          ,"tbody" => $tbody
          ,"error" => $error
        );

        echo json_encode($results);
      break;
      case 'cargarRecaudos': 
          $where = "WHERE r.estatus = '1' AND mt.estatus = '1' AND mtr.codtramite = '{$_POST['codtramite']}' ORDER BY mtr.id desc";
          $datos_recaudos = $tramite->get_recaudos($where);

          $count = count($datos_recaudos); $tbody = '';
          foreach ($datos_recaudos as $key => $value) {

            /*
              $key = array_search($value['idrecaudos'], array_column($datos_tramite, 'idrecaudo'));

              
              if($key === false){ // no encontrado
                $checked = "";
              }else{ // encontrado
                $checked = "checked";
            }
            */
            
            $tbody .= "
            <tr>
                <td style='text-align: center;'>{$count}</td>
                <td>{$value['recaudo']}</td>
                <td style='text-align: center;'>{$value['cantidad']}</td>
                <td style='text-align: center;'>
                <button type='button' onClick='removerRecaudos(".$value['id'].",".$_POST['codtramite'].")'  title='Agregar Recaudos' id='' class='btn btn-danger btn-md update'><i class='glyphicon glyphicon-edit'></i><i class='fas fa-trash'></i></button>
                </td>
              </tr>
            ";

            $count--;

          }

          $results = array(
            "tbody"=> $tbody 
          );

          echo json_encode($results);
      
      break;
      case "guardaryeditar":

        $codtramite = $_POST["codtramite"];
        $nombre     = $_POST["nombre"];
        $descripcion= $_POST["descripcion"];

        if(empty($codtramite)){
          $datos = $tramite->get_nombre_tramite($nombre);

          if(is_array($datos)==true && count($datos)==0){

            $tramite->registrar_tramite($nombre);
            $messages[]="El se registró correctamente";

          } else {

            $errors[]="El tramite ya existe";

          }

        } else {
          
          $datos = $tramite->get_nombre_tramite_edit();

          if(is_array($datos)==true && count($datos)==0){

              $tramite->editar_tramite($codtramite,$nombre);
              $messages[]="El tramite se editó correctamente";  

          }else{
             $errors[]="El tramite ya existe";
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

        $datos=$tramite->get_tramite_por_id($_POST["codtramite"]);

        if(is_array($datos)==true && count($datos)>0){

          foreach($datos as $row){
            $output["codtramite"] = $row["codtramite"];
            $output["nombre"] = $row["nombre"];
            $output["descripcion"] = $row["descripcion"];
            $output["estado"] = $row["estatus"];
          }
          echo json_encode($output);

        } else {
          $errors[]="El tramite no existe";

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
 
        $datos=$tramite->get_tramite_por_id($_POST["codtramite"]);

        if(is_array($datos)==true && count($datos)>0){

          $tramite->editar_estado($_POST["codtramite"],$_POST["est"]);
        } 
        break;
      
      case "listar":

        $datos=$tramite->get_tramite();

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

          $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["codtramite"].','.$row["estatus"].');" name="estatus" id="'.$row["codtramite"].'" class="'.$atrib.'">'.$est.'</button>';

          
          $sub_array[] = '<button type="button" onClick="mostrar('.$row["codtramite"].');"  id="'.$row["codtramite"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> EDITAR</button>
          
          
          <button type="button" onClick="asociarRecaudos('.$row["codtramite"].',\''.$row["nombre"].'\',\''.$row["descripcion"].'\')"  title="Agregar Recaudos" id="" class="btn btn-success btn-md update"><i class="glyphicon glyphicon-edit"></i><i class="fas fa-plus"></i></button>
          
          
          ';
            
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