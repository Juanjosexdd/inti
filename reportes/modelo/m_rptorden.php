<?php 
	include_once('../../config/conexion.php');
	include_once('m_repcabpiefhorizontal.php');
	
	class Reporden extends Conectar
	{

		function consultar($estatus,$dato)
		{ // consultar por aproximidad
			$conectar = parent::conexion();
			 if($estatus != "")
			 {
				 $sql ="
				 		SELECT de.idestatus,
				 				de.coddpto,
				 				de.orden,
				 				de.estatus,
				 				e.codestatus,
				 				e.nombre nomest,
				 				d.coddpto,
				 				d.nombre nomdpto
				 		FROM dptoestatus de
				 		INNER JOIN estatus e ON de.idestatus = e.codestatus
				 		INNER JOIN dpto d ON de.coddpto = d.coddpto
				 		WHERE de.estatus like UPPER('%$estatus%')
				 				AND (e.nombre like UPPER(('%$dato%')) OR d.nombre like UPPER(('%$dato%')))	 			
				 		ORDER BY de.orden";
				 $sql = $conectar->prepare($sql);
				 $sql->execute();
				 return $sql->fetchAll();
			}
			else
			{
				$conectar = parent::conexion();
							$sql ="
									SELECT de.idestatus,
							 				de.coddpto,
							 				de.orden,
							 				de.estatus,
							 				e.codestatus,
							 				e.nombre nomest,
							 				d.coddpto,
							 				d.nombre nomdpto
							 		FROM dptoestatus de
							 		INNER JOIN estatus e ON de.idestatus = e.codestatus
							 		INNER JOIN dpto d ON de.coddpto = d.coddpto
							 		WHERE (e.nombre like UPPER(('%$dato%')) OR d.nombre like UPPER(('%$dato%')))	
							 		ORDER BY de.orden";
							$sql = $conectar->prepare($sql);
							$sql->execute();
							return $sql->fetchAll();

			}
			if($estatus =="" && $dato=="")
			{
				$conectar = parent::conexion();
					$sql =" SELECT de.idestatus,
					 				de.coddpto,
					 				de.orden,
					 				de.estatus,
					 				e.codestatus,
					 				e.nombre nomest,
					 				d.coddpto,
					 				d.nombre nomdpto
					 		FROM dptoestatus de
					 		INNER JOIN estatus e ON de.idestatus = e.codestatus
					 		INNER JOIN dpto d ON de.coddpto = d.coddpto		
					 		ORDER BY de.orden";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}

		}
		function reporte($result = false)
		{
			$obj_pdf = new PDF('P', 'mm', 'letter');
			$obj_pdf->AddPage();
			$obj_pdf->AliasNbPages();
			$obj_pdf->SetFont('Times','B',14); // tipo de letra y con negrita
			$celdaAncho = 31; // variable ancho de tabla
			$celdaLargo = 7; // variable ancho de largo de tabla
			$bordetabla='T'; // variable para bordes de tabla
			//$obj_pdf->SetFillColor(139, 208, 253); 
			
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('Orden'),0,0,'C'); // celda titulo tabla
			$obj_pdf->Cell(65, $celdaLargo, utf8_decode('Nombre Estatus'),0,0,'C');
			$obj_pdf->Cell(60, $celdaLargo, utf8_decode('Nombre Departamento'),0,0,'C');
			$obj_pdf->Cell(45, $celdaLargo, utf8_decode('Estatus'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea

			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(25,65,60,45));
				$obj_pdf->SetAligns(array('C','C','C','C'));
				
				$estatus = ($row["estatus"] == 1) ? 'ACTIVO' : 'INACTIVO';

				$obj_pdf->Row(array(
									 utf8_decode($row['orden'])
									,utf8_decode($row['nomest'])
									,utf8_decode($row['nomdpto'])
									,utf8_decode($estatus)
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('reporte_secuencia_aprobacion.pdf', 'I'); // salida del pdf.
		}
	}
?>