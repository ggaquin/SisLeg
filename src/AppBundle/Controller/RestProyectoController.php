<?php

namespace AppBundle\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
;

// use twig\twig;

use AppBundle\AppBundle;
use AppBundle\Entity\Bloque;
use AppBundle\Entity\Perfil;
use AppBundle\Entity\Proyecto;
use AppBundle\Entity\ProyectoRevision;
use AppBundle\Entity\TipoProyecto;
use AppBundle\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;

/**
 * @Route("/api/proyecto")
 *
 */
class RestProyectoController extends FOSRestController{
	
    /**
     * @Rest\Get("/getAll")
     */
    public function traerTodosLosProyectosAction(Request $request)
    {

        $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:proyecto');
        $proyecto=$proyectoRepository->findAll();
        return $this->view($proyecto,200);
         
    }

    /**
     * @Rest\Get("/getByCriteria/{tipoCriterio}/{criterio}")
     */
    public function traerProyectosPorCriterioAction(Request $request)
    {
        try{
            $tipoCriterio=$request->get('tipoCriterio');
            $criterio=$request->get('criterio');
            $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
            $proyectos=null;
            if ($tipoCriterio=='todo')
                $proyectos=$proyectoRepository->findAll();
            if($tipoCriterio=='busqueda-1')
                $proyectos=$proyectoRepository->findByAutor_Nombres($criterio);
            if ($tipoCriterio=='busqueda-2')
                $proyectos=$proyectoRepository->findByExpediente_Estado_Id($criterio);
            if($tipoCriterio=='busqueda-3')
                $proyectos=$proyectoRepository->findByExpediente_Numero($criterio);
            if ($tipoCriterio=='busqueda-4')
                $proyectos=$proyectoRepository->findByTipoProyecto_Id($criterio);
            if ($tipoCriterio=='busqueda-5')
                $proyectos=$proyectoRepository->findByExpediente_Null();

            $resultados=[];
            foreach ($proyectos as $proyecto){
            	$registro=array('id'=>$proyecto->getId(),
            					'numero_expediente'=>$proyecto->getExpediente()->getNumeroCompleto(),
            					'tipo_proyecto'=>$proyecto->getTipoProyecto()->getTipoProyecto(),
            					'fecha_creacion_formateada'=>$proyecto->getFechaCreacionFormateada(),
            					'fecha_entrada_formateada'=>$proyecto->getFechaEntradaFormateada(),
            					'estado_expediente'=>$proyecto->getEstadoExpediente(),
            					'lista_concejales'=>$proyecto->getListaConcejales()
            					);
            	$resultados[]=$registro;
            }
           
            return $this->view($resultados,200);

        }catch(\Exception $e) {

            return $this->view($e->getMessage(),500);
        } 
         
    }

    /**
     * @Rest\Get("/getOne/{id}")
     */
    public function traerProyectoPorIdAction(Request $request)
    {
        $id=$request->get('id');
        $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
        $proyecto=$proyectoRepository->find($id);
        $resultado=array(
        				 'id_tipo_proyecto'=>$proyecto->getTipoProyecto()->getId(),
        				 'visto'=>$proyecto->getVisto(),'considerandos'=>$proyecto->getConsiderandos(),
        				 'concejales'=>$proyecto->getConcejales(),'articulos'=>$proyecto->getArticulos()
        				);
        return $this->view($resultado,200);
         
    }
    
    /**
     *  @Rest\Get("/sendMail/{idProyecto}")
     */
    public function enviarMailProyectoAction(Request $request)
    {
        $idProyecto=$request->get("idProyecto");
        // $idProyecto=$request->request->get("idProyecto");
        $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
        $proyecto=$proyectoRepository->find($idProyecto);


        $subject=$proyecto->getTipoProyecto()->getTipoProyecto().' - '.substr($proyecto->getAsuntoSinHtml(),0,20).'...';
            $articulos=$proyecto->getArticulos();
            $destinatarios=[];
            foreach ($proyecto->getFirmas() as $firma) 
               $destinatarios[]=$firma->getAutor()->getCorreoElectronico();

            $quienSanciona='<p class="ident"><strong>EL HONORABLE CONCEJO DELIBERANTE EN USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA LA SIGUIENTE:</strong></p>';
               

            $htmlArticulos='';
            
            foreach ($articulos as $articulo) {
                 $htmlArticulos.='<strong><u>Artículo '.$articulo->numero.'°</u>.- </strong>'.str_replace('</p>', '<br>',strip_tags($articulo->texto,'</p>'));
                if(count($articulo->incisos)>0){
                    //recordar setear ul{list-style-type: none;}
                    $htmlArticulos.='<ul style="list-style-type: none;">';
                    foreach ($articulo->incisos as $inciso) {
                        $htmlArticulos.='<li>'.$inciso->orden.' '.strip_tags($inciso->texto,'<br>').'</li>';
                    }
                    $htmlArticulos.='</ul>';
                }
            }

            $htmlArticulos.='</ul>';

            $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom('send@example.com')
            ->setTo($destinatarios)
            ->setBody(
                $this->renderView(
                    'documento/modeloProyecto.html.twig', array(
                    'asunto' => strip_tags($proyecto->getAsunto(),'<p>'),
                    'visto'=>str_replace('<p>','<p class="ident">',strip_tags($proyecto->getVisto(),'<p>')),
                    'considerando'=>str_replace('<p>','<p class="ident">',strip_tags($proyecto->getConsiderandos(),'<p>')),
                    'articulos'=>$htmlArticulos,
                    'tipo'=>$proyecto->getTipoProyecto()->getTipoProyecto(),
                    'quienSanciona'=>$quienSanciona
                )),
                'text/html'
            );

            $this->get('mailer')->send($message);
         
    }

