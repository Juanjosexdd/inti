<?php

  require_once("../config/conexion.php");

    class Estado extends Conectar{


      public function get_estado(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT 
               e.* 
              ,p.nombre AS nombre_pais
              ,p.codpais
              FROM estado e
              INNER JOIN pais p   ON e.codpais   = p.codpais";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
      }

      public function get_estado_por_id($codestado){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="SELECT 
               e.* 
              ,p.nombre AS nombre_pais
              ,p.codpais
              FROM estado e
              INNER JOIN pais p   ON e.codpais   = p.codpais 
              WHERE e.codestado=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $codestado);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_estado($nombre = false){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="insert into estado(nombre,codpais) values(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['nombre'] );
        $sql->bindValue(2 ,$_POST['codpais'] );
        $sql->execute();
      }

      public function editar_estados($nombre,$codpais,$codestado){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="update estado set 
               nombre=?
              ,codpais=?
              where 
              codestado=?

              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$_POST["nombre"]);
        $sql->bindValue(2,$_POST["codpais"]);
        $sql->bindValue(3,$_POST["codestado"]);
        $sql->execute();
        #$sql->debugDumpParams();
      }

      public function editar_estado($codestado,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="update estado set   
              estatus=?
              where 
              codestado=?
              ";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$codestado);
        $sql->execute();
        $sql->debugDumpParams();
      }
      
      public function get_nombre_estado($nombre,$codpais){
        $conectar=parent::conexion();

        $sql="select * from estado where nombre=? AND codpais=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$codpais);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_estado_edit($nombre = false, $codpais = false, $codestado){
        $conectar=parent::conexion();

        
        $sql="select * from estado where nombre=? AND codpais<>?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$codpais);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }


  }


?>