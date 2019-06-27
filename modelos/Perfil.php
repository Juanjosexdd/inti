<?php

  //conexión a la base de datos

   require_once("../config/conexion.php");

    class Perfil extends Conectar{      
      public function get_usuario_por_id($idusuario){
        $conectar= parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM usuario WHERE idusuario=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $idusuario);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      } 
      public function get_usuario_nombre($cedula,$email){

        $conectar=parent::conexion();

        $sql= "SELECT * FROM usuario WHERE cedula=? OR email=?";

        $sql=$conectar->prepare($sql);
        
        $sql->bindValue(1, $cedula);
        $sql->bindValue(2, $email);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }


      public function editar_perfil($idusuario_perfil,$nombre_perfil,$apellido_perfil,$nacionalidad_perfil,$cedula_perfil,$telefono_perfil,$email_perfil,$direccion_perfil,$usuario_perfil,$password_perfil,$password2_perfil){

        $conectar=parent::conexion();
        $sql="UPDATE usuario SET 
             
                nombre=?,
                apellido=?,
                nacionalidad=?,
                cedula=?,
                fechanacimiento=?,
                telefono=?,
                email=?,
                direccion=?,
                usuario=?,
                password=?,
                password2=?
                
                WHERE
                idusuario=?";

        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["nombre_perfil"]);
        $sql->bindValue(2,$_POST["apellido_perfil"]);
        $sql->bindValue(3,$_POST["nacionalidad_perfil"]);
        $sql->bindValue(4,$_POST["cedula_perfil"]);
        $sql->bindValue(5,$_POST["fechanacimiento_perfil"]);
        $sql->bindValue(6,$_POST["telefono_perfil"]);
        $sql->bindValue(7,$_POST["email_perfil"]);
        $sql->bindValue(8,$_POST["direccion_perfil"]);
        $sql->bindValue(9,$_POST["usuario_perfil"]);
        $sql->bindValue(10,$_POST["password_perfil"]);
        $sql->bindValue(11,$_POST["password2_perfil"]);
        $sql->bindValue(12,$_POST["idusuario_perfil"]);
        $sql->execute();
      }
    }
?>