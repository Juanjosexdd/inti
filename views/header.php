
<?php 



$objeto_bd = new Conectar();
$conectar = $objeto_bd->conexion_public();
$objeto_bd->set_names();



$sql_rolusuario = "SELECT 
ur.*
,r.nombre
FROM usersroles ur 
INNER JOIN roles r ON r.idroles = ur.idroles
WHERE idusuario = '{$_SESSION['idusuario']}'";
$rolusuario = $conectar->prepare($sql_rolusuario);
$rolusuario->execute();
$result_rolusuario = $rolusuario->fetchAll();



switch ($result_rolusuario[0]['idroles']) {
  case '6': // administrador
      include_once("menu/menu_admin.php");
  break;
  case '1': // analista 1
    include_once("menu/menu_analista1.php");
  break;
  default: // bandejas
    include_once("menu/menu_analista.php");
  break;
}


?>