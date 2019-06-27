<?php

  //conexion a la base de datos

  require_once("../config/conexion.php");


    class Ciudadano extends Conectar {

      public function login(){
        $conectar=parent::conexion();
        parent::set_names();
        if(isset($_POST["enviar"])){
          //INICIO DE VALIDACIONES
          $password = $_POST["password"];
          $correo = $_POST["correo"];
          $estado = "1";
          if(empty($correo) and empty($password)){
            header("Location:".Conectar::ruta()."views/index.php?m=2");
            exit();
          // } else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){12,15}$/", $password)) {
          //   header("Location:".Conectar::ruta()."views/index.php?m=1");
          //   exit();
          } else {
            
            $sql= "select * from usuarios where correo=? and password=? and estado=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $correo);
            $sql->bindValue(2, $password);
            $sql->bindValue(3, $estado);
            $sql->execute();
            $resultado = $sql->fetch();
            //si existe el registro entonces se conecta en session
            if(is_array($resultado) and count($resultado)>0){
              /*IMPORTANTE: la session guarda los valores de los campos de la tabla de la bd*/
              $_SESSION["id_usuario"] = $resultado["id_usuario"];
              $_SESSION["correo"] = $resultado["correo"];
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


      public function get_filas_ciudadano(){

        $conectar= parent::conexion();
        $sql="select * from ciudadano";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        return $sql->rowCount();
      }

      //listar los ciudadanos
   	  public function get_ciudadano(){

 	    	$conectar=parent::conexion();
 	    	parent::set_names();

 	    	$sql="SELECT  c.idciudadano,
                      c.nacionalidad,
                      c.cedula,
                      c.tiporif,
                      c.rif,
                      c.primernombre,
                      c.segundonombre,
                      c.primerapellido,
                      c.segundoapellido,
                      c.direccion,
                      c.telefono,
                      c.email,
                      c.estatus, 
                      n.abreviatura AS nacionalidad,
                      r.abreviatura AS tiporif
              FROM ciudadano c
              INNER JOIN nacionalidad n ON c.nacionalidad = n.id
              INNER JOIN rif r        ON c.tiporif        = r.id";

 	    	$sql=$conectar->prepare($sql);
 	    	$sql->execute();

 	    	return $resultado=$sql->fetchAll();
   	  }

      //metodo para registrar a los ciudadanos
   	  public function registrar_ciudadano($nacionalidad,$cedula,$tiporif,$rif,$primernombre,$segundonombre,$primerapellido,$segundoapellido,$direccion,$telefono,$email){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="INSERT INTO ciudadano(nacionalidad,cedula,tiporif,rif,primernombre,segundonombre,primerapellido,segundoapellido,direccion,telefono,email)
        VALUES(?,?,?,?,?,?,?,?,?,?,?)";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $_POST["nacionalidad"]);
        $sql->bindValue(2, $_POST["cedula"]);
        $sql->bindValue(3, $_POST["tiporif"]);
        $sql->bindValue(4, $_POST["rif"]);
        $sql->bindValue(5, $_POST["primernombre"]);
        $sql->bindValue(6, $_POST["segundonombre"]);
        $sql->bindValue(7, $_POST["primerapellido"]);
        $sql->bindValue(8, $_POST["segundoapellido"]);
        $sql->bindValue(9, $_POST["direccion"]);
        $sql->bindValue(10, $_POST["telefono"]);
        $sql->bindValue(11, $_POST["email"]);
        //$sql->bindValue(12, $_POST["estatus"]);
        $sql->execute();
   	  }

      //metodo para editar los datos del ciudadano
   	  public function editar_ciudadano($idciudadano,$nacionalidad,$cedula,$tiporif,$rif,$primernombre,$segundonombre,$primerapellido,$segundoapellido,$direccion,$telefono,$email){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="UPDATE ciudadano SET 
        
        nacionalidad=?,
        cedula=?,
        tiporif=?,
        rif=?,
        primernombre=?,
        segundonombre=?,
        primerapellido=?,
        segundoapellido=?,
        direccion=?,
        telefono=?,
        email=?

        WHERE
        idciudadano=?

       ";
        //echo $sql;
        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $_POST["nacionalidad"]);
        $sql->bindValue(2, $_POST["cedula"]);
        $sql->bindValue(3, $_POST["tiporif"]);
        $sql->bindValue(4, $_POST["rif"]);
        $sql->bindValue(5, $_POST["primernombre"]);
        $sql->bindValue(6, $_POST["segundonombre"]);
        $sql->bindValue(7, $_POST["primerapellido"]);
        $sql->bindValue(8, $_POST["segundoapellido"]);
        $sql->bindValue(9, $_POST["direccion"]);
        $sql->bindValue(10, $_POST["telefono"]);
        $sql->bindValue(11, $_POST["email"]);
        $sql->bindValue(12, $_POST["idciudadano"]);
        $sql->execute();

        //print_r($_POST);
   	  }

      //mostrar los datos del ciudadano por el id
	    public function get_ciudadano_por_id($idciudadano){
          
        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM ciudadano WHERE idciudadano=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $idciudadano);
        $sql->execute();

        return $resultado=$sql->fetchAll();
 	    }

 	    //editar el estatus de los ciudadanos
	    public function editar_estatus($idciudadano,$estatus){

 	    	$conectar=parent::conexion();
 	    	parent::set_names();

        //el parametro est se envia por via ajax
 	    	if($_POST["estatus"]=="0"){

 	    		$estatus=1;

 	    	} else {

 	    		$estatus=0;
 	    	}

 	    	$sql="UPDATE ciudadano SET 
          
          estatus=?

          WHERE
          idciudadano=?
 	    	";

 	    	$sql=$conectar->prepare($sql);

 	    	$sql->bindValue(1,$estatus);
 	    	$sql->bindValue(2,$idciudadano);
 	    	$sql->execute();
 	    }

   	  //valida por la cedula y rif del ciudadano
   	  public function get_cedula_rif_del_ciudadano($cedula,$rif){
          
        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT * FROM ciudadano WHERE cedula=? OR rif=?";

        $sql=$conectar->prepare($sql);

        $sql->bindValue(1, $cedula);
        $sql->bindValue(2, $rif);
        $sql->execute();

        return $resultado=$sql->fetchAll();
   	  }
   }



?>