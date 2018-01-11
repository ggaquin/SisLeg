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
use AppBundle\Entity\Comision;
use AppBundle\Entity\DemandanteParticular;
use AppBundle\Entity\EstadoExpediente;
use AppBundle\Entity\Expediente;
use AppBundle\Entity\ExpedienteComision;
use AppBundle\Entity\Movimiento;
use AppBundle\Entity\Oficina;
use AppBundle\Entity\OrigenExterno;
use AppBundle\Entity\Proyecto;
use AppBundle\Entity\Remito;
use AppBundle\Entity\Sesion;
use AppBundle\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use AppBundle\Entity\Pase;
use AppBundle\Entity\SolicitudInforme;

/**
 * @Route("/api/expediente")
 *
 */
class RestExpedienteController extends FOSRestController{


    
    /**
     * @Rest\Get("/getAll")
     */
    public function traerTodosLosExpedientesAction(Request $request)
    {

        $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
        $expedientes=$expedienteRepository->findAll();
        return $this->view($expedientes,200);
         
    }

    /**
     * @Rest\Get("/getNumeroCompletoByNumero")
     */
    public function traerNumeroCompletoByNumeroAction(Request $request)
    {
    	try{
    		
    		$numero=$request->query->get('q');
    		$destino=$request->query->get('r');
    		$usuario=$this->getUser();
    		   	    		
    		$valorRetorno=[];
    		$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    		$resultados=$expedienteRepository->findNumeroCompletoByNumero($numero,
																		  $usuario->getRol()->getOficina(),
    																	  $destino
    																	 );
    		
    		if (count($resultados)>0){
    			
    			foreach ($resultados as $resultado){
    				
    				$ejercicio=substr($resultado['periodo'],2);
    				$numeroCompleto=$resultado["numero"].'-'.$resultado["letra"].'-'.$ejercicio.'('.$resultado["folios"].')';
    				$valorRetorno[]=array(
    									  'id' => $resultado["id"],
    									  'numeroCompleto' => $numeroCompleto
    									  );    				
    			}
    		}
    		
    		return $this->view($valorRetorno,200);
    		
    	}catch(\Exception $e){
    		
    		return $this->view($e->getMessage(),500);
    	}
    }
    
//     /**
//      * @Rest\Get("/getNumeroCompletoByNumero")
//      */
//     public function traerNumeroCompletoByNumeroYPeriodoAction(Request $request)
//     {
//     	try{
    		
//     		$numeroYPeriodo=$request->query->get('q');
//     		$expedienteExclusion=$request->query->get('r');
//     		$usuario=$this->getUser();
    		
//     		$valorRetorno=[];
//     		$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
//     		$resultados=$expedienteRepository->findNumeroCompletoByNumero($numero,
//     				$usuario->getRol()->getOficina(),
//     				$destino
//     				);
    		
//     		if (count($resultados)>0){
    			
//     			foreach ($resultados as $resultado){
    				
//     				$ejercicio=substr($resultado['periodo'],2);
//     				$numeroCompleto=$resultado["numero"].'-'.$resultado["letra"].'-'.$ejercicio.'('.$resultado["folios"].')';
//     				$valorRetorno[]=array(
//     						'id' => $resultado["id"],
//     						'numeroCompleto' => $numeroCompleto
//     				);
//     			}
//     		}
    		
//     		return $this->view($valorRetorno,200);
    		
//     	}catch(\Exception $e){
    		
//     		return $this->view($e->getMessage(),500);
//     	}
//     }
    		
    
    /**
     * @Rest\Get("/getByCriteria/{tipoCriterio}/{criterio}")
     */
    public function traerExpedientesPorCriterioAction(Request $request)
    {
        try{

            $tipoCriterio=$request->get('tipoCriterio');
            $criterio=$request->get('criterio');
            $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
            $expedientes=null;
            if ($tipoCriterio=='todo')
                $expedientes=$expedienteRepository->findAll(array('fechaCreacion'=>null));
            if($tipoCriterio=='busqueda-1')
                $expedientes=$expedienteRepository->findByAutor_Nombres($criterio);
            if ($tipoCriterio=='busqueda-2')
                $expedientes=$expedienteRepository->findByEstado_Id($criterio);
            if($tipoCriterio=='busqueda-3')
            	$expedientes=$expedienteRepository->findByNumeroCompleto($criterio);
            if ($tipoCriterio=='busqueda-4')
                $expedientes=$expedienteRepository->findByTipoExpediente_Id($criterio);
            if ($tipoCriterio=='busqueda-5')
                $expedientes=$expedienteRepository->findByParticular_Nombres($criterio);
            if ($tipoCriterio=='busqueda-6')
                $expedientes=$expedienteRepository->findByParticular_DNI($criterio);
            if ($tipoCriterio=='busqueda-7')
                $expedientes=$expedienteRepository->findByArchivo();
            if ($tipoCriterio=='busqueda-8')
            	$expedientes=$expedienteRepository->findBySesion_Id($criterio);
		
            $resutado=[];	
            foreach ($expedientes as $expediente){
            	$registro=array('id'=>$expediente->getId(), 'numero_completo'=>$expediente->getNumeroCompleto(),
            					'tipo_expediente'=>$expediente->getTipoExpediente()->getTipoExpediente(),
            					'fecha_creacion_formateada'=>$expediente->getFechaCreacionFormateada(),
            					'fecha_modificacion_formateada'=>$expediente->getFechaModificacionFormateada(),
            					'oficina_actual'=>$expediente->getOficinaActual()->getOficina(),
            					'caratula_muestra'=>$expediente->getCaratulaMuestra(),
            					'caratula_sin_html'=>$expediente->getCaratulaSinHtml(),
            					'oficina_actual_externa'=>$expediente->getOficinaActual()->getEsExterna(),
            					'lista_comisiones_asignadas'=>$expediente->getListaComisionesAsignadas(),
            					'folios'=>$expediente->getFolios(),
            					'estado'=>$expediente->getEstadoExpediente()->getEstadoExpediente(),
            					'numero_sancion'=>$expediente->getNumeroSancion(),
            					'permite_edicion'=>$expediente->getPermiteEdicion(),
            					'fecha_archivo_formateada'=>$expediente->getfechaArchivoFormateada(),
            					'comision_reserva'=>$expediente->getComisionReserva(),
            					'ultimo_momento'=>$expediente->getUltimoMomento(),
            					'sesion'=>(!is_null($expediente->getSesion())
            								?$expediente->getSesion():'')
            					);
            	$resutado[]=$registro;
            	
            }
            return $this->view($resutado,200);

        }catch(\Exception $e)   {
            return $this->view($e->getMessage(),500);
        }
    }
    
