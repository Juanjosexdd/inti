<?php

  //conexion a la base de datos

  require_once("../config/conexion.php");


    class Pvisita extends Conectar {

      public function login(){
        $conectar=parent::conexion();
        parent::set_names();
        if(isset($_POST["enviar"])){
          //INICIO DE VALIDACIONES
          $password = $_POST["password"];
          $email = $_POST["email"];
          $estado = "1";
          if(empty($email) and empty($password)){
            header("Location:".Conectar::ruta()."views/index.php?m=2");
            exit();
          // } else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){12,15}$/", $password)) {
          //   header("Location:".Conectar::ruta()."views/index.php?m=1");
          //   exit();
          } else {
            
            $sql= "select * from usuarios where email=? and password=? and estado=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $email);
            $sql->bindValue(2, $password);
            $sql->bindValue(3, $estado);
            $sql->execute();
            $resultado = $sql->fetch();
            //si existe el registro entonces se conecta en session
            if(is_array($resultado) and count($resultado)>0){
              /*IMPORTANTE: la session guarda los valores de los campos de la tabla de la bd*/
              $_SESSION["idusuario"] = $resultado["idusuario"];
              $_SESSION["email"] = $resultado["email"];
              $_SESSION["cedula"] = $resultado["cedula"];
              $_SESSION["nombre"] = $resultado["nombres"];
              header("Location:".Conectar::ruta()."views/home.php");
              exit();
            } else {                          
              //si no existe el registro entonces le aparece un mensaje
              header("Location:".Conectar::ruta()."views/index.php?m=1");
              exit();
            } 
          }//cierre del else
        }//condicion enviar
      }

      //listar los ciudadanos
   	  public function get_visita(){

 	    	$conectar=parent::conexion();
 	    	parent::set_names();

 	    	$sql="SELECT  v.idvisita,
                      v.cedulaciudadano,
                      v.fechainicio,
                      v.fechafin,
                      v.codvisita,
                      v.motivo,
                      v.coddpto,
                      v.idusuario,
                      c.cedula AS cedulaciudadano,
                      mv.nombre AS codvisita,
                      d.nombre AS coddpto
              FROM visita v
              INNER JOIN ciudadano c       ON v.cedulaciudadano = c.cedula
              INNER JOIN maestrovisita mv  ON v.codvisita       = mv.codvisita
              INNER JOIN dpto d            ON v.coddpto         = d.id";

 	    	$sql=$conectar->prepare($sql);
 	    	$sql->execute();

 	    	return $resultado=$sql->fetchAll();
   	  }

   	  public function registrar_visita($cedulaciudadano,$codvisita,$motivo,$coddpto,$idusuario){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="INSERT INTO visita VALUES(NULL,?,NOW(),NULL,?,?,?,?);";

        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $_POST["cedulaciudadano"]);
        $sql->bindValue(2, $_POST["codvisita"]);
        $sql->bindValue(3, $_POST["motivo"]);
        $sql->bindValue(4, $_POST["coddpto"]);
        $sql->bindValue(5, $_POST['idusuario']);
       
        $sql->execute();
   	  }

   	  public function editar_visita($idvisita,$cedulaciudadano,$codvisita,$motivo,$coddpto,$idusuario){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="UPDATE visita SET 
        
        cedulaciudadano=?,
        codvisita=?,
        motivo=?,
        coddpto=?,
        idusuario=?
        WHERE
        idvisita=?
       ";
        //echo $sql;
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $_POST["cedulaciudadano"]);
        $sql->bindValue(2, $_POST["codvisita"]);
        $sql->bindValue(3, $_POST["motivo"]);
        $sql->bindValue(4, $_POST["coddpto"]);
        $sql->bindValue(5, $_POST["idusuario"]);
        $sql->bindValue(6, $_POST["idvisita"]);
        $sql->execute();

        //print_r($_POST);
   	  }

	    public function get_visita_por_id($idvisita){
          
        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM visita WHERE idvisita=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $idvisita);
        $sql->execute();

        return $resultado=$sql->fetchAll();
 	    }
    }

?>