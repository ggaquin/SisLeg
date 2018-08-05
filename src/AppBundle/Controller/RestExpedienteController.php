<?php

namespace AppBundle\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    		   	    		
    		$expedienteServicio=$this->get('expediente_Servicio');
    		$resultado=$expedienteServicio->findByNumeroYAño($numero,
    														  $usuario->getRol()->getOficina(),
    		    											  $destino
    		    											  );
    		
    		return $this->view($resultado,200);
    		
    	}catch(\Exception $e){
    		
    		return $this->view($e->getMessage(),500);
    	}
    }
        		
    
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
            	$registro=array('id'=>$expediente->getId(), 
            					'numero_completo'=>$expediente->getNumeroCompleto(),
            					'numeracion_origen'=>$expediente->getListadoNumerosExternos(),
            					'tipo_expediente'=>$expediente->getTipoExpediente()->getTipoExpediente(),
            					'fecha_creacion_formateada'=>$expediente->getFechaCreacionFormateada(),
            					'fecha_modificacion_formateada'=>$expediente->getFechaModificacionFormateada(),
            					'oficina_actual'=>$expediente->getOficinaActual()->getOficina(),
            					'caratula_muestra'=>$expediente->getCaratulaMuestra(),
            					'caratula_sin_html'=>$expediente->getCaratulaSinHtml(),
            					'oficina_actual_externa'=>$expediente->getOficinaActual()->getEsExterna(),
            					'lista_comisiones_asignadas'=>$expediente->getListaComisionesAsignadas(),
            					'folios'=>$expediente->getFolios(),
            					'estado'=>$expediente->getNombreEstado(),
            					'numero_sancion'=>$expediente->getNumeroSancion(),
            					'permite_edicion'=>$expediente->getPermiteEdicion(),
            					'fecha_archivo_formateada'=>$expediente->getfechaArchivoFormateada(),
            					'comision_reserva'=>$expediente->getComisionReserva(),
            					'ultimo_momento'=>$expediente->getUltimoMomento(),
            					'sesion'=>(!is_null($expediente->getSesion())
            								?$expediente->getSesion():''),
            					'caratula'=>$expediente->getCaratula(),
            					'autor'=>$expediente->getAutor()
            					);
            	$resutado[]=$registro;
            	
            }
            return $this->view($resutado,200);

        }catch(\Exception $e)   {
            return $this->view($e->getMessage(),500);
        }
    }
    
    /**
     * @Rest\POST("/archivar/{id}")
     */
    public function archivarExpedienteAction(Request $request){
    	
    	$id=$request->get('id');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
    	$estadoExpediente=$estadoExpedienteRepository->find(6);
    	$expediente=$expedienteRepository->find($id);
    	$usuario=$this->getUser();
    	
    	if (!is_null($expediente->getFechaArchivo()))
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
	 * @Rest\POST("/desarchivar/{id}")
	 */
	public function desarchivarExpediente(Request $request){
		
		$id=$request->get('id');
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
	 * @Rest\Post("/editUltimoMomento/{id}")
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
    		$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    		$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
    		$fechaActual=new \DateTime('now');
    		$idOficinaMesaEntradas=$this->getParameter('id_mesa_entradas');
    		$idOficinaComisiones=$this->getParameter('id_comisiones');
    		$idEstadoEsperaRecepcion=$this->getParameter('id_estado_espera_recepcion');
    		$idEstadoEnTramite=$this->getParameter('id_estado_en_tramite');
    		    
    		//recupera el expediente
    		$expediente=$expedienteRepository->find($idExpediente);
    		//recupera el último movimiento (no anulado) del presente expediente
    		$ultimoMovimiento=$expedienteRepository->findLastMovimientoByIdExpediente($idExpediente);
    		
    		if (is_null($ultimoMovimiento->getRemito()->getFechaRecepcion()))
    			return $this->view("No se puede realizar el retorno, ".
    							   "el remito no tiene recepción",500);
    		    	    		    			
    		$mesaDeEntradas=$oficinaRepository->find($idOficinaMesaEntradas);
    		$fechaRecepcion= \DateTime::createFromFormat('d/m/Y', $fecha);
    		
    		$em = $this->getDoctrine()->getManager();
    		
    		//remito con destino a mesa de entradas
	    	$remitoMesaEntradas= new Remito();
    		$origen=$oficinaRepository->find($expediente->getOficinaActual());
    		$remitoMesaEntradas->setDestino($mesaDeEntradas);
    		$remitoMesaEntradas->setOrigen($origen);
    		$remitoMesaEntradas->setFechaCreacion($fechaActual);
    		$remitoMesaEntradas->setUsuarioCreacion($usuario->getUsuario());
    		$remitoMesaEntradas->setFechaRecepcion($fechaRecepcion);
    		
    		//movimiento con destino a mesa de entradas
    		$movimientoMesaEntradas= new Pase();
    		$movimientoMesaEntradas->setExpediente($expediente);
    		$movimientoMesaEntradas->setFechaCreacion($fechaActual);
    		$movimientoMesaEntradas->setUsuarioCreacion($usuario->getUsuario());
    		$movimientoMesaEntradas->setRemitoRetorno($numeroRemito);
    		$movimientoMesaEntradas->setFojas($folios);
    		$movimientoMesaEntradas->setObservacion("Reingreso a HCD");
    		
    		//asociación con el movimiento y persistencia del remito de mesa de entradas
    		$remitoMesaEntradas->addMovimiento($movimientoMesaEntradas);
    		$em->persist($remitoMesaEntradas);
    		    		
    		//si el último movimiento es no nulo y el tipo es solicitud de informe
    		//realiza a la vez un pase a comisiones
    		if(!is_null($ultimoMovimiento) && $ultimoMovimiento instanceof SolicitudInforme){
    			
    			//busca el la asignación de la comisión que genera la solicitud
    			$comisionAsignacion=$expedienteComisionRepository
						    			->findByExpediente_IdAndComision_Id
						    			($idExpediente,$ultimoMovimiento->getComision()->getId());
    			
				//genera remito, movimiento a comisiones y asocia el pase
				//solo si la asigancion de comisión existe
				if (!is_null($comisionAsignacion)){    			
						    			
	    			$comisiones=$oficinaRepository->find($idOficinaComisiones);
	    			
	    			//remito de destino a comisiones
	    			$remitoComisiones= new Remito();
	    			$remitoComisiones->setDestino($comisiones);
	    			$remitoComisiones->setOrigen($mesaDeEntradas);
	    			$remitoComisiones->setFechaCreacion($fechaActual);
	    			$remitoComisiones->setUsuarioCreacion($usuario->getUsuario());
	    			
	    			//movimiento con destino a comisiones
	    			$movimientoComisiones= new Pase();
	    			$movimientoComisiones->setExpediente($expediente);
	    			$movimientoComisiones->setFechaCreacion($fechaActual);
	    			$movimientoComisiones->setUsuarioCreacion($usuario->getUsuario());
	    			$movimientoComisiones->setFojas($folios);
	    			$movimientoComisiones->setObservacion("Retorno Solicitud Informe");
    			
    				
	    			//cambia el destino actual del expediente a comisiones
	    			$expediente->setOficinaActual($comisiones);
	    			$estado=$estadoExpedienteRepository->find($idEstadoEsperaRecepcion);
	    			$expediente->setEstadoExpediente($estado);
    				
    				//asociación con el movimiento y persistencia del remito de comisiones
    				$remitoComisiones->addMovimiento($movimientoComisiones);
    				$em->persist($remitoComisiones);
    			
    				//asocia el pase actual a la asignación de comision
    				$comisionAsignacion->addPaseAsociado($movimientoComisiones);
    				//persiste la asignación de comision
    				$em->persist($comisionAsignacion);
    				
				}
    			
    			//actualiza la fecha de respuesta de la solicitud de informe
    			$ultimoMovimiento->setFechaRespuesta($fechaActual);
    			$em->persist($ultimoMovimiento);
    			
    		}
    		else {
    			// el último movimiento para el expediente es del tipo pase, por lo tanto,
    			// cambia la oficina actual del expediente a mesa de entradas y el 
    			// estado a "en tramite"
    			$expediente->setOficinaActual($mesaDeEntradas); 
    			$estado=$estadoExpedienteRepository->find($idEstadoEnTramite);
    			$expediente->setEstadoExpediente($estado);
    		}
    		
    		$expediente->setFolios($folios); //actualiza los folios del expediente
    		$em->persist($expediente);
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
    	$expedienteComisionRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    	$fechaActual=new \DateTime('now');
    	$origen=$usuario->getRol()->getOficina();
 
    	$movimientoInforme=$this->getParameter('id_Movimiento_informe');
    	$movimientoPase=$this->getParameter('id_movimiento_pase');
    	$idNuevoEstadoExpediente=$this->getParameter('id_estado_espera_recepcion');
    	$idOficinaComisiones=$this->getParameter('id_comisiones');
    	$oficinaComisiones=$oficinaRepository->find($idOficinaComisiones);
    	$idOficinaDespacho=$this->getParameter('id_despacho');
    	
    	$remito= new Remito();
    	$destino=$oficinaRepository->find($idOficina);
    	$remito->setDestino($destino);
    	$remito->setOrigen($origen);
    	$remito->setFechaCreacion($fechaActual);
    	$remito->setUsuarioCreacion($usuario->getUsuario());
    	
    	$em = $this->getDoctrine()->getManager();

    	foreach ($remitoDetalle as $detalle) {
    		
    		$detalleMovimiento=null;
    		$detalleMovimientoAMesa=null;
    		$expediente=$expedienteRepository->find($detalle->id);
    		
    		if(!$expediente->getPermiteEdicion($origen->getId()==$idOficinaDespacho)) 
    			return $this->view("El expediente ".$expediente->getNumeroCompleto().
    							   " no posee un estado habilitante para realizar movimientos"
    							   ,500);
    		 
    		//movimiento común de giro
    		if($detalle->idTipoMovimiento==$movimientoPase){
    			
    			if($expediente->getOficinaActual()->getId()==$oficinaComisiones->getId())
    				return $this->view("Al expediente ".$expediente->getNumeroCompleto().
    								   " solo se le pueden gestionar SOLICITUDES DE INFORME".
    								   " dado que se encuentra en la oficina de comisiones"
    								   ,500);
    				
    			else{
		    		   	$detalleMovimiento=new Pase();
		    		   	$detalleMovimiento->setFojas($detalle->folios);
		    		   	
		    		   	$expedienteComision=null;
		    		   	
		    		   	if ($detalle->incluyeComision){ //solo en el caso de pase a comisiones
		    		   		
		    		   		$expedienteComision=new ExpedienteComision();
		    		   		$expedienteComision->setExpediente($expediente);
		    		   		$expedienteComision->setFechaCreacion($fechaActual);
		    		   		$expedienteComision->setUsuarioCreacion($usuario->getUsuario());
		    		   		$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
		    		   		$comision=$comisionRepository->find($detalle->idComision);
		    		   		$expedienteComision->setComision($comision);
		    		   		$expedienteComision->addPaseAsociado($detalleMovimiento);
		    		     		   	
		    		   		$expediente->addAsignacionComision($expedienteComision);
		    		   		
		    		   	}
    			}
    		}
    		
    		//movimiento de giro por solicitud de informe. Expediente tomado de comsiones
    		if($detalle->idTipoMovimiento==$movimientoInforme){
    		
    			$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    			$comision=$comisionRepository->find($detalle->idComision);
    			
    			//asignación de comision para este expediente	
    			$comisionesAsignadas=$expedienteComisionRepository
    									->findVigentesBydExpediente_IdAndFechaActualAndODEStado
    										($detalle->id,$fechaActual,'conOD');
    			
    			if(count($comisionesAsignadas)>0)
    				//existen asignaciones en comision para el expediente con orden del día generada
    				return $this->view("El expediente ".
    								   $expediente->getNumeroCompleto().
    								   " posee asignaciones a comisión con orden del día ya generada ",
    								   500);

    			$expedienteComisionAsignado=$expedienteComisionRepository
    											->findByExpediente_IdAndComision_Id($detalle->id, 
    																				$detalle->idComision);
	    				   
	    		if(is_null($expedienteComisionAsignado)){
	    		  
		    		//no se encontró la asignación de comisión para el expediente
		    		return $this->view("El expediente ".
		    							$expediente->getNumeroCompleto().
		    							" no se encuentra asignado a la comision de ".
		    							$comision->getComision(),500);
	    		}
	    		else{
	    				if (is_null($expedienteComisionAsignado->getPaseOriginario()
	    													   ->getRemito()->getFechaRecepcion())
	    				   )
	    					
	    					return $this->view("El giro del expediente ".
	    									   $expediente->getNumeroCompleto().
	    									   " a la comisión ".$comision->getComision().
	    									   " no se encuentra confirmado",500);
	    				else {
			    				//no tiene sesion con orden del dia generada y 
			    				//se encuentra recibido. Se nulea la sesión
					    		$expedienteComisionAsignado->setSesion(null);
					    		$em->persist($expedienteComisionAsignado);
	    				}
	    			
    			}
    			
    			//pase automático de comisiones a mesa de entrada. 
    			//generado solo por no crear saltos en el recorrido
    			//del expediente
    			$detalleMovimientoAMesa=new Pase();
    			$detalleMovimientoAMesa->setFojas($detalle->folios);
    			
    			//solicitud de informe
    			$detalleMovimiento= new SolicitudInforme();
    			$detalleMovimiento->setComision($comision);
	    		
    		}
    		
    		//actualización de los datos del expediente
    		$expediente->setOficinaActual($destino);
    		$expediente->setSesion(null);
    		$estadoExpediente=$estadoExpedienteRepository->find($idNuevoEstadoExpediente);
    		$expediente->setEstadoExpediente($estadoExpediente);
    		$expediente->setFechaModificacion($fechaActual);
    		$expediente->setUsuarioModificacion($usuario->getUsuario());
    		
    		//resto de la información del remito final
    		$detalleMovimiento->setExpediente($expediente);
    		$detalleMovimiento->setFechaCreacion($fechaActual);
    		$detalleMovimiento->setUsuarioCreacion($usuario->getUsuario());
    		$detalleMovimiento->setObservacion($detalle->observaciones);
    		
    		//solo en caso de la soliditud de informe.
    		//resto de la información del pase automático
    		if(!is_null($detalleMovimientoAMesa)){
    			
    			$remitoMovimientoAMesa= new Remito();
    			$remitoMovimientoAMesa->setDestino($origen); //la oficina que genera la presente
    			$remitoMovimientoAMesa->setOrigen($oficinaComisiones);
    			$remitoMovimientoAMesa->setFechaCreacion($fechaActual);
    			$remitoMovimientoAMesa->setUsuarioCreacion($usuario->getUsuario());
    			$remitoMovimientoAMesa->setUsuarioModificacion($usuario->getUsuario());
    			$remitoMovimientoAMesa->setFechaCreacion($fechaActual);
    			$remitoMovimientoAMesa->setFechaRecepcion($fechaActual);
    			
    			$detalleMovimientoAMesa->setExpediente($expediente);
    			$detalleMovimientoAMesa->setFechaCreacion($fechaActual);
    			$detalleMovimientoAMesa->setUsuarioCreacion($usuario->getUsuario());
    			$detalleMovimientoAMesa->setObservacion("Pase automático por solicitud de informe");
    			
    			$remitoMovimientoAMesa->addMovimiento($detalleMovimientoAMesa);
    			
    			$em->persist($remitoMovimientoAMesa);
    			
    		}
    				
    		$remito->addMovimiento($detalleMovimiento);
    		
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
    	$idOficinaComisiones=$this->getParameter('id_comisiones');
    	$usuario=$this->getUser();
    	
    	$remitoRepository=$this->getDoctrine()->getRepository('AppBundle:Remito');
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
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
    		
    		if($movimiento instanceof SolicitudInforme){
    			$oficinaComisiones=$oficinaRepository->find($idOficinaComisiones);
    			$movimiento->getExpediente()->setOficinaActual($oficinaComisiones);
    		}	
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
    	$expedienteAsignadoRepository=$this->getDoctrine()->getRepository('AppBundle:ExpedienteComision');
    	$remito = $remitoRepository->find($idRemito);
    	
    	if ($remito->getFechaRecepcion()!=null)
    		return $this->view("El movimiento ya tiene fecha de recepción",500);
    	
    	if ($remito->getAnulado()==true)
    		return $this->view("El movimiento se encuentra anulado",500);
    	
    	$remito->setFechaRecepcion($fecha);
    	$remito->setUsuarioModificacion($usuario->getUsuario());
    	$remito->setFechaModificacion($fecha);
    	
    	$idOficinaComisiones=$this->getParameter('id_comisiones');
    	$idEstadoEstudio=$this->getParameter('id_estado_estudio_comision');
    	$idEstadoDictamen=$this->getParameter('id_estado_dictamen_comision');
    	
    	foreach ($remito->getMovimientos() as $movimiento){
    		
    		$nuevoEstadoExpediente=$estadoExpedienteRepository->find($idEstadoEstudio);
    		
    		if ($usuario->getRol()->getOficina()->getId()==$idOficinaComisiones){
    			
    			$expediente=$movimiento->getExpediente();
    			$expedientesAsignados=$expedienteAsignadoRepository
    									->findVigentesBydExpediente_IdAndFechaActualAndODEStado
    										($expediente->getId(),$fecha);
    			
    			foreach ($expedientesAsignados as $expedienteAsignado){
    	
    				if($expedienteAsignado->getTieneDictamen()){
    					$nuevoEstadoExpediente=$estadoExpedienteRepository->find($idEstadoDictamen);
    					break;
    				}   					
    			}
    		}
		
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
            $archivos=$request->files->all();
            $usuario=$this->getUser();
            $servicioUtilidades=$this->get('utilidades_servicio');
            
            //repositorios y parámetros de configuración
            $tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
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
            $expediente->setCaratula($servicioUtilidades->clean_str($caratula));
                      
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
            $archivos=$request->files->all();
            $usuario=$this->getUser();
            $servicioUtilidades=$this->get('utilidades_servicio');

            $tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
            $oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
            $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
            $expediente=$expedienteRepository->find($idExpediente); 
			
            if (!($expediente->getPermiteEdicion()))
            	return $this->view('El expediente '.$numeroExpediente.' no puede ser editado',500);
            
            //datos del HCD
            $expediente->setNumeroExpediente($numeroExpediente);
            $expediente->setPeriodo($año);
            $expediente->setFolios($folios);
            $expediente->setCaratula($servicioUtilidades->clean_str($caratula));
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
     *  @Rest\Post("/save")
     */
    public function guardarExpedienteAction(Request $request)
    {
    	try{
    		
    		$idExpediente=$request->request->get('idExpediente');
    		$idproyecto=$request->request->get('idProyecto'); 
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
    		$archivos=$request->files->all();
    		$usuario=$this->getUser();
    		$servicioUtilidades=$this->get('utilidades_servicio');
    		
    		$tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
    		$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    		$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
    		$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    		$idMesaEntradas=$this->getParameter('id_mesa_entradas');
    		$expediente=null;
    		
    		if ($idExpediente==0){ /* nuevo expediente */
    			
    			$expediente=new Expediente();
    			$expediente->setUsuarioCreacion($usuario->getUsername());
    			$expediente->setFechaCreacion(new \DateTime("now"));
    			
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
    
    			//establece el estado del expediente
    			$estadoExpediente=$estadoExpedienteRepository->find(1);
    			$expediente->setEstadoExpediente($estadoExpediente);
    		}
    		else{ /* edición de expediente */
    			
    			$expediente=$expedienteRepository->find($idExpediente);
    			//el expediente no permite ediciónes
    			if (!($expediente->getPermiteEdicion()))
    				return $this->view('El expediente '.$numeroExpediente.' no puede ser editado',500);
    			$expediente->setUsuarioModificacion($usuario->getUsername());
    			$expediente->setFechaModificacion(new \DateTime("now"));
    		}
    		    			
    		//datos del HCD
    		$expediente->setNumeroExpediente($numeroExpediente);
    		$expediente->setPeriodo($año);
    		$expediente->setFolios($folios);
    		$expediente->setCaratula($servicioUtilidades->clean_str($caratula));
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
    		if ($idTipoExpediente==4  || $idTipoExpediente==9){
    			$origenExterno= new OrigenExterno();
    			$origenExterno->setNumeracionOrigen($numeros);
    			$oficinaOrigen = $oficinaRepository->find($idOrigen);
    			$origenExterno->setOficina($oficinaOrigen);
    			$expediente->setDemandanteParticular(null);
    		}
    		$expediente->setOrigenExterno($origenExterno);
    	    					
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