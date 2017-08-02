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
     * @Rest\Get("/api/expediente/getNumeroCompletoByNumero")
     */
    public function traerNumeroCompletoByNumeroAction(Request $request)
    {
    	try{
    		
    		$numero=$request->query->get('q');
    		$usuario=$this->getUser();
    		   	    		
    		$valorRetorno=[];
    		$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    		$resultado=$expedienteRepository->findNumeroCompletoByNumero($numero,
    																	 $usuario->getRol()->getOficina());
    		if (!is_null($resultado)){
	    		$formato = 'Y-m-d H:i:s';
	    		$fecha = \DateTime::createFromFormat($formato,$resultado["fecha"]);
	    		$ejercicio=substr($fecha->format("Y"),2,2);
	    		$numeroCompleto=$resultado["numero"].'-'.$resultado["letra"].'-'.$ejercicio.'('.$resultado["folios"].')';
	    		$valorRetorno=array(array('id' => $resultado["id"],'numeroCompleto' => $numeroCompleto));
	    		return $this->view($valorRetorno,200);
    		}
    		
    	}catch(\Exception $e){
    		
    		return $this->view($e->getMessage(),500);
    	}
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
            if ($tipoCriterio=='busqueda-5')
                	$expedientes=$expedienteRepository->findByParticular_Nombres($criterio);
            if ($tipoCriterio=='busqueda-6')
                	$expedientes=$expedienteRepository->findByParticular_DNI($criterio);
			
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
     * @Rest\Get("/api/expediente/giro/getAllByExpediente/{id}")
     */
    public function traerGirosPorIdExpedienteAction(Request $request)
    {
    	$id=$request->get('id');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$giros=$expedienteRepository->findGirosByExpediente_Id($id);
    	return $this->view($giros,200);
    }
    
    /**
     * @Rest\Post("/api/expediente/retornoExterno")
     */
    public function retornoExpedienteAction(Request $request)
    {
    	$idExpediente=$request->request->get('idExpediente');
    	$folios=$request->request->get('folios');
    	$fecha=$request->request->get('fecha');
    	$numeroRemito=$request->request->get('numeroRemito');
    	
    	try {
    		
    		$usuario=$this->getUser();
    		$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    		$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    		$tipoMovimientoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoMovimiento');
    		$fechaActual=new \DateTime('now');
    		$idOficinaMesaEntradas=$this->getParameter('id_mesa_entradas');
    		$idMovimientoPase=$this->getParameter('id_movimiento_pase');
    		
    		$expediente=$expedienteRepository->find($idExpediente);
    		$tipoMovimiento=$tipoMovimientoRepository->find($idMovimientoPase);
    		$destino=$oficinaRepository->find($idOficinaMesaEntradas);
    		$fechaRecepcion= \DateTime::createFromFormat('d/m/Y', $fecha);
    		
    		$remito= new Remito();
    		$origen=$oficinaRepository->find($expediente->getOficinaActual());
    		$remito->setDestino($destino);
    		$remito->setOrigen($origen);
    		$remito->setFechaCreacion($fechaActual);
    		$remito->setUsuarioCreacion($usuario->getUsuario());
    		$remito->setFechaRecepcion($fechaRecepcion);
    		
    		$em = $this->getDoctrine()->getManager();
  
    		$expediente->setOficinaActual($destino); //cambia destino de expediente
    		$expediente->setFolios($folios); //actualiza los folios del expediente
    		$em->persist($expediente);
    				
    		$movimiento= new Movimiento();
    		$movimiento->setExpediente($expediente);
    		$movimiento->setFechaCreacion($fechaActual);
    		$movimiento->setUsuarioCreacion($usuario->getUsuario());
    		$movimiento->setRemitoRetorno($numeroRemito);
    		$movimiento->setFojas($folios);
    		$movimiento->setObservacion("Autopase por Retorno");
    		$movimiento->setTipoMovimiento($tipoMovimiento);
    		$remito->addMovimiento($movimiento);
    				
    		$em->persist($remito);
    		$em->flush();
    		
    		return $this->view("El retorno del expediente se generó forma exitosa",200);
    		
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    }
    /**
     * @Rest\Get("/api/expediente/remito/getAllByCriteria/{tipoCriterio}/{criterio}")
     */
    public function traerRemitosPorOficinayCriterioAction(Request $request)
    {
    	
    	try{
	    	$tipoCriterio=$request->get('tipoCriterio');
	    	$criterio=$request->get('criterio');
	    	$oficina=$this->getUser()->getRol()->getOficina();
	    	$remitoRepository=$this->getDoctrine()->getRepository('AppBundle:Remito');
	    	
	    	$remitos="";
	    	if ($tipoCriterio=='todo')
	    		$remitos=$remitoRepository->findByOficina($oficina,"any",$criterio);
	    	if($tipoCriterio=='busqueda-1')
	    		$remitos=$remitoRepository->findByOficina($oficina,"out",$criterio);
	    	if ($tipoCriterio=='busqueda-2'){
	    		$criterio=substr($criterio, -4)."-".substr($criterio, -6, -4)."-".substr($criterio, 0,strlen($criterio)-6);
	    		$fecha =new \DateTime($criterio);
	    		$remitos=$remitoRepository->findByOficinaYFechaCreacion($oficina,$fecha->format('Y-m-d'));
	    	}
	    	if($tipoCriterio=='busqueda-3')
	    		$remitos=$remitoRepository->findByOficina($oficina,"in",$criterio);
	    	if ($tipoCriterio=='busqueda-4'){
	    		$criterio=substr($criterio, -4)."-".substr($criterio, -6, -4)."-".substr($criterio, 0,strlen($criterio)-6);
	    		$fecha =new \DateTime($criterio);
	    		$remitos=$remitoRepository->findByOficinaYFechaRecepcion($oficina,$fecha->format('Y-m-d'));
	    	}
	    	if ($tipoCriterio=='busqueda-5'){
	    		$remitos=$remitoRepository->findByNumeroCompleto($oficina,$criterio);
	    	}
	    	
	    	return $this->view($remitos,200);
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    }
    
    /**
     * @Rest\Get("api/expedienteComision/getByCriteria/{tipoCriterio}/{criterio}")
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
    		return $this->view($expedientesAsignados,200);
	    }
	    catch (\Exception $e){
	    	return $this->view($e->getMessage(),500);
	    }
    }
    
    /**
     * @Rest\Post("/api/expedienteComision/visualizacion/update")
     */
    public function cambiarVisualizacionExpedienteComisionAction(Request $request)
    {
    	$idAsignacion=$request->request->get('idAsignacion');
    	$accion=$request->request->get('accion');	
    	$usuario=$this->getUser();
    	
    	//TODO: validar que este recibido
    	
    	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    	$expedienteComision=$expedienteComisionRepository->find($idAsignacion);
    	
    	if ($accion=="publicar"){
    		$expedienteComision->setPublicado(true);
    		$expedienteComision->setFechaPublicacion(new \DateTime());
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
     * @Rest\Post("/api/expedienteComision/comision/update")
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
     * @Rest\Post("/api/expediente/remito/create")
     */
    public function crearRemitoExpedienteAction(Request $request)
    {
    	$idOficina=$request->request->get('idDestino');
    	$remitoDetalle=json_decode($request->request->get('remitoDetalle'));
    	
    	$usuario=$this->getUser();
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$tipoMovimientoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoMovimiento');
    	$fechaActual=new \DateTime('now');
    	$origen=$usuario->getRol()->getOficina();
 
    	$movimientoInforme=$this->getParameter('id_Movimiento_informe');
    	
    	$remito= new Remito();
    	$destino=$oficinaRepository->find($idOficina);
    	$remito->setDestino($destino);
    	$remito->setOrigen($origen);
    	$remito->setFechaCreacion($fechaActual);
    	$remito->setUsuarioCreacion($usuario->getUsuario());
    	
    	$em = $this->getDoctrine()->getManager();

    	foreach ($remitoDetalle as $detalle) {
    		
    		$expediente=$expedienteRepository->find($detalle->id);
    		$tipoMovimiento=$tipoMovimientoRepository->find($detalle->idTipoMovimiento);
    		if (!($tipoMovimiento==$movimientoInforme)) 
    			$expediente->setOficinaActual($destino); //cambia destino de expediente
    		$em->persist($expediente);
    		
    		$movimiento= new Movimiento();
    		$movimiento->setExpediente($expediente);
    		$movimiento->setFechaCreacion($fechaActual);
    		$movimiento->setUsuarioCreacion($usuario->getUsuario());
    		$movimiento->setFojas($detalle->folios);
    		$movimiento->setObservacion($detalle->observaciones);
    		
    		$movimiento->setTipoMovimiento($tipoMovimiento);
    	
    		$remito->addMovimiento($movimiento);
    		if($detalle->incluyeComision){
    			$expedienteComision=new ExpedienteComision();
    			$expedienteComision->setExpediente($expediente);
    			$expedienteComision->setFechaCreacion($fechaActual);
    			$expedienteComision->setUsuarioCreacion($usuario->getUsuario());
    			$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    			$comision=$comisionRepository->find($detalle->idComision);
    			$expedienteComision->setComision($comision);
    			$em->persist($expedienteComision);
    		}
    	}
    	$em->persist($remito);
    	$em->flush();
    	
    	return $this->view("El remito se guardó en forma exitosa",200);
    	
    }
    
    /**
     * @Rest\Post("/api/expediente/remito/invalidate")
     */
    public function anularRemitoAction(Request $request)
    {	
    	$idRemito = $request->request->get('idRemito');
    	$motivoAnulacion = $request->request->get('motivoAnulacion');
    	
    	$remitoRepository=$this->getDoctrine()->getRepository('AppBundle:Remito');
    	$remito = $remitoRepository->find($idRemito);
    	
    	if($remito->getFechaRecepcion()!=null)
    		return $this->view("El remito ".$remito->getId()." tiene fecha de recepción. No se puede Anular",500);
    	
    	if($remito->getAnulado()==true)	
    		return $this->view("El remito ".$remito->getId()." ya se encuentra anulado. No se puede Anular",500);
    	
    	$remito->setAnulado(true);
    	$remito->setMotivoAnulacion($motivoAnulacion);
    	foreach ($remito->getMovimiento() as $movimiento) {
    		$movimiento->setAnulado(true);
    	}
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($remito);
    	$em->flush();
    	
    	return $this->view("El remito se anuló en forma exitosa",200);
    	
    }
    
    /**
     * @Rest\Post("/api/expediente/remito/update")
     */
    public function actualizarFechaRemitoAction(Request $request)
    {
    	$idRemito = $request->request->get('idRemito');
    	$fechaRecepcion = $request->request->get('fechaRecepcion');
    	
    	$fecha = \DateTime::createFromFormat('d/m/Y', $fechaRecepcion);
    	$remitoRepository=$this->getDoctrine()->getRepository('AppBundle:Remito');
    	$remito = $remitoRepository->find($idRemito);
    	
    	if ($remito->getFechaRecepcion()!=null)
    		return $this->view("El remito ".$remito->getId()." ya tiene fecha de recepción",500);
    	
    	if ($remito->getAnulado()==true)
    		return $this->view("El remito ".$remito->getId()." se encuentra anulado",500);
    	
    	$remito->setFechaRecepcion($fecha);
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($remito);
    	$em->flush();
    	
    	return $this->view("El remito ".$remito->getId()." se actualizó en forma exitosa",200);
    }
    
            
    /**
     * @Rest\Get("/api/expediente/informe/getAllByExpediente/{id}")
     */
    public function traerInformesPorIdExpedienteAction(Request $request)
    {
    	$id=$request->get('id');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$informes=$expedienteRepository->findInformesByExpediente_Id($id);
    	return $this->view($informes,200);
    }
    
    /**
     * @Rest\Post("/api/expediente/informe/respuesta/update")
     */
    public function actualizarRespuestaInformeAction(Request $request)
    {
    	$idInforme=$request->request->get('idInforme');
    	$fecha=$request->request->get('fecha');
    	$numeroRemito=$request->request->get('numeroRemito');
    	
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Movimiento');
    	$usuario=$this->getUser();
    	$fechaActual=new \DateTime('now');
    	
    	$informe=$expedienteRepository->find($idInforme);
    	$fechaRespuesta=\DateTime::createFromFormat('d/m/Y', $fecha);
    	$informe->setFechaRespuestaInforme($fechaRespuesta);
    	$informe->setRemitoRetorno($numeroRemito);
    	$informe->setFechaModificacion($fechaActual);
    	$informe->setUsuarioModificacion($usuario->getUsuario());
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($informe);
    	$em->flush();
    	
    	return $this->view("El informe se actualizó en forma exitosa",200);
    }
    
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
     *  @Rest\Post("/api/proyecto/create")
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
     *  @Rest\Post("/api/expediente/create")
     */
    public function crearExpedienteAction(Request $request)
    {   
        try{ 
        	//request params
            $idproyecto=$request->request->get('idProyecto'); 
            $idTipoExpediente=$request->request->get('idTipoExpediente');
            $numeroExpediente=$request->request->get('numeroExpediente');
            $año=$request->request->get('año');
            $folios=$request->request->get('folios');
            $documentoParticular=$request->request->get('documentoParticular');
            $apellidosParticular=$request->request->get('apellidosParticular');
            $nombresParticular=$request->request->get('nombresParticular');
            $idOrigen=$request->request->get('idOrigen');
            $numeros=json_decode($request->request->get('numeros'));
            $caratula=$request->request->get('caratula');
            //$idSesion=$request->request->get('numeroSancion');
            $archivos=$request->files->all();
            $usuario=$this->getUser();
            
            //repositorios y parámetros de configuración
            $tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
            //$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
            $estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
            $oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
            $idMesaEntradas=$this->getParameter('id_mesa_entradas');
                 
            //nuevo expediente
            $expediente=new Expediente();
            
            //caratulación del HCD
            $expediente->setFolios($folios);
            $expediente->setArchivos($archivos);
            $expediente->setNumeroExpediente($numeroExpediente);
            $expediente->setAño($año);
            $expediente->setCaratula($caratula);
            //$sesion=$sesionRepository->find($idSesion);
            //$expediente->setSesion($sesion);
            
            
            //establece la oficina actual (todos ingresan por mesa de entradas)
            $oficina=$oficinaRepository->find($idMesaEntradas);
            $expediente->setOficinaActual($oficina);
      		
  			//establece el proyecto
            $proyecto=null;
            if($idproyecto!=0){
                $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
                $proyecto=$proyectoRepository->find($idproyecto); 
                $expediente->setProyecto($proyecto);
            }
            
			//establece el tipo de expediente
            $tipoExpediente=null;
            if($proyecto==null)
                $tipoExpediente=$tipoExpedienteRepository->find($idTipoExpediente);
            else 
            	$tipoExpediente=$proyecto->getTipoProyecto()->getTipoExpediente();
            $expediente->setTipoExpediente($tipoExpediente);
            
            //si es un expediente particular establece los datos del demandante
            $demandanteParticular=null;
            if ($idTipoExpediente==3){
            	$demandanteParticular= new DemandanteParticular();
            	$demandanteParticular->setDocumento($documentoParticular);
            	$demandanteParticular->setApellidos($apellidosParticular);
            	$demandanteParticular->setNombres($nombresParticular);
            }
            $expediente->setDemandanteParticular($demandanteParticular);
            
            //si el expediente proviene del ejecutivo establece el origen externo
            $oficinaOrigen=null;
            if ($idTipoExpediente==4){
            	$origenExterno=new OrigenExterno();
            	$oficinaOrigen=$oficinaRepository->find($idOrigen);
            	$origenExterno->setOficina($oficinaOrigen);
            	$origenExterno->setNumeracionOrigen($numeros);
            }
            $expediente->setOrigenExterno($origenExterno);
            
            //Compatibilidad al inicio de la etapa de producción
            $primerExpedienteSistema=$this->getParameter('primer_numero_sistema');
            
            //setea el estado del expediente
            $estadoExpediente=null;
            if($numeroExpediente<$primerExpedienteSistema)
            		//entrado
            		$estadoExpediente=$estadoExpedienteRepository->find(1);
            	else
            		//incorporado sistema anterior
            		$estadoExpediente=$estadoExpedienteRepository->find(5);
            $expediente->setEstadoExpediente($estadoExpediente);

            //datos de auditoría
            $expediente->setUsuarioCreacion($usuario->getUsername());
            $expediente->setFechaCreacion(new \DateTime("now"));

            //persistencia en BD
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
            
        	$idExpediente=$request->request->get('idExpediente');
        	$idTipoExpediente=$request->request->get('idTipoExpediente');
        	$numeroExpediente=$request->request->get('numeroExpediente');
            $folios=$request->request->get('folios'); 
            $documentoParticular=$request->request->get('documentoParticular');
            $apellidosParticular=$request->request->get('apellidosParticular');
            $nombresParticular=$request->request->get('nombresParticular');
            $idOrigen=$request->request->get('idOrigen');
            $numeros=json_decode($request->request->get('numeros'));           
            $caratula=$request->request->get('caratula');
            $año=$request->request->get('año');
            //$idSesion=$request->request->get('numeroSancion');
            $numeroSancion=$request->request->get('numeroSancion');
            $archivos=$request->files->all();
            $usuario=$this->getUser();

            $tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
            //$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
            $oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
            $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
            $expediente=$expedienteRepository->find($idExpediente); 
			
            //datos del HCD
            $expediente->setNumeroExpediente($numeroExpediente);
            $expediente->setAño($año);
            $expediente->setFolios($folios);
            $expediente->setCaratula($caratula);
            //$sesion=$sesionRepository->find($idSesion);
            //$expediente->setSesion($sesion);
            $expediente->setNumeroSancion($numeroSancion);
            $expediente->setArchivos($archivos);
            $proyecto=$expediente->getProyecto();
            
            $tipoExpediente=null;
            if($proyecto==null)
                $tipoExpediente=$tipoExpedienteRepository->find($idTipoExpediente);
            else
                $tipoExpediente=$proyecto->getTipoProyecto()->getTipoExpediente();
            $expediente->setTipoExpediente($tipoExpediente);
                
           	$demandanteParticular=null;
           	if ($idTipoExpediente==3){
            	$demandanteParticular= new DemandanteParticular();
                $demandanteParticular->setDocumento($documentoParticular);
                $demandanteParticular->setApellidos($apellidosParticular);
                $demandanteParticular->setNombres($nombresParticular);
                $expediente->setOrigenExterno(null);
            }
            $expediente->setDemandanteParticular($demandanteParticular);
                  
            $origenExterno=null;
            if ($idTipoExpediente==4){
            	$origenExterno= new OrigenExterno();
            	$origenExterno->setNumeracionOrigen($numeros);
            	$oficinaOrigen = $oficinaRepository->find($idOrigen);
            	$origenExterno->setOficina($oficinaOrigen);
            	$expediente->setDemandanteParticular(null);
            }
            $expediente->setOrigenExterno($origenExterno);

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
     *  @Rest\Get("/api/rol/permisos/getByRol/{idRol}")	
     */
    public function traerPermisosRolAction(Request $request)
    {
    	$idRol=$request->get("idRol");
    	$rolRepository=$this->getDoctrine()->getRepository('AppBundle:Rol');
    	$rol=$rolRepository->find($idRol);
    	
    	return $this->view($rol->getMenus(),200);
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
            $domicilio=$request->request->get('domicilio');
            $documento=$request->request->get('documento');
            $idBloque=$request->request->get('selBloque');
            $idPerfil=$request->request->get('selLegislador');
            $permisos=json_decode($request->request->get('permisos'));
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
            $usuario->setPermisos($permisos);
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
                $domicilio=$request->request->get('domicilioMOd');
                $documento=$request->request->get('documentoMod');
                $permisos=json_decode($request->request->get('permisos'));
                $archivos=$request->files->all();
                $usuarioSesion=$this->getUser();

                $em = $this->getDoctrine()->getManager();
             
                $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
                $usuario=$usuarioRepository->find($id);
                $rolRepository=$this->getDoctrine()->getRepository('AppBundle:Rol');
                $rol=$rolRepository->find($idRol);



                $perfil=$usuario->getPerfil();

                if(!($perfil instanceof PerfilLegislador)){

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
                $usuario->setPermisos($permisos);
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