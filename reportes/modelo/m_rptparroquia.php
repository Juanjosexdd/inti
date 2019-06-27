<?php 
	include_once('../../config/conexion.php');
	include_once('m_repcabpie.php');
	
	class Repparroquia extends Conectar
	{

		function consultar($estatus,$dato)
		{ // consultar por aproximidad				
			$conectar = parent::conexion();
			 if($estatus != "")
			 {
				 $sql ="
				 		SELECT pa.codparroquia, pa.nombre nompar, m.codmunicipio, m.nombre nommun, e.codestado, e.nombre nomest, p.codpais, p.nombre nompais, m.estatus
			 			FROM parroquia pa
			 			INNER JOIN municipio m ON pa.codmunicipio = m.codmunicipio
			 			INNER JOIN estado e ON m.codestado = e.codestado
			 			INNER JOIN pais p ON e.codpais = p.codpais
			 			WHERE pa.estatus = $estatus 
			 				and pa.nombre like UPPER(('%$dato%'))  
			 			ORDER BY p.nombre, e.nombre, m.nombre, pa.nombre";
				 $sql = $conectar->prepare($sql);
				 $sql->execute();
				 return $sql->fetchAll();
			}
			else
			{
				$conectar = parent::conexion();
							$sql ="
									SELECT pa.codparroquia, pa.nombre nompar, m.codmunicipio, m.nombre nommun, e.codestado, e.nombre nomest, p.codpais, p.nombre nompais, m.estatus
						 			FROM parroquia pa
						 			INNER JOIN municipio m ON pa.codmunicipio = m.codmunicipio
						 			INNER JOIN estado e ON m.codestado = e.codestado
						 			INNER JOIN pais p ON e.codpais = p.codpais
						 			WHERE pa.nombre like UPPER(('%$dato%'))  
						 			ORDER BY p.nombre, e.nombre, m.nombre, pa.nombre";
							$sql = $conectar->prepare($sql);
							$sql->execute();
							return $sql->fetchAll();

			}
			if($estatus =="" && $dato=="")
			{
				$conectar = parent::conexion();
							$sql =" SELECT pa.codparroquia, pa.nombre nompar, m.codmunicipio, m.nombre nommun, e.codestado, e.nombre nomest, p.codpais, p.nombre nompais, m.estatus
					 			FROM parroquia pa
					 			INNER JOIN municipio m ON pa.codmunicipio = m.codmunicipio
					 			INNER JOIN estado e ON m.codestado = e.codestado
					 			INNER JOIN pais p ON e.codpais = p.codpais
					 			ORDER BY p.nombre, e.nombre, m.nombre, pa.nombre";
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
			$bordetabla='T'; // variable para bordes de tabla
			//$obj_pdf->SetFillColor(139, 208, 253); 
			
			$obj_pdf->Cell(75, $celdaLargo, utf8_decode('Parroquia'),0,0,'C'); // celda titulo tabla
			$obj_pdf->Cell(55, $celdaLargo, utf8_decode('Municipio'),0,0,'C');
			$obj_pdf->Cell(50, $celdaLargo, utf8_decode('Estado'),0,0,'C');
			$obj_pdf->Cell(45, $celdaLargo, utf8_decode('País'),0,0,'C');
			$obj_pdf->Cell(35, $celdaLargo, utf8_decode('Estatus'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea

			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(75,55,50,45,35));
				$obj_pdf->SetAligns(array('C','C','C','C','C'));
				
				$estatus = ($row["estatus"] == 1) ? 'ACTIVO' : 'INACTIVO';

				$obj_pdf->Row(array(
									 utf8_decode($row['nompar'])
									,utf8_decode($row['nommun'])
									,utf8_decode($row['nomest'])
									,utf8_decode($row['nompais'])
									,utf8_decode($estatus)
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('listado_parroquia.pdf', 'I'); // salida del pdf.	
		}
	}
?>