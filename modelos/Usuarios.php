<?php

  //conexion a la base de datos

   require_once("../config/conexion.php");


  class Usuario extends Conectar {
    public function login(){
      $conectar=parent::conexion();
      parent::set_names();
      if(isset($_POST["enviar"])){
        $password = $_POST["password"];
        $email = $_POST["email"];
        $estatus = "1";
        if(empty($email) and empty($password)){
          header("Location:".Conectar::ruta()."views/index.php?m=2");
          exit();
        // } else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){12,15}$/", $password)) {
        //   header("Location:".Conectar::ruta()."views/index.php?m=1");
        //   exit();
        } else {
          
          $sql= "select * from usuario where email=? and password=? and estatus=?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $email);
          $sql->bindValue(2, $password);
          $sql->bindValue(3, $estatus);
          $sql->execute();
          $resultado = $sql->fetch();
          //si existe el registro entonces se conecta en session
          if(is_array($resultado) and count($resultado)>0){
            /*IMPORTANTE: la session guarda los valores de los campos de la tabla de la bd*/
            $_SESSION["idusuario"] = $resultado["idusuario"];
            $_SESSION["email"] = $resultado["email"];
            $_SESSION["cedula"] = $resultado["cedula"];
            $_SESSION["nombre"] = $resultado["nombre"];
            $_SESSION["apellido"]  = $resultado["apellido"];
            $_SESSION["coddpto"]   = $resultado["coddpto"];
            header("Location:".Conectar::ruta()."views/home.php");
            exit();
          } else {                          
            //si no existe el registro entonces le aparece un mensaje
            header("Location:".Conectar::ruta()."views/index.php?m=1");
            exit();
          } 
        }//cierre del else
      }
      //print_r($_POST);
    }

    public function get_filas_usuario(){

      $conectar= parent::conexion();
      $sql="SELECT * FROM usuario";
      $sql=$conectar->prepare($sql);
      $sql->execute();
      $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
      return $sql->rowCount();
    
    }

    public function get_usuario(){

      $conectar=parent::conexion();
      parent::set_names();

      // SELECT nombre, apellido, nacionalidad FROM usuario
      // INNER JOIN nacionalidad WHERE usuario.nacionalidad = nacionalidad.nombre

      $sql = "SELECT  u.idusuario,
                      u.nombre,
                      u.apellido,
                      u.nacionalidad,
                      u.cedula,
                      u.fechanacimiento,
                      u.telefono,
                      u.email,
                      u.direccion,
                      u.fechaingreso,
                      u.coddpto,
                      u.cargo,
                      u.usuario, 
                      u.password, 
                      u.password2, 
                      u.estatus, 
                      n.abreviatura AS nacionalidad,
                      c.nombre AS cargo,
                      d.nombre AS coddpto
              FROM usuario u
              INNER JOIN nacionalidad n ON u.nacionalidad = n.id
              INNER JOIN cargo c        ON u.cargo        = c.idcargo
              INNER JOIN dpto d         ON u.coddpto      = d.id";

      $sql=$conectar->prepare($sql);
      $sql->execute();

      return $resultado=$sql->fetchAll();
    }

    public function registrar_usuario($nombre,$apellido,$nacionalidad,$cedula,$fechanacimiento,$telefono,$email,$direccion,$coddpto,$cargo,$usuario,$password,$password2){

      $conectar=parent::conexion();
      parent::set_names();

      //$sql="INSERT INTO usuario VALUES(?,?,?,?,?,?,?,?,now(),?,?,?,?,?);";
      $sql="INSERT INTO usuario(nombre,apellido,nacionalidad,cedula,fechanacimiento,telefono,email,direccion,coddpto,cargo,usuario,password,password2) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";

      $sql=$conectar->prepare($sql);
      $sql->bindValue(1, $_POST["nombre"]);
      $sql->bindValue(2, $_POST["apellido"]);
      $sql->bindValue(3, $_POST["nacionalidad"]);
      $sql->bindValue(4, $_POST["cedula"]);
      $sql->bindValue(5, $_POST["fechanacimiento"]);
      $sql->bindValue(6, $_POST["telefono"]);
      $sql->bindValue(7, $_POST["email"]);
      $sql->bindValue(8, $_POST["direccion"]);
      $sql->bindValue(9, $_POST["coddpto"]);
      $sql->bindValue(10, $_POST["cargo"]);
      $sql->bindValue(11, $_POST["usuario"]);
      $sql->bindValue(12, $_POST["password"]);
      $sql->bindValue(13, $_POST["password2"]);
      $sql->execute();
    }

    public function editar_usuario($idusuario,$nombre,$apellido,$nacionalidad,$cedula,$fechanacimiento,$telefono,$email,$direccion,$coddpto,$cargo,$usuario,$password,$password2){

      $conectar=parent::conexion();
      parent::set_names();
      $sql="UPDATE  usuario SET
      nombre=?,
      apellido=?,
      nacionalidad=?,
      cedula=?,
      fechanacimiento=?,
      telefono=?,
      email=?,
      direccion=?,
      coddpto=?,
      cargo=?,
      usuario=?,
      password=?,
      password2=?

      WHERE

      idusuario=?
      ";

      $sql=$conectar->prepare($sql);
      $sql->bindValue(1,$_POST["nombre"]);
      $sql->bindValue(2,$_POST["apellido"]);
      $sql->bindValue(3,$_POST["nacionalidad"]);
      $sql->bindValue(4,$_POST["cedula"]);
      $sql->bindValue(5,$_POST["fechanacimiento"]);
      $sql->bindValue(6,$_POST["telefono"]);
      $sql->bindValue(7,$_POST["email"]);
      $sql->bindValue(8,$_POST["direccion"]);
      $sql->bindValue(9,$_POST["coddpto"]);
      $sql->bindValue(10,$_POST["cargo"]);
      $sql->bindValue(11,$_POST["usuario"]);
      $sql->bindValue(12,$_POST["password"]);
      $sql->bindValue(13,$_POST["password2"]);
      $sql->bindValue(14,$_POST["idusuario"]);
      $sql->execute();
    }

    public function get_usuario_por_id($idusuario){
          
      $conectar=parent::conexion();
      parent::set_names();

      $sql="SELECT * FROM usuario WHERE idusuario=?";

      $sql=$conectar->prepare($sql);

      $sql->bindValue(1,$idusuario);
      $sql->execute();

      return $resultado=$sql->fetchAll();
    }

    public function editar_estatus($idusuario,$estatus){

      $conectar=parent::conexion();
      parent::set_names();

      if($_POST["estatus"]=="0"){

        $estatus=1;

      } else {

        $eestatus=0;
      }

      $sql="UPDATE usuario SET estatus=? WHERE idusuario=?";

      $sql=$conectar->prepare($sql);
      $sql->bindValue(1,$estatus);
      $sql->bindValue(2,$idusuario);
      $sql->execute();
    }

    public function get_cedula_email_del_usuario($cedula,$email){
          
      $conectar=parent::conexion();
      parent::set_names();
      $sql="SELECT * FROM usuario WHERE cedula=? or email=?";

      $sql=$conectar->prepare($sql);

      $sql->bindValue(1, $cedula);
      $sql->bindValue(2, $email);
      $sql->execute();

      return $resultado=$sql->fetchAll();
    }
  }
?>