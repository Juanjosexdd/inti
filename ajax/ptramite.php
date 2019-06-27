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
  require_once("../modelos/Tramite.php");

  $tramite = new Tramite();

  _POST(); 
    switch( $_GET["op"] ){
      case 'ProcesarTramite': 

          $idtramite   = $_POST['idtramite'];
          $observacion = (isset($_POST['observacion']) && $_POST['observacion'] != "") ? $_POST['observacion'] : '';
          $estatus     = $_POST['estatus'];

          $tramiteactualizado = 'NO';

          if(!empty($idtramite)){


          // Consultar Estatus Siguiente $tramite->get_orden_estatus($estatus)
          $data_estatus = $tramite->get_orden_estatus($estatus); 

          // FINALIZAR ESTATUS ANTERIOR
          $tramite_actualizado = $tramite->cambiar_estatus_tramite_bandeja($idtramite,$data_estatus[0]['idestatus'],$observacion," AND e.codestatus IN('{$estatus}')"); // cambiar estatus

            $estatus_actualizado = $data_estatus[0]['nombre'];

            if(!$tramite_actualizado){
              $errors[]="Error, el trámite se encuentra en un estatus que no se puede Atender";
              $_SESSION["error"] = "El trámite se encuentra en un estatus que no se puede Atender";
              $tramiteactualizado = 'NO';
            }else{
              $data_estatus = $tramite->get_orden_estatus($data_estatus[0]['idestatus']);
              $tramiteactualizado = 'SI';

              if(!$data_estatus){
                // Colocar Fecha fin al trámite
                $tramite->cerrar_tramite($idtramite);
                $_SESSION["messages"] = "El Trámite ha sido FINALIZADO";
              }else{
              
                $_SESSION["messages"] = "El Trámite ha sido cambiado a estatus {$estatus_actualizado}";
              }
              
            }

          } else {

            $errors[]="Error, intente nuevamente";

          }

          $results = array(
            "POST" => $_POST
          ,"tramiteactualizado" => $tramiteactualizado
          );

        echo json_encode($results);
      break;
      case 'AnularTramite': 

        $idtramite  = $_POST['idtramite'];
        $motivo     = $_POST['motivo'];

        $tramiteactualizado = 'NO';


        if(!empty($idtramite) && !empty($motivo)){

          $tramite_actualizado = $tramite->cambiar_estatus_tramite_bandeja($idtramite,'-1',$motivo," AND e.codestatus NOT IN('5','-1')"); // Anular

          if(!$tramite_actualizado){
            $errors[]="Error, el trámite se encuentra en un estatus que no se puede anular";
            $_SESSION["error"] = "El trámite se encuentra en un estatus que no se puede anular";
            $tramiteactualizado = 'NO';
          }else{
            // Colocar Fecha fin al trámite
            $tramite->cerrar_tramite($idtramite);

            $tramiteactualizado = 'SI';

            $_SESSION["messages"] = "El Trámite ha sido ANULADO";
            $_SESSION["messages"] = "El Trámite ha sido ANULADO";
          }
         

        } else {

          $errors[]="Error, intente nuevamente";

        }

        $results = array(
           "POST" => $_POST
          ,"tramiteactualizado" => $tramiteactualizado
        );

        echo json_encode($results);
      break;
      case 'agregarRecaudos': 

        $idtramite  = $_POST['idtramite'];
        $idrecaudo  = $_POST['idrecaudo'];
        $codtramite = $_POST['codtramite'];

        $tramiteactualizado = 'NO';
        if(!empty($idtramite) && !empty($idrecaudo) && !empty($codtramite)){
          /*
          $where = "WHERE td.id = (SELECT MAX(id) FROM tramitedetalle WHERE idtramite = td.idtramite)
                      AND t.cedulasolicitante = '{$cedulasolicitante}' 
                      AND t.codtramite        = '{$codtramite}'
                      AND e.codestatus        NOT IN ('-1','5')";
          $datos = $tramite->get_tramite($where);*/
          $datos = Array();
         
          if(is_array($datos)==true && count($datos)==0){
            # $codtramite,$cedulasolicitante,$loteterreno,$superficie,$codsector,$fechainicio,$observacion
            $tramite->registrar_tramite_recaudo();

            $where = "WHERE r.estatus = 1 AND mtr.codtramite = '{$codtramite}' AND mtr.estatus = '1'";
            $datos_recaudos = $tramite->get_recaudos($where,true);

            $where = "WHERE idtramite = '{$idtramite}'";
            $datos_tramite = $tramite->get_tramite_recaudos($where,true);

            // $datos_recaudos[0]['cantidad'] / $datos_tramite[0]['cantidad']

            if( $datos_recaudos[0]['cantidad'] == $datos_tramite[0]['cantidad'] ){ // cambiar a estatus PENDIENTE 

              $tramite_actualizado = $tramite->cambiar_estatus_tramite($idtramite,'1'); // PENDIENTE
              $tramiteactualizado = 'SI';

              $_SESSION["messages"] = "El Trámite ha sido cambiado a estatus PENDIENTE";

            }else{ // NO CAMBIAR

            }

            $messages[]="Agregado correctamente";

          } else {

            $errors[]="Error, intente nuevamente";

          }
        } 

        $results = array(
           "POST" => $_POST
          ,"tramiteactualizado" => $tramiteactualizado
        );

        echo json_encode($results);
      break;
      case 'removerRecaudos': 

        $idtramite = $_POST['idtramite'];
        $idrecaudo = $_POST['idrecaudo'];
        $codtramite = $_POST['codtramite'];

        $tramiteactualizado = 'NO';

        if(!empty($idtramite) && !empty($idrecaudo)){
          /*
          $where = "WHERE td.id = (SELECT MAX(id) FROM tramitedetalle WHERE idtramite = td.idtramite)
                      AND t.cedulasolicitante = '{$cedulasolicitante}' 
                      AND t.codtramite        = '{$codtramite}'
                      AND e.codestatus        NOT IN ('-1','5')";
          $datos = $tramite->get_tramite($where);*/
          $datos = Array();

          if(is_array($datos)==true && count($datos)==0){
            # $codtramite,$cedulasolicitante,$loteterreno,$superficie,$codsector,$fechainicio,$observacion

            $where = "WHERE r.estatus = 1 AND mtr.codtramite = '{$codtramite}' AND mtr.estatus = '1'";
            $datos_recaudos = $tramite->get_recaudos($where,true);

            $where = "WHERE idtramite = '{$idtramite}'";
            $datos_tramite = $tramite->get_tramite_recaudos($where,true);

            // $datos_recaudos[0]['cantidad'] / $datos_tramite[0]['cantidad']

            if( $datos_recaudos[0]['cantidad'] == $datos_tramite[0]['cantidad'] ){ // cambiar a estatus PENDIENTE 

              $tramite_actualizado = $tramite->cambiar_estatus_tramite($idtramite,'0'); // BORRADOR
              $tramiteactualizado  = 'SI';

              $_SESSION["messages"] = "El Trámite ha sido cambiado a estatus BORRADOR";

            }else{ // NO CAMBIAR

            }

            $tramite->eliminar_tramite_recaudo();
            $messages[]="Eliminado correctamente";

          } else {

            $errors[]="Error, intente nuevamente";

          }
        } 
        
        $results = array(
           "POST"=> $_POST 
          ,"tramiteactualizado" => $tramiteactualizado
        );

        echo json_encode($results);
      break;
      case 'cargarRecaudos': 

          $where = "WHERE r.estatus = 1 AND mtr.codtramite = '{$_POST['codtramite']}' AND mtr.estatus = '1'";
          $datos_recaudos = $tramite->get_recaudos($where);


          $where = "WHERE idtramite = '{$_POST['idtramite']}'";
          $datos_tramite = $tramite->get_tramite_recaudos($where);

          $count = 1; $tbody = '';
          foreach ($datos_recaudos as $key => $value) {

            $key = array_search($value['idrecaudos'], array_column($datos_tramite, 'idrecaudo'));

            
            if($key === false){ // no encontrado
              $checked = "";
            }else{ // encontrado
              $checked = "checked";
            }
            
            $tbody .= "
             <tr>
                <td style='text-align: center;'>{$count}</td>
                <td>{$value['nombre']}</td>
                <td style='text-align: center;'>{$value['cantidad']}</td>
                <td style='text-align: center;'><input type='checkbox' {$checked} class='minimal' value='{$value['idrecaudos']}' idtramite='{$_POST['idtramite']}' codtramite='{$_POST['codtramite']}'></td>
              </tr>
            ";

            $count++;

          }

          $results = array(
            "tbody"=> $tbody 
          );

          echo json_encode($results);
      break;
      case "guardaryeditar":

        $idtramite         = $_POST["idtramite"];
        $codtramite        = $_POST["codtramite"];
        $cedulasolicitante = $_POST["cedulasolicitante"];
        $loteterreno       = $_POST["loteterreno"];
        $superficie        = $_POST["superficie"];
        $codsector         = $_POST["codsector"];
        $fechainicio       = $_POST["fechainicio"];
        $observacion       = $_POST["observacion"];

        if(empty($idtramite)){
          $where = "WHERE td.id = (SELECT MAX(id) FROM tramitedetalle WHERE idtramite = td.idtramite)
                      AND t.cedulasolicitante = '{$cedulasolicitante}' 
                      AND t.codtramite        = '{$codtramite}'
                      AND e.codestatus        NOT IN ('-1','5')";
          $datos = $tramite->get_tramite($where);
          #$datos = Array();

          if(is_array($datos)==true && count($datos)==0){
            # $codtramite,$cedulasolicitante,$loteterreno,$superficie,$codsector,$fechainicio,$observacion
            $tramite->registrar_tramite();
            $messages[]="El se registró correctamente";

          } else {

            $errors[]="Ya existe un registro activo para este Ciudadano con el mismo Trámite";

          }

        } 

        if (isset($messages)){          
          ?>
          <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>¡Bien hecho!</strong>
              <input type="hidden" name="tipomensaje" id="tipomensaje" value="correcto">
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
                <input type="hidden" name="tipomensaje" id="tipomensaje" value="error">
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
            $output["codpais"] = $row["codpais"];
            $output["codestado"] = $row["codestado"];
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
        $variables = explode("?", $_SERVER['HTTP_REFERER']);
        //print_r($variables);

        if (isset($variables[1])){
            eval('$'.$variables[1].';'); // Crear Variable

            if(isset($estatus)){
              //print_r($estatus);
            }else{
              // echo 'No existe variable estatus';
              $estatus = 0; // BORRADOR
            }
            
        }else{
          // echo 'No existe variables $_GET';
          $estatus = 0; // BORRADOR
        }

        $where = "WHERE td.id = (SELECT MAX(id) FROM tramitedetalle WHERE idtramite = td.idtramite)
                    AND e.codestatus = {$estatus}";
        $datos = $tramite->get_tramite($where);

        $data = Array();
        $count = 0;

        if( $datos ){

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
              $datociudadano = $row["cedulasolicitante"].' - '.$row["primernombre"].' '.$row["primerapellido"];
              $sub_array[] = $datociudadano;
              $sub_array[] = $row["tramite"];


              $date = date_create( str_replace("/", "-", $row["fechacreacion"]) );
              $date = date_format($date, 'd-m-Y H:i:s'); // 'Y-m-d H:i:s'


              $sub_array[] = $date;
              $sub_array[] = $row["sector"];
              $sub_array[] = $row["estatus"];

              # onClick="mostrar('.$row["codtramite"].');"
              # onClick="mostrar('.$row["codtramite"].');"

              $accion = '';

              if( $row["codestatus"] == -1 || $row["codestatus"] == 5){ // Anular trámite
                $accion .= '
                <button type="button" disabled title="Anular" class="btn btn-danger btn-md update"><i class="glyphicon glyphicon-edit"></i><i class="fas fa-trash-alt"></i></button>';
              }else{ # data-toggle="modal" data-target="#tramiteAnularModal"
                $accion .= '
                <button type="button" onClick="anularTramite('.$row["idtramite"].','.$row["codtramite"].',\''.$datociudadano.'\',\''.$row["tramite"].'\',\''.$date.'\',\''.$row["sector"].'\',\''.$row["estatus"].'\',\''.$row["observacion"].'\');"  title="Anular" id="'.$row["idtramite"].'" class="btn btn-danger btn-md update"><i class="glyphicon glyphicon-edit"></i><i class="fas fa-trash-alt"></i></button>';
              }

              if( $row["codestatus"] == 0 || $row["codestatus"] == 1){ // Agregar Recaudos data-toggle="modal" data-target="#tramiteRecaudoModal"
                $accion .= '
                <button type="button" onClick="listarRecaudos('.$row["idtramite"].','.$row["codtramite"].',\''.$datociudadano.'\',\''.$row["tramite"].'\',\''.$date.'\',\''.$row["sector"].'\',\''.$row["estatus"].'\',\''.$row["observacion"].'\');"  title="Agregar Recaudos" id="'.$row["idtramite"].'" class="btn btn-success btn-md update"><i class="glyphicon glyphicon-edit"></i><i class="fas fa-plus"></i></button>';

              }else{
                $accion .= '
                <button type="button" disabled title="Agregar Recaudos" class="btn btn-success btn-md update"><i class="glyphicon glyphicon-edit"></i><i class="fas fa-plus"></i></button>';
              }
              
              if( $row["codestatus"] == -1 || $row["codestatus"] == 5  || $row["codestatus"] == 0 ){ // Atender Solicitud 
                $accion .= '
                <button type="button" disabled onclick="" class="btn btn-primary btn-md update"><i class="fa fa-check"></i></button>
                ';
              }else{ # data-toggle="modal" data-target="#tramiteProcesarModal"
                $accion .= '
                <button type="button" onClick="procesarTramite('.$row["idtramite"].','.$row["codtramite"].',\''.$datociudadano.'\',\''.$row["tramite"].'\',\''.$date.'\',\''.$row["sector"].'\',\''.$row["codestatus"].'\',\''.$row["observacion"].'\');"  class="btn btn-primary btn-md update"><i class="fa fa-check"></i></button>
                ';
              }

              $sub_array[] = $accion;

              $data[] = $sub_array;
            }
        }else{
            $data = Array();
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