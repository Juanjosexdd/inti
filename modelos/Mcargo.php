<?php

  require_once("../config/conexion.php");

    class Cargo extends Conectar{

      public function get_cargo(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="select * from cargo";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
        //print_r($sql);
      }

      public function get_cargo_por_id($idcargo){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="select * from cargo where idcargo=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $idcargo);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_cargo($nombre,$descripcion){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="insert into cargo(nombre,descripcion) values(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['nombre'] );
        $sql->bindValue(2 ,$_POST['descripcion'] );
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_cargo($idcargo,$nombre,$descripcion){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="update cargo set
              nombre=?,
              descripcion=?
              where 
              idcargo=?
              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$descripcion);
        $sql->bindValue(3,$idcargo);
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_estado($idcargo,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="update cargo set   
              estatus=?
              where 
              idcargo=?
              ";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$idcargo);
        $sql->execute();
        //$sql->debugDumpParams();
      }
      
      public function get_nombre_cargo($nombre){
        $conectar=parent::conexion();

        $sql="select * from cargo where nombre=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_cargo_edit($idcargo = false,$nombre = false,$descripcion){
        $conectar=parent::conexion();

        
        $sql="select * from cargo where nombre=? AND descripcion=? AND id<>?";

        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$descripcion);
        $sql->bindValue(3,$idcargo);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }
  }
?>