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
use AppBundle\Entity\Sesion;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use AppBundle\Entity\ExpedienteSesion;
use AppBundle\Entity\Sancion;
use AppBundle\Entity\Dictamen;
use AppBundle\Entity\SancionArticulada;
use AppBundle\Entity\SancionRevisionProyecto;
use AppBundle\Entity\ProyectoRevision;
use AppBundle\Entity\Notificacion;
use AppBundle\Entity\Remito;
use AppBundle\Entity\Comision;
use AppBundle\Entity\Pase;
use AppBundle\Entity\PlantillaTexto;
use AppBundle\Entity\SancionBasica;

/**
 * @Route("/api/sesion")
 *
 */
class RestSesionController extends FOSRestController{
   
       
    /**
     * @Rest\Get("/getByCriteria/{criterio}")
     */
    public function traerSesionesPorCriterioAction(Request $request){
    	
    	$criterio=$request->get('criterio');
    	
    	$sesionReposiory=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesiones=[];
    	if ($criterio=="actuales"){
    		$fecha=new \DateTime('now');
    		$año = substr($fecha->format("Y"),2,2);    		
    		$sesiones=$sesionReposiory->findBy(array('periodo' => $año),array('fecha'=>'DESC'));
    	}
    	else
    		$sesiones=$sesionReposiory->findBy(array(),array('fecha'=>'DESC'));
    	
    	$resutado=[];
    	foreach ($sesiones as $sesion){
    		$registro=array('id'=>$sesion->getId(), 
    						'tiene_orden_del_dia'=>$sesion->getTieneOrdenDelDia(),
    						'tiene_ultimo_momento'=>$sesion->getTieneUltimoMomento(),
    						'tipo_sesion'=>$sesion->getTipoSesion()->getTipoSesion(),
    						'descripcion'=>$sesion->getDescripcion(),
    						'fecha_formateada'=>$sesion->getFechaFormateada(),
    						'año'=>$sesion->getPeriodo(),
    						'cantidad_expedientes'=>$sesion->getCantidadExpedientes(),
    						'tiene_edicion_bloqueada'=>$sesion->getTieneEdicionBloqueada()
    						);
    		$resutado[]=$registro;
    			
    	}
    		
    	return $this->view($resutado,200);
    }
    
    /**
     * @Rest\Get("/getOne/{id}")
     */
    public function traerSesionPorId(Request $request){
    	
    	$idSesion=$request->get('id');
    	
    	$sesionReposiory=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesion=$sesionReposiory->find($idSesion);
   
    	return $this->view($sesion,200);
    }
    
