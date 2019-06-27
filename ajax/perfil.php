<?php

//llamo a la conexion de la base de datos 
  require_once("../config/conexion.php");
  //llamo al modelo Perfil
  require_once("../modelos/Perfil.php");

  $perfil = new Perfil();

  $idusuario=isset($_POST["idusuario_perfil"]);
  $nombre=isset($_POST["nombre_perfil"]);
  $apellido=isset($_POST["apellido_perfil"]);
  $cedula=isset($_POST["nacionalidad_perfil"]);
  $cedula=isset($_POST["cedula_perfil"]);
  $telefono=isset($_POST["telefono_perfil"]);
  $email=isset($_POST["email_perfil"]);
  $direccion=isset($_POST["direccion_perfil"]); 
  $usuario=isset($_POST["usuario_perfil"]);
  $password=isset($_POST["password_perfil"]);
  $password2=isset($_POST["password2_perfil"]);


  switch($_GET["op"]){

    case 'mostrar_perfil':

      $datos=$perfil->get_usuario_por_id($_POST["idusuario_perfil"]);
        if(is_array($datos)==true and count($datos)>0){
          foreach($datos as $row){
            $output["nombre"] = $row["nombres"];
            $output["apellido"] = $row["apellidos"];
            $output["nacionalidad"] = $row["nacionalidads"];
            $output["cedula"] = $row["cedula"];
            $output["telefono"] = $row["telefono"];
            $output["email"] = $row["email"];
            $output["direccion"] = $row["direccion"];
            $output["usuario_perfil"] = $row["usuario"];
            $output["password"] = $row["password"];
            $output["password2"] = $row["password2"];
          }
          echo json_encode($output);
        } else {   
          //si no existe el registro entonces no recorre el array
          $errors[]="El usuario no existe";
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
      case 'editar_perfil':

        $datos= $perfil->get_usuario_nombre($_POST["cedula_perfil"], $_POST["email_perfil"]);


        if($_POST["password_perfil"]==$_POST["password2_perfil"]){

          if(is_array($datos)==true and count($datos)>0){

            $perfil->editar_perfil($idusuario_perfil,$nombre_perfil,$apellido_perfil,$nacionalidad_perfil,$cedula_perfil,$telefono_perfil,$email_perfil,$direccion_perfil,$usuario_perfil,$password_perfil,$password2_perfil);
            $messages[]="El usuario se editó correctamente";
          }//cierre condicional $datos
        } else {

          $errors[]="El password no coincide";
        }
     
         //mensaje success
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
   }
?>