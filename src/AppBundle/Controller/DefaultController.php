<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use twig\twig;

use AppBundle\Entity\Bloque;
use AppBundle\Entity\Comision;
use AppBundle\Entity\ExpedienteComision;
use AppBundle\Entity\Oficina;
use AppBundle\Entity\Proyecto;
use AppBundle\Entity\Rol;
use AppBundle\Entity\Sesion;
use AppBundle\Entity\TipoExpedienteSesion;
use AppBundle\Entity\TipoSesion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Services\ImpresionServicio;


class DefaultController extends Controller
{
    
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $version=$this->getParameter('project_version'); 

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'version'       =>$version
        ));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {    }

    /**
     * @Route("/accessDenied", name="accessDenied")
     */
    public function accessDeniedAction()
    {  
        return $this->render('error/accesoDenegado.html.twig');

    }
    
    /**
     * @Route("/cambioClave", name="cambioClave")
     */
    public function cambioClaveAction(Request $request)
    {
    	return $this->render('default/cambioClave.html.twig',
    			array('base_dir'=>realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR));
    }
    
    /**
     * @Route("/renovarClave", name="renovarClave")
     * @Method("POST")
     */
    public function renovarClaveAction(Request $request){
    	
    	$mail=$request->request->get("loginEmail");
    	$PerfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
    	$perfil=$PerfilRepository->findOneBy(array('correoElectronico'=>$mail));
    	$usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
    	$usuario=$usuarioRepository->findOneBy(array('perfil'=>$perfil));
    	    	
    	if (!is_null($usuario)){
    		   		
    		$randomString=$this->get('utilidades_servicio')->randomString();
	    	$encoder = $this->container->get('security.password_encoder');
	    	$encoded = $encoder->encodePassword($usuario, $randomString);
	    	$usuario->setClave($encoded);
	    	
	    	$em = $this->getDoctrine()->getManager();
	    	$em->persist($usuario);
	    	$em->flush();

	    	$message = \Swift_Message::newInstance()
	    	->setSubject('Sisleg Reseteo de Clave')
	    	->setFrom('administrador@sisleg.com')
	    	->setTo($mail)
	    	->setBody($this->renderView(
						    			'default/recrearClave.html.twig',
	    								array('nuevaClave' => $randomString)
						    			),
					 'text/html'
	    			 );
	    	$this->get('mailer')->send($message);
	    	
	    	$version=$this->getParameter('project_version');
	    	$authenticationUtils = $this->get('security.authentication_utils');
	    	$lastUsername = $authenticationUtils->getLastUsername();
	    	    	
	    	return $this->render('security/login.html.twig', array(
	    			'last_username' => $lastUsername,
	    			'otherSuccess'  => 'La clave se renovó con exito, consulte el mail que registró en el sistema',
	    			'version'       =>$version
	    	));
    	}
    	else{
	    		$version=$this->getParameter('project_version');
	    		$authenticationUtils = $this->get('security.authentication_utils');
	    		$lastUsername = $authenticationUtils->getLastUsername();
	    			    		
	    		return $this->render('security/login.html.twig', array(
				    				 'last_username' => $lastUsername,
	    							 'otherError' => 'El mail proporcionado no se encuentra registrado',
				    				 'version'       =>$version
				    		        ));
    	}
    		
    }
    
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
 		return $this->render('default/index.html.twig', 
 							array('base_dir'=>realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR));
    }

    /**
     * @Route("/usuarios", name="usuarios")
     */
    public function usuarioAction(Request $request)
    {
        $rolRepository=$this->getDoctrine()->getRepository('AppBundle:Rol');
        $roles=$rolRepository->findAll();
        $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
        $usuarios=$usuarioRepository->findAll();
        $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
        $bloques=$bloqueRepository->findAll();
             
        $data=[];       
        $data['base_dir']=realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR;
        $data['roles']=$roles;
        $data['usuarios']=$usuarios;
        $data['bloques']=$bloques;
        $data['status']='render';
        return $this->render('default/usuario.html.twig', $data);
         
    }

    /**
     * @Route("/legisladores", name="legisladores")
     */
    public function legisladoresAction(Request $request)
    {
        $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
        $bloques=$bloqueRepository->findBy(array(), array('bloque' => 'ASC'));
     
        return $this->render('default/legisladores.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'bloques' => $bloques));
         
    }

    /**
     * @Route("/proyectos", name="proyectos")
     */
    public function proyectoAction(Request $request)
    {
        $tiposProyectoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoProyecto');
        $tiposProyecto=$tiposProyectoRepository->findBy(array(),array('tipoProyecto' => 'ASC') );
        $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
        $bloques=$bloqueRepository->findBy(array(),array('bloque' => 'ASC') );
        $estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
        $estadosExpediente=$estadoExpedienteRepository->findBy(array(),array('estadoExpediente' => 'ASC') );
       
        return $this->render('default/proyecto.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'tipos' => $tiposProyecto,'estados'=>$estadosExpediente,'bloques'=>$bloques
        ));
         
    }

    /**
     * @Route("/expedientes", name="expedientes")
     */
    public function expedienteAction(Request $request)
    {
        $tiposExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
        $estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
        $tipoOficinaRepository=$this->getDoctrine()->getRepository('AppBundle:TipoOficina');
        $oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
        $tipoSesionRepository=$this->getDoctrine()->getRepository('AppBundle:TipoSesion');
        $sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
        $idOficinaExterna=$this->getParameter('id_oficina_externa');
        
        $tiposExpediente=$tiposExpedienteRepository->findBy(array(),array('tipoExpediente' => 'ASC'));
        $estadosExpediente=$estadoExpedienteRepository->findBy(array(),array('estadoExpediente' => 'ASC'));
        $tipoOficinaExterna=$tipoOficinaRepository->find($idOficinaExterna);
        $oficinasExternas=$oficinaRepository->findBy(array('tipoOficina' => $tipoOficinaExterna)); 
        $años=$sesionRepository->findByDistinctPeriodos();
        
        $array=[];
        $array['base_dir']=realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR;
        $array['tipos']=$tiposExpediente;
        $array['estados']=$estadosExpediente;
        $array['oficinasExternas']=$oficinasExternas;
        $array['tiposSesion']=$tipoSesionRepository->findAll();
        $array['años']=$años;
        return $this->render('default/expediente.html.twig', $array);
    }
    
    /**
     * @Route("/expedientesComisiones", name="expedientesComisiones")
     */
    public function expedientesComisionesAction(Request $request)
    {
    	$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    	$tipoProyectoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoProyecto');
    	$tipoSesionRepository=$this->getDoctrine()->getRepository('AppBundle:TipoSesion');
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	
    	$años=$sesionRepository->findByDistinctPeriodos();
    	$comisiones=$comisionRepository->findBy(array('activa' => true));
    	$tipoProyectos=$tipoProyectoRepository->findAll();
    	return $this->render('default/expedientes_comisiones.html.twig',array(
    		   'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    		   'comisiones' => $comisiones, 'tipoProyectos'=> $tipoProyectos,
    		   'años'=>$años,
    		   'MAYORIA' => $this->getParameter('dictaminantes_en_mayoria'),
    		   'PRIMERA_MINORIA' => $this->getParameter('dictaminantes_en_primer_minoria'),
    		   'SEGUNDA_MINORIA' => $this->getParameter('dictaminantes_en_segunda_minoria'),
    		   'tiposSesion'=>$tipoSesionRepository->findAll()
    	));
    }
    
    
    /**
     * @Route("/seleccionSesion", name="seleccionSesion")
     */
    public function seleccionSesionAction(Request $request)
    {
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$años=$sesionRepository->findByDistinctPeriodos(true);
    	
    	return $this->render('default/seleccion_sesion.html.twig',array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    			'años'=> $años
    	));
    }
    
    /**
     * @Route("/expedientesOrdenDia", name="expedientesOrdenDia")
     */
    public function traerExpedientesOrdenDiaAction(Request $request)
    {
    	$idSesion=$request->query->get('idSesion');
    	$tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
    	$tipoProyectoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoProyecto');
    	$tipoExpedienteSesionRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpedienteSesion');
    	$tipoOficinaRepository=$this->getDoctrine()->getRepository('AppBundle:TipoOficina');
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    	$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	
    	$tipoOficina=$tipoOficinaRepository->find(2);
    	$oficinas=$oficinaRepository->findBy(array('tipoOficina' => $tipoOficina));
    	$tiposExpediente=$tipoExpedienteRepository->findAll();
    	$tiposExpedienteSesion=$tipoExpedienteSesionRepository->findAll();
    	$tiposProyecto=$tipoProyectoRepository->findAll();
    	$comisiones=$comisionRepository->findAll();
    	$sesion=$sesionRepository->find($idSesion);
    	$años=$sesionRepository->findByDistinctPeriodos();
    	
    	$nombreSesion=$sesion->getFechaFormateada().' ( '.($sesion->getTipoSesion()->getTipoSesion()).' )';
    	return $this->render('default/expedientes_orden_dia.html.twig',array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    			'tiposExpediente'=> $tiposExpediente, 'tiposExpedienteSesion'=>$tiposExpedienteSesion,
    			'idSesion'=>$idSesion, 'nombreSesion'=>$nombreSesion, 'años'=>$años,
    			'permiteEdicion'=>(($sesion->getTieneEdicionBloqueada()==true)?0:1),
    			'tiposProyecto'=>$tiposProyecto, 'comisiones'=>$comisiones,
    			'oficinas'=>$oficinas, 
    	));
    }
    
    /**
     * @Route("/impresionE", name="impresionE")
     */
    public function impresionEAction(Request $request)
    {
    	return $this->render('default/impresion_e.html.twig',array(
    						 'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR));
    }
    
    /**
     * @Route("/movimientos", name="movimientos")
     */
    public function movimientosAction(Request $request)
    {
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    	$tipoOficinaRepository=$this->getDoctrine()->getRepository('AppBundle:TipoOficina');
    	$idOficinaInterna=$this->getParameter('id_oficina_interna');
    	$tipoOficina= $tipoOficinaRepository->find($idOficinaInterna);
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    	$tipoMovimientoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoMovimiento');
    	$comisionesRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    	
    	$usuario=$this->getUser();
    	$oficinaUsuario=$usuario->getRol()->getOficina();
    	$idMesaEntradas=$this->getParameter('id_mesa_entradas');
    	$oficinas=null;
    	$tiposMovimientos=null;    	
    	
    	if ($oficinaUsuario!=null && $oficinaUsuario->getId()!=$idMesaEntradas){
    		$oficinas=$oficinaRepository->findBy(array('tipoOficina' => $tipoOficina));
    		$tiposMovimientos=$tipoMovimientoRepository->findBy(array('tipoMovimiento' => 'Pase'));
    		$muestra_comisiones=0;
    		$muestra_remitos=0;
    	}
    	else{
    		$oficinas=$oficinaRepository->findAll();
    		$tiposMovimientos=$tipoMovimientoRepository->findAll();
    		$muestra_comisiones=1;
    		$muestra_remitos=1;
    	}
  
    	$movimientosCompletosHTML="";
    	foreach ($tiposMovimientos as $tipoMovimiento){
    		$movimientosCompletosHTML.="<option value='".$tipoMovimiento->getId().
    		"'>".$tipoMovimiento->getTipoMovimiento().
    		"</option>";
    	}
    	
    	$movimientoPase=$tipoMovimientoRepository->findBy(array('tipoMovimiento' => 'Pase'));
    	foreach ($movimientoPase as $tipoMovimiento){
    		$movimientosPaseHTML="<option value='".$tipoMovimiento->getId().
    		"' selected>".$tipoMovimiento->getTipoMovimiento().
	    	"</option>";
    	}
    	
    	$comisiones=$comisionesRepository->findAll();
    	$comisionesHTML="";
    	foreach ($comisiones as $comision){
    		$comisionesHTML.="<option value='".$comision->getId().
    		"'>".$comision->getComision().
    		"</option>";
    	}
    	
    	return $this->render('default/movimientos.html.twig', array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    			'oficinas' => $oficinas, 'movimientosCompletos' => $movimientosCompletosHTML,
    			'movimientoPase' => $movimientosPaseHTML, 'comisiones' => $comisionesHTML,
    			'muestra_comisiones' => $muestra_comisiones,'muestra_remitos' => $muestra_remitos
    	));
    	
    }

    /*
     *  @Route("/mail")
     *
    public function traerMailAction(Request $request)
    {
        $idProyecto=$request->query->get("idProyecto");
        // $idProyecto=$request->request->get("idProyecto");
        $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
        $proyecto=$proyectoRepository->find($idProyecto);


        $subject=$proyecto->getTipoProyecto()->getTipoProyecto().' - '.substr($proyecto->getAsuntoSinHtml(),0,20).'...';
        $articulos=$proyecto->getArticulos();

        var_dump($articulos);
        die();

        $quienSanciona=($proyecto->getQuienSanciona()==1)
            ?'<p class="ident"><strong>EL HONORABLE CONCEJO DELIBERANTE EN USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA LA SIGUIENTE:</strong></p>'
            :'<p class="ident"><strong>EL SR. PRESIDENTE DE ESTE HONORABLE CONCEJO DELIBERANTE, EN USO DE ATRIBUCIONES QUE LE SON PROPIAS, SANCIONA LA SIGUIENTE:</strong></p>';

        $htmlArticulos='';//<ul style="list-style-type: none;">';
        
        foreach ($articulos as $articulo) {
             $htmlArticulos.='<strong><u>Artículo '.$articulo['numero'].'°</u>.- </strong>'.str_replace('</p>', '<br>',strip_tags($articulo['texto'],'</p>'));
            if(count($articulo['incisos'])>0){
                //recordar setear ul{list-style-type: none;}
                $htmlArticulos.='<ul style="list-style-type: none;">';
                foreach ($articulo['incisos'] as $inciso) {
                    $htmlArticulos.='<li>'.$inciso['orden'].' '.strip_tags($inciso['texto'],'<br>').'</li>';
                }
                $htmlArticulos.='</ul>';
            }
            //$htmlArticulos.='</li>';
        }

        $htmlArticulos.='</ul>';

        return $this->render('emails/notificacionProyecto.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'asunto' => strip_tags($proyecto->getAsunto(),'<p>'),
            'visto'=>str_replace('<p>','<p class="ident">',strip_tags($proyecto->getVisto(),'<p>')),
            'considerando'=>str_replace('<p>','<p class="ident">',strip_tags($proyecto->getConsiderandos(),'<p>')),
            'articulos'=>$htmlArticulos,
            'tipo'=>$proyecto->getTipoProyecto()->getTipoProyecto(),
            'quienSanciona'=>$quienSanciona
        ));
    }*/

     /**
     * @Route("/comisiones", name="Comisiones")
     */
    public function comisionAction(Request $request)
    {
    	$tipoComisionRepository=$this->getDoctrine()->getRepository('AppBundle:TipoComision');
    	$tiposComision=$tipoComisionRepository->findAll();
    	return $this->render('default/comision.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    		'tiposComision'=>$tiposComision
        ));   
    }
    
    /**
     * @Route("/bloques", name="bloques")
     */
    public function bloquesAction(Request $request)
    {
    	return $this->render('default/bloques.html.twig', array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR
    	));  
    }
    
    /**
     * @Route("/oficinas", name="oficinas")
     */
    public function oficinasAction(Request $request)
    {
    	$tipoOficinaRepository=$this->getDoctrine()->getRepository('AppBundle:TipoOficina');
    	$tiposOficina=$tipoOficinaRepository->findAll();
    	return $this->render('default/oficinas.html.twig', array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    			'tiposOficina'=>$tiposOficina
    	));
    }
    
    /**
     * @Route("/listadoCh", name="listadoCH")
     */
    public  function listadoCH(Request $request)
    {	
    	$idTipoOficina=$this->getParameter('id_oficina_externa');
    	$tipoOficinaRepository=$this->getDoctrine()->getRepository('AppBundle:TipoOficina');
    	$tipoOficina=$tipoOficinaRepository->find($idTipoOficina);
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    	$oficinas=$oficinaRepository->findBy(array('tipoOficina'=>$tipoOficina));
    	$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    	$comisiones=$comisionRepository->findAll();
    	return $this->render('default/listado_ch.html.twig', array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    			'destinos'=>$oficinas,'comisiones'=>$comisiones
    	));
    }
    
    /**
     * @Route("/versionesTaquigraficas", name="versionesTaquigraficas")
     */
    public function versionesTaquigraficasAction(Request $request)
    {
    	return $this->render('default/versiones_taquigraficas.html.twig', array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR
    	));
    }
    
    /**
     * @Route("/votacion")
     */
    public function votacionAction(Request $request){

        return $this->render('base_session.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR
        ));

    }
    
    /**
     * @Route("/sesion", name="sesiones")
     */
    public function sesionAction(Request $request){
    	
    	$tipoSeionRepository=$this->getDoctrine()->getRepository('AppBundle:TipoSesion');
    	$tiposSesion=$tipoSeionRepository->findAll();
    	
    	return $this->render('default/sesion.html.twig', array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    			'tiposSesion' => $tiposSesion
    	));
    }
        
    /**
     * @Route("/imprimirOrdenDelDia")
     */
    public function imprimirOrdenDelDiaAction(Request $request){
    	
    	$idSesion = $request->query->get('idSesion');
    	$tipo = $request->query->get('tipo');
    	
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesion=$sesionRepository->find($idSesion);
    	$tipoSesion=$sesion->getTipoSesion()->getTipoSesion();
    	$tipoExpedienteSesionRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpedienteSesion');
    	$servicioImpresion=$this->get('impresion_servicio');
    	$tiposExpedientesSesion=[];
    	
    	if ($tipo=='OD')
    		$tiposExpedientesSesion=$tipoExpedienteSesionRepository->findAll();
    	else 
    		$tiposExpedientesSesion=$tipoExpedienteSesionRepository->findBy(array('letra'=>'U'));
    	
    	//fecha de la sesion
    	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    	$fecha=$sesion->getFecha()->format('d')." de ".$meses[$sesion->getFecha()->format('n')-1].
    	" de ".$sesion->getFecha()->format('Y') ;
    	//url base
    	$base=$request->getSchemeAndHttpHost().$request->getBasePath();
    	   	
    	//crea el word
    	$word = $servicioImpresion->getTemplateOD();
    	
     	//caratula
     	$page=$servicioImpresion->getPage($word,'Legal');
     	$page=$servicioImpresion->writeHTMLToPage('<p></p><p></p><p></p>', $page);
     	$page=$servicioImpresion->addImageToPage($base.'/document_bootstrap/portada_orden_dia.png', $page);
     	$nombreDocumento=(($tipo=='OD')?'Orden del Día':'Último Momento');
     	$html='<p></p><p></p><p></p><h1><strong>SESIÓN '.(($tipoSesion=='Mayores Contribuyentes')?'DE ':'').
     		  strtoupper($tipoSesion	).' A CELEBRARSE EL DÍA '.
     		  strtoupper($fecha).'</strong></h1><p></p><p></p><p></p><p></p><h2><strong>'.
     		  strtoupper($nombreDocumento).'</strong></h2>';
     	$page=$servicioImpresion->writeHTMLToPage($html, $page,1);
     
     	
     	//primer página
     	$page = $servicioImpresion->getPage($word,'Legal');
     	//encabezado de primer página
     	$page=$servicioImpresion->setHeader($page, $base.'/document_bootstrap/header_concejo.png');
          	 
     	if ($tipo=='OD'){
     		
	     	//encabezado de comunicaciones de la presidencia
	     	$html='<h3><strong>I) COMUNICACIONES DE PRESIDENCIA</strong></h3><p></p><p></p><p></p>';
	     	//encabezado de versiones taquigráficas
	     	$html.='<h3><strong>II) VERSIONES TAQUIGRÁFICAS</strong></h3>';
	     	//contenido de versiones taquigráficas
	     	$content=$sesionRepository->findVersionesTaquigraficasBySesion($idSesion);
	     	$html.=$content[0]["versiones"];
	     	$page=$servicioImpresion->writeHTMLToPage($html, $page,1);
     	}
	     	
     	$apartadoInicial=true;
     				
     	//reporte para cada apetado de la orden del día
     	foreach ($tiposExpedientesSesion as $tipoExpedienteSesion){
     				
     		if ($tipo=='OD' && $tipoExpedienteSesion->getLetra()=='U')
     			continue;
     		
     		$content=$sesionRepository->findOrdenDiaBySesionYApartado($idSesion, $tipoExpedienteSesion->getId());
     		$html="";
     		
     		if (count($content)>0){
     			
     			//nueva pagina del apartado
     			$page=$servicioImpresion->getPage($word, 'Legal',1);
     			//header de la nueva página del apartado
     			$page=$servicioImpresion->setHeader($page, $base.'/document_bootstrap/header_concejo.png');
     			//footer de la nueva página del apartado
     			$textoFooter=$tipoExpedienteSesion->getLetra(). ').- {PAGE}';
     			$page=$servicioImpresion->setFooter($page, $textoFooter);
     			
     			//texto del apartado
     			if ($apartadoInicial==true && $tipo=='OD'){
     				$html='<h3><strong>IV) ASUNTOS ENTRADOS</strong></h3>';
     				$apartadoInicial=false;
     			}
     			$html.='<h4><strong>'.$tipoExpedienteSesion->getLetra().') '.
       			$tipoExpedienteSesion->getTipoExpedienteSesion().'</strong></h4>';
       			$html.=($content[0]["textoApartado"]);
       			       			
       			$page=$servicioImpresion->writeHTMLToPage($html, $page,1);				   		
     		}			   	
     	}
         	     	
     	return $servicioImpresion->getArchivoOD($word, $fecha, $tipo, $nombreDocumento);
    }
        
    /**
     * @Route("/imprimirDictamen")
     */
    public function imprimirDictamenAction(Request $request){
    	
    	$idDictamen = $request->query->get('idDictamen');
    	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    	$servicioImpresion=$this->get('impresion_servicio');
    	
    	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    	
    	$fechaActual=new \DateTime('now');
    	
    	$fecha=$fechaActual->format('d')." de ".$meses[$fechaActual->format('n')-1].
    	" de ".$fechaActual->format('Y') ;
  
    	//url base
    	$base=$request->getSchemeAndHttpHost().$request->getBasePath();
    	
    	//crea el word
    	$word = $servicioImpresion->getTemplateOD();
    	$page=$servicioImpresion->getPage($word, 'Legal');
    	$page=$servicioImpresion->setHeader($page,  $base.'/document_bootstrap/header_concejo.png');
    	
    	$content=$expedienteComisionRepository->traerTextoDictamen($idDictamen);
    	$html.=($content[0]["textoDictamen"]);
    	$page=$servicioImpresion->writeHTMLToPage($html, $page);
    	$expediente=$content[0]["expediente"];
    	$comisiones=$content[0]["comisiones"];
    	
    	return  $servicioImpresion->getArchivoDictamen($word, $fecha, $expediente, $comisiones);	
    }
    
    /**
     * @Route("/imprimirSancion")
     */
    public function imprimirSancionAction(Request $request){
    	
    	$idSancion = $request->query->get('idSancion');
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$servicioImpresion=$this->get('impresion_servicio');
    	
    	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    	
    	$fechaActual=new \DateTime('now');
    	
    	$fecha=$fechaActual->format('d')." de ".$meses[$fechaActual->format('n')-1].
    	" de ".$fechaActual->format('Y') ;
    	
    	//url base
    	$base=$request->getSchemeAndHttpHost().$request->getBasePath();
    	
    	//crea el word
    	$word = $servicioImpresion->getTemplateOD();
    	$page=$servicioImpresion->getPage($word, 'Legal');
    	$page=$servicioImpresion->setHeader($page,  $base.'/document_bootstrap/header_concejo.png');
    	
    	$content=$sesionRepository->traerTextoSancion($idSancion);
    	$html.=($content[0]["textoSancion"]);
    	$page=$servicioImpresion->writeHTMLToPage($html, $page);
    	$firmaSecretario=$content[0]["firmaSecretario"];
    	$firmaPresidente=$content[0]["firmaPresidente"];
    	$page=$servicioImpresion->addsignatureSancion($page, $base.'/document_bootstrap/escudo.png',
    												  $firmaSecretario, $firmaPresidente);
    	$expediente=$content[0]["expediente"];
    	$numeroSancion=$content[0]["numeroSancion"];
    	
    	return  $servicioImpresion->getArchivoSancion($word, $fecha, $expediente, $numeroSancion);	
    	    	
    }
    
    /**
     * @Route("/imprimirProyecto")
     */
    public function imprimirProyectoAction(Request $request){
    	
    	$idProyecto = $request->query->get('idProyecto');   	
    	$proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
    	$servicioImpresion=$this->get('impresion_servicio');
    	
    	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    	$fechaActual=new \DateTime('now');
    	$fecha=$fechaActual->format('d')." de ".$meses[$fechaActual->format('n')-1].
    	" de ".$fechaActual->format('Y') ;
    	
    	//url base
    	$base=$request->getSchemeAndHttpHost().$request->getBasePath();
    	
    	//crea el word
    	$word = $servicioImpresion->getTemplateOD();
    	$page=$servicioImpresion->getPage($word, 'Legal');
    	$page=$servicioImpresion->setHeader($page,  $base.'/document_bootstrap/header_concejo.png');
    	
    	$content=$proyectoRepository->traerProyectoParaImpresion($idProyecto);
    	$html.=($content[0]["textoProyecto"]);
    	$page=$servicioImpresion->writeHTMLToPage($html, $page);
    	$autor=$content[0]["autor"];
    	$bloque=$content[0]["bloque"];
    	$page=$servicioImpresion->addsignatureProyecto($page, $autor,$bloque);
    	
    	
    	return  $servicioImpresion->getArchivoProyecto($word, $fecha,$autor);
    	
    }
    
    /**
     * @Route("/imprimirExpediente")
     */
    public function imprimirExpedienteAction(Request $request){
    	
    	$idExpediente= $request->query->get('idExpediente');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$servicioImpresion=$this->get('impresion_servicio');
    	
    	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    	$fechaActual=new \DateTime('now');
    	$fecha=$fechaActual->format('d')." de ".$meses[$fechaActual->format('n')-1].
    	" de ".$fechaActual->format('Y') ;
    	
    	//url base
    	$base=$request->getSchemeAndHttpHost().$request->getBasePath();
    	
    	//crea el word
    	$word = $servicioImpresion->getTemplateOD();
    	$page= $servicioImpresion->getPage($word, 'Legal');
    	$page= $servicioImpresion->setHeader($page,  $base.'/document_bootstrap/header_concejo.png');
    	
    	$content=$expedienteRepository->traerExpedienteParaImpresion($idExpediente);
    	
    	$numero=$content[0]["numeroExpediente"];
    	$letra=$content[0]["letra"];
    	$periodo=$content[0]["periodo"];
    	$caratula=$content[0]["caratula"];
    	$fechaIngreso=$content[0]["fechaIngreso"];
    	$origen=$content[0]["origen"];
    	$textoProyecto=$content[0]["textoProyecto"];
    	
    	$page=$servicioImpresion->crearCaratulaExpediente($page,$numero,$letra,$periodo,
    													  $caratula,$fechaIngreso,$origen);
    	if ($textoProyecto!=''){
	    	$page2=$servicioImpresion->getPage($word, 'Legal');
	    	$page2=$servicioImpresion->writeHTMLToPage($textoProyecto, $page2);
    	}
    	
    	$expediente=$numero.'_'.$letra.'_'.$periodo;
    	
    	return  $servicioImpresion->getArchivoExpediente($word, $fecha, $expediente);
    	
    }
    
    /**
     * @Route("/imprimirE")
     */
    public function immprimirEAction(Request $request)
    {	
    	$fechaDesde= $request->query->get('fechaDesde');
    	$fechaHasta= $request->query->get('fechaHasta');
    	
    	$format = 'd/m/Y H:i:s';
    	$fechaDesdeAsDate= \DateTime::createFromFormat($format, $fechaDesde.' 00:00:00');
    	$fechaHastaAsDate= \DateTime::createFromFormat($format, $fechaHasta.' 23:59:59');
    	
	    $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
	    $servicioImpresion=$this->get('impresion_servicio');
	    
	    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	    $fechaActual=new \DateTime('now');
	    $fecha=$fechaActual->format('d')." de ".$meses[$fechaActual->format('n')-1].
	    " de ".$fechaActual->format('Y') ;
	    
	    //url base
	    $base=$request->getSchemeAndHttpHost().$request->getBasePath();
	    
	    //crea el word
	    $word = $servicioImpresion->getTemplateOD();
	    $page= $servicioImpresion->getPage($word, 'Legal');
	    $page= $servicioImpresion->setHeader($page,  $base.'/document_bootstrap/header_concejo.png');
	    
	    $content=$expedienteRepository->traerESinCuerpo($fechaDesdeAsDate,$fechaHastaAsDate);
	    $texto=$content[0]["texto"];
	    $html='<h3><strong>Listado E</strong></h3><p></p>';
	    $html.='<h5>Ingresos del '.$fechaDesde.' al '.$fechaHasta.'</h5>';
	    $page=$servicioImpresion->writeHTMLToPage($html, $page);
	    $page=$servicioImpresion->writeHTMLToPage($texto, $page);
	   	    
	    return  $servicioImpresion->getArchivoListadoE($word, $fecha);
	    	
	}
	
	/**
	 * @Route("/imprimirRemito")
	 */
	public function immprimirRemitoAction(Request $request)
	{
		$idRemito= $request->query->get('idRemito');
		$usuario=$this->getUser();
		
		$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
		$servicioImpresion=$this->get('impresion_servicio');
		
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$fechaActual=new \DateTime('now');
		$fecha=$fechaActual->format('d')." de ".$meses[$fechaActual->format('n')-1].
		" de ".$fechaActual->format('Y') ;
		
		//url base
		$base=$request->getSchemeAndHttpHost().$request->getBasePath();
		$urlImagen=$base. '/document_bootstrap/escudo2_LZ.png';
		
		//crea el word
		$word = $servicioImpresion->getTemplateOD();
		//$page= $servicioImpresion->getPage($word, 'A4');
		
		$content=$expedienteRepository->traerDatosRemito($idRemito);//($idRemito);
		$destino=$content[0]["destino"];
		$numero=$content[0]["numero"];
		$pases=$content[0]["pases"];
		$informes=$content[0]["informes"];
		$notificaciones=$content[0]["notificaciones"];
		
		$word=$servicioImpresion->setDatosRemito($word, $pases, $informes, $notificaciones,
												 $urlImagen, $destino, $usuario->getNombreCompleto(),
												 $numero);
		
// 		$word->duplicateSection($page);
		return  $servicioImpresion->getArchivoRemito($word, $fecha, 1);
		
	}
    
}

