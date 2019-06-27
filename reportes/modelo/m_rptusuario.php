<?php 
	include_once('../../config/conexion.php');
	include_once('m_repcabpie.php');
	
	class Repusuario extends Conectar
	{

		function consultar($estatus,$dato)
		{ // consultar por aproximidad
			$conectar = parent::conexion();
			 if($estatus != "")
			 {
				 $sql ="
				 		SELECT 	u.idusuario,
				 				u.nombre,
				 				u.apellido,
				 				u.nacionalidad,
				 				u.cedula,
				 				u.telefono,
				 				u.email,
				 				u.fechaingreso,
				 				u.coddpto,
				 				u.cargo,
				 				u.usuario,
				 				u.estatus,
				 				n.abreviatura,
				 				d.nombre nomdpto,
				 				c.nombre nomcargo
			 			FROM usuario u
			 			INNER JOIN nacionalidad n ON u.nacionalidad = n.id 
			 			INNER JOIN dpto d ON u.coddpto = d.coddpto
			 			INNER JOIN cargo c ON u.cargo = c.idcargo
			 			WHERE u.estatus = $estatus 
			 				AND (u.nombre like UPPER(('%$dato%'))  OR u.cedula like UPPER(('%$dato%')))
			 			ORDER BY u.cedula, u.nombre, u.apellido";
				 $sql = $conectar->prepare($sql);
				 $sql->execute();
				 return $sql->fetchAll();
			}
			else
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	u.idusuario,
					 				u.nombre,
					 				u.apellido,
					 				u.nacionalidad,
					 				u.cedula,
					 				u.telefono,
					 				u.email,
					 				u.fechaingreso,
					 				u.coddpto,
					 				u.cargo,
					 				u.usuario,
					 				u.estatus,
					 				n.abreviatura,
					 				d.nombre nomdpto,
					 				c.nombre nomcargo
				 			FROM usuario u
				 			INNER JOIN nacionalidad n ON u.nacionalidad = n.id 
				 			INNER JOIN dpto d ON u.coddpto = d.coddpto
				 			INNER JOIN cargo c ON u.cargo = c.idcargo
				 			WHERE (u.nombre like UPPER(('%$dato%'))  OR u.cedula like UPPER(('%$dato%')))
				 			ORDER BY u.cedula, u.nombre, u.apellido";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}
			if($estatus =="" && $dato=="")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	u.idusuario,
					 				u.nombre,
					 				u.apellido,
					 				u.nacionalidad,
					 				u.cedula,
					 				u.telefono,
					 				u.email,
					 				u.fechaingreso,
					 				u.coddpto,
					 				u.cargo,
					 				u.usuario,
					 				u.estatus,
					 				n.abreviatura,
					 				d.nombre nomdpto,
					 				c.nombre nomcargo
				 			FROM usuario u
				 			INNER JOIN nacionalidad n ON u.nacionalidad = n.id 
				 			INNER JOIN dpto d ON u.coddpto = d.coddpto
				 			INNER JOIN cargo c ON u.cargo = c.idcargo
				 			ORDER BY u.cedula, u.nombre, u.apellido";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}

		}

		function reporte($result = false)
		{
			$obj_pdf = new PDF('L', 'mm', 'letter');
			$obj_pdf->AddPage();
			$obj_pdf->AliasNbPages();
			$obj_pdf->SetFont('Times','B',14); // tipo de letra y con negrita
			$celdaAncho = 31; // variable ancho de tabla
			$celdaLargo = 7; // variable ancho de largo de tabla
			$bordetabla ='T'; // variable para bordes de tabla
			

			$obj_pdf->Cell(19, $celdaLargo, utf8_decode('Cédula'),0,0,'C'); // celda titulo tabla
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Nombre'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Apellido'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Teléfono'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('F. Ingreso'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Dpto.'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Cargo'),0,0,'C');
			$obj_pdf->Cell(36, $celdaLargo, utf8_decode('Usuario/Email'),0,0,'C');
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('Estatus'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea

			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(4,15,30,30,30,30,30,30,36,25));
				$obj_pdf->SetAligns(array('R','L','C','C','C','C','C','C','C','C'));
				
				$estatus = ($row["estatus"] == 1) ? 'ACTIVO' : 'INACTIVO';

				$obj_pdf->Row(array(
									 utf8_decode($row['abreviatura'])
									,utf8_decode($row['cedula'])
									,utf8_decode($row['nombre'])
									,utf8_decode($row['apellido'])
									,utf8_decode($row['telefono'])
									,utf8_decode($row['fechaingreso'])
									,utf8_decode($row['nomdpto'])
									,utf8_decode($row['nomcargo'])
									,utf8_decode($row['usuario'])
									,utf8_decode($estatus)
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('listado_usuario.pdf', 'I'); // salida del pdf.			
		}
	}
?>