<?php

  require_once("../config/conexion.php");

    class Dpto extends Conectar{

      public function get_dpto(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM dpto";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
      }

      public function get_dpto_por_id($id){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM dpto WHERE id=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $id);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_dpto($coddpto,$nombre){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="INSERT INTO dpto VALUES(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['coddpto'] );
        $sql->bindValue(2 ,$_POST['nombre'] );

        $sql->execute();
        //$sql->debugDumpParams();

      }

      public function editar_dpto($id,$coddpto,$nombre){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="UPDATE dpto SET
              coddpto=?,
              nombre=?
              WHERE 
              id=?

              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$coddpto);
        $sql->bindValue(2,$nombre);
        $sql->bindValue(3,$id);
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_estado($id,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="UPDATE dpto SET   
              estatus=?
              WHERE 
              id=?
              ";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$id);
        $sql->execute();
        #$sql->debugDumpParams();
      }
      
      public function get_nombre_dpto($nombre){
        $conectar=parent::conexion();

        $sql="SELECT * FROM dpto WHERE nombre=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_dpto_edit($coddpto,$nombre = true, $id = true){
        $conectar=parent::conexion();

        
        $sql="SELECT * FROM dpto WHERE coddpto=? AND nombre=? AND id<>?";

        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$coddpto);
        $sql->bindValue(2,$nombre);
        $sql->bindValue(3,$id);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }


  }


?>