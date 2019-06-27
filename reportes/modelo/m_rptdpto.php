<?php 
	include_once('../../config/conexion.php');
	include_once('m_repcabpiefhorizontal.php');
	
	class Repdpto extends Conectar
	{

		function consultar($estatus)
		{ // consultar por aproximidad
			 $conectar = parent::conexion();
			 if($estatus != "")
			 {
				 $sql ="
				 		SELECT d.coddpto, d.nombre, d.estatus
				 		FROM dpto d
				 		WHERE d.estatus like UPPER('%$estatus%') 
				 		ORDER BY d.nombre";
				 $sql = $conectar->prepare($sql);
				 $sql->execute();
				 return $sql->fetchAll();
			}
			else
			{
				$conectar = parent::conexion();
							$sql ="
									SELECT d.coddpto, d.nombre, d.estatus
							 		FROM dpto d
							 		ORDER BY d.nombre";
							$sql = $conectar->prepare($sql);
							$sql->execute();
							return $sql->fetchAll();
			}				
		}
		function reporte($result = false){
			$obj_pdf = new PDF('P', 'mm', 'letter');
			$obj_pdf->AddPage();
			$obj_pdf->AliasNbPages();
			$obj_pdf->SetFont('Times','B',14); // tipo de letra y con negrita
			$celdaAncho = 31; // variable ancho de tabla
			$celdaLargo = 7; // variable ancho de largo de tabla
			$bordetabla='T'; // variable para bordes de tabla
			//$obj_pdf->SetFillColor(139, 208, 253); 
			
			$obj_pdf->Cell(40, $celdaLargo, utf8_decode('Código'),0,0,'C'); // celda titulo tabla
			$obj_pdf->Cell(105, $celdaLargo, utf8_decode('Nombre'),0,0,'C');
			$obj_pdf->Cell(50, $celdaLargo, utf8_decode('Estatus'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea

			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(40,105,50));
				$obj_pdf->SetAligns(array('C','C','C'));

				$estatus = ($row["estatus"] == 1) ? 'ACTIVO' : 'INACTIVO';

				$obj_pdf->Row(array(
								 	 utf8_decode($row['coddpto'])
									,utf8_decode($row['nombre'])
									,utf8_decode($estatus)
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('listado_departamento.pdf', 'I'); // salida del pdf.			
		}
	}
?>