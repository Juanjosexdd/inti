<?php 
	include_once('../../config/conexion.php');
	include_once('m_repcabpiefhorizontal.php');
	
	class Reptramiterecaudos extends Conectar
	{

		function consultar($estatus,$dato)
		{ // consultar por aproximidad
			$conectar = parent::conexion();
			 if($estatus != "")
			 {
				 $sql ="
				 		SELECT 	tr.id,
				 				tr.codtramite,
				 				tr.idrecaudos,
				 				tr.cantidad,
				 				tr.estatus,
				 				t.codtramite,
				 				t.nombre,
				 				r.idrecaudos,
				 				r.descripcion
				 		FROM maestrotramiterecaudos tr
				 		INNER JOIN maestrotramite t ON tr.codtramite = t.codtramite
				 		INNER JOIN recaudos r ON tr.idrecaudos = r.idrecaudos
				 		WHERE tr.estatus like UPPER('%$estatus%')
				 				AND (t.nombre like UPPER(('%$dato%')))	 			
				 		ORDER BY t.nombre, r.descripcion";
				 $sql = $conectar->prepare($sql);
				 $sql->execute();
				 return $sql->fetchAll();
			}
			else
			{
				$conectar = parent::conexion();
							$sql ="
									SELECT 	tr.id,
							 				tr.codtramite,
							 				tr.idrecaudos,
							 				tr.cantidad,
							 				tr.estatus,
							 				t.codtramite,
							 				t.nombre,
							 				r.idrecaudos,
							 				r.descripcion
							 		FROM maestrotramiterecaudos tr
							 		INNER JOIN maestrotramite t ON tr.codtramite = t.codtramite
							 		INNER JOIN recaudos r ON tr.idrecaudos = r.idrecaudos
							 		WHERE (t.nombre like UPPER(('%$dato%')))	 			
							 		ORDER BY t.nombre, r.descripcion";
							$sql = $conectar->prepare($sql);
							$sql->execute();
							return $sql->fetchAll();

			}
			if($estatus =="" && $dato=="")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	tr.id,
				 				tr.codtramite,
				 				tr.idrecaudos,
				 				tr.cantidad,
				 				tr.estatus,
				 				t.codtramite,
				 				t.nombre,
				 				r.idrecaudos,
				 				r.descripcion
				 		FROM maestrotramiterecaudos tr
				 		INNER JOIN maestrotramite t ON tr.codtramite = t.codtramite
				 		INNER JOIN recaudos r ON tr.idrecaudos = r.idrecaudos 			
				 		ORDER BY t.nombre, r.descripcion";
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
			
			$obj_pdf->Cell(60, $celdaLargo, utf8_decode('Tramite'),0,0,'C'); // celda titulo tabla
			$obj_pdf->Cell(120, $celdaLargo, utf8_decode('Recaudos'),0,0,'C');
			$obj_pdf->Cell(15, $celdaLargo, utf8_decode('Cant.'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea

			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(60,120,15));
				$obj_pdf->SetAligns(array('C','C','C'));
				
				$estatus = ($row["estatus"] == 1) ? 'ACTIVO' : 'INACTIVO';

				$obj_pdf->Row(array(
									 utf8_decode($row['nombre'])
									,utf8_decode($row['descripcion'])
									,utf8_decode($row['cantidad'])
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('reporte_secuencia_aprobacion.pdf', 'I'); // salida del pdf.
		}
	}
?>