    /**
     * @Rest\Put("/archivar/{id}")
     */
    public function archivarExpedienteAction(Request $request){
    	
    	$id=$request->get('id');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
    	$estadoExpediente=$estadoExpedienteRepository->find(6);
    	$expediente=$expedienteRepository->find($id);
    	$usuario=$this->getUser();
    	
    	if (!is_null($expediente->getFerchaArchivo()))
    		return $this->view("El expediente ya se encuentra archivado desde "+$expediente->fechaArchivoFormateada(),500);
    	else {
    			$fechaActual=new \DateTime('now');
    			$expediente->setFechaModificacion($fechaActual);
    			$expediente->setUsuarioModificacion($usuario->getUsuario());
    			$expediente->setFechaArchivo($fechaActual);
    			$expediente->setEstadoExpediente($estadoExpediente);
    			
    			$em = $this->getDoctrine()->getManager();
    			$em->persist($expediente);
    			$em->flush();
    			
    			return $this->view("El expediente se archivó con exito ",200);
    	}
    	
	}
	
	/**
	 * @Rest\Put("/desarchivar/{id}")
	 */
	public function desarchivarExpediente(Request $request){
		
		$id=$request->request->get('id');
		$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
		$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
		$estadoExpediente=$estadoExpedienteRepository->find(7);
		$expediente=$expedienteRepository->find($id);
		$usuario=$this->getUser();
		
		if($expediente->getNumeroSancion!='')
			return $this->view("El expediente tiene sanción, no puede ser desarchivado ",500);
		else{
				$fechaActual=new \DateTime('now');
				$expediente->setFechaModificacion($fechaActual);
				$expediente->setUsuarioModificacion($usuario->getUsuario());
				$expediente->setFechaArchivo(null);
				$expediente->setSesion(null);
				$expediente->setUltimoMomento(false);
				$expediente->setEstadoExpediente($estadoExpediente);
				
				$em = $this->getDoctrine()->getManager();
				$em->persist($expediente);
				$em->flush();
			
				return $this->view("El expediente se archivó con exito ",200);
		}
	}
	
