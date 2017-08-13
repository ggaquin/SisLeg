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

/**
 * @Route("/api/comisionAsignacion")
 *
 */
class RestComisionAsignacionController extends FOSRestController{

    
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
    		
    		if ($tipoCriterio=='todo')
    			$expedientesAsignados=$expedienteComisionRepository->findBy(array('anulado' => false));
    		if($tipoCriterio=='busqueda-1')
    			$expedientesAsignados=$expedienteComisionRepository->findByExpediente_Numero($criterio);
    		if ($tipoCriterio=='busqueda-2'){
    			$expedientesAsignados=$expedienteComisionRepository->findByComision_Id($criterio);
    		}
    		if($tipoCriterio=='busqueda-3')
    			$expedientesAsignados=$expedienteComisionRepository->findBy(array('publicado' => false, 'anulado' => false));
    		if ($tipoCriterio=='busqueda-4'){
    			$expedientesAsignados=$expedienteComisionRepository->findByDictamen(array('dictamen' => null,'anulado' => false));
    		}
    		$respuesta=[];
    		foreach ($expedientesAsignados as $e){
    			$datosAsignacion=array( 'id'=>$e->getId(), 'numero_completo'=>$e->getExpediente()->getNumeroCompleto(),
				    				  	'comision_nombre'=>$e->getComision()->getComision(), 'comision_id'=>$e->getComision()->getId(),
				    				  	'publicado'=>$e->getPublicado(), 'tiene_dictamen_mayoria'=>$e->getTieneDictamenMayoria(),
				    				  	'tiene_dictamen_primera_minoria'=>$e->getTieneDictamenPrimeraMinoria(),
				    				  	'tiene_dictamen_segunda_minoria'=>$e->getTieneDictamenSegundaMinoria(),
    									'id_proyecto'=>(is_null($e->getExpediente()->getProyecto())?0:$e->getExpediente()->getProyecto()->getId()),
    									'id_expediente'=>$e->getExpediente()->getId(),
				    					'dictamen_mayoria'=>(is_null($e->getDictamenMayoria())?0:$e->getDictamenMayoria()->getId()),
				    					'dictamen_primera_minoria'=>(is_null($e->getDictamenPrimeraMinoria())?0:$e->getDictamenPrimeraMinoria()->getId()),
				    					'dictamen_segunda_minoria'=>(is_null($e->getDictamenSegundaMinoria())?0:$e->getDictamenSegundaMinoria()->getId()),
    									'fecha_publicacion_formateada'=>$e->getFechaPublicacionFormateada(),
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
     * @Rest\Post("/updateVisualizacion")
     */
    public function cambiarVisualizacionExpedienteComisionAction(Request $request)
    {
    	$idAsignacion=$request->request->get('idAsignacion');
    	$accion=$request->request->get('accion');	
    	$usuario=$this->getUser();
    	
    	//TODO: validar que este recibido
    	
    	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    	$expedienteComision=$expedienteComisionRepository->find($idAsignacion);
    	$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
    	
    	
    	if ($accion=="publicar"){
    		$expedienteComision->setPublicado(true);
    		$expedienteComision->setFechaPublicacion(new \DateTime());
    		$idNuevoEstadoExpediente=$this->getParameter('id_estado_estudio_comision');
    		$nuevoEstadoExpediente=$estadoExpedienteRepository->find($idNuevoEstadoExpediente);
    		$expedienteComision->getExpediente()->setEstadoExpediente($nuevoEstadoExpediente);
    	}
    	if ($accion=="anular"){
    		$expedienteComision->setAnulado(true);
    	}
    
    	$expedienteComision->setFechaModificacion(new \DateTime());
    	$expedienteComision->setUsuarioModificacion($usuario->getUsuario());
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($expedienteComision);
    	$em->flush();
    	
    	return $this->view("La asignación de expediente se logró ".$accion." en forma exitosa",200);
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
    					 					?$dictamen->getRevisionProyecto()->getId():0)
    					 );
   
    	return $this->view($resultado,200);
    }
    
    /**
     * @Rest\Post("/saveDictamen")
     */
    public function guardarDictamen(Request $request)
    {
    	$idExpediente=$request->request->get('idExpediente');
    	$idProyecto=$request->request->get('idProyecto');
    	$numeroDictaminantes=$request->request->get('numeroDictaminantes');
    	$tipoRedaccion=$request->request->get('tipoRedaccion');
    	$idTipoDictamen=$request->request->get('tipoDictamen');
    	$comisiones=$request->request->get('comisiones');
    	$texto=$request->request->get('texto');
    	$idRevision=$request->request->get('idRevision');
    	$editaRevision=$request->request->get('editaRevision');
    	$vistosYConsiderandos=$request->request->get('vistosYConsiderandos');
    	$vistos=$request->request->get('vistos');
    	$considerandos=$request->request->get('considerandos');
    	$articulos=json_decode($request->request->get('articulos'));
    	
    	$dictamen=null;
    	$usuario=$this->getUser();

    	$tipoProyectoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoProyecto');
    	$proyectoRevisionRepository=$this->getDoctrine()->getRepository('AppBundle:ProyectoRevision');
    	$proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');  
    	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
 
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
    		
    	//para el tipo articulado
    	if ($tipoRedaccion=="articulado"){
    		$tipoDictamen=$tipoProyectoRepository->find($idTipoDictamen);
    		$dictamen->setTextoArticulado($articulos);
    		$dictamen->setTipoDictamen($tipoDictamen);
    	}
    		
    	//para el tipo revision
    	if ($tipoRedaccion=="revision"){
    		$revision=null;
    		if (!$editaRevision)
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
       		
       		if($numeroDictaminantes==1)
	       	{	//dictamen mayoria
	       		$dictamenOriginal=$expedienteComision->getDictamenMayoria();
	       		if (!is_null($dictamenOriginal))
	       			$dictamenOriginal->removeAsignacionPorMayoria($expedienteComision);
       			$dictamen->addAsignacionPorMayoria($expedienteComision);
       		}
       		if($numeroDictaminantes==2)
       		{	//dictamen primera Minoria
       			$dictamenOriginal=$expedienteComision->getDictamenPrimeraMinoria();
       			if (!is_null($dictamenOriginal))
       				$dictamenOriginal->removeAsignacionPorPrimeraMinoria($expedienteComision);
       			$dictamen->addAsignacionPorPrimeraMinoria($expedienteComision);
       		}
       		if($numeroDictaminantes==3)
       		{	//dictamen segunda Minoria
       			$dictamenOriginal=$expedienteComision->getDictamenSegundaMinoria();
       			if (!is_null($dictamenOriginal))
       				$dictamenOriginal->removeAsignacionSegundaMinoria($expedienteComision);
       			$dictamen->addAsignacionPorSegundaMinoria($expedienteComision);
       		}
       		   
       		if (!is_null($dictamenOriginal) && !$dictamenOriginal->getTieneAsignaciones()) 
       			$em->remove($dictamenOriginal);
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
       * @Rest\Get("/getByExpedienteAndNombre")
       */
      public  function traerPorExpedienteYNombre(Request $request){
      	$term1=$request->query->get('q');
      	$term2=$request->query->get('r');
      	$term3=$request->query->get('s');
      	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
      	$expedientesAsignados=$expedienteComisionRepository->findByExpediente_IdAndComision_Nombre($term1, $term2,$term3);
      	$comisiones=[];
      	foreach ($expedientesAsignados as $expedienteAsignado){
      		$comisiones[]=$expedienteAsignado->getComision();
      	}
      	return $this->view($comisiones,200);
      }
    
}