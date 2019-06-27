<?php

  require_once("../config/conexion.php");

    class Municipio extends Conectar{


      public function get_municipio(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT 
               m.* 
              ,e.nombre AS nombre_estado
              ,p.nombre AS nombre_pais
              ,p.codpais
              FROM municipio m
              INNER JOIN estado e ON m.codestado = e.codestado
              INNER JOIN pais p   ON e.codpais   = p.codpais";

        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll();
      }

      public function get_municipio_por_id($codmunicipio){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="SELECT 
               m.* 
              ,e.nombre AS nombre_estado
              ,p.nombre AS nombre_pais
              ,p.codpais
              FROM municipio m
              INNER JOIN estado e ON m.codestado = e.codestado
              INNER JOIN pais p   ON e.codpais   = p.codpais 
              WHERE m.codmunicipio=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $codmunicipio);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_municipio($nombre = false){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="insert into municipio(nombre,codestado) values(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['nombre'] );
        $sql->bindValue(2 ,$_POST['codestado'] );
        $sql->execute();
      }

      public function editar_municipio($nombre,$codestado,$codmunicipio){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="update municipio set 
               nombre=?
              ,codestado=?
              where 
              codmunicipio=?

              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$_POST["nombre"]);
        $sql->bindValue(2,$_POST["codestado"]);
        $sql->bindValue(3,$_POST["codmunicipio"]);
        $sql->execute();
        #$sql->debugDumpParams();
      }

      public function editar_estado($codmunicipio,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="update municipio set   
              estatus=?
              where 
              codmunicipio=?
              ";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$codmunicipio);
        $sql->execute();
        #$sql->debugDumpParams();
      }
      
      public function get_nombre_municipio($nombre,$codestado){
        $conectar=parent::conexion();

        $sql="select * from municipio where nombre=? AND codestado=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$codestado);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_municipio_edit($nombre = false, $codestado = false, $codmunicipio){
        $conectar=parent::conexion();

        
        $sql="SELECT * FROM municipio WHERE nombre=? AND codestado=? AND codmunicipio<>?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$codestado);
        $sql->bindValue(3,$codmunicipio);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }


  }


?>