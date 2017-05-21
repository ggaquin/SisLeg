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
                    $documento["origen"]=$proyecto->getBloque()->getBloque();
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
        $documento["origen"]=$proyecto->getBloque()->getBloque();      

        $tipo = $proyecto->getTipoProyecto()->getTipoProyecto();
        $numeroCompleto = $proyecto->getId();

        $encabezado = array('tipo' => $tipo, 'numeroCompleto' => $numeroCompleto, 'fecha' => date('d-m-Y H:i:s'));


        $nombreArchivo=sprintf('Proyecto %s %s.pdf', $numeroCompleto, date('d-m-Y H:i:s'));

        return array('documento' => $documento, 'encabezado' => $encabezado, 'nombreArchivo' => $nombreArchivo);

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
            
            $quienSanciona=(($proyecto->getQuienSanciona()==1)
                ?'<p class="ident"><strong>EL HONORABLE CONCEJO DELIBERANTE EN USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA LA SIGUIENTE:</strong></p>'
                :'<p class="ident"><strong>EL SR. PRESIDENTE DE ESTE HONORABLE CONCEJO DELIBERANTE, EN USO DE ATRIBUCIONES QUE LE SON PROPIAS, SANCIONA LA SIGUIENTE:</strong></p>');
                
            foreach ($articulos as $articulo) {
                 $htmlArticulos.='<strong><u>Artículo '.$articulo['numero'].'°</u>.- </strong>'.str_replace('</p>', '<br>',strip_tags($articulo['texto'],'</p>'));
                if(count($articulo['incisos'])>0){
                    $htmlArticulos.='<ul style="list-style-type: none;">';
                    foreach ($articulo['incisos'] as $inciso) {
                        $htmlArticulos.='<li>'.$inciso['orden'].' '.strip_tags($inciso['texto'],'<br>').'</li>';
                    }
                    $htmlArticulos.='</ul>';
                }
            } 
            
            $visto=str_replace('<p>','<p class="ident">',strip_tags($proyecto->getVisto(),'<p>'));
            $considerando=str_replace('<p>','<p class="ident">',strip_tags($proyecto->getConsiderandos(),'<p>'));
            $tipoProyecto=$proyecto->getTipoProyecto()->getTipoProyecto();

            return array('visto' => $visto, 'considerando' => $considerando, 
                         'tipoProyecto' => $tipoProyecto, 'articulos' => $htmlArticulos,
                         'quienSanciona' => $quienSanciona, 'verProyecto' => !is_null($proyecto));
        }
    }
    

}