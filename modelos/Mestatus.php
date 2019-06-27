<?php

  require_once("../config/conexion.php");

    class Mestatus extends Conectar{


      public function get_estatus(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM estatus";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
      }

      public function get_estatus_por_id($idestatus){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="select * from estatus where idestatus=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $idestatus);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_estatus($codestatus,$nombre = false,$descripcion){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="insert into estatus(codestatus,nombre,descripcion) values(?,?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $_POST["codestatus"]);
        $sql->bindValue(2, $_POST["nombre"]);
        $sql->bindValue(3, $_POST["descripcion"]);
        $sql->execute();
      }

      public function editar_estatus($codestatus,$nombre,$descripcion){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="update estatus set
              codestatus=?,
              nombre=?,
              descripcion=?
              where 
              idestatus=?
              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['codestatus'] );
        $sql->bindValue(2 ,$_POST['nombre'] );
        $sql->bindValue(3 ,$_POST['descripcion'] );
        $sql->bindValue(4 ,$_POST['idestatus'] );
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_estado($idestatus,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="update estatus set   
              estatus=?
              where 
              idestatus=?
              ";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$idestatus);
        $sql->execute();
        #$sql->debugDumpParams();
      }
      
      public function get_nombre_estatus($nombre){
        $conectar=parent::conexion();

        $sql="select * from estatus where nombre=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_estatus_edit($nombre = false, $cod = false){
        $conectar=parent::conexion();

        
        $sql="select * from estatus where nombre=? AND idestatus<>?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$cod);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }


  }


?>