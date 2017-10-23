<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
;

// use twig\twig;

use AppBundle\Entity\Rol;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Perfil;
use AppBundle\Entity\PerfilLegislador;  
use AppBundle\Entity\PerfilPublico;
use AppBundle\Entity\Bloque;
use AppBundle\Entity\Expediente;
use AppBundle\Entity\Proyecto;
use AssistBundle\Entity\AdministracionSesion;
use AppBundle\Entity\Remito;
use AppBundle\Entity\Oficina;
use AppBundle\Entity\DemandanteParticular;
use AppBundle\Entity\OrigenExterno;
use AppBundle\Entity\ExpedienteComision;
use AppBundle\Entity\Movimiento;
use FOS\RestBundle\Controller\Annotations\Get;
use AppBundle\Entity\Sesion;
use AppBundle\Entity\ProyectoRevision;
use AppBundle\Entity\Comision;
use AppBundle\Entity\Dictamen;
use AppBundle\Entity\DictamenArticulado;
use AppBundle\Entity\DictamenRevision;
use AppBundle\Entity\TipoProyecto;
use AppBundle\AppBundle;
use AppBundle\Entity\EstadoExpediente;
use FOS\RestBundle\Controller\Annotations\Route;
use AppBundle\Repository\ExpedienteComisionRepository;
use AppBundle\Entity\Pase;

/**
 * @Route("/api/comisionAsignacion")
 *
 */
class RestComisionAsignacionController extends FOSRestController{

    
	/**
	 * @Rest\Post("/create")
	 */
	public function crearAsignacionAction(Request $request)
	{
		$idExpediente=$request->request->get('idExpediente');
		$comisiones=$request->request->get('comisiones');
		$usuario=$this->getUser();
		
		$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
		$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
		$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
		$em = $this->getDoctrine()->getManager();
		$expediente=$expedienteRepository->find($idExpediente);
		
		$listaComisiones=explode(',', $comisiones);
		foreach ($listaComisiones as $idComision){
			$primerAsignacion=$expedienteComisionRepository
								->findPrimerAsignacionByExpediente_Id($expediente->getId());
			if (count($primerAsignacion)==0)
					return $this->view("El expediente ".$expediente->getNumeroCompleto().
									   "no posee ningina asignación actual",500);
			$asignacion=new ExpedienteComision();
			$comision=$comisionRepository->find($idComision);
			$asignacion->setComision($comision);
			$asignacion->setPaseOriginario(($primerAsignacion[0])->getPaseOriginario());
			$asignacion->setExpediente($expediente);
			$asignacion->setFechaAsignacion(new \DateTime('now'));
			$asignacion->setUsuarioCreacion($usuario->getUsuario());
			$em->persist($asignacion);
		}
		
		$em->flush();
		
		return $this->view("Las nuevas asignaciones se generaron en forma exitosa",200);
		
		
	}
	
