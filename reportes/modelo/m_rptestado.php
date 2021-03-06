<?php 
	include_once('../../config/conexion.php');
	include_once('m_repcabpiefhorizontal.php');
	
	class Repestado extends Conectar
	{

		function consultar($estatus,$dato)
		{ // consultar por aproximidad
			$conectar = parent::conexion();				
			if($estatus != "")
			 {
				 $sql ="
				 		SELECT e.codestado, e.nombre nomest, p.codpais, p.nombre nompais, e.estatus
			 			FROM estado e
			 			INNER JOIN pais p ON p.codpais = e.codpais
			 			WHERE e.estatus = $estatus 
			 				and e.nombre like UPPER(('%$dato%'))  
			 			ORDER BY p.nombre, e.nombre";
				 $sql = $conectar->prepare($sql);
				 $sql->execute();
				 return $sql->fetchAll();
			}
			else
			{
				$conectar = parent::conexion();
							$sql ="
									SELECT e.codestado, e.nombre nomest, p.codpais, p.nombre nompais, e.estatus
						 			FROM estado e
						 			INNER JOIN pais p ON p.codpais = e.codpais
						 			WHERE e.nombre like UPPER(('%$dato%'))  
						 			ORDER BY p.nombre, e.nombre";
							$sql = $conectar->prepare($sql);
							$sql->execute();
							return $sql->fetchAll();
			}
			if($estatus =="" && $dato=="")
			{
				$conectar = parent::conexion();
					$sql =" SELECT SELECT e.codestado, e.nombre nomest, p.codpais, p.nombre nompais, e.estatus
				 			FROM estado e
				 			INNER JOIN pais p ON p.codpais = e.codpais
				 			ORDER BY p.nombre, e.nombre";
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
			
			$obj_pdf->Cell(75, $celdaLargo, utf8_decode('Estado'),0,0,'C'); // celda titulo tabla
			$obj_pdf->Cell(70, $celdaLargo, utf8_decode('País'),0,0,'C');
			$obj_pdf->Cell(50, $celdaLargo, utf8_decode('Estatus'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea

			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(75,70,50));
				$obj_pdf->SetAligns(array('C','C','C'));

				$estatus = ($row["estatus"] == 1) ? 'ACTIVO' : 'INACTIVO';

				$obj_pdf->Row(array(
								 	 utf8_decode($row['nomest'])
									,utf8_decode($row['nompais'])
									,utf8_decode($estatus)
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('listado_estado.pdf', 'I'); // salida del pdf.	
		
		}
	}
?>