<?php

  require_once("../config/conexion.php");

    class Nacionalidad extends Conectar{

      public function get_nacionalidad(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="select * from nacionalidad";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
        //print_r($sql);
      }

      public function get_nacionalidad_por_id($id){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="select * from nacionalidad where id=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $id);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_nacionalidad($nombre,$abreviatura){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="insert into nacionalidad(nombre,abreviatura) values(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['nombre'] );
        $sql->bindValue(2 ,$_POST['abreviatura'] );
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_nacionalidad($id,$nombre,$abreviatura){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="update nacionalidad set
              nombre=?,
              abreviatura=?
              where 
              id=?

              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$abreviatura);
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

        $sql="update nacionalidad set   
              estatus=?
              where 
              id=?
              ";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$id);
        $sql->execute();
        //$sql->debugDumpParams();
      }
      
      public function get_nombre_nacionalidad($nombre){
        $conectar=parent::conexion();

        $sql="select * from nacionalidad where nombre=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_nacionalidad_edit($id = false,$nombre = false,$abreviatura){
        $conectar=parent::conexion();

        
        $sql="select * from nacionalidad where nombre=? AND abreviatura=? AND id<>?";

        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$abreviatura);
        $sql->bindValue(3,$id);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }
  }
?>