<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Proyecto;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ImpresionServicio
{
   
   private $em;

    public function __construct(EntityManager $em,$rootDir) {
            $this->em=$em;
    }
    
   
    private function getIdentation($identationType)
    {
    	$identation=new \PhpOffice\PhpWord\Style\Indentation();
    	if ($identationType=='none'){
    		$identation->setFirstLine(-25);
    		$identation->setLeft(0);
    		$identation->setRight(0);
    	}
    	if($identationType=='OD'){
    		$identation->setFirstLine(300);
    		$identation->setLeft(0);
    		$identation->setRight(0);
    	}
    	if($identationType=='LEGEND'){
    		$identation->setFirstLine(1600);
    		$identation->setLeft(0);
    		$identation->setRight(0);
    	}
    	
    	return $identation;
    }
    
    public function setHeader(\PhpOffice\PhpWord\Element\Section $section,$urlImage)
    {
    	$header = $section->addHeader();
    	$header->addImage($urlImage,
		    			  array('width' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(15.48), 
		    				    'height' =>  \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.5),
		    				    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START,
		    				    'wrappingStyle'=>'tight',
		    				    'marginLeft'=>\PhpOffice\PhpWord\Shared\Converter::cmToInch(-0.5)
		    				   )
    				   	  );

    	\PhpOffice\PhpWord\Shared\Html::addHtml($header, '<p></p>');
    	
    	return $section;
    }
    
    public function setFooter(\PhpOffice\PhpWord\Element\Section $section, $texto)
    {
    	$footer = $section->addFooter();
    	$footer->addPreserveText($texto, null,
    							 array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
    	
    	return $section;
    }
    
    public function getTemplateOD()
    {
    	$phpWord = new PhpWord();
    	$phpWord->setDefaultFontSize(12);
    	$phpWord->setDefaultFontName('Times New Roman');
    	$phpWord->setDefaultParagraphStyle(array(
								    			'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
								    			'indentation' => $this->getIdentation('OD'),
    											'alignment' => Jc::BOTH
								    			)
								    	   );
    	$phpWord->addTitleStyle(1, array('name'=>'Times New Roman', 'size'=>22, 'color'=>'000000'),
    							   array('alignment'=>Jc::CENTER,'indentation' => $this->getIdentation('none')));
    	$phpWord->addTitleStyle(2, array('name'=>'Times New Roman', 'size'=>24, 'color'=>'000000',
    									 'underline' => 'single'),
    							   array('alignment'=>Jc::CENTER, 'indentation' => $this->getIdentation('none')));
    	//encabezad8 para apartado
    	$phpWord->addTitleStyle(3, array('name'=>'Times New Roman', 'size'=>18, 'color'=>'000000'),
    							   array('alignment'=>Jc::CENTER,'indentation' => $this->getIdentation('none')));
    	//encabezado de apartado A,B,C,...,etc
    	$phpWord->addTitleStyle(4, array('name'=>'Times New Roman', 'size'=>18, 'color'=>'000000',
    									 'underline'=>'single'),
    							   array('alignment'=>Jc::BOTH, 'indentation' => $this->getIdentation('none')));
    	//encabezado para tipo de proyecto
    	$phpWord->addTitleStyle(5, array('name'=>'Times New Roman', 'size'=>13, 'color'=>'000000',
    								     'bold'=>true, 'underline' => 'single'),
    							   array('alignment'=>Jc::CENTER, 'indentation' => $this->getIdentation('none')));
    	//encabezado de lugar y fecha
    	$phpWord->addTitleStyle(6, array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    							   array('alignment'=>Jc::END, 'indentation' => $this->getIdentation('none')));
    	////encabezade de secciones del proyecto vistos, considerandos,...,etc
    	$phpWord->addTitleStyle(7, array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000',
    									 'bold'=>true, 'underline' => 'single'),
    							  array('alignment'=>Jc::START, 'indentation' => $this->getIdentation('none')));
    	//encabezado de caratula del expediente y encabezado para formato de artículo
    	$phpWord->addTitleStyle(8, array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    							   array('alignment'=>Jc::BOTH, 'indentation' => $this->getIdentation('none')	,
    									 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12)));
    	//leyendas "el hoonorable ..."  y "sancionada en la sala ..."
    	$phpWord->addTitleStyle(9, array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000', 'bold'=>true),
    							   array('alignment'=>Jc::BOTH,'indentation' => $this->getIdentation('LEGEND'),
    									 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12)));
    	//encabezado para formato de inciso
    	$phpWord->addTitleStyle(10, array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    								array('alignment'=>Jc::BOTH, 'indentation' => 600,
    									  'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12)));
    								
    	return $phpWord;
    }
    
    public function getPage( \PhpOffice\PhpWord\PhpWord $phpWord,$size,$resetNumbering=0)
    {
    	return $phpWord->addSection(array('paperSize' => $size,'pageNumberingStart' => $resetNumbering,
    								'marginLeft'=>\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3),
    								'marginRight'=>\PhpOffice\PhpWord\Shared\Converter::cmToTwip(3)
    								));
    }
    
    public function writeHTMLToPage($html,\PhpOffice\PhpWord\Element\Section $page,$withBreak=0)
    {
    	\PhpOffice\PhpWord\Shared\Html::addHtml($page, $html); 
    	if ($withBreak==1)
    		$page->addPageBreak();
    	
    	return $page;
    }
    
    public function addImageToPage($url,$htmlText,\PhpOffice\PhpWord\Element\Section $page)
    {
    	$table=$page->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0,
    								 'cellMarginBottom' => 0, 'cellMarginLeft' => 0)
    						  );
    	
    	$cellRowSpan = array('indentation' => $this->getIdentation('none'),'valign' => Jc::CENTER,
    						 'alignment'=>Jc::CENTER);
    	
    	$row1=$table->addRow();
    	$cell1=$row1->addCell(8800,$cellRowSpan);
    	
    	$cell1->addImage($url,array('width' => 585, 'height' => 316, 'positioning' => 'absolute',
    								'posHorizontalRel' => 'margin',
    								'posVerticalRel' => 'line',
    								'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
    								'wrappingStyle' => 'tight'));
    	$row2=$table->addRow();
    	$cell2=$row2->addCell(8800,$cellRowSpan);
    	\PhpOffice\PhpWord\Shared\Html::addHtml($cell2, $htmlText);
    	
    	$page->addPageBreak();
    	
    	/*
    	$page->addImage($url,array('width' => 630, 'height' => 340, 'positioning'=>'relative',
    							   'marginTop' => 100, 'marginLeft'    => 0,
    					           'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
    					           'wrappingStyle' => 'square'));
    	*/
    	
    	return $page;
    }
    
    public function addsignatureProyecto(\PhpOffice\PhpWord\Element\Section $page, $autor,$bloque)
    {
    	
    	\PhpOffice\PhpWord\Shared\Html::addHtml($page, '<p></p><p></p><p></p>');
    	
    	$table=$page->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0, 
    								 'cellMarginBottom' => 0, 'cellMarginLeft' => 0)
    						  );
    	$cellRowSpan = array('indentation' => $this->getIdentation('none'),'valign' => Jc::CENTER,
    						 'alignment'=>Jc::CENTER);
    	
    	$row1=$table->addRow(10);
    	$cell1=$row1->addCell(4500,$cellRowSpan);
    	$cell1->addText('________________________________');
    	$row2=$table->addRow(10);
    	$cell2=$row2->addCell(4500,$cellRowSpan);
    	$cell2->addText($autor,array('name'=>'Times New Roman', 'size'=>10, 'color'=>'000000', 'bold'=>true),
    						   array('alignment'=>Jc::CENTER, 'indentation' => 900));
    	$row3=$table->addRow(10);
    	$cell3=$row3->addCell(4500,$cellRowSpan);
    	$cell3->addText($bloque,array('name'=>'Times New Roman', 'size'=>10, 'color'=>'000000', 'bold'=>true),
    			array('alignment'=>Jc::CENTER, 'indentation' => 900));
    	
    	return $page;
    	
		    		
    }
    
    public function addsignatureSancion(\PhpOffice\PhpWord\Element\Section $page ,$urlImage, $firmaSecretario,$firmaPresidente)
    {
    	
    	\PhpOffice\PhpWord\Shared\Html::addHtml($page, '<p></p><p></p><p></p>');
    	
    	
    	$cellRowSpan = array('indentation' => $this->getIdentation('none'),'valign' => Jc::CENTER,
    						  'alignment'=>Jc::CENTER);	
    	$cellRowMerge = array('vMerge' => 'restart', 'indentation' => $this->getIdentation('none'));
    	$cellRowContinue = array('vMerge' => 'continue', 'indentation' => $this->getIdentation('none'));
    	
    	
    	$table = $page->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0,
				    			 'cellMarginBottom' => 0, 'cellMarginLeft' => 0)
				    			);
    	
    	$row1=$table->addRow(10);
    	$cell1=$row1->addCell(3200,$cellRowSpan);
    	if ($firmaPresidente!='')
    		$cell1->addText('______________________',array(),array('spaceAfter' => 0));
    	else
    		$cell1->addText('',array(),array('spaceAfter' => 0));
    	
    	$row1->addCell(2500,$cellRowMerge)
			 ->addImage($urlImage,
			 			array('width' =>\PhpOffice\PhpWord\Shared\Converter::cmToPixel(3.36	), 
			 				  'height' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(4.5),
				    		  'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
				    		 )
			    		);
		$cell2=$row1->addCell(3200,$cellRowSpan);
		$cell2->addText('______________________',array(),array('spaceAfter' => 0));
		
		$row2=$table->addRow(10);
		$cell3=$row2->addCell(3200,$cellRowSpan);
		if ($firmaPresidente!='')
			$cell3->addText(strtoupper($firmaSecretario),
							array('name'=>'Times New Roman', 'size'=>10, 'color'=>'000000', 'bold'=>true),
							array('alignment'=>Jc::CENTER, 'indentation' => $this->getIdentation('none'),
								  'spaceAfter' => 0
								 )
						   	);	
		else
			$cell3->addText('',array(),array('spaceAfter' => 0));
		
    	$row2->addCell(2500,$cellRowContinue);
    	$cell4=$row2->addCell(3200,$cellRowSpan);
    	if($firmaPresidente=='')
    		$cell4->addText(strtoupper($firmaSecretario),
    						array('name'=>'Times New Roman', 'size'=>10, 'color'=>'000000', 'bold'=>true),
    						array('alignment'=>Jc::CENTER, 'indentation' => $this->getIdentation('none'),
    							  'spaceAfter' => 0
    						)
    					   );
    	else 
    		$cell4->addText(strtoupper($firmaPresidente),
    						array('name'=>'Times New Roman', 'size'=>10, 'color'=>'000000', 'bold'=>true),
    						array('alignment'=>Jc::CENTER, 'indentation' => $this->getIdentation('none'),
    							  'spaceAfter' => 0
    						)
    					   );
    	
    	$row3=$table->addRow(10);
    	$cell5=$row3->addCell(3200,$cellRowSpan);
    	if($firmaPresidente!='')
    		$cell5->addText('SECRETARIO',
    						array('name'=>'Times New Roman', 'size'=>10, 'color'=>'000000', 'bold'=>true),
    						array('alignment'=>Jc::CENTER, 'indentation' => $this->getIdentation('none'),
    							  'spaceAfter' => 0
    						)
    					   );
    	else
    		$cell5->addText('',array(),array('spaceAfter' => 0));
    		
    	$row3->addCell(2500,$cellRowContinue);
    	$cell6=$row3->addCell(3200,$cellRowSpan);
    	if($firmaPresidente=='')
    		$cell6->addText('SECRETARIO',
    						 array('name'=>'Times New Roman', 'size'=>10, 'color'=>'000000', 'bold'=>true),
    						 array('alignment'=>Jc::CENTER, 'indentation' => $this->getIdentation('none'),
    						 	   'spaceAfter' => 0
    						 )
    						);
    	else
    		$cell6->addText('PRESIDENTE',
    						array('name'=>'Times New Roman', 'size'=>10, 'color'=>'000000', 'bold'=>true),
    						array('alignment'=>Jc::CENTER, 'indentation' => $this->getIdentation('none'),
    							  'spaceAfter' => 0
    						)
    					   );	
    	
    	$row4=$table->addRow(10);
    	$cell7=$row4->addCell(3200,$cellRowSpan);
    	if($firmaPresidente!='')
    		$cell7->addText('Honorable Concejo Deliberante',
    						array('name'=>'Times New Roman', 'size'=>10, 'color'=>'000000', 'bold'=>true),
    				        array('alignment'=>Jc::CENTER, 'indentation' => $this->getIdentation('none'),
    				        	  'spaceAfter' => 0
    				        )
    					   );
    	else
    		$cell7->addText('',array(),array('spaceAfter' => 0));
    
    	$row4->addCell(2500,$cellRowContinue);
    	$cell8=$row4->addCell(3200,$cellRowSpan);
    	$cell8->addText('Honorable Concejo Deliberante',
    					array('name'=>'Times New Roman', 'size'=>10, 'color'=>'000000', 'bold'=>true),
    					array('alignment'=>Jc::CENTER, 'indentation' => $this->getIdentation('none'),
    						  'spaceAfter' => 0
    					)
    				   );
    	
    	$row5=$table->addRow();
    	$row5->addCell(3200,$cellRowSpan);
    	$row5->addCell(2500,$cellRowContinue);
    	$row5->addCell(3200,$cellRowSpan);
    	
    	return $page;    	
    }
    
    public function setHeaderRemito(\PhpOffice\PhpWord\Element\Section $page,$urlImagen,$tipo,$numero)
    {
    	$fechaActual=new \DateTime('now');
    	$fechaImpresion=$fechaActual->format('d/m/Y');
    	$cellRowSpan = array('vMerge' => 'restart', 'indentation' => $this->getIdentation('none'));
    	$cellRowContinue = array('vMerge' => 'continue', 'indentation' => $this->getIdentation('none'));
      	
    	$tablaEncabezado=$page->addTable();
    	$filaEncabezado=$tablaEncabezado->addRow();
    	$filaEncabezado->addCell(2000,$cellRowSpan)
				       ->addImage($urlImagen,array('width' => 57, 'height' => 75,
							    					'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
							    					)
				    			  );
    	$filaEncabezado->addCell(2200)->addText('H.C.D',array('name'=>'Times New Roman', 'size'=>16,
    														  'color'=>'000000', 'bold'=>true),
    													array('indentation' => $this->getIdentation('none'))
    											);
    	$filaEncabezado->addCell(3000)->addText('REMITO INTERNO',
    											array('name'=>'Times New Roman', 'size'=>14,
    												  'color'=>'000000', 'bold'=>true, 'underline'=>'single'),
    											array('indentation' => $this->getIdentation('none'),
    												  'alignment'=>Jc::CENTER)
    			);
    	$filaEncabezado->addCell(2000)->addText('FECHA: '.$fechaImpresion,
    											array('name'=>'Times New Roman', 'size'=>10, 'bold'=>true,
    												  'color'=>'000000'),
    											array('indentation' => $this->getIdentation('none')));
    	
    	$filaEncabezado2=$tablaEncabezado->addRow();
    	
    	$filaEncabezado2->addCell(2000,$cellRowContinue);
    	$filaEncabezado2->addCell(2200)->addText('Lomas de Zamora',
    											 array('name'=>'Times New Roman', 'size'=>12,
    												   'color'=>'000000', 'bold'=>true),
    											  array('indentation' => $this->getIdentation('none'))
    											);
    	$filaEncabezado2->addCell(3000)->addText($tipo,
    											 array('name'=>'Times New Roman', 'size'=>14,
    												   'color'=>'000000'),
								    			 array('indentation' => $this->getIdentation('none'),
								    				'alignment'=>Jc::CENTER)
    											 );
    	$filaEncabezado2->addCell(2000)->addText('REMITO: '.$numero,
    											  array('name'=>'Times New Roman', 'size'=>10, 'bold'=>true,
    												    'color'=>'000000'),
    											  array('indentation' => $this->getIdentation('none')));
    	return $page;
    }
    
    public function setDatosRemito(\PhpOffice\PhpWord\PhpWord $phpWord,$pases, $informes, $notificaciones,
    		$urlImagen, $destino,$usuario,$numero=1)
    {
    	
    	$tableStyle = array('cellMargin' => 0, 'cellMarginRight' => 0,
    					    'cellMarginBottom' => 0, 'cellMarginLeft' => 30,
    						'borderSize' => 6
    						);
    	
    	$cellTextHeaderStyle= array('name'=>'Times New Roman', 'size'=>11, 'color'=>'000000', 'bold'=>true);
    	$cellTextStyle = array('name'=>'Times New Roman', 'size'=>11, 'color'=>'000000', 'bold'=>false);
    	
    	$cellSettingsInitial = array('alignment'=>Jc::START, 'indentation' => $this->getIdentation('none'));
    	$cellSettings = array('alignment'=>Jc::CENTER, 'indentation' => $this->getIdentation('none'));
    	
    	$page= $this->getPage($phpWord, 'Legal');
    	
    	for ($copy=1;$copy<3;$copy++){
    	    		
    		if ($copy==1)
    			$page=$this->setHeaderRemito($page, $urlImagen, 'ORIGINAL', $numero);
    		else{
    			
    			$page->addShape( 'line',
		    					 array(
		    							'points'  => '1,1 570,1',
		    							'outline' => array(
					    									'color'      => '#000000',
					    									'line'       => 'thickThin',
					    									'weight'     => 1,
					    									'startArrow' => 'none',
					    									'endArrow'   => 'none',
					    								   ),
		    						  )
    						  );
    			$page=$this->setHeaderRemito($page, $urlImagen, 'COPIA', $numero);
    		}
    	
	    	$html='<p></p><h8><strong>DE HONORABLE CONCEJO DELIBERANTE A: </strong>'.strtoupper($destino).'</h8>';
	    	\PhpOffice\PhpWord\Shared\Html::addHtml($page, $html);
	    	$html='<h8>Remite lo Siguiente:</h8>';
	    	\PhpOffice\PhpWord\Shared\Html::addHtml($page, $html);
	    	
	    	$tablaPrincipal=$page->addTable();
	    	$rowPrincipal=$tablaPrincipal->addRow();
	    	$celda1=$rowPrincipal->addCell(5500);
	    	    	
	    	//pases
	    	$filasPase=explode(',', substr($pases, 0,-1));
	    	
	    	if(strlen($filasPase[0])>0){
	    		    	
	    		$html='<h7>Expedientes</h7>';
	    		\PhpOffice\PhpWord\Shared\Html::addHtml($celda1, $html);
	    		
	    		$tablaPases=$celda1->addTable($tableStyle);
	    		    		
		    	$headerPase=$tablaPases->addRow();
		    	$headerPase->addCell(2000)->addText('Expte. N°',$cellTextHeaderStyle,$cellSettingsInitial);
		    	$headerPase->addCell(1000)->addText('Año',$cellTextHeaderStyle,$cellSettings);
		    	$headerPase->addCell(1000)->addText('Letra',$cellTextHeaderStyle,$cellSettings);
		    	$headerPase->addCell(1000)->addText('Folios',$cellTextHeaderStyle,$cellSettings);
		    	$filasPase=explode(',', substr($pases, 0,-1));
		    	
		    	foreach ($filasPase as $fila){
		    		$row=$tablaPases->addRow();
		    		$camposFila=explode('|', $fila);
		    		$esPrimerCampo=true;
		    		foreach ($camposFila as $campo){
		    			$cell=$row->addCell(1000);
		    			if ($esPrimerCampo==true)
		    				$cell->addText($campo,$cellTextStyle,$cellSettingsInitial);
		    			else
		    				$cell->addText($campo,$cellTextStyle,$cellSettings);
		    			
		    			$esPrimerCampo=false;
		    		}
		    	
		    	}
		    	
		    	$html='<p></p>';
		    	\PhpOffice\PhpWord\Shared\Html::addHtml($celda1, $html);
	    	}
	    	
	    	//informes
	    	$filasInforme=explode(',', substr($informes, 0,-1));
	    	
	    	if(strlen($filasInforme[0])>0){
	    		
		    	$html='<h7>Pedidos de Informe</h7>';
		    	\PhpOffice\PhpWord\Shared\Html::addHtml($celda1, $html);
		    	
		    	$tablaInformes=$celda1->addTable($tableStyle);
		    	
		    	$headerInformes=$tablaInformes->addRow();
		    	
		    	$headerInformes->addCell(2000)->addText('Expte. N°',$cellTextHeaderStyle,$cellSettingsInitial);
		    	$headerInformes->addCell(1000)->addText('Año',$cellTextHeaderStyle,$cellSettings);
		    	$headerInformes->addCell(1000)->addText('Letra',$cellTextHeaderStyle,$cellSettings);
		    	$headerInformes->addCell(1000)->addText('Folios',$cellTextHeaderStyle,$cellSettings);
		    	
		    	$filasInforme=explode(',', substr($informes, 0,-1));
		    	foreach ($filasInforme as $fila){
		    		$row=$tablaInformes->addRow();
		    		$camposFila=explode('|', $fila);
		    		$esPrimerCampo=true;
		    		foreach ($camposFila as $campo){
		    			$cell=$row->addCell(1000);
		    			if ($esPrimerCampo==true)
		    				$cell->addText($campo,$cellTextStyle,$cellSettingsInitial);
	    				else
	    					$cell->addText($campo,$cellTextStyle,$cellSettings);
	    					
	    				$esPrimerCampo=false;
		    		}
		    		
		    	}
		    	
		    	$html='<p></p>';
		    	\PhpOffice\PhpWord\Shared\Html::addHtml($celda1, $html);
	    	}
	    	
	    	//notificaciones
	    	$filasNotificacion=explode(',', substr($notificaciones, 0,-1));
	    	
	    	if (strlen($filasNotificacion[0])>0){
		    	$html='<h7>Notificaciones</h7>';
		    	\PhpOffice\PhpWord\Shared\Html::addHtml($celda1, $html);
		    	
		    	$tablaNotificaciones=$celda1->addTable($tableStyle);
		    	
		    	$headerNotificaciones=$tablaNotificaciones->addRow();
		    	$headerNotificaciones->addCell(2000)->addText('N° Sanción',$cellTextHeaderStyle,$cellSettingsInitial);
		    	$headerNotificaciones->addCell(3000)->addText('Tipo',$cellTextHeaderStyle,$cellSettings);
		    
		    	foreach ($filasNotificacion as $fila){
		    		$row=$tablaNotificaciones->addRow();
		    		$camposFila=explode('|', $fila);
		    		$esPrimerCampo=true;
		    		foreach ($camposFila as $campo){
		    			$cell=$row->addCell(1000);
		    			if($esPrimerCampo==true)
		    				$cell->addText($campo,$cellTextStyle,$cellSettingsInitial);
		    			else
		    				$cell->addText($campo,$cellTextStyle,$cellSettings);
		    			
		    			$esPrimerCampo=false;
		    		}
		    		
		    	}
	    	}
	    	
	    	$celda2=$tablaPrincipal->addCell(3800);
	    	$html='<h7>Oficina Receptora</h7>';
	    	\PhpOffice\PhpWord\Shared\Html::addHtml($celda2, $html);
	    	$tablaFirmante=$celda2->addTable(20);
	    	$row1=$tablaFirmante->addRow();
	    	$row1->addCell(1200)->addText("FIRMA: ",$cellTextHeaderStyle,$cellSettingsInitial);
	    	$row1->addCell(2400)->addText(" _________________",$cellTextStyle,$cellSettingsInitial);
	    	$row2=$tablaFirmante->addRow();
	    	$row2->addCell(1200)->addText("LEG.: ",$cellTextHeaderStyle,$cellSettingsInitial);
	    	$row2->addCell(2400)->addText(" _________________",$cellTextStyle,$cellSettingsInitial);
	    	$row3=$tablaFirmante->addRow(); 
	    	$row3->addCell(1200)->addText("FECHA: ",$cellTextHeaderStyle,$cellSettingsInitial);
	    	$row3->addCell(2400)->addText(" ____/____/_______",$cellTextStyle,$cellSettingsInitial);
	    	
	    	$html='<p></p><h8><strong>MESA DE ENTRADAS, INTERVINO: </strong>'.strtoupper($usuario).'</h8>';
	    	\PhpOffice\PhpWord\Shared\Html::addHtml($page, $html);
	    	
    	}
	
    	return $phpWord;
    }
    
    public function addMembreteExpedientes($page,$numerosExpedientes){
        	
    	$expedientes=explode(',', $numerosExpedientes);
    	$tableStyle = array('cellMargin' => 0, 'cellMarginRight' => 0,
			    			'cellMarginBottom' => -10, 'cellMarginLeft' => 0
			    		   );
    	$cellTextStyle = array('name'=>'Times New Roman', 'size'=>11, 'color'=>'000000', 'bold'=>true);
    	$cellSettings = array('alignment'=>Jc::START, 'indentation' => $this->getIdentation('none'),'spaceAfter' => 0);
    	
    	$tablaNumeros=$page->addTable($tableStyle);
    	$esPrimerFila=true;
    	$totalFilas=count($expedientes);
    	$filaActual=1;
    	foreach ($expedientes as $expediente){
    		$row=$tablaNumeros->addRow(10,array('exactHeight'=>10));
    		
    		$row->addCell(2200)->addText('',$cellTextStyle,$cellSettings);
    		
    		if ($esPrimerFila==true){
    			
    			if($filaActual==$totalFilas)
    				$row->addCell(3200,array('borderBottomSize'=>10,'borderBottomColor'=>000000))
    					->addText("CORRESPONDE AL EXPTE. N°",$cellTextStyle,$cellSettings);	
    			else
    				$row->addCell(3200)->addText("CORRESPONDE AL EXPTE. N°",$cellTextStyle,$cellSettings);
    			
    			$esPrimerFila=false;
    		}
    		else{
    			if($filaActual==$totalFilas)
    				$row->addCell(3200,array('borderBottomSize'=>10,'borderBottomColor'=>000000))
	    				->addText('                 "             "         "        " ',
	    						  $cellTextStyle,$cellSettings);
    			else
    				$row->addCell(3200)
    				->addText('                 "             "         "        " ',
    						  $cellTextStyle,$cellSettings);
    		}
    		if($filaActual==$totalFilas)
    			$row->addCell(3400,array('borderBottomSize'=>10,'borderBottomColor'=>000000))
    				->addText($expediente,$cellTextStyle,$cellSettings);
    		else
    			$row->addCell(3400)
    				->addText($expediente,$cellTextStyle,$cellSettings);
    		
    				$filaActual++;
    	}
    	
    	\PhpOffice\PhpWord\Shared\Html::addHtml($page, '<p></p>');
    	
    	return $page;
    	
    }
    
    public function crearCaratulaExpediente(\PhpOffice\PhpWord\Element\Section $page,
    										$numero,$letra,$periodo,$caratula,$fecha,$origen)
    {
    	
    	//encabezado
    	$html='<h3><strong>CONCEJO DELIBERANTE</strong></h3>'.
    		  '<h5>DE</h5><h5>LOMAS DE ZAMORA</h5>'.
    		  '<p></p>';
    	
    	\PhpOffice\PhpWord\Shared\Html::addHtml($page, $html);
    	
    	//tabla nomenclatura expediente
    	$table1=$page->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0,
    								  'cellMarginBottom' => 0, 'cellMarginLeft' => 0)
    			);
    	$cellRowSpan = array('indentation' => $this->getIdentation('none'),'valign' => Jc::CENTER,
    			             'alignment'=>Jc::CENTER);
    	
    	$row1=$table1->addRow(1000);
    	$cell1=$row1->addCell(2000,$cellRowSpan);
    	$cell1->addText('Expediente N°:', array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    			   						  array('alignment'=>Jc::CENTER,'indentation'=> $this->getIdentation('none')));
    	
    	$cell2=$row1->addCell(2100,$cellRowSpan);
    	$cell2->addText($numero,array('name'=>'Times New Roman', 'size'=>18, 'color'=>'000000', 'bold'=>true),
    							array('alignment'=>Jc::CENTER, 'indentation' => -10));
    	
    	$cell3=$row1->addCell(1200,$cellRowSpan);
    	$cell3->addText('Letra:', array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    			array('alignment'=>Jc::CENTER, 'indentation' => -10));
    	
    	$cell4=$row1->addCell(800,$cellRowSpan);
    	$cell4->addText($letra,array('name'=>'Times New Roman', 'size'=>18, 'color'=>'000000', 'bold'=>true),
    			array('alignment'=>Jc::CENTER, 'indentation' => -10));
    	
    	$cell5=$row1->addCell(1200,$cellRowSpan);
    	$cell5->addText('Año:', array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    			array('alignment'=>Jc::CENTER, 'indentation' => -10));
    	
    	$cell6=$row1->addCell(1500,$cellRowSpan);
    	$cell6->addText($periodo,array('name'=>'Times New Roman', 'size'=>18, 'color'=>'000000', 'bold'=>true),
    			array('alignment'=>Jc::CENTER, 'indentation' => -10));
    	
    	//texto caratula
    	\PhpOffice\PhpWord\Shared\Html::addHtml($page, '<p></p>');
    	$table2=$page->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0,
					    			  'cellMarginBottom' => 0, 'cellMarginLeft' => 0)
					    			 );
    	
    	$row2=$table2->addRow(5000);
    	$cell7=$row2->addCell(8800,array('bgColor'=>'F1EBEA'));
    	\PhpOffice\PhpWord\Shared\Html::addHtml($cell7,$caratula);
    	
    	//fecha, origen y observaciones
    	\PhpOffice\PhpWord\Shared\Html::addHtml($page, '<p></p>');
    	$table3=$page->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0,
    			'cellMarginBottom' => 0, 'cellMarginLeft' => 0)
    			);
    	$cellRowSpan2 = array('indentation' => $this->getIdentation('none'),'valign' => Jc::CENTER,
    			'alignment'=>Jc::START);
    	
    	$row3=$table3->addRow();
    	$cell8=$row3->addCell(2000,$cellRowSpan2);
    	$cell8->addText('Fecha Entrada:', array('name'=>'Times New Roman', 'size'=>13, 'color'=>'000000','bold'=>true),
    									  array('alignment'=>Jc::START, 'indentation'=> $this->getIdentation('none')));
    	$cell9=$row3->addCell(6800,$cellRowSpan2);
    	$cell9->addText($fecha, array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    							array('alignment'=>Jc::START, 'indentation'=> $this->getIdentation('none')));
    	$row4=$table3->addRow();
    	$cell8=$row4->addCell(2000,$cellRowSpan2);
    	$cell8->addText('Origen:', array('name'=>'Times New Roman', 'size'=>13, 'color'=>'000000', 'bold'=>true),
    							   array('alignment'=>Jc::START, 'indentation'=> $this->getIdentation('none')));
    	$cell9=$row4->addCell(6800,$cellRowSpan2);
    	$cell9->addText($origen, array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    							 array('alignment'=>Jc::START, 'indentation'=> $this->getIdentation('none')));
    	
    	
    	\PhpOffice\PhpWord\Shared\Html::addHtml($page, '<p></p>');
    	$table4=$page->addTable(array('cellMargin' => 0, 'cellMarginRight' => 0,
						    			'cellMarginBottom' => 0, 'cellMarginLeft' => 0)
						    			);
    	$cellRowSpan3 = array('indentation' => $this->getIdentation('none'),'valign' => 'top',
    						  'alignment'=>Jc::START);
    	$cellRowSpan4 = array('indentation' => $this->getIdentation('none'),'valign' => 'top',
    						  'alignment'=>Jc::CENTER, 'bgColor'=>'F1EBEA');
    	
    	$row5=$table4->addRow(3000);
    	$cell10=$row5->addCell(2000,$cellRowSpan3);
    	$cell10->addText('Observaciones:', array('name'=>'Times New Roman', 'size'=>13, 'color'=>'000000', 'bold'=>true),
    									   array('alignment'=>Jc::START, 'indentation'=> $this->getIdentation('none')));
    	
    	$cell11=$row5->addCell(6800,$cellRowSpan4);
    	$html='<p></p>'.
      		  '<p>____________________________________________________</p>'.
      		  '<p>____________________________________________________</p>'.
      		  '<p>____________________________________________________</p>'.
      		  '<p>____________________________________________________</p>'.
      		  '<p>____________________________________________________</p>'.
      		  '<p>____________________________________________________</p>'.
      		  '<p>____________________________________________________</p>';
    	
    	\PhpOffice\PhpWord\Shared\Html::addHtml($cell11,$html);
    	
    	return $page;
    	
    }
    
    public function getArchivoOD(\PhpOffice\PhpWord\PhpWord $word,$fecha,$tipo,$nombreDocumento)
    {
    	$objWriter = IOFactory::createWriter($word, 'Word2007');
    	$fileName = $nombreDocumento.$fecha.'.docx';
    	$directorioTemporal=sys_get_temp_dir();
    	$uniqid=uniqid();
    	mkdir($directorioTemporal.'/'.$tipo.'-'.$uniqid);
    	$temp_file = tempnam($directorioTemporal.'/'.$tipo.'-'.$uniqid, $fileName);
    	
    	$objWriter->save($temp_file);
    	
    	$response = new BinaryFileResponse($temp_file);
    	$response->setContentDisposition(
							    			ResponseHeaderBag::DISPOSITION_ATTACHMENT,
							    			$fileName
							    		);
    	return $response;
    }
    
    public function getArchivoDictamen(\PhpOffice\PhpWord\PhpWord $word,$fecha,$expediente,$comisiones)
    {
    	$objWriter = IOFactory::createWriter($word, 'Word2007');
    	$fileName = 'Dictamen_Expediente_'.$expediente.'_'.$comisiones.'_'.$fecha.'.docx';
    	$directorioTemporal=sys_get_temp_dir();
    	$uniqid=uniqid();
    	mkdir($directorioTemporal.'/DICTAMEN-'.$uniqid);
    	$temp_file = tempnam($directorioTemporal.'/DICTAMEN-'.$uniqid, $fileName);
    	
    	$objWriter->save($temp_file);
    	
    	$response = new BinaryFileResponse($temp_file);
    	$response->setContentDisposition(
    			ResponseHeaderBag::DISPOSITION_ATTACHMENT,
    			$fileName
    			);
    	return $response;
    }
    
    public  function getArchivoSancion(\PhpOffice\PhpWord\PhpWord $word, $fecha, $expediente, $numeroSancion)
    {
    	$objWriter = IOFactory::createWriter($word, 'Word2007');
    	$fileName = 'Sancion_'.$numeroSancion.'_Expediente_'.$expediente.'_'.$fecha.'.docx';
    	$directorioTemporal=sys_get_temp_dir();
    	$uniqid=uniqid();
    	mkdir($directorioTemporal.'/SANCION-'.$uniqid);
    	$temp_file = tempnam($directorioTemporal.'/SANCION-'.$uniqid, $fileName);
    	
    	$objWriter->save($temp_file);
    	
    	$response = new BinaryFileResponse($temp_file);
    	$response->setContentDisposition(
    			ResponseHeaderBag::DISPOSITION_ATTACHMENT,
    			$fileName
    			);
    	return $response;
    	
    }
    
    public  function getArchivoProyecto(\PhpOffice\PhpWord\PhpWord $word, $fecha, $autor)
    {
    	$objWriter = IOFactory::createWriter($word, 'Word2007');
    	$fileName = 'Proyecto'.'_'.$autor.'_'.$fecha.'.docx';
    	$directorioTemporal=sys_get_temp_dir();
    	$uniqid=uniqid();
    	mkdir($directorioTemporal.'/PROYECTO-'.$uniqid);
    	$temp_file = tempnam($directorioTemporal.'/PROYECTO-'.$uniqid, $fileName);
    	
    	$objWriter->save($temp_file);
    	
    	$response = new BinaryFileResponse($temp_file);
    	$response->setContentDisposition(
    			ResponseHeaderBag::DISPOSITION_ATTACHMENT,
    			$fileName
    			);
    	return $response;
    	
    }
    
    public  function getArchivoExpediente(\PhpOffice\PhpWord\PhpWord $word, $fecha, $expediente)
    {
    	$objWriter = IOFactory::createWriter($word, 'Word2007');
    	$fileName = 'Expediente'.'_'.$expediente.'_'.$fecha.'.docx';
    	$directorioTemporal=sys_get_temp_dir();
    	$uniqid=uniqid();
    	mkdir($directorioTemporal.'/EXPEDIENTE-'.$uniqid);
    	$temp_file = tempnam($directorioTemporal.'/EXPEDIENTE-'.$uniqid, $fileName);
    	
    	$objWriter->save($temp_file);
    	
    	$response = new BinaryFileResponse($temp_file);
    	$response->setContentDisposition(
    			ResponseHeaderBag::DISPOSITION_ATTACHMENT,
    			$fileName
    			);
    	return $response;
    	
    }
    
    public  function getArchivoListadoE(\PhpOffice\PhpWord\PhpWord $word, $fecha)
    {
    	$objWriter = IOFactory::createWriter($word, 'Word2007');
    	$fileName = 'Listado_E_'.$fecha.'.docx';
    	$directorioTemporal=sys_get_temp_dir();
    	$uniqid=uniqid();
    	mkdir($directorioTemporal.'/E-'.$uniqid);
    	$temp_file = tempnam($directorioTemporal.'/E-'.$uniqid, $fileName);
    	
    	$objWriter->save($temp_file);
    	
    	$response = new BinaryFileResponse($temp_file);
    	$response->setContentDisposition(
    			ResponseHeaderBag::DISPOSITION_ATTACHMENT,
    			$fileName
    			);
    	return $response;
    	
    }
    
    public  function getArchivoRemito(\PhpOffice\PhpWord\PhpWord $word, $fecha, $numeroRemito)
    {
    	$objWriter = IOFactory::createWriter($word, 'Word2007');
    	$fileName = 'Remito_'.$numeroRemito.'_'.$fecha.'.docx';
    	$directorioTemporal=sys_get_temp_dir();
    	$uniqid=uniqid();
    	mkdir($directorioTemporal.'/Remito-'.$uniqid);
    	$temp_file = tempnam($directorioTemporal.'/Remito'.$uniqid, $fileName);
    	
    	$objWriter->save($temp_file);
    	
    	$response = new BinaryFileResponse($temp_file);
    	$response->setContentDisposition(
    			ResponseHeaderBag::DISPOSITION_ATTACHMENT,
    			$fileName
    			);
    	return $response;
    	
    }
    

}