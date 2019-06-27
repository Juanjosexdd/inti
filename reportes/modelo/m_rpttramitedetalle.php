<?php 
	include_once('../../config/conexion.php');	//falta el filtro por fecha
	include_once('m_repcabpie.php');
	
	class Reptramitedetalle extends Conectar 
	{
		function consultar($tramite,$cedula,$estatus)
		{ // consultar por aproximidad
			$conectar = parent::conexion();
			 if($tramite != "" && $cedula != "" && $estatus != "")
			 {
				 $sql ="
				 		SELECT 	t.idtramite,
								t.cedulasolicitante,
						        t.codtramite,
						        t.loteterreno,
						        t.superficie,
						        t.codsector,
						        td.fechacreacion,
						        td.fechafin,
						        t.idusuario,
						        c.nacionalidad,
						        c.primernombre,
						        c.primerapellido,
						        mt.nombre nomtra,
						        s.nombre nomsec,
						        pa.nombre nompa,
						        m.nombre nommun,
						        e.nombre nomest,
						        p.nombre nompais,
						        u.usuario,
						        n.abreviatura,
						        es.codestatuS,
						        es.nombre nomesta,
						        td.observaciones obser
						FROM tramite t
						INNER JOIN tramitedetalle td ON t.idtramite = td.idtramite
						INNER JOIN estatus es ON td.codestatus = es.codestatus
						INNER JOIN ciudadano c ON t.cedulasolicitante = c.cedula
						INNER JOIN nacionalidad n ON c.nacionalidad = n.id
						INNER JOIN maestrotramite mt ON t.codtramite = mt.codtramite
						INNER JOIN sector s ON t.codsector = s.codsector
						INNER JOIN parroquia pa ON s.codparroquia = pa.codparroquia
						INNER JOIN municipio m ON pa.codmunicipio = m.codmunicipio
						INNER JOIN estado e ON m.codestado = e.codestado
						INNER JOIN pais p ON e.codpais = p.codpais 
						INNER JOIN usuario u ON t.idusuario = u.idusuario
						WHERE t.idtramite like UPPER(('%$tramite%'))  
							AND t.cedulasolicitante like UPPER(('%$cedula%'))
							AND es.nombre like UPPER(('%$estatus%'))
						ORDER BY t.idtramite, es.codestatus, td.fechacreacion";
				 $sql = $conectar->prepare($sql);
				 $sql->execute();
				 return $sql->fetchAll();
			}
			if($tramite == "" && $cedula == "" && $estatus == "")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	t.idtramite,
									t.cedulasolicitante,
							        t.codtramite,
							        t.loteterreno,
							        t.superficie,
							        t.codsector,
							        td.fechacreacion,
							        td.fechafin,
							        t.idusuario,
							        c.nacionalidad,
							        c.primernombre,
							        c.primerapellido,
							        mt.nombre nomtra,
							        s.nombre nomsec,
							        pa.nombre nompa,
							        m.nombre nommun,
							        e.nombre nomest,
							        p.nombre nompais,
							        u.usuario,
							        n.abreviatura,
							        es.codestatuS,
							        es.nombre nomesta,
							        td.observaciones obser
							FROM tramite t
							INNER JOIN tramitedetalle td ON t.idtramite = td.idtramite
							INNER JOIN estatus es ON td.codestatus = es.codestatus
							INNER JOIN ciudadano c ON t.cedulasolicitante = c.cedula
							INNER JOIN nacionalidad n ON c.nacionalidad = n.id
							INNER JOIN maestrotramite mt ON t.codtramite = mt.codtramite
							INNER JOIN sector s ON t.codsector = s.codsector
							INNER JOIN parroquia pa ON s.codparroquia = pa.codparroquia
							INNER JOIN municipio m ON pa.codmunicipio = m.codmunicipio
							INNER JOIN estado e ON m.codestado = e.codestado
							INNER JOIN pais p ON e.codpais = p.codpais 
							INNER JOIN usuario u ON t.idusuario = u.idusuario
							ORDER BY t.idtramite, es.codestatus, td.fechacreacion";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}			
			if($tramite != "" && $cedula == "" && $estatus == "")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	t.idtramite,
									t.cedulasolicitante,
							        t.codtramite,
							        t.loteterreno,
							        t.superficie,
							        t.codsector,
							        td.fechacreacion,
							        td.fechafin,
							        t.idusuario,
							        c.nacionalidad,
							        c.primernombre,
							        c.primerapellido,
							        mt.nombre nomtra,
							        s.nombre nomsec,
							        pa.nombre nompa,
							        m.nombre nommun,
							        e.nombre nomest,
							        p.nombre nompais,
							        u.usuario,
							        n.abreviatura,
							        es.codestatuS,
							        es.nombre nomesta,
							        td.observaciones obser
							FROM tramite t
							INNER JOIN tramitedetalle td ON t.idtramite = td.idtramite
							INNER JOIN estatus es ON td.codestatus = es.codestatus
							INNER JOIN ciudadano c ON t.cedulasolicitante = c.cedula
							INNER JOIN nacionalidad n ON c.nacionalidad = n.id
							INNER JOIN maestrotramite mt ON t.codtramite = mt.codtramite
							INNER JOIN sector s ON t.codsector = s.codsector
							INNER JOIN parroquia pa ON s.codparroquia = pa.codparroquia
							INNER JOIN municipio m ON pa.codmunicipio = m.codmunicipio
							INNER JOIN estado e ON m.codestado = e.codestado
							INNER JOIN pais p ON e.codpais = p.codpais 
							INNER JOIN usuario u ON t.idusuario = u.idusuario
							WHERE t.idtramite like UPPER(('%$tramite%'))  
							ORDER BY t.idtramite, es.codestatus, td.fechacreacion";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}
			if($cedula != "" && $estatus == "" && $tramite == "")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	t.idtramite,
									t.cedulasolicitante,
							        t.codtramite,
							        t.loteterreno,
							        t.superficie,
							        t.codsector,
							        td.fechacreacion,
							        td.fechafin,
							        t.idusuario,
							        c.nacionalidad,
							        c.primernombre,
							        c.primerapellido,
							        mt.nombre nomtra,
							        s.nombre nomsec,
							        pa.nombre nompa,
							        m.nombre nommun,
							        e.nombre nomest,
							        p.nombre nompais,
							        u.usuario,
							        n.abreviatura,
							        es.codestatuS,
							        es.nombre nomesta,
							        td.observaciones obser
							FROM tramite t
							INNER JOIN tramitedetalle td ON t.idtramite = td.idtramite
							INNER JOIN estatus es ON td.codestatus = es.codestatus
							INNER JOIN ciudadano c ON t.cedulasolicitante = c.cedula
							INNER JOIN nacionalidad n ON c.nacionalidad = n.id
							INNER JOIN maestrotramite mt ON t.codtramite = mt.codtramite
							INNER JOIN sector s ON t.codsector = s.codsector
							INNER JOIN parroquia pa ON s.codparroquia = pa.codparroquia
							INNER JOIN municipio m ON pa.codmunicipio = m.codmunicipio
							INNER JOIN estado e ON m.codestado = e.codestado
							INNER JOIN pais p ON e.codpais = p.codpais 
							INNER JOIN usuario u ON t.idusuario = u.idusuario
							WHERE t.cedula like UPPER(('%$cedula%'))
							ORDER BY t.idtramite, es.codestatus, td.fechacreacion";
					$sql = $conectar->prepare($sql);
					$sql->execute();
					return $sql->fetchAll();
			}
			if($estatus != "" && $tramite == "" && $cedula == "")
			{
				$conectar = parent::conexion();
					$sql =" 
							SELECT 	t.idtramite,
									t.cedulasolicitante,
							        t.codtramite,
							        t.loteterreno,
							        t.superficie,
							        t.codsector,
							        td.fechacreacion,
							        td.fechafin,
							        t.idusuario,
							        c.nacionalidad,
							        c.primernombre,
							        c.primerapellido,
							        mt.nombre nomtra,
							        s.nombre nomsec,
							        pa.nombre nompa,
							        m.nombre nommun,
							        e.nombre nomest,
							        p.nombre nompais,
							        u.usuario,
							        n.abreviatura,
							        es.codestatuS,
							        es.nombre nomesta,
							        td.observaciones obser
							FROM tramite t
							INNER JOIN tramitedetalle td ON t.idtramite = td.idtramite
							INNER JOIN estatus es ON td.codestatus = es.codestatus
							INNER JOIN ciudadano c ON t.cedulasolicitante = c.cedula
							INNER JOIN nacionalidad n ON c.nacionalidad = n.id
							INNER JOIN maestrotramite mt ON t.codtramite = mt.codtramite
							INNER JOIN sector s ON t.codsector = s.codsector
							INNER JOIN parroquia pa ON s.codparroquia = pa.codparroquia
							INNER JOIN municipio m ON pa.codmunicipio = m.codmunicipio
							INNER JOIN estado e ON m.codestado = e.codestado
							INNER JOIN pais p ON e.codpais = p.codpais 
							INNER JOIN usuario u ON t.idusuario = u.idusuario
							WHERE es.nombre like UPPER(('%$estatus%'))
							ORDER BY t.idtramite, es.codestatus, td.fechacreacion";
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
			
			$obj_pdf->Cell(10, $celdaLargo, utf8_decode('Nro.'),0,0,'C'); // celda titulo tabla
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('Cédula'),0,0,'C');
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('Terreno'),0,0,'C');
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('Superficie'),0,0,'C');
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('Sector'),0,0,'C');
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('F. Inicio'),0,0,'C');
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('F. Fin'),0,0,'C');
			$obj_pdf->Cell(25, $celdaLargo, utf8_decode('Estatus'),0,0,'C');
			$obj_pdf->Cell(45, $celdaLargo, utf8_decode('Observación'),0,0,'C');
			$obj_pdf->Cell(30, $celdaLargo, utf8_decode('Usuario'),0,0,'C');
			$obj_pdf->Ln(); // salto de linea


			foreach ($result as $key => $row) 
			{
				$obj_pdf->SetFont("Times","",9);
				$obj_pdf->SetWidths(array(10,6,19,25,25,25,25,25,25,45,30));
				$obj_pdf->SetAligns(array('C','R','L','C','C','C','C','C','C','C','C'));

				$obj_pdf->Row(array(
								 	 utf8_decode($row['idtramite'])
								 	,utf8_decode($row['abreviatura'])
									,utf8_decode($row['cedulasolicitante'])
									,utf8_decode($row['loteterreno'])
									,utf8_decode($row['superficie'])
									,utf8_decode($row['nomsec'])
									,utf8_decode($row['fechacreacion'])
									,utf8_decode($row['fechafin'])
									,utf8_decode($row['nomesta'])
									,utf8_decode($row['obser'])
									,utf8_decode($row['usuario'])
									)
									,array('borderCell'=>'T'),'T');
			}
			$obj_pdf->Ln(5);

			$obj_pdf->Output('listado_detalletramite.pdf', 'I'); // salida del pdf.			
		}
	}
?>