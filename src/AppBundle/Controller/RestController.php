<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\File\UploadedFile;;

// use twig\twig;

use AppBundle\Entity\Rol;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Perfil;
use AppBundle\Entity\PerfilLegislador;  
use AppBundle\Entity\PerfilPublico;
use AppBundle\Entity\Bloque;
use AppBundle\Entity\Expediente;
use AppBundle\Entity\Proyecto;
use AppBundle\Entity\ProyectoFirma;
use AssistBundle\Entity\AdministracionSesion;


class RestController extends FOSRestController{


	/**
	 * @Rest\Get("/api/usuario/getAll")
     */
    public function traerTodosLosUsuariosAction(Request $request)
    {

        $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
        $usuarios=$usuarioRepository->findAll();
        return $this->view($usuarios,200);
    }	

    /**
     * @Rest\Get("/api/usuario/getOne/{id}")
     */
    public function traerUsuarioPorIdAction(Request $request)
    {
        $id=$request->get('id');
        $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
        $usuario=$usuarioRepository->find($id);
        return $this->view($usuario,200);
    }

    /**
     * @Rest\Get("/api/proyecto/getAll")
     */
    public function traerTodosLosProyectosAction(Request $request)
    {

        $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:proyecto');
        $proyecto=$proyectoRepository->findAll();
        return $this->view($proyecto,200);
         
    }

    /**
     * @Rest\Get("/api/proyecto/getByCriteria/{tipoCriterio}/{criterio}")
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

            return $this->view($proyectos,200);

        }catch(\Exception $e) {

            return $this->view($e->getMessage(),500);
        } 
         
    }

    /**
     * @Rest\Get("/api/expediente/getAll")
     */
    public function traerTodosLosExpedientesAction(Request $request)
    {

        $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
        $expedientes=$expedienteRepository->findAll();
        return $this->view($expedientes,200);
         
    }

    /**
     * @Rest\Get("/api/proyecto/getOne/{id}")
     */
    public function traerProyectoPorIdAction(Request $request)
    {
        $id=$request->get('id');
        $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
        $proyecto=$proyectoRepository->find($id);
        return $this->view($proyecto,200);
         
    }

    /**
     * @Rest\Get("/api/expediente/getByCriteria/{tipoCriterio}/{criterio}")
     */
    public function traerExpedientesPorCriterioAction(Request $request)
    {
        try{

            $tipoCriterio=$request->get('tipoCriterio');
            $criterio=$request->get('criterio');
            $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
            $expedientes=null;
            if ($tipoCriterio=='todo')
                $expedientes=$expedienteRepository->findAll();
            if($tipoCriterio=='busqueda-1')
                $expedientes=$expedienteRepository->findByAutor_Nombres($criterio);
            if ($tipoCriterio=='busqueda-2')
                $expedientes=$expedienteRepository->findByEstado_Id($criterio);
            if($tipoCriterio=='busqueda-3')
                $expedientes=$expedienteRepository->findBy(array('numeroExpediente'=>$criterio));
            if ($tipoCriterio=='busqueda-4')
                $expedientes=$expedienteRepository->findByTipoExpediente_Id($criterio);

            return $this->view($expedientes,200);

        }catch(\Exception $e)   {
            return $this->view($e->getMessage(),500);
        }
    }

    /**
     * @Rest\Get("/api/expediente/getOne/{id}")
     */
    public function traerExpedientePorIdAction(Request $request)
    {
        $id=$request->get('id');
        $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
        $expediente=$expedienteRepository->find($id);
        return $this->view($expediente,200);
    }

    /**
     * @Rest\Get("/api/legislador/getAll")
     */
    public function traerTodosLosLegisladoresAction(Request $request)
    {
        $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:PerfilLegislador');
        $perfiles=$perfilRepository->findAll();
        return $this->view($perfiles,200);
    }

    /**
     * @Rest\Get("/api/legislador/getOne/{id}")
     */
    public function traerLegisladorIdAction(Request $request)
    {
        $id=$request->get('id');
        $legisladorRepository=$this->getDoctrine()->getRepository('AppBundle:PerfilLegislador');
        $legislador=$legisladorRepository->find($id);
        return $this->view($legislador,200);
    }

