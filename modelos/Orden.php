<?php

  require_once("../config/conexion.php");

    class Dptoestatus extends Conectar{

      public function get_dptoestatus(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="select * from dptoestatus";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
        //print_r($sql);
      }

      public function get_dptoestatus_por_id($idcargo){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="select * from dptoestatus where idcargo=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $idcargo);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_dptoestatus($nombre,$descripcion){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="insert into dptoestatus(nombre,descripcion) values(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['nombre'] );
        $sql->bindValue(2 ,$_POST['descripcion'] );
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_dptoestatus($idcargo,$nombre,$descripcion){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="update dptoestatus set
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

        $sql="update dptoestatus set   
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
      
      public function get_nombre_dptoestatus($nombre){
        $conectar=parent::conexion();

        $sql="select * from dptoestatus where nombre=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_dptoestatus_edit($idcargo = false,$nombre = false,$descripcion){
        $conectar=parent::conexion();

        
        $sql="select * from dptoestatus where nombre=? AND descripcion=? AND id<>?";

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