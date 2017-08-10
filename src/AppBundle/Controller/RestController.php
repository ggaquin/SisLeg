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


class RestController extends FOSRestController{
   
    /**
     * @Rest\Get("/api/legislador/getByCriteria/{criterio}")
     */
    public function traerTodosLosLegisladoresAction(Request $request)
    {
    	$criterio=$request->get('criterio');
    	
    	if ($criterio=='todo'){
    		$perfilRepository=$this->getDoctrine()->getRepository('AppBundle:PerfilLegislador');
    		$perfiles=$perfilRepository->findAll();
    	}
    	else{
    		$perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
    		$perfiles=$perfilRepository->findLegisladoresActivos();
    	}
        
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
        $perfiles=$perfilRepository->findLegisladorByPatronBusqueda($term);
        return $this->view($perfiles,200);
    }


    /**
     * @Rest\Get("/api/legislador/descripcion/getByCriteria")
     */
    public function traerLegisladorDescripcionPorCriterioAction(Request $request)
    {   
        $term=$request->query->get('q');
        $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
        $perfiles=$perfilRepository->findLegisladorByPatronBusqueda($term,true);
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
        $resultado=[];
        foreach ($comisiones as $comision){
        	$registro=array(
        					'id'=>$comision->getId(), 'comision'=>$comision->getComision(),
        					'presidente'=>$comision->getPresidente()->getNombreCompleto(),
        					'vice_presidente'=>$comision->getVicePresidente()->getNombreCompleto(),
        					'lista_titulares'=>$comision->getListaTitulares(),
        					'lista_suplentes'=>$comision->getListaSuplentes()
        					);
        	$resultado[]=$registro;
        }
        return $this->view($resultado,200);
    }
    
    /**
     * @Rest\Get("/api/sesion/getByCriteria/{criterio}")
     */
    public function traerSesionesPorCriterioAction(Request $request){
    	
    	$criterio=$request->get('criterio');
    	
    	$sesionReposiory=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesiones=[];
    	if ($criterio=="actuales"){
    		$fecha=new \DateTime('now');
    		$año = substr($fecha->format("Y"),2,2);    		
    		$sesiones=$sesionReposiory->findBy(array('año' => $año));
    	}
    	else
    		$sesiones=$sesionReposiory->findAll();
    	
    	return $this->view($sesiones,200);
    }
    
    /**
     * @Rest\Get("/api/sesion/getOne/{id}")
     */
    public function traerSesionPorId(Request $request){
    	
    	$idSesion=$request->get('id');
    	
    	$sesionReposiory=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesion=$sesionReposiory->find($idSesion);
   
    	return $this->view($sesion,200);
    }
    
    /**
     * @Rest\Post("/api/sesion/save")
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
	    	$sesionPersistida=$sesionReposiory->findBy(array('tipoSesion' => $tipoSesion, 
	    													 'fecha' => $fechaSesion
	    													)
	    											  );
	    	if (count($sesionPersistida)>0)
	    		return $this->view('Ya existe una sesion del tipo '.
	    						   $tipoSesion->getTipoSesion().
	    						   ' creada para la fecha dada',500);
	    	
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
	    	$sesion->setAño($año);
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
     * @Rest\Get("/api/session/getLastByType")
     */
    public function  traerUltimasSesionesPorTipoAction(Request $request){
    	
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesionesValidas=$sesionRepository->findLastActivoByTipo();
    	return $this->view($sesionesValidas,200);
    }
    
    /**
     * @Rest\Get("/api/comision/getByCriteria")
     */
    public function traerComisionesPorCriterio(Request $request) {
    	$term=$request->query->get('q');
    	$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    	$comisiones=$comisionRepository->findComisionByPatronBusqueda($term);
    	
    	return $this->view($comisiones,200);
    }
    
   
    
    // Ojo con las sesiones de abajo son sesiones de usuario

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
     *  @Rest\Get("/api/ejemplo")
     */
    public function ejemploAction(Request $request){

//     	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
//     	$oficina=$oficinaRepository->find(9);
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$expediente=$expedienteRepository->findByNumeroCompleto('1/2017',null);
    	return $this->view($expediente,200);
        
    }


}