	/**
	 * @Rest\Post("/modificarSesion")
	 */
	public function modificarSesionAction(Request $request)
	{
		$idExpediente=$request->request->get('idExpediente');
		$idSesion=$request->request->get('idSesion');
		$usuario=$this->getUser();
		
			$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
		$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
		$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
		$fechaActual=new \DateTime('now');
		
		$sesion=$sesionRepository->find($idSesion);
		$expediente=$expedienteRepository->find($idExpediente);
		$expedientesGirados=$expedienteComisionRepository->findBy(array('expediente'=>$expediente,
																		'sesion'=>$sesion));
		
		$em = $this->getDoctrine()->getManager();
		
		$expediente->setSesion($sesion);
		$expediente->setUltimoMomento($sesion->getTieneOrdenDelDia());
		$expediente->setUsuarioModificacion($usuario->getUsuario());
		if($idSesion!=$expediente->getSesion()->getId())
			$expediente->setUltimoMomento(false);
		$expediente->setFechaModificacion($fechaActual);
		$cuentaExpedientesGirados=count($expedientesGirados);
		foreach ($expedientesGirados as $expedienteGirado){
			$expedienteGirado->setSesion($sesion);
			$expedienteGirado->setUsuarioModificacion($usuario->getUsuario());
			$expedienteGirado->setFechaModificacion($fechaActual);
			$em->persist($expedienteGirado);
		}
		
		$cambiosExpedienteGirados=(($cuentaExpedientesGirados>0)
								   ?"También se cambiaron las fechas de sesión en ".$cuentaExpedientesGirados.
									" asignaciones en comisión"
								   :"");
		
		$em->persist($expediente);
		$em->flush();
		
		return $this->view("La fecha de sesión se cambió con éxito. ".$cambiosExpedienteGirados,200);
		
	}
	
	/**
	 * @Rest\Patch("/editUltimoMomento/{id}")
	 */
	public function editarUltimoMomento(Request $request)
	{
		$idExpediente=$request->get('id');
		$usuario=$this->getUser();
		
		$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
		$expediente=$expedienteRepository->find($idExpediente);
		$fechaActual=new \DateTime('now');
		
		$expediente->setUltimoMomento(false);
		$expediente->setUsuarioModificacion($usuario->getUsuario());
		$expediente->setFechaModificacion($fechaActual);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($expediente);
		$em->flush();
		
		return $this->view("El expediente se quitó del listado de último momento con éxito",200);
		
		
	}
	
    /**
     * @Rest\Get("/getOne/{id}")
     */
    public function traerExpedientePorIdAction(Request $request)
    {
        $id=$request->get('id');
        $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
        $expediente=$expedienteRepository->find($id);
        $resultado=array(
        				 'tipo_expediente'=>$expediente->getTipoExpediente()->getId(),
        				 'numero_expediente'=>$expediente->getNumeroExpediente(),
        				 'caratula'=>$expediente->getCaratula(),
        				 'folios'=>$expediente->getFolios(),
        				 'numero_sancion'=>$expediente->getNumeroSancion(),
        				 'año'=>$expediente->getPeriodo(), 
        				 'sesion'=>$expediente->getSesion(),
        				 'concejal'=>(!is_null($expediente->getProyecto())
        				 				?$expediente->getProyecto()->getConcejal()->getNombreCompleto()
        				 				:""),
        				 'proyecto'=>(($expediente->getProyecto()!=null)?$expediente->getProyecto()->getId():0),
        				 'demandante_documento'=>(($expediente->getDemandanteParticular()!=null)
        				 							?$expediente->getDemandanteParticular()->getDocumento()
        				 							:""),
        				 'demandante_apellidos'=>(($expediente->getDemandanteParticular()!=null)
        				 							?$expediente->getDemandanteParticular()->getApellidos()
        				 							:""),
        				 'demandante_nombres'=>(($expediente->getDemandanteParticular()!=null)
        				 							?$expediente->getDemandanteParticular()->getNombres()
        				 							:""),
        				'demandante_id'=>(($expediente->getDemandanteParticular()!=null)
        									?$expediente->getDemandanteParticular()->getId()
        									:0),
        				'origen_id'=>(($expediente->getOrigenExterno()!=null)
        								?$expediente->getOrigenExterno()->getId():0),
        				'origen_externo_id'=>(($expediente->getOrigenExterno()!=null)
        										?$expediente->getOrigenExterno()->getOficina()->getId():0),
        				'origen_numeracion'=>(($expediente->getOrigenExterno()!=null)
        										?$expediente->getOrigenExterno()->getNumeracionOrigen():[]),
        				'lista_imagenes'=>$expediente->getListaImagenes(),
        				'rutas_web_expediente'=>$expediente->getRutasWebExpediente(),
        				'ultimo_momento'=>$expediente->getUltimoMomento(),
        				
        				);
        return $this->view($resultado,200);
    }
    
