<?php

  require_once("../config/conexion.php");

    class Parroquia extends Conectar{


      public function get_parroquia(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT 
              pr.*
              ,m.nombre as nombre_municipio
              ,e.nombre AS nombre_estado
              ,p.nombre AS nombre_pais
              ,p.codpais
              ,e.codestado
              FROM parroquia pr
              INNER JOIN municipio m  ON pr.codmunicipio = m.codmunicipio
              INNER JOIN estado e     ON m.codestado = e.codestado
              INNER JOIN pais p       ON e.codpais   = p.codpais";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
      }

      public function get_parroquia_por_id($codparroquia){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="SELECT 
              pr.*
              ,m.nombre as nombre_municipio
              ,e.nombre AS nombre_estado
              ,p.nombre AS nombre_pais
              ,p.codpais
              ,e.codestado
              FROM parroquia pr
              INNER JOIN municipio m  ON pr.codmunicipio = m.codmunicipio
              INNER JOIN estado e     ON m.codestado = e.codestado
              INNER JOIN pais p       ON e.codpais   = p.codpais
              WHERE pr.codparroquia=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $codparroquia);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_parroquia($nombre,$codmunicipio){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="INSERT INTO parroquia(nombre,codmunicipio) VALUES(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['nombre']);
        $sql->bindValue(2 ,$_POST['codmunicipio']);
        $sql->execute();
      }

      public function editar_parroquia($codparroquia,$nombre,$codmunicipio){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="UPDATE parroquia SET 
              nombre=?,
              codmunicipio=?
              WHERE
              codparroquia=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["nombre"]);
        $sql->bindValue(2,$_POST["codmunicipio"]);
        $sql->bindValue(3,$_POST["codparroquia"]);
        $sql->execute();
        #$sql->debugDumpParams();
      }

      public function editar_estado($codparroquia,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="UPDATE parroquia SET   
              estatus=?
              WHERE 
              codparroquia=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$codparroquia);
        $sql->execute();
        #$sql->debugDumpParams();
      }
      
      public function get_nombre_parroquia($nombre,$codmunicipio){
        $conectar=parent::conexion();

        $sql="SELECT * FROM parroquia WHERE nombre=? AND codmunicipio=?";

        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$codmunicipio);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_parroquia_edit($nombre = false, $codmunicipio = false, $codparroquia){
        $conectar=parent::conexion();
        
        $sql="SELECT * FROM parroquia WHERE nombre=? AND codmunicipio=? AND codparroquia<>?";

        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$codmunicipio);
        $sql->bindValue(3,$codparroquia);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        #$sql->debugDumpParams();
      }


  }


?>