     /**
     *  @Rest\Post("/create")
     */
    public function crearProyectoAction(Request $request)
    {   
        $idtipoProyecto=$request->request->get('idtipoProyecto');
        $listaConcejales=$request->request->get('concejales');
        $listaBloques=$request->request->get('bloques');
        $visto=$request->request->get('visto');

        $considerando=$request->request->get('considerando');
        $articulos=json_decode($request->request->get('articulos'));
        /*
          ---------------------------------------------
          descomentar si se acuerda mail de notifcacion
          ---------------------------------------------

          $notificar=$request->request->get('notificar');

          ------------------------------------------------
        */
        $usuario=$this->getUser();

        $concejales=(($listaConcejales=="")?[]:explode(',',$listaConcejales));
        $bloques=(($listaBloques=="")?[]:explode(',',$listaBloques));       

        $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
        $tipoProyectoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoProyecto');
        $tipoProyecto=$tipoProyectoRepository->find($idtipoProyecto);
        $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
      
        $proyecto=new Proyecto();
        $proyecto->setTipoProyecto($tipoProyecto);
        $proyecto->setVisto($visto);
        $proyecto->setConsiderandos($considerando);

        if(is_array($bloques)){
            foreach ($bloques as $bloque) {
                $bloque=$bloqueRepository->find($bloque);
                $concejalesBloque=$bloque->getConcejales();
                foreach ($concejalesBloque as $concejal) {
                	$proyecto->addConcejal($concejal);
                	/*
                	 ---------------------------------------------
                	 descomentar si se acuerda mail de notifcacion
                	 ---------------------------------------------
                	 
                	 $firma= new ProyectoFirma();
                	 $firma->setAutor($concejal);
                	 $proyecto->addFirma($firma);
                	 */
                }
            }
        }

        if (is_array($concejales)){
            foreach ($concejales as $concejal) {
                $perfil=$perfilRepository->find($concejal);
                $proyecto->addConcejal($perfil);
                /*
                    ---------------------------------------------
                    descomentar si se acuerda mail de notifcacion
                    ---------------------------------------------

                $firma= new ProyectoFirma();
                $firma->setAutor($perfil);
                $proyecto->addFirma($firma);
                */
            }
        }

        $proyecto->setArticulos($articulos);
        $proyecto->setUsuarioCreacion($usuario->getUsername());
        $proyecto->setFechaCreacion(new \DateTime("now"));

        $em = $this->getDoctrine()->getManager();
        $em->persist($proyecto);
        $em->flush();

        /*
            ---------------------------------------------
            descomentar si se acuerda mail de notifcacion
            ----------------------------------------------
                  esto debe ser pasado a in servicio
            ----------------------------------------------

        if($notificar==true){
            $subject=$proyecto->getTipoProyecto()->getTipoProyecto().' - '.substr($proyecto->getAsuntoSinHtml(),0,20).'...';
            $articulos=$proyecto->getArticulos();
            $destinatarios=[];
            foreach ($proyecto->getFirmas() as $firma) 
               $destinatarios[]=$firma->getAutor()->getCorreoElectronico();

            $quienSanciona=(($proyecto->getQuienSanciona()==1)
                ?'<p class="ident"><strong>EL HONORABLE CONCEJO DELIBERANTE EN USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA LA SIGUIENTE:</strong></p>'
                :'<p class="ident"><strong>EL SR. PRESIDENTE DE ESTE HONORABLE CONCEJO DELIBERANTE, EN USO DE ATRIBUCIONES QUE LE SON PROPIAS, SANCIONA LA SIGUIENTE:</strong></p>');

            $htmlArticulos='';
            
            foreach ($articulos as $articulo) {
                 $htmlArticulos.='<strong><u>Artículo '.$articulo->numero.'°</u>.- </strong>'.str_replace('</p>', '<br>',strip_tags($articulo->texto,'</p>'));
                if(count($articulo->incisos)>0){
                    //recordar setear ul{list-style-type: none;}
                    $htmlArticulos.='<ul style="list-style-type: none;">';
                    foreach ($articulo->incisos as $inciso) {
                        $htmlArticulos.='<li>'.$inciso->orden.' '.strip_tags($inciso->texto,'<br>').'</li>';
                    }
                    $htmlArticulos.='</ul>';
                }
            }

            $htmlArticulos.='</ul>';

            $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom('send@example.com')
            ->setTo($destinatarios)
            ->setBody(
                $this->renderView(
                    'emails/notificacionProyecto.html.twig', array(
                    'asunto' => strip_tags($proyecto->getAsunto(),'<p>'),
                    'visto'=>str_replace('<p>','<p class="ident">',strip_tags($proyecto->getVisto(),'<p>')),
                    'considerando'=>str_replace('<p>','<p class="ident">',strip_tags($proyecto->getConsiderandos(),'<p>')),
                    'articulos'=>$htmlArticulos,
                    'tipo'=>$proyecto->getTipoProyecto()->getTipoProyecto(),
                    'quienSanciona'=>$quienSanciona
                )),
                'text/html'
            );

            $this->get('mailer')->send($message);
                
            
        }
        */

        return $this->view('El proyecto se guardó en forma exitosa',200);
    }

