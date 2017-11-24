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

    public function __construct(EntityManager $em) {
            $this->em=$em;
    }
    
    public function traerParametrosCaratula($idExpediente)
    {
         try {

            if (is_null($idExpediente))
                return null;
			$documento=[];
            $expedienteRepository=$this->em->getRepository('AppBundle:Expediente');
            $expediente=$expedienteRepository->find($idExpediente);
            $pgph_style='<p style="text-align: justify;margin-top: 0">&nbsp;&nbsp;&nbsp;&nbsp;';
            $documento["caratula"]  = str_replace('<p>', $pgph_style, $expediente->getCaratula());
            $documento["numeroExp"] = $expediente->getNumeroExpediente();
            $documento["letra"] = $expediente->getTipoExpediente()->getLetra();
            $documento["ejercicio"] = $expediente->getEjercicio();
            $documento["entrada"] = $expediente->getFechaCreacionFormateada();

            $idTipoExpediente = $expediente->getTipoExpediente()->getId();
			
            $tieneProyecto=false;
            $idProyecto=null;

         
            switch ($idTipoExpediente) {
                case '3': //Petición Particular
                	$demandante=$expediente->getDemandanteParticular();
                	$demandante="PARTICULAR".((!is_null($demandante))?(" - ".$demandante):"");
                	$documento["origen"]=$demandante;
                    break;
                case '4': //Poder Ejecutivo
                	$externo=$expediente->getOrigenExterno()->getOficina()->getOficina();
                	$origen=((!is_null($externo))?(" - ".$externo):"");
                	$origen='PODER EJECUTIVO'.$origen;
                	$documento["origen"]=$origen;
                    break;
                case '5': //Secretaría Administrativa
                    $documento["origen"]='SECRETARIA ADMINISTRATIVA';
                    break;
                default: //proyecto
                    $proyecto=$expediente->getProyecto();
                    //$bloques=$proyecto->getBloques();
                    //$listaConcejales="";
                    //$perfilRepository=$this->em->getRepository('AppBundle:Perfil');
//                     foreach ($bloques as $bloque) {
//                        $listaConcejales.=($listaConcejales!=""?" - ":"");
//                        $listaConcejales.=$perfilRepository->findLegisladorByBloque_Id($bloque->getId());
//                     }
                    //$listaConcejales.=($listaConcejales!=""?" - ":"");
                    //$listaConcejales.=$proyecto->getListaConcejales(";");
                    $documento["origen"]=$proyecto->getConcejal()->getBloque()->getBloque();
                    $tieneProyecto=true;
                    $idProyecto=$proyecto->getId();
                    break;
            }

            $tipo = $expediente->getTipoExpediente()->getTipoExpediente();
            $numeroCompleto = $expediente->getNumeroCompleto();

            $nombreArchivo=sprintf('Expediente %s %s.pdf', $expediente->getNumeroCompleto(), date('d-m-Y H:i:s'));

            $titulo=sprintf('Expediente %s', $expediente->getNumeroCompleto());

            $nombreArchivo=sprintf('Expediente %s %s.pdf', $numeroCompleto, date('d-m-Y H:i:s'));
            return array('documento' => $documento, 'tipo' => $tipo, 'nombreArchivo' => $nombreArchivo, 'titulo' => $titulo, 'tieneProyecto' => $tieneProyecto, 'idProyecto' => $idProyecto);
            
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function traerParametrosProyecto($idProyecto)
    {
        
        try{

            if(is_null($idProyecto))
                return null;

            $proyectoRepository=$this->em->getRepository('AppBundle:Proyecto');
            $proyecto=$proyectoRepository->find($idProyecto);
            //return $proyecto;
            
            $documento = $this->traerDatosProyecto($proyecto);  
            $numeroCompleto = $proyecto->getId();
            $tipo=$proyecto->getTipoProyecto()->getTipoProyecto();

            $nombreArchivo=sprintf('Proyecto %s %s.pdf', $numeroCompleto, date('d-m-Y H:i:s'));
            $titulo=sprintf('Proyecto %s', $numeroCompleto);

            return array('documento' => $documento, 'tipo' => $tipo, 'nombreArchivo' => $nombreArchivo, 'titulo' => $titulo);

        } catch (Exception $e) {
            throw $e;
        }
        
    }

    protected function traerDatosProyecto($proyecto)
    {
        
        $articulos='';
        $quienSanciona='';
        $htmlArticulos='';
        $visto='';
        $considerando='';
        $tipoProyecto='';
        $htmlArticulos='';
        
        if(!is_null($proyecto)){

            $articulos=$proyecto->getArticulos();
            $pgph_style='<p style="text-align: justify;margin-top: 0">&nbsp;&nbsp;&nbsp;&nbsp;';
            $tipoProyecto=$proyecto->getTipoProyecto()->getTipoProyecto();
            
            
            $quienSanciona=$pgph_style.'<strong>EL HONORABLE CONCEJO DELIBERANTE EN USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA '.
            			  (($tipoProyecto=='Decreto')?'EL':'LA').' SIGUIENTE:</strong></p>';
            
            foreach ($articulos as $articulo) {
                $textoArticulo=substr($articulo['texto'], 3,strlen($articulo['texto'])+3);
                $textoArticulo=str_replace('<p>', $pgph_style, $textoArticulo);
                $htmlArticulos.='<p><strong><u>Artículo '.$articulo['numero'].'°</u>.- </strong>';
                $htmlArticulos.=$textoArticulo;

                if(count($articulo['incisos'])>0){
                    $htmlArticulos.='<ul style="list-style-type: none;">';
                    foreach ($articulo['incisos'] as $inciso) {
                        $htmlArticulos.='<li>'.$inciso['orden'].' '.strip_tags($inciso['texto'],'<br>').'</li>';
                    }
                    $htmlArticulos.='</ul>';
                }
            } 
            
            $visto=str_replace('<p>', $pgph_style, $proyecto->getVisto());
            $considerando= str_replace('<p>', $pgph_style, $proyecto->getConsiderandos());
            

            return array('visto' => $visto, 'considerando' => $considerando, 
                         'tipoProyecto' => $tipoProyecto, 'articulos' => $htmlArticulos,
                         'quienSanciona' => $quienSanciona);
        }
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
    	
    	return $identation;
    }
    
    public function setHeader(\PhpOffice\PhpWord\Element\Section $section,$urlImage,$textUp,$textDown)
    {
    	$header = $section->addHeader();
    	$fontTextHeader=array('name'=>'Times New Roman', 'size'=>10, 'color'=>'000000', 'bold'=>true);
    	$table = $header->addTable();
    	$table->addRow();
    	$cellRowSpan = array('vMerge' => 'restart', 'indentation' => $this->getIdentation('none'));
    	$table->addCell(1400,$cellRowSpan)
			  ->addImage($urlImage,
			    		 array('width' => 38, 'height' => 50,
			    			   'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
			    			   )
			    		);
    	$table->addCell(8200)->addText($textUp,$fontTextHeader);
    	$table->addRow();
    	$cellRowContinue = array('vMerge' => 'continue', 'indentation' => $this->getIdentation('none'));
    	$table->addCell(1400,$cellRowContinue);
    	$table->addCell(8200)->addText($textDown,$fontTextHeader);
    	$header->addShape( 'line',
			    			array(
			    					'points'  => '1,1 570,1',
			    					'outline' => array(
			    							'color'      => '#000000',
			    							'line'       => 'thickThin',
			    							'weight'     => 2,
			    							'startArrow' => 'none',
			    							'endArrow'   => 'none',
			    					),
			    			)
    					);
    	
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
    	$phpWord->addTitleStyle(5, array('name'=>'Times New Roman', 'size'=>16, 'color'=>'000000',
    									 'bold'=>true),
    							   array('alignment'=>Jc::CENTER, 'indentation' => $this->getIdentation('none')));
    	//encabezado de lugar y fecha
    	$phpWord->addTitleStyle(6, array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    							   array('alignment'=>Jc::END, 'indentation' => $this->getIdentation('none')));
    	////encabezade de secciones del proyecto vistos, considerandos,...,etc
    	$phpWord->addTitleStyle(7, array('name'=>'Times New Roman', 'size'=>13, 'color'=>'000000',
    									 'bold'=>true),
    							  array('alignment'=>Jc::START, 'indentation' => $this->getIdentation('none')));
    	//encabezado de caratula del expoediente
    	$phpWord->addTitleStyle(8, array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    							   array('alignment'=>Jc::BOTH, 'indentation' => $this->getIdentation('none')	,
    									 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12)));
    	//encabezado para formato de artículo
    	$phpWord->addTitleStyle(9, array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    							   array('alignment'=>Jc::BOTH,'indentation' => $this->getIdentation('none'),
    									 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12)));
    	//encabezado para formato de inciso
    	$phpWord->addTitleStyle(10, array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    								array('alignment'=>Jc::BOTH, 'indentation' => 600,
    									  'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12)));
    								
    	return $phpWord;
    }
    
    public function getPage( \PhpOffice\PhpWord\PhpWord $phpWord,$size,$resetNumbering=0)
    {
    	return $phpWord->addSection(array('paperSize' => $size,'pageNumberingStart' => $resetNumbering));
    }
    
    public function writeHTMLToPage($html,\PhpOffice\PhpWord\Element\Section $page,$withBreak=0)
    {
    	\PhpOffice\PhpWord\Shared\Html::addHtml($page, $html); 
    	if ($withBreak==1)
    		$page->addPageBreak();
    	
    	return $page;
    }
    
    public function addImageToPage($url,\PhpOffice\PhpWord\Element\Section $page)
    {
    	$page->addImage($url,array('width' => 630, 'height' => 340, 'positioning'=>'relative',
    							   'marginTop' => 100, 'marginLeft'    => 0,
    					           'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
    					           'wrappingStyle' => 'square'));
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
    
    public function crearCaratulaExpediente(\PhpOffice\PhpWord\Element\Section $page,
    										$numero,$letra,$periodo,$caratula,$fecha,$origen)
    {
    	
    	//encabezado
    	$html='<p></p><h3><strong>CONSEJO DELIBERANTE</strong></h3>'.
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
    	
    	$cell2=$row1->addCell(2000,$cellRowSpan);
    	$cell2->addText($numero,array('name'=>'Times New Roman', 'size'=>18, 'color'=>'000000', 'bold'=>true),
    							array('alignment'=>Jc::CENTER, 'indentation' => -10));
    	
    	$cell3=$row1->addCell(1500,$cellRowSpan);
    	$cell3->addText('Letra:', array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    			array('alignment'=>Jc::CENTER, 'indentation' => -10));
    	
    	$cell4=$row1->addCell(1000,$cellRowSpan);
    	$cell4->addText($letra,array('name'=>'Times New Roman', 'size'=>18, 'color'=>'000000', 'bold'=>true),
    			array('alignment'=>Jc::CENTER, 'indentation' => -10));
    	
    	$cell5=$row1->addCell(1500,$cellRowSpan);
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
    	$cell7=$row2->addCell(9500,array('bgColor'=>'F1EBEA'));
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
    	$cell9=$row3->addCell(7500,$cellRowSpan2);
    	$cell9->addText($fecha, array('name'=>'Times New Roman', 'size'=>12, 'color'=>'000000'),
    							array('alignment'=>Jc::START, 'indentation'=> $this->getIdentation('none')));
    	$row4=$table3->addRow();
    	$cell8=$row4->addCell(2000,$cellRowSpan2);
    	$cell8->addText('Origen:', array('name'=>'Times New Roman', 'size'=>13, 'color'=>'000000', 'bold'=>true),
    							   array('alignment'=>Jc::START, 'indentation'=> $this->getIdentation('none')));
    	$cell9=$row4->addCell(7500,$cellRowSpan2);
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
    	
    	$cell11=$row5->addCell(7500,$cellRowSpan4);
    	$html='<p></p>'.
      		  '<p>_________________________________________________________</p>'.
      		  '<p>_________________________________________________________</p>'.
      		  '<p>_________________________________________________________</p>'.
      		  '<p>_________________________________________________________</p>'.
      		  '<p>_________________________________________________________</p>'.
      		  '<p>_________________________________________________________</p>'.
      		  '<p>_________________________________________________________</p>';
    	
    	\PhpOffice\PhpWord\Shared\Html::addHtml($cell11,$html);
    	
    	return $page;
    	
    }
    
    public function getArchivoOD(\PhpOffice\PhpWord\PhpWord $word,$fecha)
    {
    	$objWriter = IOFactory::createWriter($word, 'Word2007');
    	$fileName = 'Orden del Dia '.$fecha.'.docx';
    	$directorioTemporal=sys_get_temp_dir();
    	$uniqid=uniqid();
    	mkdir($directorioTemporal.'/OD-'.$uniqid);
    	$temp_file = tempnam($directorioTemporal.'/OD-'.$uniqid, $fileName);
    	
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
    

}