    /**
     * @Rest\Get("/getByCriteria/{tipoCriterio}/{criterio}")
     */
    public function traerExpedientesComisionPorCriterioAction(Request $request)
    {
    	try {
	    	$tipoCriterio=$request->get('tipoCriterio');
    		$criterio=$request->get('criterio');
    		
    		$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    		$expedientesAsignados=null;
    		
    		if ($tipoCriterio=='busqueda-0')
    			$expedientesAsignados=$expedienteComisionRepository->findAllActivos();
    		if($tipoCriterio=='busqueda-1')
    			$expedientesAsignados=$expedienteComisionRepository->findByExpediente_Numero($criterio,false);
    		if ($tipoCriterio=='busqueda-2'){
    			$expedientesAsignados=$expedienteComisionRepository->findByComision_Id($criterio);
    		}
    		if ($tipoCriterio=='busqueda-3'){
    			$idEstadoEstudioComision=$this->getParameter('id_estado_estudio_comision');
    			$expedientesAsignados=$expedienteComisionRepository
    									->findExpedienteComisionByExpediente_Estado($idEstadoEstudioComision);
    		}
    		if($tipoCriterio=='busqueda-4'){
    			$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    			$sesion=$sesionRepository->find($criterio);
    			$expedientesAsignados=$expedienteComisionRepository->findBy(array('anulado'=>false,
    																			  'sesion'=>$sesion));
    		}
    		if ($tipoCriterio=='busqueda-5')
    			$expedientesAsignados=$expedienteComisionRepository->findBy(array('anulado'=>false));
    		$respuesta=[];
    		foreach ($expedientesAsignados as $e){
    			$datosAsignacion=array( 'id'=>$e->getId(), 
    									'numero_completo'=>$e->getExpediente()->getNumeroCompleto(),
				    				  	'comision_nombre'=>$e->getComision()->getComision(), 
    									'comision_id'=>$e->getComision()->getId(),
    									'letra'=>$e->getComision()->getLetraOrdenDelDia(),
    									'id_proyecto'=>(is_null($e->getExpediente()->getProyecto())?0:$e->getExpediente()->getProyecto()->getId()),
    									'id_expediente'=>$e->getExpediente()->getId(),
    									'dictamen_mayoria_id'=>(!is_null($e->getDictamenMayoria())
    																		?$e->getDictamenMayoria()->getId()
    																		:0),
    									'dictamen_primera_minoria_id'=>(!is_null($e->getDictamenPrimeraMinoria())
    																				?$e->getDictamenPrimeraMinoria()->getId()
    																				:0),
    									'dictamen_segunda_minoria_id'=>(!is_null($e->getDictamenSegundaMinoria())
    																				?$e->getDictamenSegundaMinoria()->getId()
    																				:0),
    									'recibido'=>!is_null($e->getPaseOriginario()->getRemito()->getFechaRecepcion()),
    									'anulado'=>$e->getAnulado(),
    									'edicion_habilitada'=>$e->getPermiteEdicion(),
    									'sesion'=>$e->getSesionMuestra(),
    									'sesion_id'=>(is_null($e->getSesion())?0:$e->getSesion()->getId()),
    									'ultimo_momento'=>$e->getUltimoMomento()
				    				);
    			$respuesta[]=$datosAsignacion;
    		}
    		return $this->view($respuesta,200);
	    }
	    catch (\Exception $e){
	    	return $this->view($e->getMessage(),500);
	    }
    }
    
    /**
     * @Rest\Post("/updateSesion")
     */
    public function actualizarSesionAction(Request $request) 
    {
    	$idAsignacion=$request->request->get('idAsignacion');
    	$idSesion=$request->request->get('idSesion');
    	$ultimoMomento=$request->request->get('ultimoMomento');
    	$usuario=$this->getUser();
    	
    	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$expedienteComision=$expedienteComisionRepository->find($idAsignacion);
    	$sesion=$sesionRepository->find($idSesion);
    	   	
    	if($expedienteComision->getUltimoMomento()=="true" && $ultimoMomento=="false")
    			$expedienteComision->setUltimoMomento(false);
    	else 
    		if (is_null($expedienteComision->getSesion()) || 
    			$expedienteComision->getSesion()->getId()!=$sesion->getId())
    			$expedienteComision->setUltimoMomento($sesion->getTieneOrdenDelDia());	
    	
    	$expedienteComision->setSesion($sesion);
    	$expedienteComision->setFechaModificacion(new \DateTime());
    	$expedienteComision->setUsuarioModificacion($usuario->getUsuario());
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($expedienteComision);
    	$em->flush();
    	
    	return $this->view("La sesion se asignó e forma exitosa",200);
    }
        
    /**
     * @Rest\Post("/anular")
     */
    public function anularExpedienteComisionAction(Request $request)
    {
    	$idAsignacion=$request->request->get('idAsignacion');
    	$usuario=$this->getUser();
    	
       	$idNuevoEstadoExpediente=$this->getParameter('id_estado_espera_recepcion');
    	$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
    	$nuevoEstadoExpediente=$estadoExpedienteRepository->find($idNuevoEstadoExpediente);
    	
    	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    	$expedienteComision=$expedienteComisionRepository->find($idAsignacion);
    	$idExpediente=$expedienteComision->getExpediente()->getId();
    	$idComision=$expedienteComision->getComision()->getId();
    	$cuentaAsignaciones=$expedienteComisionRepository
    							->countComisionesByExpediente_IdAndFiltro($idExpediente,$idComision);
    	
    	$expedienteComision->setAnulado(true);
    	$expedienteComision->setFechaModificacion(new \DateTime());
    	$expedienteComision->setUsuarioModificacion($usuario->getUsuario());
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($expedienteComision);
    	
    	if ($cuentaAsignaciones[1]==0){
    		
    		$oficinaOrigen=$expedienteComision->getPaseOriginario()->getRemito()->getOrigen();
    		
    		$expediente=$expedienteComision->getExpediente()->setEstadoExpediente($nuevoEstadoExpediente);
    		$expediente->setOficinaActual($oficinaOrigen); 
    		
    		$remito= new Remito();
    		$remito->setDestino($oficinaOrigen);
    		$remito->setOrigen($usuario->getRol()->getOficina());
    		$remito->setFechaCreacion(new \DateTime());
    		$remito->setUsuarioCreacion($usuario->getUsuario());
    		
    		$pase=new Pase();
    		$pase->setExpediente($expediente);
    		$pase->setFechaCreacion(new \DateTime());
    		$pase->setUsuarioCreacion($usuario->getUsuario());
    		$pase->setFojas($expediente->getFolios());
    		$pase->setObservacion('Devuelto por anulacion de comisiones');
    		
    		$remito->addMovimiento($pase);
    		$em->persist($remito);
    		    		
    	}
    	
    	$em->flush();
    	
    	return $this->view("La asignación de expediente se logró anular en forma exitosa",200);
    }
    
