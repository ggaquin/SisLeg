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
use AppBundle\Entity\TipoComision;


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
     * @Rest\Get("/api/bloque/getAll")
     */
    public function traerTodosLosBloquesAction(Request $request)
    {
    	$bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
    	$bloques=$bloqueRepository->findBy(array('activo'=>true));
    	
    	$resultado=[];
    	foreach ($bloques as $bloque){
    		$resultado[]=array(
    							'id'=>$bloque->getId(),
    							'bloque'=>$bloque->getBloque(),
    							'lista_concejales'=>$bloque->getListaConcejales(),
    							'fecha_creacion_formateada'=>$bloque->getFechaCreacionFormateada()
    						  );
    	}
    	
    	return $this->view($resultado,200);
    }
    
    /**
     * @Rest\Post("/api/bloque/save")
     */
    public function guardarBloqueAction(Request $request)
    {
    	$idBloque=$request->request->get('idBloque');
    	$nombreBloque=$request->request->get('nombreBloque');
    	$usuarioSesion=$this->getUser();
    	
    	$bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
    	$bloque=null;
    	$mensaje="";
    	   	
    	if ($idBloque!=0){
    		$bloque=$bloqueRepository->find($idBloque);
    		$bloque->setUsuarioModificacion($usuarioSesion->getUsername());
    		$bloque->setFechaModificacion(new \DateTime("now"));
    		$mensaje="El bloque se actualizó con éxito";
    	}
    	else {
    			$bloque=new Bloque();
    			$bloque->setUsuarioCreacion($usuarioSesion->getUsername());
    			$bloque->setFechaCreacion(new \DateTime("now"));
    			$mensaje="El bloque se agregó con éxito";
    	}
    	
    	$bloque->setBloque($nombreBloque);
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($bloque);
    	$em->flush();
    	
    	return $this->view($mensaje,200);
    	
    }
    
    /**
     * @Rest\Post("/api/bloque/remove/{id}")
     */
    public function eliminarBloqueAction(Request $request)
    {
    	$idBloque=$request->get('id');
    	$usuarioSesion=$this->getUser();
    	
    	$bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
    	$bloque=$bloqueRepository->find($idBloque);
    	
    	$bloque->setActivo(false);
    	$bloque->setUsuarioModificacion($usuarioSesion->getUsername());
    	$bloque->setFechaModificacion(new \DateTime("now"));
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($bloque);
    	$em->flush();
    	
    	return $this->view("El bloque se eliminó en forma exitosa",200);
    }
    
    /**
     * @Rest\Get("/api/oficina/getAll")
     */
    public function traerTodosLasOficinasAction(Request $request)
    {
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    	$oficinas=$oficinaRepository->findBy(array('activa'=>true),array('oficina'=>'ASC'));
    	
    	$resultado=[];
    	foreach ($oficinas as $oficina){
    		$resultado[]=array(
    				'id'=>$oficina->getId(),
    				'oficina'=>$oficina->getOficina(),
    				'tipo_oficina'=>$oficina->getTipoOficina()->getTipoOficina(),
    				'id_tipo_oficina'=>$oficina->getTipoOficina()->getId(),
    				'codigo'=>$oficina->getCodigo()
    		);
    	}
    	
    	return $this->view($resultado,200);
    }
    
    /**
     * @Rest\Post("/api/oficina/save")
     */
    public function guardarOficinaAction(Request $request)
    {
    	$idOficina=$request->request->get('idOficina');
    	$idTipoOficina=$request->request->get('idTipoOficina');
    	$nombreOficina=$request->request->get('nombreOficina');
    	$codigoOficina=$request->request->get('codigoOficina');
    	$usuarioSesion=$this->getUser();
    	
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    	$tipoOficinaRepository=$this->getDoctrine()->getRepository('AppBundle:TipoOficina');
    	$oficina=null;
    	$mensaje="";
    	
    	if ($idOficina!=0){
    		$oficina=$oficinaRepository->find($idOficina);
    		$oficina->setUsuarioModificacion($usuarioSesion->getUsername());
    		$oficina->setFechaModificacion(new \DateTime("now"));
    		$mensaje="La oficina se actualizó con éxito";
    	}
    	else {
    		$oficina=new Oficina();
    		$oficina->setUsuarioCreacion($usuarioSesion->getUsername());
    		$oficina->setFechaCreacion(new \DateTime("now"));
    		$mensaje="La oficina se agregó con éxito";
    	}
    	
    	$oficina->setOficina($nombreOficina);
    	$tipoOficina=$tipoOficinaRepository->find($idTipoOficina);
    	$oficina->setTipoOficina($tipoOficina);
    	$oficina->setCodigo($codigoOficina);
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($oficina);
    	$em->flush();
    	
    	return $this->view($mensaje,200);
    	
    }
    
    /**
     * @Rest\Post("/api/oficina/remove/{id}")
     */
    public function eliminarOficinaAction(Request $request)
    {
    	$idOficina=$request->get('id');
    	$usuarioSesion=$this->getUser();
    	
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    	$oficina=$oficinaRepository->find($idOficina);
    	
    	$oficina->setActiva(false);
    	$oficina->setUsuarioModificacion($usuarioSesion->getUsername());
    	$oficina->setFechaModificacion(new \DateTime("now"));
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($oficina);
    	$em->flush();
    	
    	return $this->view("La oficina se eliminó en forma exitosa",200);
    }

    /**
     * @Rest\Get("/api/comision/getAll")
     */
    public function traerTodasLasComisionesAction(Request $request)
    {
        
        $comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
        $comisiones=$comisionRepository->findBy(array('activa'=>true),array('comision' => 'ASC'));
        $resultado=[];
        foreach ($comisiones as $comision){
        	$registro=array(
        					'id'=>$comision->getId(), 'comision'=>$comision->getComision(),
        					'presidente'=>$comision->getPresidente()->getNombreCompleto(),
        					'vice_presidente'=>$comision->getVicePresidente()->getNombreCompleto(),
        					'lista_titulares'=>$comision->getListaTitulares(),
        					'lista_suplentes'=>$comision->getListaSuplentes(),
        					'tipo_comision'=>$comision->getTipoComision()->getTipoComision()
        					);
        	$resultado[]=$registro;
        }
        return $this->view($resultado,200);
    }
    
    /**
     * @Rest\Get("/api/comision/getOne/{id}")
     */
    public function traerComisionPorIdAction(Request $request)
    {
    	$idComision=$request->get('id');
    	$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    	$comision=$comisionRepository->find($idComision);
    	$titulares=[];
    	foreach ($comision->getTitulares() as $titular){
    		$registro=array('id'=>$titular->getId(), 'nombre_completo'=>$titular->getNombreCompleto());
    		$titulares[]=$registro;
    	}
    	$suplentes=[];
    	foreach ($comision->getSuplentes() as $suplente){
    		$registro=array('id'=>$suplente->getId(), 'nombre_completo'=>$suplente->getNombreCompleto());
    		$suplentes[]=$registro;
    	}
    	$resultado=array('comision'=>$comision->getComision(),
				    	 'presidente'=>array(
				    					 	 'id'=>$comision->getPresidente()->getId(),
				    					 	 'nombre_completo'=>$comision->getPresidente()->getNombreCompleto()
				    					 	 ),
    					 'vice_presidente'=>array(
							    				  'id'=>$comision->getVicePresidente()->getId(),
							    				  'nombre_completo'=>$comision->getVicePresidente()->getNombreCompleto()
							    			),
    					 'titulares'=>$titulares,
    					 'suplentes'=>$suplentes,
    					 'tipo_comision'=>$comision->getTipoComision()->getId()
    	);
    	
    	return $this->view($resultado,200);
    }
    
    /**
     * @Rest\Post("/api/comision/remove/{id}")
     */
    public function eliminarComisionAction(Request $request){
    	
    	try {
		    	$idComision=$request->get('id');
		    	$comisionReposiory=$this->getDoctrine()->getRepository('AppBundle:Comision');
		    	$comision=$comisionReposiory->find($idComision);
		    	$usuarioSesion=$this->getUser();
		    	
		    	$comision->setActiva(false);
		    	$comision->setUsuarioModificacion($usuarioSesion->getUsername());
		    	$comision->setFechaModificacion(new \DateTime("now"));
		    	
		    	$em = $this->getDoctrine()->getManager();
		    	$em->persist($comision);
		    	$em->flush();
		    	
		    	return $this->view("La comisión ".$comision->getComision()." se eliminó exitosamente",200);
		    	
    	}catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    }
    
    /**
     * @Rest\Post("/api/comision/save")
     */
    public function guardarCommisionAction(Request $request){
    	
    	$idTipoComision=$request->request->get('idTipoComision');
    	$descripcion=$request->request->get('descripcion');
    	$presidente=$request->request->get('presidente');
    	$vicePresidente=$request->request->get('vicePresidente');
    	$titulares=$request->request->get('titulares');
    	$suplentes=$request->request->get('suplentes');
    	$idComision=$request->request->get('idComision');
    	$usuarioSesion=$this->getUser();
    	
    	$mensaje="";
    	
    	try{
		    	$comisionReposiory=$this->getDoctrine()->getRepository('AppBundle:Comision');
		    	$perfilReposiory=$this->getDoctrine()->getRepository('AppBundle:Perfil');
		    	$tipoComisionReposiory=$this->getDoctrine()->getRepository('AppBundle:TipoComision');
		    	$tipoComision=$tipoComisionReposiory->find($idTipoComision);
		    	
		    	$comision=null;
		    	
		    	if($idComision!=0){
		    		$comision=$comisionReposiory->find($idComision);
		    		$comision->setUsuarioModificacion($usuarioSesion->getUsername());
		    		$comision->setFechaModificacion(new \DateTime("now"));
		    		$mensaje="La comisión ".$comision->getComision()." se modificó con éxito";
		    	}
		    	else {
		    			$comision= new Comision();
		    			$comision->setUsuarioCreacion($usuarioSesion->getUsername());
		    			$comision->setFechaCreacion(new \DateTime("now"));
		    			$mensaje="La comisión de agregó con éxito";
		    	}
		    	
		    	$perfilPresidente=$perfilReposiory->find($presidente);
		    	$perfilVicePresidente=$perfilReposiory->find($vicePresidente);
		    	$concejalesTitulares=explode(',',$titulares);
		    	$nuevosTitulares=[];
		    	foreach ($concejalesTitulares as $titular){
		    		$perfilTitular=$perfilReposiory->find($titular);
		    		$nuevosTitulares[]=$perfilTitular;	
		    	}
		    	$concejalesSuplentes=explode(',',$suplentes);
		    	$nuevosSuplentes=[];
		    	foreach ($concejalesSuplentes as $suplente){
		    		$perfilSuplente=$perfilReposiory->find($suplente);
		    		$nuevosSuplentes[]=$perfilSuplente;
		    	}
		    	
		    	$comision->setActiva(true);
		    	$comision->setComision($descripcion);
		    	$comision->setTipoComision($tipoComision);
		    	$comision->setPresidente($perfilPresidente);
		    	$comision->setVicePresidente($perfilVicePresidente);
		    	$comision->setTitulares($nuevosTitulares);
		    	$comision->setSuplentes($nuevosSuplentes);
		    	
		    	$em = $this->getDoctrine()->getManager();
		    	$em->persist($comision);
		    	$em->flush();
		    	
		    	return $this->view($mensaje,200);
		    	
	    }catch(\Exception $e){
	    	
	    	return $this->view($e->getMessage(),500);
	    }
    	
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
    	
    	$resutado=[];
    	foreach ($sesiones as $sesion){
    		$registro=array('id'=>$sesion->getId(), 
    						'tiene_orden_del_dia'=>$sesion->getTieneOrdenDelDia(),
    						'tipo_sesion'=>$sesion->getTipoSesion()->getTipoSesion(),
    						'descripcion'=>$sesion->getDescripcion(),
    						'fecha_formateada'=>$sesion->getFechaFormateada(),
    						'año'=>$sesion->getAño(),
    						'cantidad_expedientes'=>$sesion->getCantidadExpedientes(),
    						'tiene_edicion_bloqueada'=>$sesion->getTieneEdicionBloqueada()
    						);
    		$resutado[]=$registro;
    			
    	}
    		
    	return $this->view($resutado,200);
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
	    	$sesionesPersistidas=$sesionReposiory->findBy(array('tipoSesion' => $tipoSesion,'fecha' => $fechaSesion));
	    	
	    	if (count($sesionesPersistidas)>0)
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
    
    /**
     * @Rest\Post("/api/sesion/ordenDia/create")
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
     * @Rest\Post("/api/sesion/ordenDia/remove")
     */
    public function  borrarOrdenDelDia(Request $request){
    	
    	$idSesion=$request->request->get('idSesion');
    	
    	try {
    		$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    		$sesionRepository->removeOrdenDelDia($idSesion);
    		
    		return $this->view('La orden del día se eliminó en forma correcta',200);
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    	
    }
    
    /**
     * @Rest\Post("/api/sesion/ordenDia/invalidate")
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