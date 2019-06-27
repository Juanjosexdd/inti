<?php

  require_once("../config/conexion.php");

    class Sector extends Conectar{


      public function get_sector(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT 
              s.*
              ,pr.nombre AS nombre_parroquia
              ,m.nombre AS nombre_municipio
              ,e.nombre AS nombre_estado
              ,p.nombre AS nombre_pais
              ,p.codpais
              ,e.codestado
              ,m.codmunicipio
              ,pr.codparroquia
              ,s.codsector
              FROM sector s
              INNER JOIN parroquia pr ON s.codparroquia = pr.codparroquia
              INNER JOIN municipio m ON pr.codmunicipio = m.codmunicipio
              INNER JOIN estado e ON m.codestado = e.codestado
              INNER JOIN pais p   ON e.codpais   = p.codpais";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
      }

      public function get_sector_por_id($codsector){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="SELECT 
              s.*
              ,pr.nombre AS nombre_parroquia
              ,m.nombre AS nombre_municipio
              ,e.nombre AS nombre_estado
              ,p.nombre AS nombre_pais
              ,p.codpais
              ,e.codestado
              ,m.codmunicipio
              ,pr.codparroquia
              ,s.codsector
              FROM sector s
              INNER JOIN parroquia pr ON s.codparroquia = pr.codparroquia
              INNER JOIN municipio m ON pr.codmunicipio = m.codmunicipio
              INNER JOIN estado e ON m.codestado = e.codestado
              INNER JOIN pais p   ON e.codpais   = p.codpais
              WHERE s.codsector=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $codsector);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_sector($nombre = false,$codparroquia){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="INSERT INTO sector(nombre,codparroquia) VALUES(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['nombre'] );
        $sql->bindValue(2 ,$_POST['codparroquia'] );
        $sql->execute();
      }

      public function editar_sector($codsector,$nombre,$codparroquia){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="UPDATE sector SET 
              nombre=?,
              codparroquia=?
              WHERE
              codsector=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$_POST["nombre"]);
        $sql->bindValue(2,$_POST["codparroquia"]);
        $sql->bindValue(3,$_POST["codsector"]);
        $sql->execute();
        #$sql->debugDumpParams();
      }

      public function editar_estado($codsector,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="UPDATE sector SET   
              estatus=?
              WHERE 
              codsector=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$codsector);
        $sql->execute();
        #$sql->debugDumpParams();
      }
      
      public function get_nombre_sector($nombre,$codparroquia){
        $conectar=parent::conexion();

        $sql="SELECT * FROM sector WHERE nombre=? AND codparroquia=?";

        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$codparroquia);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_sector_edit($nombre = false, $codparroquia = false, $codsector){
        $conectar=parent::conexion();
        
        $sql="SELECT * FROM sector WHERE nombre=? AND codparroquia=? AND codsector<>?";

        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$codparroquia);
        $sql->bindValue(3,$codsector);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        #$sql->debugDumpParams();
      }


  }


?>