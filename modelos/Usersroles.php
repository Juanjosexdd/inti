<?php

  require_once("../config/conexion.php");

    class Usersroles extends Conectar{

      public function get_usersroles(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT
              ur.*
              ,u.nombre AS nombre_ciudadano
              ,rl.nombre AS nombre_rol
              ,ur.fechainicio
              FROM usersroles ur
              INNER JOIN usuario u ON ur.idusuario = u.idusuario
              INNER JOIN roles rl ON ur.idroles = rl.idroles";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
        //print_r($sql);
      }

      public function get_usersroles_por_id($id){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM usersroles WHERE id=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $id);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_usersroles($idusuario,$idroles){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="INSERT INTO usersroles(idusuario,idroles) VALUES(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['idusuario'] );
        $sql->bindValue(2 ,$_POST['idroles'] );
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_usersroles($id,$idusuario,$idroles){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="UPDATE usersroles SET
              idusuario=?,
              idroles=?
              WHERE 
              id=?
              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$idusuario);
        $sql->bindValue(2,$idroles);
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

        $sql="UPDATE usersroles SET   
              estatus=?
              WHERE 
              id=?
              ";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$id);
        $sql->execute();
        //$sql->debugDumpParams();
      }
      
      public function get_idusuario_usersroles($idusuario){
        $conectar=parent::conexion();

        $sql="SELECT * FROM usersroles WHERE idusuario=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$idusuario);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_idusuario_usersroles_edit($id = false,$idusuario,$idroles){
        $conectar=parent::conexion();

        
        $sql="SELECT * FROM usersroles WHERE idusuario=? AND idroles=? AND id<>?";

        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$idusuario);
        $sql->bindValue(2,$idroles);
        $sql->bindValue(3,$id);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }
  }
?>