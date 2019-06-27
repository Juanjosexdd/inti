<?php 
	include_once('../../config/conexion.php');
	include_once('m_repcabpiefhorizontal.php');
	
	class Repestatus extends Conectar
	{

		function consultar($estatus)
		{ // consultar por aproximidad				
			 $conectar = parent::conexion();
			 if($estatus != "")
			 {
				 $sql ="
				 		SELECT e.codestatus, e.nombre, e.descripcion, e.estatus
				 		FROM estatus e
				 		WHERE e.estatus like UPPER('%$estatus%') 
				 		ORDER BY e.codestatus";
				 $sql = $conectar->prepare($sql);
				 $sql->execute();
				 return $sql->fetchAll();
			}
			else
			{
				$conectar = parent::conexion();
							$sql ="
									SELECT e.codestatus, e.nombre, e.descripcion, e.estatus
							 		FROM estatus e
							 		ORDER BY e.codestatus";
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
			$obj_pdf->Cell(55, $celdaLargo, utf8_decode('Nombre'),0,0,'C');
			$obj_pdf->Cell(55, $celdaLargo, utf8_decode('Descripción'),0,0,'C');
			$obj_pdf->Cell(45, $celdaLargo, utf8_decode('Estatus'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea

			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(40,55,55,45));
				$obj_pdf->SetAligns(array('C','C','C','C'));
				
				$estatus = ($row["estatus"] == 1) ? 'ACTIVO' : 'INACTIVO';

				$obj_pdf->Row(array(
									 utf8_decode($row['codestatus'])
									,utf8_decode($row['nombre'])
									,utf8_decode($row['descripcion'])
									,utf8_decode($estatus)
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('listado_estatus.pdf', 'I'); // salida del pdf.	
		}
	}
?>