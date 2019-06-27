<?php 
	include_once('../../config/conexion.php');	//falta el filtro por fecha
	include_once('m_repcabpie.php');
	
	class Repvisita extends Conectar 
	{
		function consultar($dato, $fecha)
		{ // consultar por aproximidad
			$conectar = parent::conexion();
			 if($dato != "" && $fecha != "")
			 {
				 $sql ="
				 		SELECT 	v.idvisita,
									v.cedulaciudadano,
							        v.fechainicio,
							        v.fechafin,
							        v.codvisita,
							        v.motivo,
							        v.coddpto,
							        v.idusuario,
							        c.nacionalidad,
							        c.primernombre,
							        c.primerapellido,
							        mv.nombre nomvis,
							        d.nombre nomdpto,
							        u.usuario,
							        n.abreviatura
							FROM visita v
							INNER JOIN ciudadano c ON v.cedulaciudadano = c.cedula
							INNER JOIN nacionalidad n ON c.nacionalidad = n.id
							INNER JOIN maestrovisita mv ON v.codvisita = mv.codvisita
							INNER JOIN dpto d ON v.coddpto = d.coddpto
							INNER JOIN usuario u ON v.idusuario = u.idusuario
							WHERE (mv.nombre like UPPER(('%$dato%'))
								OR d.nombre like UPPER(('%$dato%'))
								OR c.primernombre like UPPER(('%$dato%')))
							AND CAST(v.fechainicio AS DATE) = (('$fecha'))
							ORDER BY v.idvisita";

				 $sql = $conectar->prepare($sql);
				 $sql->execute();
				 return $sql->fetchAll();
			}
			if($dato == "" && $fecha == "")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	v.idvisita,
									v.cedulaciudadano,
							        v.fechainicio,
							        v.fechafin,
							        v.codvisita,
							        v.motivo,
							        v.coddpto,
							        v.idusuario,
							        c.nacionalidad,
							        c.primernombre,
							        c.primerapellido,
							        mv.nombre nomvis,
							        d.nombre nomdpto,
							        u.usuario,
							        n.abreviatura
							FROM visita v
							INNER JOIN ciudadano c ON v.cedulaciudadano = c.cedula
							INNER JOIN nacionalidad n ON c.nacionalidad = n.id
							INNER JOIN maestrovisita mv ON v.codvisita = mv.codvisita
							INNER JOIN dpto d ON v.coddpto = d.coddpto
							INNER JOIN usuario u ON v.idusuario = u.idusuario
							ORDER BY v.idvisita";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}			
			if($dato != "")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	v.idvisita,
									v.cedulaciudadano,
							        v.fechainicio,
							        v.fechafin,
							        v.codvisita,
							        v.motivo,
							        v.coddpto,
							        v.idusuario,
							        c.nacionalidad,
							        c.primernombre,
							        c.primerapellido,
							        mv.nombre nomvis,
							        d.nombre nomdpto,
							        u.usuario,
							        n.abreviatura
							FROM visita v
							INNER JOIN ciudadano c ON v.cedulaciudadano = c.cedula
							INNER JOIN nacionalidad n ON c.nacionalidad = n.id
							INNER JOIN maestrovisita mv ON v.codvisita = mv.codvisita
							INNER JOIN dpto d ON v.coddpto = d.coddpto
							INNER JOIN usuario u ON v.idusuario = u.idusuario
							WHERE (mv.nombre like UPPER(('%$dato%'))
								OR d.nombre like UPPER(('%$dato%'))
								OR c.primernombre like UPPER(('%$dato%')))
							ORDER BY v.idvisita";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}
			if($fecha != "")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	v.idvisita,
									v.cedulaciudadano,
							        v.fechainicio,
							        v.fechafin,
							        v.codvisita,
							        v.motivo,
							        v.coddpto,
							        v.idusuario,
							        c.nacionalidad,
							        c.primernombre,
							        c.primerapellido,
							        mv.nombre nomvis,
							        d.nombre nomdpto,
							        u.usuario,
							        n.abreviatura
							FROM visita v
							INNER JOIN ciudadano c ON v.cedulaciudadano = c.cedula
							INNER JOIN nacionalidad n ON c.nacionalidad = n.id
							INNER JOIN maestrovisita mv ON v.codvisita = mv.codvisita
							INNER JOIN dpto d ON v.coddpto = d.coddpto
							INNER JOIN usuario u ON v.idusuario = u.idusuario
							WHERE CAST(v.fechainicio AS DATE) = (('$fecha'))
							ORDER BY v.idvisita";
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
			
			$obj_pdf->Cell(21, $celdaLargo, utf8_decode('Cédula'),0,0,'C'); // celda titulo tabla
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('Nombre'),0,0,'C');
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('Apellido'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('T. Visita'),0,0,'C');
			$obj_pdf->Cell(42, $celdaLargo, utf8_decode('Motivo'),0,0,'C');
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('F. Inicio'),0,0,'C');
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('F. Fin'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Destino'),0,0,'C');
			$obj_pdf->Cell(35, $celdaLargo, utf8_decode('Usuario'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea


			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(6,15,25,25,30,43,25,25,30,35));
				$obj_pdf->SetAligns(array('R','L','C','C','C','C','C','C','C','C'));

				$obj_pdf->Row(array(
								 	 utf8_decode($row['abreviatura'])
									,utf8_decode($row['cedulaciudadano'])
									,utf8_decode($row['primernombre'])
									,utf8_decode($row['primerapellido'])
									,utf8_decode($row['nomvis'])
									,utf8_decode($row['motivo'])
									,utf8_decode($row['fechainicio'])
									,utf8_decode($row['fechafin'])
									,utf8_decode($row['nomdpto'])
									,utf8_decode($row['usuario'])
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('listado_visitas.pdf', 'I'); // salida del pdf.			
		}
	}
?>