    /**
     * @Rest\Get("/api/legislador/nombre/getByCriteria")
     */
    public function traerLegisladorNombrePorCriterioAction(Request $request)
    {   
        $term=$request->query->get('q');
        $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
        $perfiles=$perfilRepository->findLegisladorByNombre_Patron($term);
        return $this->view($perfiles,200);
    }


    /**
     * @Rest\Get("/api/legislador/descripcion/getByCriteria")
     */
    public function traerLegisladorDescripcionPorCriterioAction(Request $request)
    {   
        $term=$request->query->get('q');
        $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
        $perfiles=$perfilRepository->findLegisladorByDescripcion_Patron($term);
        return $this->view($perfiles,200);
    }

    /**
     * @Rest\Get("/api/bloques/getByCriteria")
     */
    public function traerBloquePorCriterioAction(Request $request)
    {   
        $term=$request->query->get('q');
        $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
        $bloques=$bloqueRepository->findBloqueByNombre_Patron($term);
        return $this->view($bloques,200);
    }

    /**
     * @Rest\Get("/api/comision/getAll")
     */
    public function traerTodasLasComisionesAction(Request $request)
    {
        
        $comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
        $comisiones=$comisionRepository->findBy(array(),array('comision' => 'ASC'));
        return $this->view($comisiones,200);
    }