    /**
     * @Rest\Get("/getGirosByExpediente_Id/{id}")
     */
    public function traerGirosPorIdExpedienteAction(Request $request)
    {
    	$id=$request->get('id');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$giros=$expedienteRepository->findGirosByExpediente_Id($id);
    
    	$resultados=[];
    	foreach ($giros as $giro){
    		
    		$registro=array('id'=>$giro->getId(),'numero_remito'=>$giro->getRemito()->getNumeroRemito(),
    						'origen'=>$giro->getOrigen(),'fecha_envio'=>$giro->getFechaEnvio(),
    						'destino'=>$giro->getDestino(), 'observacion'=>$giro->getObservacion(),
		    				'fojas'=>$giro->getFojas(), 'fecha_recepcion'=>$giro->getFechaRecepcion(),
		    				'remito_retorno'=>$giro->getRemitoRetorno()
    		);
    		
    		$resultados[]=$registro;
    		
    	}
    	return $this->view($resultados,200);
    }
    
    /**
     * @Rest\Post("/setRetornoExterno")
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
    		//$tipoMovimientoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoMovimiento');
    		$fechaActual=new \DateTime('now');
    		$idOficinaMesaEntradas=$this->getParameter('id_mesa_entradas');
    		//$idMovimientoPase=$this->getParameter('id_movimiento_pase');
    		
    		$expediente=$expedienteRepository->find($idExpediente);
    		//$tipoMovimiento=$tipoMovimientoRepository->find($idMovimientoPase);
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
    				
    		$movimiento= new Pase();
    		$movimiento->setExpediente($expediente);
    		$movimiento->setFechaCreacion($fechaActual);
    		$movimiento->setUsuarioCreacion($usuario->getUsuario());
    		$movimiento->setRemitoRetorno($numeroRemito);
    		$movimiento->setFojas($folios);
    		$movimiento->setObservacion("Autopase por Retorno");
    		//$movimiento->setTipoMovimiento($tipoMovimiento);
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
     * @Rest\Post("/upateFechaIngreso")
     */
    public function actualizarFechaIngresoAction(Request $request)
    {
		    	$idExpediente=$request->request->get('idExpediente');
    		$fecha=$request->request->get('fecha');
    	   	
    	try {
    		
    		$usuario=$this->getUser();
    		$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    		$fechaActual=new \DateTime('now');
    		    		
    		$expediente=$expedienteRepository->find($idExpediente);
    		$fechaIngreso= \DateTime::createFromFormat('d/m/Y', $fecha);
    		
    		$expediente->setFechaCreacion($fechaIngreso);
    		$expediente->setFechaModificacion($fechaActual);
    		$expediente->setUsuarioModificacion($usuario->getUsuario());
    		
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($expediente);
    		$em->flush();
    		    		
    		return $this->view("El fecha de ingreso se actualizó forma exitosa",200);
    		
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    }
    
    /**
     * @Rest\Get("/getRemitosByCriteria/{tipoCriterio}/{criterio}")
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
	    	
	    	$resultado=[];
	    	foreach ($remitos as $remito){
	    		$registro=array('id'=>$remito->getId(),'numero_remito'=>$remito->getNumeroRemito(),
	    						'oficina_origen'=>$remito->getOrigen()->getOficina(),
	    						'fecha_movimiento_formateada'=>$remito->getFechaMovimientoFormateada(),
	    						'oficina_destino'=>$remito->getDestino()->getOficina(),
	    						'destino_externo'=>$remito->getDestino()->getEsExterna(),
	    						'fecha_recepcion_formateada'=>$remito->getFechaRecepcionFormateada(),
	    						'lista_expedientes'=>$remito->getListaExpedientes(),
	    						'anulado'=>$remito->getAnulado()
	    						);
	    		$resultado[]=$registro;
	    	}
	    	
	    	return $this->view($resultado,200);
    	}
    	catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    }
    
    /**
     * @Rest\Post("/createRemito")
     */
    public function crearRemitoExpedienteAction(Request $request)
    {
    	$idOficina=$request->request->get('idDestino');
    	$remitoDetalle=json_decode($request->request->get('remitoDetalle'));
    	
    	$usuario=$this->getUser();
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
    	$fechaActual=new \DateTime('now');
    	$origen=$usuario->getRol()->getOficina();
 
    	$movimientoInforme=$this->getParameter('id_Movimiento_informe');
    	$movimientoPase=$this->getParameter('id_movimiento_pase');
    	$movimientoInformeYPase=$this->getParameter('id_Movimiento_pase_informe');
    	$idNuevoEstadoExpediente=$this->getParameter('id_estado_espera_recepcion');
    	
    	$remito= new Remito();
    	$destino=$oficinaRepository->find($idOficina);
    	$remito->setDestino($destino);
    	$remito->setOrigen($origen);
    	$remito->setFechaCreacion($fechaActual);
    	$remito->setUsuarioCreacion($usuario->getUsuario());
    	
    	$em = $this->getDoctrine()->getManager();

    	foreach ($remitoDetalle as $detalle) {
    		
    		$expediente=$expedienteRepository->find($detalle->id);
    		    		
    		if($detalle->idTipoMovimiento==$movimientoInformeYPase ||
    		   $detalle->idTipoMovimiento==$movimientoPase){
    			
    		   	$expediente->setOficinaActual($destino); //cambia destino de expediente
    		   	
    		   	$pase=new Pase();
    		   	$pase->setExpediente($expediente);
    		   	$pase->setFechaCreacion($fechaActual);
    		   	$pase->setUsuarioCreacion($usuario->getUsuario());
    		   	$pase->setFojas($detalle->folios);
    		   	$pase->setObservacion($detalle->observaciones);
    		   	
    		   	$expedienteComision=null;
    		   	
    		   	if ($detalle->incluyeComision){
    		   		
    		   		$expedienteComision=new ExpedienteComision();
    		   		$expedienteComision->setExpediente($expediente);
    		   		$expedienteComision->setFechaCreacion($fechaActual);
    		   		$expedienteComision->setUsuarioCreacion($usuario->getUsuario());
    		   		$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    		   		$comision=$comisionRepository->find($detalle->idComision);
    		   		$expedienteComision->setComision($comision);
    		   		$expedienteComision->setPaseOriginario($pase);
    		     		   	
    		   		$expediente->addAsignacionComision($expedienteComision);
    		   		$estadoExpediente=$estadoExpedienteRepository->find($idNuevoEstadoExpediente);
    		   		$expediente->setEstadoExpediente($estadoExpediente);
    		   		$expediente->setFechaCreacion($fechaActual);
    		   		$expediente->setUsuarioCreacion($usuario->getUsuario());
    		   	}
    		   	
//				$em->persist($expediente);
    		   	
//     		   	$pase=new Pase();
//     		   	$pase->setExpediente($expediente);
//     		   	$pase->setFechaCreacion($fechaActual);
//     		   	$pase->setUsuarioCreacion($usuario->getUsuario());
//     		   	$pase->setFojas($detalle->folios);
//     		   	$pase->setObservacion($detalle->observaciones);
    		   	
    		   	$remito->addMovimiento($pase);
    		    	
    		}
    		
    		if($detalle->idTipoMovimiento==$movimientoInformeYPase ||
    		   $detalle->idTipoMovimiento==$movimientoInforme){
    		
	    		$informe= new SolicitudInforme();
	    		$informe->setExpediente($expediente);
	    		$informe->setFechaCreacion($fechaActual);
	    		$informe->setUsuarioCreacion($usuario->getUsuario());
	    		$informe->setObservacion($detalle->observaciones);
	    		    	
	    		$remito->addMovimiento($informe);
	    		
    		}
    		
    	}
    	
    	$em->persist($remito);
    	$em->flush();
    	
    	return $this->view("El movimiento se guardó en forma exitosa",200);
    	
    }
    
    /**
     * @Rest\Post("/invalidateRemito")
     */
    public function anularRemitoAction(Request $request)
    {	
    	$idRemito = $request->request->get('idRemito');
    	$motivoAnulacion = $request->request->get('motivoAnulacion');
    	$usuario=$this->getUser();
    	
    	$remitoRepository=$this->getDoctrine()->getRepository('AppBundle:Remito');
    	$remito = $remitoRepository->find($idRemito);
    	
    	if($remito->getFechaRecepcion()!=null)
    		return $this->view("El movimiento tiene fecha de recepción. No se puede Anular",500);
    	
    	if($remito->getAnulado()==true)	
    		return $this->view("El movimiento ya se encuentra anulado. No se puede Anular",500);
    	
    	$remito->setAnulado(true);
    	$remito->setUsuarioModificacion($usuario->getUsuario());
    	$remito->setFechaModificacion(new \DateTime('now'));
    	
    	$remito->setMotivoAnulacion($motivoAnulacion);
    	foreach ($remito->getMovimientos() as $movimiento) {
    		$movimiento->setAnulado(true);
    		$remito->setUsuarioModificacion($usuario->getUsuario());
    		$remito->setFechaModificacion(new \DateTime('now'));
    		$movimiento->getExpediente()->setOficinaActual($remito->getOrigen());
    		$movimiento->getExpediente()->setUsuarioModificacion($usuario->getUsuario());
    		$movimiento->getExpediente()->setFechaModificacion(new \DateTime('now'));
    	}
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($remito);
    	$em->flush();
    	
    	return $this->view("El movimiento se anuló en forma exitosa",200);
    	
    }
    
    /**
     * @Rest\Post("/updateRecepcionRemito")
     */
    public function actualizarFechaRemitoAction(Request $request)
    {
    	$idRemito = $request->request->get('idRemito');
    	$fecha = new \DateTime('now');
    	$usuario=$this->getUser();

    	$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
    	$remitoRepository=$this->getDoctrine()->getRepository('AppBundle:Remito');
    	$remito = $remitoRepository->find($idRemito);
    	
    	if ($remito->getFechaRecepcion()!=null)
    		return $this->view("El movimiento ya tiene fecha de recepción",500);
    	
    	if ($remito->getAnulado()==true)
    		return $this->view("El movimiento se encuentra anulado",500);
    	
    	$remito->setFechaRecepcion($fecha);
    	$remito->setUsuarioModificacion($usuario->getUsuario());
    	$remito->setFechaModificacion($fecha);
    	
    	$idOficinaComisiones=$this->getParameter('id_comisiones');
    	foreach ($remito->getMovimientos() as $movimiento){
    		
    		if ($usuario->getRol()->getOficina()->getId()==$idOficinaComisiones)
    			$idNuevoEstadoExpediente=$this->getParameter('id_estado_estudio_comision');
    		else
    			$idNuevoEstadoExpediente=$this->getParameter('id_estado_en_tramite');
    		
    		$nuevoEstadoExpediente=$estadoExpedienteRepository->find($idNuevoEstadoExpediente);
    		$movimiento->getExpediente()->setEstadoExpediente($nuevoEstadoExpediente);
    		$movimiento->getExpediente()->setUsuarioModificacion($usuario->getUsuario());
    		$movimiento->getExpediente()->setFechaModificacion($fecha);
    	}
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($remito);
    	$em->flush();
    	
    	return $this->view("El movimiento se actualizó en forma exitosa",200);
    }
    
            
    /**
     * @Rest\Get("/getInformesByExpediente_Id/{id}")
     */
    public function traerInformesPorIdExpedienteAction(Request $request)
    {
    	$id=$request->get('id');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$movimientos=$expedienteRepository->findInformesByExpediente_Id($id);
    	
    	return $this->view($movimientos,200);
    }
    
    /**
     * @Rest\Get("/getInformesByCriteria/{tipoCriterio}/{criterio}")
     */
    public function traerInformesPorCriterioAction(Request $request)
    {
    	$tipoCriterio=$request->get('tipoCriterio');
    	$criterio=$request->get('criterio');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$informes=null;
    	if ($tipoCriterio=='todo')
    		$informes=$expedienteRepository->findAllInformes();
    	if ($tipoCriterio=='busqueda-1')
    			$informes=$expedienteRepository->findInformeByNumeroExpediente($criterio);
    	if ($tipoCriterio=='busqueda-2')
    		$informes=$expedienteRepository->findInformeByTipo($criterio);
    	if ($tipoCriterio=='busqueda-3')
    		$informes=$expedienteRepository->findInformeByDestino($criterio);
    	if($tipoCriterio=='busqueda-4')
    		$informes=$expedienteRepository->findInformeByComisionReserva($criterio);
  
      	
    	return $this->view($informes,200);
    }
    
    
    /**
     * @Rest\Post("/updateRespuestaInforme")
     */
    public function actualizarRespuestaInformeAction(Request $request)
    {
    	$idInforme=$request->request->get('idInforme');
    	$fecha=$request->request->get('fecha');
    	$idSesion=$request->request->get('idSesion');
    	$numeroRemito=$request->request->get('numeroRemito');
    	
    	$movimientoRepository=$this->getDoctrine()->getRepository('AppBundle:Movimiento');
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesion=$sesionRepository->find($idSesion);
    	$usuario=$this->getUser();
    	$fechaActual=new \DateTime('now');
    	
    	$informe=$movimientoRepository->find($idInforme);
    	$fechaRespuesta=\DateTime::createFromFormat('d/m/Y', $fecha);
    	$informe->setSesion($sesion);
    	$informe->setFechaRespuesta($fechaRespuesta);
    	$informe->setRemitoRetorno($numeroRemito);
    	$informe->setFechaModificacion($fechaActual);
    	$informe->setUsuarioModificacion($usuario->getUsuario());
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($informe);
    	$em->flush();
    	
    	return $this->view("El informe se actualizó en forma exitosa",200);
    }
    
    /**
     *  @Rest\Post("/create")
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
//             $idSesion=$request->request->get('idSesion');
            $archivos=$request->files->all();
            $usuario=$this->getUser();
            
            //repositorios y parámetros de configuración
            $tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
//             $sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
            $estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
            $oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
            $idMesaEntradas=$this->getParameter('id_mesa_entradas');
                 
            //nuevo expediente
            $expediente=new Expediente();
            
            //caratulación del HCD
            $expediente->setFolios($folios);
            $expediente->setArchivos($archivos);
            $expediente->setNumeroExpediente($numeroExpediente);
            $expediente->setPeriodo($año);
            $expediente->setCaratula($caratula);
//             $sesion=$sesionRepository->find($idSesion);
//             $expediente->setSesion($sesion);
//             $expediente->setUltimoMomento($sesion->getTieneOrdenDelDia());
            
            
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
            		$estadoExpediente=$estadoExpedienteRepository->find(8);
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
            return $this->view('El expediente '.$numeroExpediente.' ya existe',500);
        
        }catch(\Exception $e){
            return $this->view($e->getMessage(),500);            
        }

    }

    /**
     *  @Rest\Post("/update")
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
//             $idSesion=$request->request->get('idSesion');
//             $ultimoMomento=$request->request->get('ultimoMomento');
            $archivos=$request->files->all();
            $usuario=$this->getUser();

            $tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
//             $sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
            $oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
            $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
            $expediente=$expedienteRepository->find($idExpediente); 
			
            if (!($expediente->getPermiteEdicion()))
            	return $this->view('El expediente '.$numeroExpediente.' no puede ser editado',500);
            
            //datos del HCD
            $expediente->setNumeroExpediente($numeroExpediente);
            $expediente->setPeriodo($año);
            $expediente->setFolios($folios);
            $expediente->setCaratula($caratula);
//             $sesion=$sesionRepository->find($idSesion);
                  
//             if($expediente->getUltimoMomento()=="true" && $ultimoMomento=="false")
//             	$expediente->setUltimoMomento(false);
//             else
//             	if (is_null($expediente->getSesion()) || $expediente->getSesion()->getId()!=$sesion->getId())
//             		$expediente->setUltimoMomento($sesion->getTieneOrdenDelDia());	
            
//             $expediente->setSesion($sesion);
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
            return $this->view('El expediente '.$numeroExpediente.' ya existe',500);

        }catch(\Exception $e){
            return $this->view($e->getMessage(),500);
            
        }
    }

    /**
     *  @Rest\Post("/removeArchivo")
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
        
  }