    /**
     * @Rest\Post("/updateComision")
     */
    public function actualizarComisionAsignada(Request $request)
    {
    	$idAsignacion=$request->request->get('idAsignacion');
    	$idNuevaComision=$request->request->get('idNuevaComision');
    	$usuario=$this->getUser();
    	
    	//TODO: validar que este recibido y que no exista ya la asignacion de comision para el expediente
    	
    	$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    	$expedienteComision=$expedienteComisionRepository->find($idAsignacion);
    	$comision=$comisionRepository->find($idNuevaComision);
    	    		
    	$expedienteComision->setComision($comision);
    	$expedienteComision->setFechaModificacion(new \DateTime());
    	$expedienteComision->setUsuarioModificacion($usuario->getUsuario());
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($expedienteComision);
    	$em->flush();
    	
    	return $this->view("La comision se cambió en forma exitosa en forma exitosa",200);
    }
    
    /*
     * @Rest\Get("/validarAltaDictamen/{numeroDictaminantes}/{idAsignacion}")
     *
    public function  validarAltaDictamen(Request $request)
    {
    	$numeroDictaminantes=$request->get('numeroDictaminantes');
    	$idAsignacion=$request->get('idAsignacion');
    	
    	$mensaje="";
    	$response_state=200;
    	
    	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    	$dictamenes=$expedienteComisionRepository
    				 ->findDictamenByAsignacionAndSesionPendiente
    				  ($idAsignacion,$numeroDictaminantes);
    	
    	if(count($dictamenes)>0){
    		$mensaje='El dictamen '.$dictamenes[0]->getSesionMuestra().' aún no tiene paso por el cuerpo';
    		$response_state=500;
    	}	
    		
    	return $this->view($mensaje,$response_state);
    	
    }*/
    
    /**
     * @Rest\Get("/getDictamen/{id}")
     */
    public function traerDictamenPorId(Request $request){
    	
    	$idDictamen=$request->get('id');
    	$dictamenRepository=$this->getDoctrine()->getRepository('AppBundle:Dictamen');
    	$dictamen=$dictamenRepository->find($idDictamen);
    	
    	$resultado=array(
    					 'clase_dictamen'=>$dictamen->getClaseDictamen(),
    					 'id_tipo_dictamen'=>(($dictamen instanceof DictamenArticulado)
    					 						?$dictamen->getTipoDictamen()->getId():0),
    					 'texto_libre'=>$dictamen->getTextoLibre(),
    					 'texto_articulado'=>(($dictamen instanceof DictamenArticulado)
    					 						?$dictamen->getTextoArticulado():[]),
    					 'vistos'=>(($dictamen instanceof DictamenRevision)
    					 			 ?$dictamen->getRevisionProyecto()->getVisto():''),
    					 'considerandos'=>(($dictamen instanceof DictamenRevision)
    					 					?$dictamen->getRevisionProyecto()->getConsiderandos():''),
    					 'articulos'=>(($dictamen instanceof DictamenRevision)
    					 				?$dictamen->getRevisionProyecto()->getArticulos():[]),
    					 'incluye_vistos_y_considerandos'=>(($dictamen instanceof DictamenRevision)
    					 									?$dictamen->getRevisionProyecto()->getIncluyeVistosyConsiderandos():true),
    					 'revision_id'=>(($dictamen instanceof DictamenRevision)
    					 					?$dictamen->getRevisionProyecto()->getId():0)//,
    					 //'sesion_id'=>(!is_null($dictamen->getSesion())?$dictamen->getSesion()->getId():0)
    					 );
   
    	return $this->view($resultado,200);
    }
    
