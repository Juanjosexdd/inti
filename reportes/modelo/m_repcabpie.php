<?php
	@session_start();
	include_once('../fpdf/fpdf.php');

	class PDF extends FPDF
	{
  	public $title;

    public function Header()
    {
		$this->Image('../img/hearder.jpg',5,3,270); //logo comunidad debe estar en img carpeta reportes
		$this->Ln(10);
		$this->SetFont('Arial','B',15);
		
		$this->Cell(0,10,$_GET['titulo'],0,0,'C'); // titulo del reporte llega desde el control
		$this->SetFont('Times','',10);
		$fecha=date('d-m-Y');
		$this->Cell(0,10,utf8_decode('Fecha de impresión: ').$fecha,0,0,'R');
		$this->Ln(10);
	}
	
	function Footer()
	{
		$this->SetY(-25);
		$this->SetFont('Arial','I',8);
		//$this->Cell(0,10,'Derechos Compartidos MPPAT.'.' Generado por: Pamela Peraza ',0,0,'L');
		$this->Cell(0,10, ('Derechos Compartidos MPPAT. Generado por: ').$_SESSION['nombre'].' '.$_SESSION['apellido'],0,0,'L');
		$this->Ln();
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }

	var $widths;
	var $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function Row($data, $parameter = array(),$bordcell = 0)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();

			//Define si el paramentro de border de las celdas del array ROW esta definido para pintarlas
			$Bh = (isset($parameter['borderCell'])) ? $parameter['borderCell'] :  1;
			if($Bh == 0){
				$this->Rect(0,0,0,0);
			}else{
				$this->Rect($x,$y,$w,$h);	
			}
			
			//Print the text
			$this->MultiCell($w,5,$data[$i],$bordcell,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}
	
	var $angle=0;

	function Rotate($angle,$x=-1,$y=-1)
	{
		if($x==-1)
			$x=$this->x;
		if($y==-1)
			$y=$this->y;
		if($this->angle!=0)
			$this->_out('Q');
		$this->angle=$angle;
		if($angle!=0)
		{
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}

	function _endpage()
	{
		if($this->angle!=0)
		{
			$this->angle=0;
			$this->_out('Q');
		}
		parent::_endpage();
	}


	function SetCellHeight($ch) {
		$this->cell_height=$ch;
	}


	//////////////////////////////////////
	// FUNCIONES PARA LA TRANSPARENCIA  //
	//////////////////////////////////////
	///Este script ofrece soporte de transparencia. Puede establecer el canal alfa de 0 (completamente transparente) a 1 (totalmente opaco). Se aplica a todos los elementos (texto, dibujos, imágenes).

	var $extgstates = array();

	// alpha: real value from 0 (transparent) to 1 (opaque)
	// bm:    blend mode, one of the following:
	//          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
	//          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
	function SetAlpha($alpha, $bm='Normal')
	{
		// set alpha for stroking (CA) and non-stroking (ca) operations
		$gs = $this->AddExtGState(array('ca'=>$alpha, 'CA'=>$alpha, 'BM'=>'/'.$bm));
		$this->SetExtGState($gs);
	}

	function AddExtGState($parms)
	{
		$n = count($this->extgstates)+1;
		$this->extgstates[$n]['parms'] = $parms;
		return $n;
	}

	function SetExtGState($gs)
	{
		$this->_out(sprintf('/GS%d gs', $gs));
	}

	function _enddoc()
	{
		if(!empty($this->extgstates) && $this->PDFVersion<'1.4')
			$this->PDFVersion='1.4';
		parent::_enddoc();
	}

	function _putextgstates()
	{
		for ($i = 1; $i <= count($this->extgstates); $i++)
		{
			$this->_newobj();
			$this->extgstates[$i]['n'] = $this->n;
			$this->_out('<</Type /ExtGState');
			$parms = $this->extgstates[$i]['parms'];
			$this->_out(sprintf('/ca %.3F', $parms['ca']));
			$this->_out(sprintf('/CA %.3F', $parms['CA']));
			$this->_out('/BM '.$parms['BM']);
			$this->_out('>>');
			$this->_out('endobj');
		}
	}

	function _putresourcedict()
	{
		parent::_putresourcedict();
		$this->_out('/ExtGState <<');
		foreach($this->extgstates as $k=>$extgstate)
			$this->_out('/GS'.$k.' '.$extgstate['n'].' 0 R');
		$this->_out('>>');
	}

	function _putresources()
	{
		$this->_putextgstates();
		parent::_putresources();
	}
	

}


?>