    /**
     *  @Rest\Post("/update")
     */
    public function actualizarProyectoAction(Request $request)
    {   
        $idProyecto=$request->request->get('idProyecto');
        $idtipoProyecto=$request->request->get('idtipoProyecto');
        $listaConcejales=$request->request->get('concejales');
        $listaBloques=$request->request->get('bloques');

        $visto=$request->request->get('visto');
        $considerando=$request->request->get('considerando');
        $articulos=json_decode($request->request->get('articulos'));
     
        $usuario=$this->getUser();

        $concejales=(($listaConcejales=='')?[]:explode(',',$listaConcejales));
        $bloques=(($listaBloques=='')?[]:explode(',',$listaBloques));

        $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
        $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
        $tipoProyectoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoProyecto');
        $tipoProyecto=$tipoProyectoRepository->find($idtipoProyecto);
        $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
      
        $proyecto=$proyectoRepository->find($idProyecto);
        $proyecto->setTipoProyecto($tipoProyecto);
        $proyecto->setVisto($visto);
        $proyecto->setConsiderandos($considerando);

        $nuevosConcejales=[];
        if(is_array($bloques) &&  count($bloques)>0){
            foreach ($bloques as $bloque) {
                $bloque=$bloqueRepository->find($bloque);
                $concejalesBloque=$bloque->getConcejales();
                foreach ($concejalesBloque as $concejal) {
                	$nuevosConcejales[]=$concejal;
                	/*
                	 ----------------------------------------------
                	 descomentar si se acuerda mail de notificacion
                	 ----------------------------------------------
                	 $firma= new ProyectoFirma();
                	 $firma->setAutor($concejal);
                	 $proyecto->addFirma($firma);
                	 */
                }
            }
        }
        
        if (is_array($concejales)){
            foreach ($concejales as $concejal) {
                    $perfil=$perfilRepository->find($concejal);
                    $nuevosConcejales[]=$perfil;
                   
                    /*
                        ----------------------------------------------
                        descomentar si se acuerda mail de notificacion
                        ----------------------------------------------
                    $firma= new ProyectoFirma();
                    $firma->setAutor($perfil);
                    $proyecto->addFirma($firma);
                    */
            }
        }
        
        $proyecto->setConcejales($nuevosConcejales);

        $proyecto->setArticulos($articulos);
        $proyecto->setUsuarioModificacion($usuario->getUsername());
        $proyecto->setFechaModificacion(new \DateTime("now"));

        $em = $this->getDoctrine()->getManager();
        $em->persist($proyecto);
        $em->flush();

        return $this->view('El proyecto se modificó en forma exitosa',200);
    }
    
    /**
     * @Rest\Get("/getRevisiones/{idProyecto}")
     */
    public function traerRevisionesPorIdProyectoAction(Request $request)
    {
    	$idProyecto=$request->get("idProyecto");
    	$proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
    	$proyectoRevisionRepository=$this->getDoctrine()->getRepository('AppBundle:ProyectoRevision');
    	
    	$proyecto=$proyectoRepository->find($idProyecto);
    	$revisiones=$proyectoRevisionRepository->findAll(array('proyecto' => $proyecto), array('id' => 'ASC'));
    	$revisionOriginal=new ProyectoRevision();
    	$revisionOriginal->setArticulos($proyecto->getArticulos());
    	$revisionOriginal->setVisto($proyecto->getVisto());
    	$revisionOriginal->setConsiderandos($proyecto->getConsiderandos());
    	$revisionOriginal->setIncluyeVistosYConsiderandos(true);
    	$revisionOriginal->setId(0);
    	$revisionOriginal->setUsuarioCreacion($proyecto->getUsuarioCreacion());
    	$revisionOriginal->setFechaCreacion($proyecto->getFechaCreacion());
    	$revisionOriginal->setOficina(null);
    	array_unshift($revisiones, $revisionOriginal);
    	
    	return $this->view($revisiones,200);
  	
    }
}