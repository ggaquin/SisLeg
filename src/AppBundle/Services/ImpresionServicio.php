<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Proyecto;

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

    /*
    public function traerParametrosImpresionExpediente($idExpediente)
    {
        try {

            $expedienteRepository=$this->em->getRepository('AppBundle:Expediente');
            $expediente=$expedienteRepository->find($idExpediente);
            $proyecto=$expediente->getProyecto();   
            
            $documento = $this->traerDatosProyecto($proyecto); 
            $documento["verPortada"] = true; 
            $documento["caratula"]  = $expediente->getCaratulaSinHtml();
            $documento["numeroExp"] = $expediente->getNumeroExpediente();
            $documento["letra"] = $expediente->getTipoExpediente()->getLetra();
            $documento["ejercicio"] = $expediente->getEjercicio();
            $documento["entrada"] = $expediente->getFechaCreacionFormateada();

            $idTipoExpediente = $expediente->getTipoExpediente()->getId();
         
            switch ($idTipoExpediente) {
                case '3': //Petición Particular
                    $documento["origen"]='Petición Particular';
                    break;
                case '4': //Departamento Ejecutivo
                    $documento["origen"]='Departamento Ejecutivo';
                    break;
                case '5': //Secretaría Administrativa
                    $documento["origen"]='Secretaría Administrativa';
                    break;
                default: //proyecto
                    $documento["origen"]=$proyecto->getListaAutores();
                    break;
            }

            $tipo = $expediente->getTipoExpediente()->getTipoExpediente();
            $numeroCompleto = $expediente->getNumeroCompleto();

            $encabezado = array('tipo' => $tipo, 'numeroCompleto' => $numeroCompleto, 'fecha' => date('d-m-Y H:i:s'));

            $nombreArchivo=sprintf('Expediente %s %s.pdf', $expediente->getNumeroCompleto(), date('d-m-Y H:i:s'));

            return array('documento' => $documento, 'encabezado' => $encabezado, 'nombreArchivo' => $nombreArchivo);
            
        } catch (Exception $e) {
            throw $e;
            
        }
       
    }
    
    public function traerParametrosImpresionProyecto($idProyecto)
    {
        $proyectoRepository=$this->em->getRepository('AppBundle:Proyecto');
        $proyecto=$proyectoRepository->find($idProyecto);
     
        $documento = $this->traerDatosProyecto($proyecto); 
        $documento["verPortada"] = false; 
        $documento["caratula"]  = '';  
        $documento["numeroExp"] = '';
        $documento["letra"] = '';
        $documento["ejercicio"] = '';
        $documento["entrada"] = '';
        $documento["origen"] = '';
        $documento["origen"]=$proyecto->getListaAutores();     

        $tipo = $proyecto->getTipoProyecto()->getTipoProyecto();
        $numeroCompleto = $proyecto->getId();

        $encabezado = array('tipo' => $tipo, 'numeroCompleto' => $numeroCompleto, 'fecha' => date('d-m-Y H:i:s'));


        $nombreArchivo=sprintf('Proyecto %s %s.pdf', $numeroCompleto, date('d-m-Y H:i:s'));

        return array('documento' => $documento, 'encabezado' => $encabezado, 'nombreArchivo' => $nombreArchivo);

    }
    */

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
            
            $quienSanciona=$pgph_style.'<strong>EL HONORABLE CONCEJO DELIBERANTE EN USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA '.(($tipoProyecto=='Decreto')?'EL':'LA').' SIGUIENTE:</strong></p>';
            
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
    

}