<?php 
	include_once('../../config/conexion.php');
	include_once('m_repcabpiefhorizontal.php');
	
	class Reptramite extends Conectar
	{

		function consultar($estatus,$dato)
			{ // consultar por aproximidad
				$conectar = parent::conexion();
				 if($estatus != "")
				 {
					 $sql ="
					 		SELECT *
				 			FROM maestrotramite t
				 			WHERE t.estatus = $estatus 
				 				and (t.nombre like UPPER(('%$dato%')) OR t.descripcion like UPPER(('%$dato%')))
				 			ORDER BY t.nombre, t.descripcion";
					 $sql = $conectar->prepare($sql);
					 $sql->execute();
					 return $sql->fetchAll();
				}
				else
				{
					$conectar = parent::conexion();
								$sql ="
										SELECT *
							 			FROM maestrotramite t
							 			WHERE (t.nombre like UPPER(('%$dato%')) OR t.descripcion like UPPER(('%$dato%')))
							 			ORDER BY t.nombre, t.descripcion";
								$sql = $conectar->prepare($sql);
								$sql->execute();
								return $sql->fetchAll();

				}
				if($estatus =="" && $dato=="")
				{
					$conectar = parent::conexion();
						$sql =" SELECT *
					 			FROM maestrotramite t
					 			ORDER BY t.nombre, t.descripcion";
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
			
			$obj_pdf->Cell(75, $celdaLargo, utf8_decode('Nombre'),0,0,'C'); // celda titulo tabla
			$obj_pdf->Cell(90, $celdaLargo, utf8_decode('Descripción'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Estatus'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea

			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(75,90,30));
				$obj_pdf->SetAligns(array('C','C','C'));

				$estatus = ($row["estatus"] == 1) ? 'ACTIVO' : 'INACTIVO';

				$obj_pdf->Row(array(
								 	 utf8_decode($row['nombre'])
									,utf8_decode($row['descripcion'])
									,utf8_decode($estatus)
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('listado_tipo_tramite.pdf', 'I'); // salida del pdf.	
		}
	}
?>