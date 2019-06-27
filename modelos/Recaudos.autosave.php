<?php

  require_once("../config/conexion.php");

    class Recaudos extends Conectar{

      public function get_recaudos(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM recaudos";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
      }

      public function get_recaudos_por_id($idrecaudos){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM recaudos WHERE idrecaudos=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$idrecaudos);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_recaudos($nombre,$descripcion){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="INSERT INTO recaudos VALUES(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $_POST["nombre"]);
        $sql->bindValue(2, $_POST["descripcion"]);
        $sql->execute();
        //print_r($_POST);
      }

      public function editar_recaudos($idrecaudos,$nombre,$descripcion){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="UPDATE recaudos SET
              nombre=?,
              descripcion=?
              WHERE 
              idrecaudos=?

              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$_POST['nombre']);
        $sql->bindValue(2,$_POST['descripcion']);
        $sql->bindValue(3,$_POST['idrecaudos']);
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_estado($idrecaudos,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="UPDATE recaudos SET   
              estatus=?
              WHERE 
              idrecaudos=?
              ";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$idrecaudos);
        $sql->execute();
        #$sql->debugDumpParams();
      }
      
      public function get_nombre_recaudos($nombre){
        $conectar=parent::conexion();

        $sql="select * from recaudos where nombre=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_recaudos_edit($nombre = false, $cod = false){
        $conectar=parent::conexion();

        
        $sql="select * from recaudos where nombre=? AND idrecaudos<>?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$cod);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }


  }


?>