    /**
     * @Rest\Post("/saveDictamen")
     */
    public function guardarDictamen(Request $request)
    {
    	$idExpediente=$request->request->get('idExpediente');
    	$idDictamen=$request->request->get('idDictamen');
    	$idProyecto=$request->request->get('idProyecto');
    	$numeroDictaminantes=$request->request->get('numeroDictaminantes');
    	$tipoRedaccion=$request->request->get('tipoRedaccion');
    	$idTipoDictamen=$request->request->get('tipoDictamen');
    	$comisiones=$request->request->get('comisiones');
    	$texto=$request->request->get('texto');
    	//$idSesion=$request->request->get('idSesion');
    	$idRevision=$request->request->get('idRevision');
    	$editaRevision=$request->request->get('editaRevision');
    	$vistosYConsiderandos=$request->request->get('vistosYConsiderandos');
    	$vistos=$request->request->get('vistos');
    	$considerandos=$request->request->get('considerandos');
    	$articulos=json_decode($request->request->get('articulos'));
    	
    	$dictamen=null;
    	$dictamenOriginal=null;
    	$usuario=$this->getUser();

    	$dictamenRepository=$this->getDoctrine()->getRepository('AppBundle:Dictamen');
    	$tipoProyectoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoProyecto');
    	$proyectoRevisionRepository=$this->getDoctrine()->getRepository('AppBundle:ProyectoRevision');
    	$proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');  
    	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
    	//$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
 
    	if ($idDictamen!=0)
    		$dictamenOriginal = $dictamenRepository->find($idDictamen);
    	
	    if ($tipoRedaccion=="basico")
	    	$dictamen=new Dictamen();
	    if ($tipoRedaccion=="articulado")
	    	$dictamen= new DictamenArticulado();
	    if ($tipoRedaccion=="revision")
	    	$dictamen= new DictamenRevision();
    		
	    $dictamen->setFechaCreacion(new \DateTime('now'));
	    $dictamen->setUsuarioCreacion($usuario->getUsuario());
    	
    	//campo común a todos los tipos
    	$dictamen->setTextoLibre($texto);
    	//$sesion=$sesionRepository->find($idSesion);
    	//$dictamen->setSesion($sesion);
    		
    	//para el tipo articulado
    	if ($tipoRedaccion=="articulado"){
    		$tipoDictamen=$tipoProyectoRepository->find($idTipoDictamen);
    		$dictamen->setTextoArticulado($articulos);
    		$dictamen->setTipoDictamen($tipoDictamen);
    	}
    		
    	//para el tipo revision
    	if ($tipoRedaccion=="revision"){
    		$revision=null;
    		if ($editaRevision=="false")
    		{	//usa le revisión elegida sin modificaciones
    				
    			if ($idRevision==0)
    			{	// usa el proyecto original sin modificaciones
    					
    				$proyecto=$proyectoRepository->find($idProyecto);
    				$revision=new ProyectoRevision();
    				$revision->setArticulos($proyecto->getArticulos());
    				$revision->setConsiderandos($proyecto->getConsiderandos());
    				$revision->setVisto($proyecto->getVistos());
    				$revision->setFechaCreacion(new \DateTime('now'));
    				$revision->setIncluyeVistosYConsiderandos($vistosYConsiderandos);
    				$revision->setOficina($usuario->getRol()->getOficina);
					$revision->setProyecto($proyecto);
					$revision->setUsuarioCreacion($usuario->getUsuario());
    			}
    			else
    			{		//usa una revision existente sin modfificaciones	
    					$revision=$proyectoRevisionRepository->find($idRevision);
    			}
    		}
    		else
    		{	//edita la revisión seleccionada
    			$proyecto=$proyectoRepository->find($idProyecto);
    			$revision=new ProyectoRevision();
    			$revision->setArticulos($articulos);
    			$revision->setConsiderandos($considerandos);
    			$revision->setVisto($vistos);
    			$revision->setFechaCreacion(new \DateTime('now'));
    			$revision->setIncluyeVistosYConsiderandos((($vistosYConsiderandos=="true")?true:false));
    			$revision->setOficina($usuario->getRol()->getOficina);
    			$revision->setProyecto($proyecto);
    			$revision->setUsuarioCreacion($usuario->getUsuario());
    		}
    		
    		$dictamen->setRevisionProyecto($revision);	
    	}
    	
    	$em = $this->getDoctrine()->getManager();
    	    	
    	$comisionesArray=explode(",", $comisiones);
    	foreach ($comisionesArray as $idComision){
       		
       		$expedienteComision=$expedienteComisionRepository->findByExpediente_IdAndComision_Id($idExpediente, $idComision);
       		if($expedienteComision->getPermiteEdicion()){
       		
	       		if($numeroDictaminantes==1)
		       	{	//dictamen mayoria
		       		if (!is_null($dictamenOriginal))
			       		$dictamenOriginal->removeAsignacionPorMayoria($expedienteComision);
		       		
	       			$dictamen->addAsignacionPorMayoria($expedienteComision);
	       		}
	       		if($numeroDictaminantes==2)
	       		{	//dictamen primera Minoria
	       			if (!is_null($dictamenOriginal))
	       				$dictamenOriginal->removeAsignacionPorPrimeraMinoria($expedienteComision);
	       			$dictamen->addAsignacionPorPrimeraMinoria($expedienteComision);
	       		}
	       		if($numeroDictaminantes==3)
	       		{	//dictamen segunda Minoria
	       			if (!is_null($dictamenOriginal))
	       				$dictamenOriginal->removeAsignacionSegundaMinoria($expedienteComision);
	       			$dictamen->addAsignacionPorSegundaMinoria($expedienteComision);
	       		}
	       		   
	       		if (!is_null($dictamenOriginal) && !$dictamenOriginal->getTieneAsignaciones()) 
	       			$em->remove($dictamenOriginal);
       		}
       		else 
       			return $this->view("El dictamen no está habilitado para edición",500);
       	}
       	
      	$expediente=$expedienteRepository->find($idExpediente);
      	$idNuevoEstadoExpediente=$this->getParameter('id_estado_dictamen_comision');
      	$nuevoEstadoExpediente=$estadoExpedienteRepository->find($idNuevoEstadoExpediente);
      	$expediente->setEstadoExpediente($nuevoEstadoExpediente);
      	
      	$em->persist($expediente);
       	$em->persist($dictamen);  
       	$em->flush();
       	
       	return $this->view("El Dictamen se ha guardado de manera exitosa",200);
      }
      
