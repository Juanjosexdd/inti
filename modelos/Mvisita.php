<?php

  require_once("../config/conexion.php");

    class Mvisita extends Conectar{

      public function get_maestrovisita(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM maestrovisita";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
      }

      public function get_maestrovisita_por_id($codvisita){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="select * from maestrovisita where codvisita=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $codvisita);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_maestrovisita($nombre,$descripcion){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="insert into maestrovisita(nombre,descripcion) values(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['nombre'] );
        $sql->bindValue(2 ,$_POST['descripcion'] );

        $sql->execute();
        //$sql->debugDumpParams();

      }

      public function editar_maestrovisita($codvisita,$nombre,$descripcion){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="update maestrovisita set
              nombre=?,
              descripcion=?
              where 
              codvisita=?

              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$descripcion);
        $sql->bindValue(3,$codvisita);
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_estado($codvisita,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="update maestrovisita set   
              estatus=?
              where 
              codvisita=?
              ";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$codvisita);
        $sql->execute();
        #$sql->debugDumpParams();
      }
      
      public function get_nombre_maestrovisita($nombre){
        $conectar=parent::conexion();

        $sql="select * from maestrovisita where nombre=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_maestrovisita_edit($nombre = false, $codvisita = false,$descripcion){
        $conectar=parent::conexion();

        
        $sql="select * from dpto where nombre=? AND descripcion=? AND codvisita<>?";

        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$descripcion);
        $sql->bindValue(3,$codvisita);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }


  }


?>