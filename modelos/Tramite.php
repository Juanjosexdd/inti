<?php

  require_once("../config/conexion.php");

    class Tramite extends Conectar{

      public function get_filas_tramite(){

        $conectar= parent::conexion();
        $sql="select * from tramite";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        return $sql->rowCount();
      }


      public function get_tramite( $where = '' ){
        #'WHERE td.id = (SELECT MAX(id) FROM tramitedetalle WHERE idtramite = td.idtramite)';

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT 
                t.* 
              ,c.primernombre
              ,c.primerapellido
              ,mt.nombre tramite
              ,s.nombre sector
              ,e.codestatus
              ,e.nombre estatus
              ,td.id
              FROM tramite t
              INNER JOIN tramitedetalle td ON td.idtramite = t.idtramite
              INNER JOIN estatus e ON e.codestatus = td.codestatus
              INNER JOIN ciudadano c ON t.cedulasolicitante = c.cedula
              INNER JOIN maestrotramite mt ON mt.codtramite = t.codtramite
              INNER JOIN sector s ON s.codsector = t.codsector
              {$where}";

        $sql=$conectar->prepare($sql);
        $sql->execute();
        #$sql->debugDumpParams();
     
        return $resultado=$sql->fetchAll();
      }

      public function get_tramite_id( $where = '' ){
        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT idtramite
                FROM tramite t
               {$where}";

        $sql=$conectar->prepare($sql);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll();
      }

      public function get_tramite_por_id($codtramite){
      
        $conectar= parent::conexion();
        parent::set_names();

        $sql="SELECT 
               m.* 
              ,e.nombre AS nombre_estado
              ,p.nombre AS nombre_pais
              ,p.codpais
              FROM tramite m
              INNER JOIN estado e ON m.codestado = e.codestado
              INNER JOIN pais p   ON e.codpais   = p.codpais 
              WHERE m.codtramite=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $codtramite);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }

      public function get_recaudos( $where = '', $count = false){
        $conectar=parent::conexion();
        parent::set_names();

        if(!$count){
          $SELECT = "r.*
                    ,mtr.codtramite
                    ,mtr.cantidad";
        }else{
          $SELECT = "COUNT(*) cantidad";
        }

        $sql="SELECT 
                {$SELECT} 
              FROM recaudos r
              INNER JOIN maestrotramiterecaudos mtr ON mtr.idrecaudos = r.idrecaudos   
              {$where}";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll();
      }

      public function get_tramite_recaudos($where, $count = false){
        $conectar=parent::conexion();
        parent::set_names();

        if(!$count){
          $SELECT = "tr.*";
        }else{
          $SELECT = "COUNT(*) cantidad";
        }

        $sql="SELECT {$SELECT} 
              FROM tramiterecaudos tr 
              {$where}";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll();
      }

      public function eliminar_tramite_recaudo(){
          $conectar= parent::conexion();
          parent::set_names();

          $sql="DELETE FROM tramiterecaudos WHERE idtramite = ? AND idrecaudo = ?";

          $sql = $conectar->prepare($sql);

          $sql->bindValue(1 ,$_POST['idtramite'] ); // (A)
          $sql->bindValue(2 ,$_POST['idrecaudo'] );
          $sql->execute();
          #$sql->debugDumpParams();
      }

      public function registrar_tramite_recaudo(){
          $conectar= parent::conexion();
          parent::set_names();

          $sql="insert into tramiterecaudos(idtramite,idrecaudo) 
          values(?,?)";

          $sql = $conectar->prepare($sql);

          $sql->bindValue(1 ,$_POST['idtramite'] ); // (A)
          $sql->bindValue(2 ,$_POST['idrecaudo'] );
          $sql->execute();
          #$sql->debugDumpParams();
      }

      public function registrar_tramite(){
        # $codtramite,$cedulasolicitante,$loteterreno,$superficie,$codsector,$fechainicio,$observacion
        $conectar= parent::conexion();
        parent::set_names();

        #CABECERA
        $sql="insert into tramite(cedulasolicitante,codtramite,loteterreno,superficie,codsector,fechainicio,observacion,idusuario) 
            values(?,?,?,?,?,?,?,?)";
            

        $sql=$conectar->prepare($sql);

        $date = $this->convertir_fecha_bd($_POST['fechainicio']);
        
        $sql->bindValue(1 ,$_POST['cedulasolicitante'] );
        $sql->bindValue(2 ,$_POST['codtramite'] );
        $sql->bindValue(3 ,$_POST['loteterreno'] );
        $sql->bindValue(4 ,$_POST['superficie'] );
        $sql->bindValue(5 ,$_POST['codsector'] );
        $sql->bindValue(6 ,$date);
        $sql->bindValue(7 ,$_POST['observacion'] );
        $sql->bindValue(8 ,$_SESSION['idusuario'] );
        $sql->execute();
        #$sql->debugDumpParams();

        // Consultar id Generado de idtramite 
        $where = "WHERE t.cedulasolicitante = '{$_POST['cedulasolicitante']}' 
                    AND t.codtramite        = '{$_POST['codtramite']}'
                    AND t.loteterreno       = '{$_POST['loteterreno']}'
                    AND t.superficie        = '{$_POST['superficie']}'
                    AND t.codsector         = '{$_POST['codsector']}'
                    AND t.idusuario         = '{$_SESSION['idusuario']}'
                    AND t.observacion       = '{$_POST['observacion']}'";
        $datos = $this->get_tramite_id($where); // (A)
         
        $conectar= parent::conexion();
        parent::set_names();
        
        #DETALLE
        $sql="insert into tramitedetalle(idtramite,observaciones,idusuario) 
            values(?,?,?)";

        $sql=$conectar->prepare($sql);
       
        $sql->bindValue(1 ,$datos[0]['idtramite'] ); // (A)
        #$sql->bindValue(1 ,31 );
        $sql->bindValue(2 ,$_POST['observacion'] );
        $sql->bindValue(3 ,$_SESSION['idusuario'] );
        $sql->execute();
        #$sql->debugDumpParams();
   
       
      }

      public function cambiar_estatus_tramite($idtramite,$estatus){
        $conectar = parent::conexion();
        parent::set_names();

        // CONSULTAR ULTIMO ESTATUS DETALLE
        $where = "WHERE td.id = (SELECT MAX(id) FROM tramitedetalle WHERE idtramite = td.idtramite)
                    AND t.idtramite = {$idtramite}";
        $datos = $this->get_tramite($where); // (A)

        // Finalizar estatus anterior
        $sql="update tramitedetalle set 
                  fechafin=now()
                  where 
                  id=?
                ";
              
          $sql=$conectar->prepare($sql);

          $sql->bindValue(1,$datos[0]['id']);
          $sql->execute();

         # INSERTAR DETALLE
         $sql="insert into tramitedetalle(idtramite,codestatus,idusuario) 
         values(?,?,?)";

        $sql=$conectar->prepare($sql);
        
        $sql->bindValue(1 ,$idtramite ); 
        $sql->bindValue(2 ,$estatus );
        $sql->bindValue(3 ,$_SESSION['idusuario'] );
        $sql->execute();
        #$sql->debugDumpParams();

      }

      public function cerrar_tramite($idtramite){
        $conectar = parent::conexion();
        parent::set_names();

          // cerrar trámite
          $sql="update tramite set 
                fechafin = now()
                where 
                idtramite = ?
              ";
        
          $sql = $conectar->prepare($sql);

          $sql->bindValue(1,$idtramite);
          $sql->execute();


          // CONSULTAR ULTIMO ESTATUS DETALLE
        $where = "WHERE td.id = (SELECT MAX(id) FROM tramitedetalle WHERE idtramite = td.idtramite)
                AND t.idtramite = {$idtramite}";
        $datos = $this->get_tramite($where); // (A)


         // Finalizar estatus anterior
         $sql="update tramitedetalle set 
                fechafin=now()
                  where 
                  id=?
                ";
              
          $sql=$conectar->prepare($sql);

          $sql->bindValue(1,$datos[0]['id']);
          $sql->execute();
      }

      public function cambiar_estatus_tramite_bandeja($idtramite,$estatus,$motivo,$and = ''){
        $conectar= parent::conexion();
        parent::set_names();

        // CONSULTAR ULTIMO ESTATUS DETALLE
        $where = "WHERE td.id = (SELECT MAX(id) FROM tramitedetalle WHERE idtramite = td.idtramite)
                    AND t.idtramite = {$idtramite}
                    {$and}";
        $datos = $this->get_tramite($where); // (A)


        if( !$datos ){
          return false;
        }else{
          // Finalizar estatus anterior
          $sql="update tramitedetalle set 
                  fechafin=now()
                  where 
                  id=?
                ";
              
          $sql=$conectar->prepare($sql);

          $sql->bindValue(1,$datos[0]['id']);
          $sql->execute();

          # INSERTAR DETALLE
          $sql="insert into tramitedetalle(idtramite,codestatus,observaciones,idusuario) 
          values(?,?,?,?)";

          $sql=$conectar->prepare($sql);

          $sql->bindValue(1 ,$idtramite ); 
          $sql->bindValue(2 ,$estatus );
          $sql->bindValue(3 ,$motivo );
          $sql->bindValue(4 ,$_SESSION['idusuario'] );
          $sql->execute();
          #$sql->debugDumpParams();
          return true;
        }

      }

      public function editar_tramite($nombre,$codestado,$codtramite){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="update tramite set 
               nombre=?
              ,codestado=?
              where 
              codtramite=?

              ";
            
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$_POST["nombre"]);
        $sql->bindValue(2,$_POST["codestado"]);
        $sql->bindValue(3,$_POST["codtramite"]);
        $sql->execute();
        #$sql->debugDumpParams();
      }

      public function editar_estado($codtramite,$estado){

        $conectar=parent::conexion();

        if($_POST["est"]=="0"){
          $estado=1;
        } else {
          $estado=0;
        }

        $sql="update tramite set   
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

      public function get_orden_estatus( $estatus = false ){
        $conectar=parent::conexion();

        $sql="SELECT 
                 de.* 
                ,e.nombre
                FROM dptoestatus de
                INNER JOIN estatus e ON e.codestatus = de.idestatus
                WHERE de.estatus = 1 
                AND de.orden = (SELECT DISTINCT(CASE WHEN orden IS NULL THEN 1000 ELSE orden END)+1 AS orden
                                  FROM dptoestatus de
                                 WHERE estatus   = 1 
                                   AND idestatus = ?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estatus);
        $sql->execute();
        #$sql->debugDumpParams(); 
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_orden_estatus_dpto( $estatus = false ){
        $conectar=parent::conexion();

        $sql="SELECT 
                 de.* 
                ,e.nombre
                FROM dptoestatus de
                INNER JOIN estatus e ON e.codestatus = de.idestatus
                WHERE de.estatus = 1 
                AND de.orden = (SELECT (CASE WHEN orden IS NULL THEN 1000 ELSE orden END)+1 AS orden
                                  FROM dptoestatus de
                                 WHERE estatus   = 1 
                                   AND idestatus = ? AND coddpto ='{$_SESSION['coddpto']}')";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$estatus);
        $sql->execute();
        #$sql->debugDumpParams(); 
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }
      
      public function get_nombre_tramite($nombre,$codestado){
        $conectar=parent::conexion();

        $sql="select * from tramite where nombre=? AND codestado=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$codestado);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function get_nombre_tramite_edit($nombre = false, $codestado = false, $codtramite){
        $conectar=parent::conexion();

        
        $sql="select * from tramite where nombre=? AND codestado=? AND codtramite<>?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1,$nombre);
        $sql->bindValue(2,$codestado);
        $sql->bindValue(3,$codtramite);
        $sql->execute();
        #$sql->debugDumpParams();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
      }

      public function convertir_fecha_bd($fecha = false){
        $date = date_create( str_replace("/", "-", $fecha) );
        $date = date_format($date, 'Y-m-d'); // 'Y-m-d H:i:s'
        return $date;
      }


  }


?>