    /**
     * @Rest\Post("/save")
     */
    public function guardarSesion(Request $request){
    	
    	try{
	    	$idSesion=$request->request->get('idSesion');
	    	$idTipoSesion=$request->request->get('idTipoSesion');
	    	$fecha=$request->request->get('fecha');
	    	$descripcion=$request->request->get('descripcion');
	    	$fecha.=' 00:00:00';
	    	$fechaSesion =\DateTime::createFromFormat('d/m/Y H:i:s',$fecha);
	    	$año=substr($fechaSesion->format("Y"),2,2);
	    	
	    	$sesionReposiory=$this->getDoctrine()->getRepository('AppBundle:Sesion');
	    	$tipoSesionReposiory=$this->getDoctrine()->getRepository('AppBundle:TipoSesion');
	    	$tipoSesion=$tipoSesionReposiory->find($idTipoSesion);
	    	$sesionPersistida=$sesionReposiory->findOneBy(array('tipoSesion' => $tipoSesion,'fecha' => $fechaSesion));
	    	
	    	if (!is_null($sesionPersistida) && $sesionPersistida->getId()!=$idSesion)
	    		return $this->view('Ya existe una sesion del tipo '.
	    						   $tipoSesion->getTipoSesion().
	    						   ' creada para la misma fecha',500);
	    	
	    	$sesion=null;
	    	$mensaje="";
	    	
	    	if($idSesion==0){
	    		$sesion=new Sesion();
	    		$mensaje='La sesion fue creó en forma exitosa';
	    	}
	    	else {
	    		$sesion=$sesionReposiory->find($idSesion);
	    		$mensaje='La sesión se modifico en forma exitosa';
	    	}
	    	
	    	$sesion->setTipoSesion($tipoSesion);
	    	$sesion->setFecha($fechaSesion);
	    	$sesion->setPeriodo($año);
	    	$sesion->setDescripcion($descripcion);
	    	
	    	$em = $this->getDoctrine()->getManager();
	    	$em->persist($sesion);
	    	$em->flush();
	    
	    	return $this->view($mensaje,200);
    	}
    	catch(\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    }
    
    /**
     * @Rest\Get("/getLastByType")
     */
    public function  traerUltimasSesionesPorTipoAction(Request $request){
    	
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesionesValidas=$sesionRepository->findLastActivoByTipo();
    	return $this->view($sesionesValidas,200);
    }
    
    
    /**
     * @Rest\Get("/getAllByPeriodo/{periodo}")
     */
    public function traerSesiones(Request $request){
    	$periodo=$request->get('periodo');
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesiones=$sesionRepository->findActivasByPeriodo($periodo);
    	return $this->view($sesiones,200);
    }
           
    /**
     * @Rest\Post("/ordenDia/create")
     */
    public function  generarOrdenDelDia(Request $request){
    	
    	$idSesion=$request->request->get('idSesion');
    	
    	try {
    		$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    		$sesionRepository->createOrdenDelDia($idSesion);
    		
    		return $this->view('La orden del día se generó correctamente',200);
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    	
    }
    
    /**
     * @Rest\Post("/ultimoMomento/create")
     */
    public function  generarUltimoMomento(Request $request){
    	
    	$idSesion=$request->request->get('idSesion');
    	
    	try {
    		$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    		$sesionRepository->createUltimoMomento($idSesion);
    		
    		return $this->view('El contenido de último momento se generó correctamente',200);
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    	
    }
    
    /**
     * @Rest\Post("/ordenDia/remove")
     */
    public function  borrarOrdenDelDia(Request $request){
    	
    	$idSesion=$request->request->get('idSesion');
    	$usuario=$this->getUser();
    	$idRolAdministrador=$this->getParameter('id_rol_administrador');
    	
    	try {
    		$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    		$sanciones=$sesionRepository->countSancionesPorSesion($idSesion);
    		if ($sanciones['cuenta']!=0 && $usuario->getRol()->getId()!=$idRolAdministrador) 
    			return $this->view('Existen sanciones cargadas para esta sesión. Solo el administrador puede eliminarla',500);
    		
    		$sesionRepository->removeOrdenDelDia($idSesion);
    		
    		return $this->view('La orden del día se eliminó en forma correcta',200);
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    	
    }
    
    /**
     * @Rest\Post("/ordenDia/invalidate")
     */
    public function  invalidarEdicionOrdenDelDia(Request $request){
    	
    	$idSesion=$request->request->get('idSesion');
    	
    	try {
    		$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    		$sesion=$sesionRepository->find($idSesion);
    		$sesion->setTieneEdicionBloqueada(true);
    		
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($sesion);
    		$em->flush();
    		
    		return $this->view('El bloqueo de ediciones sobre la orden del día'.
    							$sesion->getFechaMuestra().'se realizó en forma exitosa',200);
    	
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    	
    }
    
    /**
     * @Rest\Get("/getExpedienteSesionByCriteria/{idSesion}/{tipoCriterio}/{criterio}")
     */
    public function traerExpedienteSesionesPorCriterioAction(Request $request){
    	
    	$idSesion=$request->get('idSesion');
    	$tipoCriterio=$request->get('tipoCriterio');
    	$criterio=$request->get('criterio');
    	
    	$expedienteSesionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteSesion');
    	$expedientesEnSesion=null;
    	
    	if ($tipoCriterio=='todo') //todos los expedientes
    		$expedientesEnSesion=$expedienteSesionRepository->findDistinctBySesion_Id($idSesion);
    	if($tipoCriterio=='busqueda-1') //por numero de expediente sesion
    		$expedientesEnSesion=$expedienteSesionRepository->findDistinctByExpediente_Numero($criterio,$idSesion);
    	if ($tipoCriterio=='busqueda-2') //por tipo de expediente sesion
    		$expedientesEnSesion=$expedienteSesionRepository->findDistinctByTipoExpediente_Id($criterio,$idSesion);
    	if ($tipoCriterio=='busqueda-3') //estado expediente sesion
    		$expedientesEnSesion=$expedienteSesionRepository->findDistinctByletraOrdenDia($criterio,$idSesion);
    	    		
    	return $this->view($expedientesEnSesion,200);
    }
    
    /**
     * @Rest\Get("/getDictamenesByExpediente/{idExpediente}/{idSesion}")
     */
    public function traerDictamenesPorExpediente(Request $request){
    	
    	$idExpediente=$request->get('idExpediente');
    	$idSesion=$request->get('idSesion');
    	
    	$expedienteSesionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteSesion');
    	$dictamenes=$expedienteSesionRepository->findDictamenesByExedienteYSesion($idExpediente, $idSesion);
    	
    	return $dictamenes;
    	
    }
    
    /**
     * @Rest\Get("/getSesionesByPeriodo/{periodo}")
     */
    public function traerSesionesPorPeriodoAction(Request $request){
    	
    	$periodo=$request->get('periodo');
    	
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesiones=$sesionRepository->findActivasByPeriodo($periodo);
    	
    	return $sesiones;
    }
    
    /**
     * @Rest\Post("/saveSancion")
     */
    public function guardarSancion(Request $request){
    	
    	$idSesion=$request->request->get('idSesion');
    	$idSancion=$request->request->get('idSancion');
    	$idDictamen=$request->request->get('idDictamen');
    	$idExpediente=$request->request->get('idExpediente');
    	$idProyecto=$request->request->get('idProyecto');
    	$tipoRedaccion=$request->request->get('tipoRedaccion');
    	$idTipoSancion=$request->request->get('tipoSancion');
    	$idSpeech=$request->request->get('idSpeech');
//     	$idSpeechPie=$request->request->get('idSpeechPie');
    	$firmaPresidente=$request->request->get('firmaPresidente');
    	$firmaSecretario=$request->request->get('firmaSecretario');
    	$numeroSancion=$request->request->get('numeroSancion');
    	$aplicaNotificacion=$request->request->get('aplicaNotificacion');
    	$destinosNotificacion=$request->request->get('destinosNotificacion');
    	$comisionReserva=$request->request->get('comisionReserva');
    	$texto_libre=$request->request->get('texto');
    	$idRevision=$request->request->get('idRevision');
    	$editaRevision=$request->request->get('editaRevision');
    	$vistosYConsiderandos=$request->request->get('vistosYConsiderandos');
    	$vistos=$request->request->get('vistos');
    	$considerandos=$request->request->get('considerandos');
    	$articulos=json_decode($request->request->get('articulos'));
    	
    	$sancion=null;
    	$sancionOriginal=null;
    	$remitoExterno=null;
    	$usuario=$this->getUser();
    	$estadoExpediente=null;
    	
    	try {
    	
	    	$sancionRepository=$this->getDoctrine()->getRepository('AppBundle:Sancion');
	    	$dictamenRepository=$this->getDoctrine()->getRepository('AppBundle:Dictamen');
	    	$tipoProyectoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoProyecto');
	    	$proyectoRevisionRepository=$this->getDoctrine()->getRepository('AppBundle:ProyectoRevision');
	    	$proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
	    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
	    	$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
	    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
	    	$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
	    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
	    	$expedienteSesionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteSesion');
	    	$speechRepository=$this->getDoctrine()->getRepository('AppBundle:Speech');
	    	$autoridadRepository=$this->getDoctrine()->getRepository('AppBundle:Autoridad');
	    		    	
	    	$em = $this->getDoctrine()->getManager();
	
	    	/*--------------------------obtener datos del proceso -----------------------------------*/
	    	    	
	    	$expediente=$expedienteRepository->find($idExpediente);
	    	$sesion=$sesionRepository->find($idSesion);
	    	if ($sesion->getTieneEdicionBloqueada())
	    		return $this->view("La sesión se encuentra bloqueda para ediciones",500);
	 	    	
	    	if ($idSancion!=0)
	    		$sancionOriginal= $sancionRepository->find($idSancion);
	   
	    	
	    	/*-------------------------------crear resolución----------------------------------------*/
	    		
	    	if ($tipoRedaccion=="basico")
	    		$sancion=new SancionBasica();
	    	if ($tipoRedaccion=="articulado")
	    		$sancion=new SancionArticulada();
	    	if ($tipoRedaccion=="revision")
	    		$sancion=new SancionRevisionProyecto();
	    					
	    	$sancion->setFechaCreacion(new \DateTime('now'));
	    	$sancion->setUsuarioCreacion($usuario->getUsuario());
	    					
	    	//campos comunes a todos los tipos
	    	$dictamen=(($idDictamen==0)?null:$dictamenRepository->find($idDictamen));
		    $sancion->setDictamen($dictamen);
		    
		    if ($idSpeech!=null){
		    	$speech=$speechRepository->find($idSpeech);
		    	$sancion->setSpeech($speech);
		    }
		    	
		    if($firmaPresidente=='true'){
		    	$persidente=$autoridadRepository->findAutoridadByTipo('presidente');
		    	$sancion->setFirmaPresidente($persidente);
		    }
		    if($firmaSecretario=='true'){
		    	$secretario=$autoridadRepository->findAutoridadByTipo('secretario');
		    	$sancion->setFirmaSecretario($secretario);
		    }
		   	    		
		    //para texto rápido
		    if ($tipoRedaccion=="basico")
		    	$sancion->setTextoLibre($texto_libre);
	    	
	    	//para el tipo articulado
	    	if ($tipoRedaccion=="articulado"){
	    		$tipoSancion=$tipoProyectoRepository->find($idTipoSancion);
	    		$sancion->setTextoArticulado($articulos);
	    		$sancion->setTipoSancion($tipoSancion);
	    		$sancion->setNumeroSancion($numeroSancion);
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
	    				{	//usa una revision existente sin modfificaciones
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
	    						
	    		$sancion->setRevisionProyecto($revision);
	    		$sancion->setNumeroSancion($numeroSancion);
	    	}
	    	 
	    	/*----------------determinación del nuevo estado del expediente-----------------------*/
	    	
	    	if ($numeroSancion!="")
	    		
	    		if ($aplicaNotificacion=="false") 							//estado sancionado
		    		$estadoExpediente=$estadoExpedienteRepository->find(5);
	    		else														//estado reserva comision
	    			$estadoExpediente=$estadoExpedienteRepository->find(4);
	    	else															//estado en trámite
	    		$estadoExpediente=$estadoExpedienteRepository->find(10);
	    		    	
	 		/*----------------------------actualización del expediente-----------------------------*/
	    		
	    	$expediente->setEstadoExpediente($estadoExpediente);
	    	$expediente->setNumeroSancion($numeroSancion);
	   		
	    	/*------------------------crear notificacion y pase a comisiones-----------------------*/
	    	    	
	    	if($aplicaNotificacion=="true" && $tipoRedaccion!="basico"){
	    		
	    		$idOficinaComisiones=$this->getParameter('id_comisiones');
	    		$oficinaComisiones=$oficinaRepository->find($idOficinaComisiones);
	    		$comision=$comisionRepository->find($comisionReserva);
	    		
	    		//cambio de oficina actual
	    		$expediente->setOficinaActual($oficinaComisiones);
	    		
	    		//destinos de notificacion
	    		$destinos=explode(',',$destinosNotificacion);
	    		
	    		foreach ($destinos as $destino)
	    		{		    		
	    			
	    			$oficinaNotificacion=$oficinaRepository->find($destino);
		    		
		    		//notificacion
		    		$remitoExterno=new Remito();
		    		$remitoExterno->setAnulado(false);
		    		$remitoExterno->setDestino($oficinaNotificacion);
		    		$remitoExterno->setOrigen($usuario->getRol()->getOficina());
		    		$remitoExterno->setFechaCreacion(new \DateTime('now'));
		    		$remitoExterno->setUsuarioCreacion($usuario->getUsuario());
		    		
		    		$notificacion=new Notificacion();
		    		$notificacion->setAnulado(false);
		    		$notificacion->setExpediente($expediente);
		    		$notificacion->setComision($comision);
		    		$notificacion->setFechaCreacion(new \DateTime('now'));
		    		$notificacion->setUsuarioCreacion($usuario->getUsuario());
		    		
		    		$remitoExterno->addMovimiento($notificacion);
		    		$em->persist($remitoExterno);
		    		$sancion->addNotificacion($notificacion);
		    		
	    		}
	    		
	    		//movimiento a comisiones
	    		$remitoInterno=new Remito();
	    		$remitoInterno->setAnulado(false);
	    		$remitoInterno->setDestino($oficinaComisiones);
	    		$remitoInterno->setOrigen($usuario->getRol()->getOficina());
	    		$remitoInterno->setFechaCreacion(new \DateTime('now'));
	    		$remitoInterno->setUsuarioCreacion($usuario->getUsuario());
	    		
	    		$pase=new Pase();
	    		$pase->setAnulado(false);
	    		$pase->setExpediente($expediente);
	    		$pase->setFojas($expediente->getFolios());
	    		$pase->setFechaCreacion(new \DateTime('now'));
	    		$pase->setUsuarioCreacion($usuario->getUsuario());
	
	    		$remitoInterno->addMovimiento($pase);
	    		$em->persist($remitoInterno);
	    		
	    		//$sancion->setNotificacion($notificacion);
	    		$sancion->setPase($pase);
	    		    		
	    	}
	    	
	    	/*-------------impacto de la sancion en los expedientes de la sesion-------------------*/
	    	
	    	$expedientesEnSesion=$expedienteSesionRepository->findBy(array('expediente'=>$expediente,
	    																   'sesion'=>$sesion));
	    	
	    	foreach ($expedientesEnSesion as $expedienteSesion){
	    		$expedienteSesion->setSancion($sancion);
	    		$em->persist($expedienteSesion);
	    	}
	    	
	    	/*-------------borrado de los datos anteriores si es edición------------------------------*/
	    			
	    	if (!is_null($sancionOriginal)){
	    		
	    		if (($sancionOriginal instanceof SancionArticulada) || 
	    			($sancionOriginal instanceof  SancionRevisionProyecto)) {
	    		
		    		$notificacionesOriginales=$sancionOriginal->getNotificaciones();
		    		$paseOriginal=$sancionOriginal->getPase();
		    		
		    		foreach ($notificacionesOriginales as $notificacionPersistida){
		    				    			
		    			$remitoOriginal=$notificacionPersistida->getRemito();
		    			$sancionOriginal->removeNotificacion($notificacionPersistida);
		    			$em->persist($sancionOriginal);
		    			$em->remove($remitoOriginal);
		    		}
		    		
		    		if (!is_null($paseOriginal)){
		    			
		    			$remitoOriginal=$paseOriginal->getRemito();
		    			$em->remove($remitoOriginal);
		    		}
	    		}
	    		
	    		$em->remove($sancionOriginal);
	    	}
	    						
	    	$em->flush();
	    					
	    	return $this->view("La sanción se guardó en forma exitosa",200);
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    	
    }
    
    /**
     * @Rest\Get("/getSancion/{id}")
     */
    public  function traerSancionPorId(Request $request){
    	
	    $idSancion=$request->get('id');
    	$sancionRepository=$this->getDoctrine()->getRepository('AppBundle:Sancion');
    	$sancion=$sancionRepository->find($idSancion);
    	$resultado=array(
		    			'clase_sancion'=>$sancion->getClaseSancion(),
		    			'id_tipo_sancion'=>(($sancion instanceof SancionArticulada)
		    									?$sancion->getTiposancion()->getId():0),
		    			'texto_libre'=>(($sancion instanceof SancionBasica)
		    								?$sancion->getTextoLibre():''),
		    			'texto_articulado'=>(($sancion instanceof SancionArticulada)
		    									?$sancion->getTextoArticulado():[]),
		    			'vistos'=>(($sancion instanceof SancionRevisionProyecto)
		    						 ?$sancion->getRevisionProyecto()->getVisto():''),
		    			'considerandos'=>(($sancion instanceof SancionRevisionProyecto)
		    								?$sancion->getRevisionProyecto()->getConsiderandos():''),
		    			'articulos'=>(($sancion instanceof SancionRevisionProyecto)
		    							?$sancion->getRevisionProyecto()->getArticulos():[]),
		    			'incluye_vistos_y_considerandos'=>(($sancion instanceof SancionRevisionProyecto)
		    							?$sancion->getRevisionProyecto()->getIncluyeVistosyConsiderandos():true),
		    			'revision_id'=>(($sancion instanceof SancionRevisionProyecto)
		    							?$sancion->getRevisionProyecto()->getId():0),
		    			'numero_sancion'=>(($sancion->getClaseSancion()!="basico")
		    								?$sancion->getNumeroSancion():''),
						'firma_presidente'=>($sancion->getFirmaPresidente!=null),
    					'firma_secretario'=>($sancion->getFirmaSecretario!=null),
    					'comision_reserva'=>((!($sancion instanceof SancionBasica) &&
		    								  count($sancion->getNotificaciones())>0)
						    					?($sancion->getNotificaciones()[0])
						    								->getComision()->getId():0),
    					'speech'=>$sancion->getSpeech(),
    					'notificaciones'=>(!($sancion instanceof SancionBasica)
    										?$sancion->getListaNotificaciones():[])
				    	);
    	
    	return $this->view($resultado,200);
    	
    }
    
}