<?php 
	include_once('../../config/conexion.php');
	include_once('m_repcabpiefhorizontal.php');
	
	class Reppais extends Conectar
	{

		function consultar($estatus)
		{ // consultar por aproximidad
				$conectar = parent::conexion();
				 if($estatus != "")
				 {
					 $sql ="
					 		SELECT p.nombre, p.estatus
					 		FROM pais p
					 		WHERE p.estatus like UPPER('%$estatus%') 
					 		ORDER BY p.nombre";
					 $sql = $conectar->prepare($sql);
					 $sql->execute();
					 return $sql->fetchAll();
				}
				else
				{
					$conectar = parent::conexion();
								$sql ="
										SELECT p.nombre, p.estatus
								 		FROM pais p
								 		ORDER BY p.nombre";
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
			
			$obj_pdf->Cell(115, $celdaLargo, utf8_decode('Nombre'),0,0,'C'); // celda titulo tabla
			$obj_pdf->Cell(80, $celdaLargo, utf8_decode('Estatus'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea

			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(115,80));
				$obj_pdf->SetAligns(array('C','C'));

				$estatus = ($row["estatus"] == 1) ? 'ACTIVO' : 'INACTIVO';

				$obj_pdf->Row(array(
								 	 utf8_decode($row['nombre'])
									,utf8_decode($estatus)
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('listado_pais.pdf', 'I'); // salida del pdf.	
		}
	}
?>