<?php 
	include_once('../../config/conexion.php');	//falta el filtro por fecha
	include_once('m_repcabpie.php');
	
	class Reptramite extends Conectar 
	{
		function consultar($cedula, $nombres,$fecha)
		{ // consultar por aproximidad
			$conectar = parent::conexion();
			 if($cedula != "" && $nombres != "" && $fecha != "")
			 {
				 $sql ="
				 		SELECT 	t.idtramite,
								t.cedulasolicitante,
						        t.codtramite,
						        t.loteterreno,
						        t.superficie,
						        t.codsector,
						        t.fechainicio,
						        t.fechafin,
						        t.idusuario,
						        c.nacionalidad,
						        c.primernombre,
						        c.primerapellido,
						        mt.nombre nomtra,
						        u.usuario,
						        n.abreviatura
						FROM tramite t
						INNER JOIN ciudadano c ON t.cedulasolicitante = c.cedula
						INNER JOIN nacionalidad n ON c.nacionalidad = n.id
						INNER JOIN maestrotramite mt ON t.codtramite = mt.codtramite
						INNER JOIN usuario u ON t.idusuario = u.idusuario
						WHERE t.cedulasolicitante like UPPER(('%$cedula%'))  
							AND (c.primernombre like UPPER(('%$nombres%')) OR c.primerapellido like UPPER(('%$nombres%')))
							AND CAST(t.fechainicio AS DATE) = (('$fecha'))
						ORDER BY t.idtramite";
				 $sql = $conectar->prepare($sql);
				 $sql->execute();
				 return $sql->fetchAll();
			}
			if($cedula == "" && $nombres == "" && $fecha == "")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	t.idtramite,
									t.cedulasolicitante,
							        t.codtramite,
							        t.loteterreno,
							        t.superficie,
							        t.codsector,
							        t.fechainicio,
							        t.fechafin,
							        t.idusuario,
							        c.nacionalidad,
							        c.primernombre,
							        c.primerapellido,
							        mt.nombre nomtra,
							        u.usuario,
							        n.abreviatura
							FROM tramite t
							INNER JOIN ciudadano c ON t.cedulasolicitante = c.cedula
							INNER JOIN nacionalidad n ON c.nacionalidad = n.id
							INNER JOIN maestrotramite mt ON t.codtramite = mt.codtramite
							INNER JOIN usuario u ON t.idusuario = u.idusuario
							ORDER BY t.idtramite";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}			
			if($cedula != "" && $nombres == "" && $fecha == "")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	t.idtramite,
									t.cedulasolicitante,
							        t.codtramite,
							        t.loteterreno,
							        t.superficie,
							        t.codsector,
							        t.fechainicio,
							        t.fechafin,
							        t.idusuario,
							        c.nacionalidad,
							        c.primernombre,
							        c.primerapellido,
							        mt.nombre nomtra,
							        u.usuario,
							        n.abreviatura
							FROM tramite t
							INNER JOIN ciudadano c ON t.cedulasolicitante = c.cedula
							INNER JOIN nacionalidad n ON c.nacionalidad = n.id
							INNER JOIN maestrotramite mt ON t.codtramite = mt.codtramite
							INNER JOIN usuario u ON t.idusuario = u.idusuario							
							WHERE t.cedulasolicitante like UPPER(('%$cedula%'))
							ORDER BY t.idtramite";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}
			if($nombres != "" && $cedula == "" && $fecha == "")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	t.idtramite,
									t.cedulasolicitante,
							        t.codtramite,
							        t.loteterreno,
							        t.superficie,
							        t.codsector,
							        t.fechainicio,
							        t.fechafin,
							        t.idusuario,
							        c.nacionalidad,
							        c.primernombre,
							        c.primerapellido,
							        mt.nombre nomtra,
							        u.usuario,
							        n.abreviatura
							FROM tramite t
							INNER JOIN ciudadano c ON t.cedulasolicitante = c.cedula
							INNER JOIN nacionalidad n ON c.nacionalidad = n.id
							INNER JOIN maestrotramite mt ON t.codtramite = mt.codtramite
							INNER JOIN usuario u ON t.idusuario = u.idusuario
							WHERE (c.primernombre like UPPER(('%$nombres%')) OR c.primerapellido like UPPER(('%$nombres%')))
							ORDER BY t.idtramite";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}
			if($fecha != "" && $cedula == "" && $nombres == "")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	t.idtramite,
									t.cedulasolicitante,
							        t.codtramite,
							        t.loteterreno,
							        t.superficie,
							        t.codsector,
							        t.fechainicio,
							        t.fechafin,
							        t.idusuario,
							        c.nacionalidad,
							        c.primernombre,
							        c.primerapellido,
							        mt.nombre nomtra,
							        u.usuario,
							        n.abreviatura
							FROM tramite t
							INNER JOIN ciudadano c ON t.cedulasolicitante = c.cedula
							INNER JOIN nacionalidad n ON c.nacionalidad = n.id
							INNER JOIN maestrotramite mt ON t.codtramite = mt.codtramite
							INNER JOIN usuario u ON t.idusuario = u.idusuario				
							WHERE AND CAST(t.fechainicio AS DATE) = (('$fecha'))
							ORDER BY t.idtramite";
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
			$celdaLargo = 8; // variable ancho de largo de tabla
			$bordetabla='T'; // variable para bordes de tabla
			//$obj_pdf->SetFillColor(139, 208, 253); 
			
			$obj_pdf->Cell(15, $celdaLargo, utf8_decode('Nro.'),0,0,'C'); // celda titulo tabla
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Cédula'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Nombre'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Apellido'),0,0,'C');
			$obj_pdf->Cell(60, $celdaLargo, utf8_decode('T. Trámite'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('F. Inicio'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('F. Fin'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Usuario'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea


			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(15,10,20,30,30,60,30,30,30));
				$obj_pdf->SetAligns(array('C','R','L','C','C','C','C','C','C'));

				$obj_pdf->Row(array(
								 	 utf8_decode($row['idtramite'])
								 	,utf8_decode($row['abreviatura'])
									,utf8_decode($row['cedulasolicitante'])
									,utf8_decode($row['primernombre'])
									,utf8_decode($row['primerapellido'])
									,utf8_decode($row['nomtra'])
									,utf8_decode($row['fechainicio'])
									,utf8_decode($row['fechafin'])
									,utf8_decode($row['usuario'])
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('listado_tramites.pdf', 'I'); // salida del pdf.			
		}
	}
?>