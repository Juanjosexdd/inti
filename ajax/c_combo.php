<?php


    //llamo a la conexion de la base de datos 
    require_once("../config/conexion.php");

    switch($_GET["op"]){

        case "list_combo":

            /*
                Array
                    (
                        [id] => 8
                        [field_foreign] => codpais
                        [table] => estado
                        [value] => codestado
                        [description] => nombre
                    )
            
            */

            $objeto_bd = new Conectar();
            $conectar  = $objeto_bd->conexion_public();
            $objeto_bd->set_names();
            
            if( isset($_POST['id']) && isset($_POST['field_foreign']) && $_POST['id'] != "" && $_POST['field_foreign'] != "" ){
                $sql = "SELECT * FROM {$_POST['table']} WHERE {$_POST['field_foreign']} = {$_POST['id']} AND estatus = 1";
            }else{
                $sql = "SELECT * FROM {$_POST['table']} WHERE estatus = 1";
            }
            
            $sql = $conectar->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll();

            $opciones = "<option value=''>Seleccione una opcion</option>";
            
            foreach ( $result as $key => $value ) {
                $seleccionado = ($result[$key][$_POST['value']]==$_POST['selected'])?"selected":""; 
                $opciones    .= "<option value='".$result[$key][$_POST['value']]."' ".$seleccionado."> ".utf8_encode($result[$key][$_POST['description']])." </option>";
            } 
            
            //echo $opciones;

            echo $opciones;
        break;
        

    }



?>