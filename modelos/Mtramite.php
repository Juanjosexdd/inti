<?php

  require_once("../config/conexion.php");

    class Tramite extends Conectar{


      public function get_tramite( $orderby = '' ){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="select * from maestrotramite {$orderby}";

        $sql=$conectar->prepare($sql);
        $sql->execute();
        #$sql->debugDumpParams();
        return $resultado=$sql->fetchAll();
      }

      public function get_tramite_por_id($codtramite){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="select * from maestrotramite where codtramite=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $codtramite);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function registrar_tramite($nombre = false){

        $conectar= parent::conexion();
        parent::set_names();

        $sql="insert into maestrotramite(nombre,descripcion) values(?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['nombre'] );
        $sql->bindValue(2 ,$_POST['descripcion'] );
        $sql->execute();
      }

      public function editar_tramite(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="update maestrotramite 
              set nombre=?, descripcion =?
              where codtramite=?
              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$_POST["nombre"]);
        $sql->bindValue(2,$_POST["descripcion"]);
        $sql->bindValue(3,$_POST["codtramite"]);
        $sql->execute();
        //$sql->debugDumpParams();
      }

      public function editar_estado($codtramite,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="update maestrotramite set   
              estatus=?
              where 
              codtramite=?
              ";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estado);
        $sql->bindValue(2,$codtramite);
        $sql->execute();
        #$sql->debugDumpParams();
      }
      
      public function get_nombre_tramite($nombre){
        $conectar=parent::conexion();

        $sql="select * from maestrotramite where nombre=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_tramite_edit($nombre = false, $cod = false){
        $conectar=parent::conexion();

        
        $sql="select * from maestrotramite where nombre=? AND codtramite<>?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$cod);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_recaudos( $where = ''){
        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT 
                mtr.* 
              ,mt.nombre AS tramite
              ,r.nombre AS recaudo
              FROM maestrotramiterecaudos mtr
              INNER JOIN maestrotramite mt ON mt.codtramite = mtr.codtramite
              INNER JOIN recaudos r ON r.idrecaudos = mtr.idrecaudos    
              {$where}";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll();
      }

      function registrar_tramite_recaudo(){
          $conectar= parent::conexion();
          parent::set_names();

          $sql="insert into maestrotramiterecaudos(idrecaudos,codtramite,cantidad) values(?,?,?)";

          $sql=$conectar->prepare($sql);

          $sql->bindValue(1 ,$_POST['idrecaudos'] );
          $sql->bindValue(2 ,$_POST['codtramite'] );
          $sql->bindValue(3 ,$_POST['cantidad'] );
          $sql->execute();
          #$sql->debugDumpParams();
          
      }

      public function eliminar_tramite_recaudo(){
        $conectar= parent::conexion();
        parent::set_names();

        $sql="DELETE FROM maestrotramiterecaudos WHERE id = ?";

        $sql = $conectar->prepare($sql);

        $sql->bindValue(1 ,$_POST['id'] );
        $sql->execute();
        #$sql->debugDumpParams();
    }


    public function actualizar_estatus_tramite_recaudo($estatus = '1'){
      $conectar=parent::conexion();

      $sql="update maestrotramiterecaudos set   
            estatus = ?
            where 
            id = ?
            ";

      $sql=$conectar->prepare($sql);

      $sql->bindValue(1, $estatus );
      $sql->bindValue(2, $_POST['id'] );
      $sql->execute();
      #$sql->debugDumpParams();
    }

    public function actualizar_cantidad(){
      $conectar=parent::conexion();

      $sql="update maestrotramiterecaudos set   
            cantidad = ?
            where 
            id = ?
            ";

      $sql=$conectar->prepare($sql);

      $sql->bindValue(1, $_POST['value'] );
      $sql->bindValue(2, $_POST['id'] );
      $sql->execute();
      #$sql->debugDumpParams();
    }


  }


?>