<?php

  require_once("../config/conexion.php");

    class Pais extends Conectar{


      public function get_pais(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM pais";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
      }

      public function get_pais_por_id($codpais){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="select * from pais where codpais=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $codpais);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_pais($nombre = false){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="insert into pais(nombre) values(?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['nombre'] );
        $sql->execute();
      }

      public function editar_pais($codpais,$nombre){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="update pais set 
              nombre=?
              where 
              codpais=?

              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$_POST["nombre"]);
        $sql->bindValue(2,$_POST["codpais"]);
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_estado($codpais,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="update pais set   
              estatus=?
              where 
              codpais=?
              ";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$codpais);
        $sql->execute();
        #$sql->debugDumpParams();
      }
      
      public function get_nombre_pais($nombre){
        $conectar=parent::conexion();

        $sql="select * from pais where nombre=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_pais_edit($nombre = false, $cod = false){
        $conectar=parent::conexion();

        
        $sql="select * from pais where nombre=? AND codpais<>?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$cod);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }


  }


?>