    /**
     *  @Rest\Get("/api/proyecto/enviarMail/{idProyecto}")
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
     *  @Rest\Post("/api/proyecto/create")
     */
    public function crearProyectoAction(Request $request)
    {   
        $idtipoProyecto=$request->request->get('idtipoProyecto');
        $listaConcejales=$request->request->get('concejales');
        $listaBloques=$request->request->get('bloques');
        $visto=$request->request->get('visto');

        $considerando=$request->request->get('considerando');
        $quienSanciona=$request->request->get('quienSanciona');
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
        $proyecto->setQuienSanciona($quienSanciona);

        if(is_array($bloques)){
            foreach ($bloques as $bloque) {
                $bloque=$bloqueRepository->find($bloque);
                $proyecto->addBloque($bloque);
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
     *  @Rest\Post("/api/proyecto/update")
     */
    public function actualizarProyectoAction(Request $request)
    {   
        $idProyecto=$request->request->get('idProyecto');
        $idtipoProyecto=$request->request->get('idtipoProyecto');
        $listaConcejales=$request->request->get('concejales');
        $listaBloques=$request->request->get('bloques');

        $visto=$request->request->get('visto');
        $considerando=$request->request->get('considerando');
        $quienSanciona=$request->request->get('quienSanciona');
        $articulos=json_decode($request->request->get('articulos'));
     
        $usuario=$this->getUser();

        $concejales=(($listaConcejales=='')?[]:explode(',',$listaConcejales));
        $bloques=(($listaBloques=''?[]:explode(',',$listaBloques));

        $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
        $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
        $tipoProyectoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoProyecto');
        $tipoProyecto=$tipoProyectoRepository->find($idtipoProyecto);
        $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
      
        $proyecto=$proyectoRepository->find($idProyecto);
        $proyecto->setTipoProyecto($tipoProyecto);
        $proyecto->setVisto($visto);
        $proyecto->setConsiderandos($considerando);
        $proyecto->setQuienSanciona($quienSanciona);

        $nuevosBloques=[];
        if(is_array($bloques)){
            foreach ($bloques as $bloque) {
                $bloque=$bloqueRepository->find($bloque);
                $nuevosBloques[]=$bloque;
            }
        }
        
        $proyecto->setBloques($nuevosBloques);

        $nuevosConcejales=[];
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
     *  @Rest\Post("/api/expediente/create")
     */
    public function crearExpedienteAction(Request $request)
    {   
        try{ 
            $idproyecto=$request->request->get('idProyecto'); 
            $folios=$request->request->get('folios');  
            $origen=$request->request->get('origen');
            $apellidosSiParticular=$request->request->get('apellidosSiParticular');
            $nombresSiParticular=$request->request->get('nombresSiParticular');           
            $numeroExpediente=$request->request->get('numeroExpediente');
            $idTipoExpediente=$request->request->get('selTipoExpediente');
            $caratula=$request->request->get('caratula');
            $archivos=$request->files->all();
            $usuario=$this->getUser();

            $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
            $tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
            $estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
            $estadoExpediente=$estadoExpedienteRepository->find(1);

            $expediente=new Expediente();
            $expediente->setFolios($folios);
            $expediente->setArchivos($archivos);
            $expediente->setNumeroExpediente($numeroExpediente);
            $expediente->setCaratula($caratula);

            $proyecto=null;
            $tipoExpediente=null;

            if($idproyecto!=0){
                $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
                $proyecto=$proyectoRepository->find($idproyecto);
                $expediente->setProyecto($proyecto);
            }

            if($proyecto==null)
                $tipoExpediente=$tipoExpedienteRepository->find($idTipoExpediente);
            else
                $tipoExpediente=$proyecto->getTipoProyecto()->getTipoExpediente();

            if ($origen==2){
                $expediente->setApellidosSiParticular($apellidosSiParticular);
                $expediente->setNombresSiParticular($nombresSiParticular);
            }

            $expediente->setTipoExpediente($tipoExpediente);
            $expediente->setUsuarioCreacion($usuario->getUsername());
            $expediente->setFechaCreacion(new \DateTime("now"));
            $expediente->setEstadoExpediente($estadoExpediente);

            $em = $this->getDoctrine()->getManager();
            $em->persist($expediente);
            $em->flush();

            return $this->view('El expediente '.$numeroExpediente.' se guardó en forma exitosa',200);

        }catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e){ 
            return $this->view('El expediente '.$numeroExpediente.' ya existe');
        
        }catch(\Exception $e){
            return $this->view($e->getMessage());            
        }

    }

    /**
     *  @Rest\Post("/api/expediente/update")
     */
    public function actualizarExpedienteAction(Request $request)
    {   
        try{
            $id=$request->request->get('id');
            $folios=$request->request->get('foliosMod'); 
            $origen=$request->request->get('origen');
            $apellidosSiParticular=$request->request->get('apellidosSiParticular-mod');
            $nombresSiParticular=$request->request->get('nombresSiParticular-mod');
            $numeroExpediente=$request->request->get('numeroExpedienteMod');
            $idTipoExpediente=$request->request->get('selTipoExpedienteMod');
            $caratula=$request->request->get('caratulaMod');

            // var_dump($request->request->all());
            // die();

            $archivos=$request->files->all();
            $usuario=$this->getUser();

            $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
            $tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
           
            $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
            $expediente=$expedienteRepository->find($id); 

            $expediente->setFolios($folios);
            $expediente->setArchivos($archivos);
            $expediente->setNumeroExpediente($numeroExpediente);
            $expediente->setCaratula($caratula);

            $proyecto=$expediente->getProyecto();
            $tipoExpediente=null;

            if($proyecto==null)
                $tipoExpediente=$tipoExpedienteRepository->find($idTipoExpediente);
            else
                $tipoExpediente=$proyecto->getTipoProyecto()->getTipoExpediente();

            if ($origen==2){
                $expediente->setApellidosSiParticular($apellidosSiParticular);
                $expediente->setNombresSiParticular($nombresSiParticular);
            }

            $expediente->setTipoExpediente($tipoExpediente);
            $expediente->setUsuarioModificacion($usuario->getUsername());
            $expediente->setFechaModificacion(new \DateTime("now"));

            $em = $this->getDoctrine()->getManager();
            $em->persist($expediente);
            $em->flush();

            return $this->view('El expediente '.$numeroExpediente.' se modificó en forma exitosa',200);

         }catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e){ 
            return $this->view('El expediente '.$numeroExpediente.' ya existe');

        }catch(\Exception $e){
            return $this->view($e->getMessage());
            
        }
    }

    /**
     *  @Rest\Post("/api/expediente/archivo/remove")
     */
    public function borrarArchivoAction(Request $request)
    { 
        
        try {
            $claveBorrado=$request->request->get("key");
            $usuario=$this->getUser();
            
            $stripPath=explode("/",$claveBorrado);

            $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
            $result=$expedienteRepository->searchByHashValue($stripPath[0]); 

            $expediente=$expedienteRepository->find($result["idExpediente"]);
            
            $expediente->setArchivoBorrado($stripPath[1]);

            $expediente->setUsuarioModificacion($usuario->getUsername());
            $expediente->setFechaModificacion(new \DateTime("now"));

            $em = $this->getDoctrine()->getManager();
            $em->persist($expediente);
            $em->flush();

            return $this->view('La imagen se eliminó en forma exitosa',200);   
            
        } catch (Exception $e) {
            return $this->view($e->getMessage());
            
        }
    }

    /**
     *  @Rest\Post("/api/usuario/create")
     */
    public function crearUsuarioAction(Request $request)
    {   
        

            $idTipoPerfil=$request->request->get('selTipo');
            $apellidos=$request->request->get('apellidos');
            $nombres=$request->request->get('nombres');
            $login=$request->request->get('login');
            $idRol=$request->request->get('selRol');
            $clave=$request->request->get('clave');
            $eMail=$request->request->get('eMail');
            $telefono=$request->request->get('telefono');
            $oficina=$request->request->get('oficina');
            $domicilio=$request->request->get('domicilio');
            $documento=$request->request->get('documento');
            $idBloque=$request->request->get('selBloque');
            $idPerfil=$request->request->get('selLegislador');
            $archivos=$request->files->all();
            $usuarioSesion=$this->getUser();

        try{

            $perfil=null;

            if ($idTipoPerfil==2){
                $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
                $perfil=$perfilRepository->find($idPerfil);
            }
            else {
                    if($idTipoPerfil==1){
                        $perfil=new Perfil();
                    }
                    if($idTipoPerfil==2){
                        $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
                        $perfil=$perfilRepository->find($idBloque);
                    }
                    if($idTipoPerfil==3){
                        $perfil=new PerfilPublico();
                        $perfil->setDocumento($documento);
                        $perfil->setDomcilio($domicilio);
                    }

                    $perfil->setApellidos($apellidos);
                    $perfil->setNombres($nombres);
                    $perfil->setTelefono($telefono);
                    $perfil->setCorreoElectronico($eMail);
                    $perfil->setUsuarioCreacion($usuarioSesion->getUsername());
                    $perfil->setFechaCreacion(new \DateTime("now"));


                    if(count($archivos)>0){
                        $perfil->setArchivo($archivos["uploadedFiles-0"]);
                        $perfil->setPrefijo($usuarioSesion->getUsername());
                    }
                }

            $rolRepository=$this->getDoctrine()->getRepository('AppBundle:Rol');
            $rol=$rolRepository->find($idRol);

            $usuario=new Usuario();
            $usuario->setUsuario($login);
            $usuario->setFechaCreacion(new \DateTime("now"));
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($usuario, $clave);
            $usuario->setClave($encoded);
            $usuario->setRol($rol);
            $usuario->setPerfil($perfil);
            $usuario->setUsuarioCreacion($usuarioSesion->getUsername());

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->view('El usuario se guardo en forma exitosa',200);

        }catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e){ 
                $mensaje='';
                $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
                if ($idTipoPerfil==2 && !is_null($idPerfil) &&
                    $perfilRepository->perfilPoseeUsuario($idPerfil))
        
                    $mensaje='El legislador ya posee un usuario';
                else
                     $mensaje='El nombre de usuario ya existe';

                return $this->view($mensaje,500);
        }
        catch(\Exception $e){
             return $this->view($e->getMessage());
        }
    }

     /**
     *  @Rest\get("/api/roles/getByTipoPerfil/{idTipoPerfil}")
     */
     public function traerRolesPorPerfilAction(Request $request)
     {

         $idTipoPerfil=$request->get('idTipoPerfil');
         $tipoPerfilRepository=$this->getDoctrine()->getRepository('AppBundle:TipoPerfil');
         $tipoPerfil=$tipoPerfilRepository->find($idTipoPerfil);

         return $this->view($tipoPerfil,200);
     }

    /**
     *  @Rest\Post("/api/usuario/perfil/update")
     */
     public function actualizarPerfilAction(Request $request)
    {   
        try {
                $id=$request->request->get('id');
                $apellidos=$request->request->get('apellidosMod');
                $nombres=$request->request->get('nombresMod');
                $idRol=$request->request->get('selRolMod');
                $conservarClave=$request->request->get('conservaContraseña');
                $clave=$request->request->get('claveMod');
                $eMail=$request->request->get('eMailMod');
                $telefono=$request->request->get('telefonoMod');
                $oficina=$request->request->get('oficinaMod');
                $domicilio=$request->request->get('domicilioMOd');
                $documento=$request->request->get('documentoMod');
                $idBloque=$request->request->get('selBloqueMod');
                $archivos=$request->files->all();
                $usuarioSesion=$this->getUser();

                $em = $this->getDoctrine()->getManager();
             
                $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
                $usuario=$usuarioRepository->find($id);
                $rolRepository=$this->getDoctrine()->getRepository('AppBundle:Rol');
                $rol=$rolRepository->find($idRol);



                $perfil=$usuario->getPerfil();

                if($perfil instanceof PerfilLegislador){

                    if($perfil instanceof PerfilPublico){

                        $perfil->setDocumento($documento);
                        $perfil->setDomcilio($domicilio);
                    }

                    $perfil->setApellidos($apellidos);
                    $perfil->setNombres($nombres);
                    $perfil->setTelefono($telefono);
                    $perfil->setCorreoElectronico($eMail);
                    $perfil->setUsuarioModificacion($usuarioSesion->getUsername());
                    $perfil->setFechaModificacion(new \DateTime("now"));

                    if(count($archivos)>0){
                        $perfil->setArchivo($archivos["uploadedFiles-0"]);
                        $perfil->setPrefijo($usuarioSesion->getUsername());
                    }
                }
                 
                if($conservarClave==false){
                    $encoder = $this->container->get('security.password_encoder');
                    $encoded = $encoder->encodePassword($usuario, $clave);
                    $usuario->setClave($encoded);
                }

                $usuario->setRol($rol);
                $usuario->setPerfil($perfil);
                $usuario->setUsuarioModificacion($usuarioSesion->getUsername());
                $usuario->setFechaModificacion(new \DateTime("now"));

                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $em->flush();

                return $this->view('La modificacion del usuario se realizó con éxito',200);
            }
            catch(\Exception $e){
                return $this->view($e->getMessage());
            }
    }

    /**
     *  @Rest\Post("/api/perfilLegislador/create")
     */
    public function crearLegisladorAction(Request $request)
    {   
        try{

            $apellidos=$request->request->get('apellidos');
            $nombres=$request->request->get('nombres');
            $eMail=$request->request->get('eMail');
            $telefono=$request->request->get('telefono');
            $oficina=$request->request->get('oficina');
            $idBloque=$request->request->get('selBloque');
            $desde=$request->request->get('desde');
            $hasta=$request->request->get('hasta');
            $archivos=$request->files->all();
            $usuarioSesion=$this->getUser();

            $legislador=new PerfilLegislador();
            $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
            $bloque=$bloqueRepository->find($idBloque);
            $legislador->setBloque($bloque);
            $legislador->setOficina($oficina);
            $legislador->setApellidos($apellidos);
            $legislador->setNombres($nombres);
            $legislador->setTelefono($telefono);
            $legislador->setCorreoElectronico($eMail);
            $fechaDesde=\DateTime::createFromFormat('d/m/Y', $desde);
            $legislador->setDesde($fechaDesde);
            $fechaHasta=\DateTime::createFromFormat('d/m/Y', $hasta);
            $legislador->setHasta($fechaHasta);
            $legislador->setUsuarioCreacion($usuarioSesion->getUsername());
            $legislador->setFechaCreacion(new \DateTime("now"));

            if(count($archivos)>0){
                $legislador->setArchivo($archivos["uploadedFiles-0"]);
                $legislador->setPrefijo($usuarioSesion->getUsername());
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($legislador);
            $em->flush();

            return $this->view('El legislador: '.$legislador->getNombreCompleto().', se guardo en forma exitosa',200);
        }
        catch(\Exception $e){
             return $this->view($e->getMessage());
        }
    }

    /**
     *  @Rest\Post("/api/perfilLegislador/update")
     */     
     public function actualizarLegisladorAction(Request $request)
    {   
        try {
                $id=$request->request->get('id');
                $apellidos=$request->request->get('apellidos');
                $nombres=$request->request->get('nombres');
                $eMail=$request->request->get('eMail');
                $telefono=$request->request->get('telefono');
                $oficina=$request->request->get('oficina');
                $idBloque=$request->request->get('selBloque');
                $desde=$request->request->get('desde');
                $hasta=$request->request->get('hasta');
                $archivos=$request->files->all();
                $usuarioSesion=$this->getUser();

                $em = $this->getDoctrine()->getManager();
             
                $legisladorRepository=$this->getDoctrine()->getRepository('AppBundle:PerfilLegislador');
                $legislador=$legisladorRepository->find($id);
                $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
                $bloque=$bloqueRepository->find($idBloque);
                $legislador->setBloque($bloque);
                $legislador->setOficina($oficina);
                $legislador->setApellidos($apellidos);
                $legislador->setNombres($nombres);
                $legislador->setTelefono($telefono);
                $legislador->setCorreoElectronico($eMail);
                $fechaDesde=\DateTime::createFromFormat('d/m/Y', $desde);
                $legislador->setDesde($fechaDesde);
                $fechaHasta=\DateTime::createFromFormat('d/m/Y', $hasta);
                $legislador->setHasta($fechaHasta);
                $legislador->setUsuarioModificacion($usuarioSesion->getUsername());
                $legislador->setFechaModificacion(new \DateTime("now"));

                if(count($archivos)>0){
                    $legislador->setArchivo($archivos["uploadedFiles-0"]);
                    $legislador->setPrefijo($usuarioSesion->getUsername());
                }
                 
                $em = $this->getDoctrine()->getManager();
                $em->persist($legislador);
                $em->flush();

                return $this->view('La modificacion del usuario: '.$legislador->getNombreCompleto().' se realizó con éxito',200);
            }
            catch(\Exception $e){
                return $this->view($e->getMessage());
            }   
    }

    /**
     * @Rest\Post("/api/perfil/imagen/remove")
     */
    public function borrarImagenAction(Request $request)
    {
        $key=$request->request->get("key");
        if($key!="no-unlink-preview"){

            $stripPath=explode("/",$key);
            $claveBorrado=$stripPath[2];
            $usuarioSesion=$this->getUser();

            

            $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
            $perfil=$perfilRepository->findOneBy(array('imagen'=>$claveBorrado));
            $perfil->setBorrarImagen();

            $perfil->setUsuarioModificacion($usuarioSesion->getUsername());
            $perfil->setFechaModificacion(new \DateTime("now"));
        

            $em = $this->getDoctrine()->getManager();
            $em->persist($perfil);
            $em->flush();
        }
    }

    /**
     * @Rest\Put("/api/usuario/estado/{id}/{estado}")
     */
    public function cambiarEstadoAction(Request $request){

        try{
            $id=$request->get('id');
            $estado=$request->get('estado');

            $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
            $usuario=$usuarioRepository->find($id);
            $mensaje='El usuario '.$usuario->getUsuario().' se '.(($estado==0)?'desactivó':'activó').' con exito';

            $usuario->setActivo($estado);

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->view($mensaje,200);
        }
        catch(\Exception $e){
            return $this->view($e->getMessage());
        }
    }

    /**
     *  @Rest\Get("/api/session/getId")
     */
    public function getSessionIdAction(Request $request)
    {   
        
        $seccion=$request->query->get('seccion');
        $session = $this->get('session');

        $administracionSesion = new AdministracionSesion();
        $administracionSesion->setId($session->getId());
        $administracionSesion->setSectionId($seccion);
        $administracionSesion->setElementId(5);
        $administracionSesion->setTimeId(1);

        $em=$this->get('doctrine')->getManager('sqlite');
        $em->persist($administracionSesion);
        $em->flush();

        return $this->view($administracionSesion,200);

    }


    /**
     *  @Rest\Get("/api/sesion/traerAccion")
     */
    public function traerAccionIdAction(Request $request)
    {   
        return $this->view($this->getUser(),200);
    
        /*
        $mensaje;
        $session = $this->get('session');
        $administracionSesionRepository=$this->get('doctrine')->getRepository('AssistBundle:AdministracionSesion', 'sqlite');
        $id=$session->getId();
        $administracionSesion=$administracionSesionRepository->findOneBy(array('id' => $id));

        if(is_null($administracionSesion)){
            $administracionSesion = new AdministracionSesion();
            $administracionSesion->setId($id);
            $administracionSesion->setSectionId(0);
            $administracionSesion->setElementId(0);
            $administracionSesion->setTimeId(0);
            $mensaje='crea nuevo';
        }
        else{
            $em=$this->get('doctrine')->getManager('sqlite');
            $em->remove($administracionSesion);
            $em->flush();
            $mensaje='borrar existente';
        }

        return $this->view($administracionSesion,200);
*/
    }

    /**
     *  @Rest\Get("/api/ejemplo/{id}")
     */
    public function ejemploAction(Request $request){

        $id=$request->get('id');
        $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
        $usuario=$usuarioRepository->perfilPoseeUsuario($id);



        return $this->view($usuario,200);

    
    }


}