      /**
       * @Rest\Get("/getByExpedienteAndNombreWhithFiltro")
       */
      public  function traerPorExpedienteYNombreConFiltro(Request $request){
      	$term1=$request->query->get('q');
      	$term2=$request->query->get('r');
      	$term3=$request->query->get('s');
      	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
      	$expedientesAsignados=$expedienteComisionRepository->findByExpediente_IdAndComision_NombreAndFiltro($term1, $term2,$term3);
      	$comisiones=[];
      	foreach ($expedientesAsignados as $expedienteAsignado){
      		$comisiones[]=array(
			      				'id' => $expedienteAsignado->getComision()->getId(),
			      				'comision' => $expedienteAsignado->getComision()->getComision()
					      		);
      	}
      	return $this->view($comisiones,200);
      }
      
      /**
       * @Rest\Get("/getByExpedienteAndNombre")
       */
      public  function traerPorExpedienteYNombre(Request $request){
      	$term1=$request->query->get('q');
      	$term2=$request->query->get('r');
      	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
      	$comisiones=$expedienteComisionRepository->findByExpediente_IdAndComision_Nombre($term1, $term2);
      	$resultado=[];
      	foreach ($comisiones as $comision){
      		$resultado[]=array(
					      		'id' => $comision->getId(),
					      		'comision' => $comision->getComision()
					      	  );
      	}
      	return $this->view($resultado,200);
      }
      
      /**
       * @Rest\Get("/getExpedientefromAsignados")
       */
      public  function traerExpedienteAsignados(Request $request){
      	
      	$term=$request->query->get('q');
      	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
      	$expedientesAsignados=$expedienteComisionRepository->findExpedienteVigenteByNumero($term);
      	$expedientes=[];
      	foreach ($expedientesAsignados as $expedienteAsignado){
      		$expedientes[]=array(
      							'id' => $expedienteAsignado->getExpediente()->getId(),
      							'numeroCompleto' => $expedienteAsignado->getExpediente()->getNumeroCompleto()
      					       );
      	}
      	return $this->view($expedientes,200);
      }
          
}