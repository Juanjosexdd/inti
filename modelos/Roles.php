<?php

  require_once("../config/conexion.php");

    class Roles extends Conectar{

      public function get_roles(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM roles";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
        //print_r($sql);
      }

      public function get_roles_por_id($idroles){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM roles WHERE idroles=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $idroles);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_roles($nombre,$descripcion){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="INSERT INTO roles(nombre,descripcion) VALUES(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['nombre']);
        $sql->bindValue(2 ,$_POST['descripcion']);
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_roles($idroles,$nombre,$descripcion){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="UPDATE roles SET
              nombre=?,
              descripcion=?
              WHERE 
              idroles=?
              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$descripcion);
        $sql->bindValue(3,$idroles);
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_estado($idroles,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="UPDATE roles SET   
              estatus=?
              WHERE 
              idroles=?
              ";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$idroles);
        $sql->execute();
        //$sql->debugDumpParams();
      }
      
      public function get_nombre_roles($nombre){
        $conectar=parent::conexion();

        $sql="SELECT * FROM roles WHERE nombre=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_roles_edit($idroles = false,$nombre = false,$descripcion){
        $conectar=parent::conexion();

        
        $sql="SELECT * FROM roles WHERE nombre=? AND descripcion=? AND id<>?";

        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$descripcion);
        $sql->bindValue(3,$idroles);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }
  }
?>