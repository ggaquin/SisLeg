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
			/*
			{ "data": "id" },
      		{ "data": "null","width":"7%"},
      		{ "data": "numero_completo","width":"10%"},
            { "data": "tipo_expediente.tipo_expediente","width":"8%" },
            { "data": "fecha_creacion_formateada","width":"8%" },
            { "data": "fecha_modificacion_formateada","width":"8%" },
            { "data": "oficina_actual.oficina","width":"25%" },
            { "data": "caratula_muestra", "width": "34%"},
            
			 */
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
            					'folios'=>$expediente->getFolios()
            					);
            	$resutado[]=$registro;
            	
            }
            return $this->view($resutado,200);

        }catch(\Exception $e)   {
            return $this->view($e->getMessage(),500);
        }
    }

    /**
     * @Rest\Get("/getOne/{id}")
     */
    public function traerExpedientePorIdAction(Request $request)
    {
        $id=$request->get('id');
        $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
        $expediente=$expedienteRepository->find($id);
        return $this->view($expediente,200);
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
    	$tipoMovimientoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoMovimiento');
    	$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
    	$fechaActual=new \DateTime('now');
    	$origen=$usuario->getRol()->getOficina();
 
    	$movimientoInforme=$this->getParameter('id_Movimiento_informe');
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
    		$tipoMovimiento=$tipoMovimientoRepository->find($detalle->idTipoMovimiento);
    		if (!($tipoMovimiento==$movimientoInforme)) 
    			$expediente->setOficinaActual($destino); //cambia destino de expediente
    			if ($detalle->incluyeComision){
    				$estadoExpediente=$estadoExpedienteRepository->find($idNuevoEstadoExpediente);
    				$expediente->setEstado($estadoExpediente);
    		}
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
     * @Rest\Post("/invalidateRemito")
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
     * @Rest\Post("/updateRemito")
     */
    public function actualizarFechaRemitoAction(Request $request)
    {
    	$idRemito = $request->request->get('idRemito');
    	$fechaRecepcion = $request->request->get('fechaRecepcion');
    	
    	$fecha = \DateTime::createFromFormat('d/m/Y', $fechaRecepcion);
    	$estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
    	$remitoRepository=$this->getDoctrine()->getRepository('AppBundle:Remito');
    	$remito = $remitoRepository->find($idRemito);
    	
    	if ($remito->getFechaRecepcion()!=null)
    		return $this->view("El remito ".$remito->getId()." ya tiene fecha de recepción",500);
    	
    	if ($remito->getAnulado()==true)
    		return $this->view("El remito ".$remito->getId()." se encuentra anulado",500);
    	
    	$remito->setFechaRecepcion($fecha);
    	
    	foreach ($remito->getMovimientos() as $movimiento){
    		$idNuevoEstadoExpediente=$this->getParameter('id_estado_en_tramite');
    		$nuevoEstadoExpediente=$estadoExpedienteRepository->find($idNuevoEstadoExpediente);
    		$movimiento->getExpediente()->setEstadoExpediente($nuevoEstadoExpediente);
    	}
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($remito);
    	$em->flush();
    	
    	return $this->view("El remito ".$remito->getId()." se actualizó en forma exitosa",200);
    }
    
            
    /**
     * @Rest\Get("/getInformesByExpediente_Id/{id}")
     */
    public function traerInformesPorIdExpedienteAction(Request $request)
    {
    	$id=$request->get('id');
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$informes=$expedienteRepository->findInformesByExpediente_Id($id);
    	
    	$resultado=[];
    	foreach ($informes as $informe){
    		$registro=array('id'=>$informe->getId(),'numero_remito'=>$informe->getRemito()->getNumeroRemito(),
    						'destino'=>$informe->getDestino(),'fecha_envio'=>$informe->getFechaEnvio(),
    						'observacion'=>$informe->getObservacion(),
    						'fecha_recepcion'=>$informe->getFechaRecepcion, 
    						'fecha_respuesta_formateada'=>$informe->getFechaRespuestaFormateada(),
    						'remito_retorno'=>$informe->getRemitoRetorno()
    		);
    		$resultado[]=$registro;
    	}
    	
    	return $this->view($resultado,200);
    }
    
    /**
     * @Rest\Post("/updateRespuestaInforme")
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
            $idSesion=$request->request->get('idSesion');
            $archivos=$request->files->all();
            $usuario=$this->getUser();
            
            //repositorios y parámetros de configuración
            $tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
            $sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
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
            $sesion=$sesionRepository->find($idSesion);
            $expediente->setSesion($sesion);
            
            
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
            $idSesion=$request->request->get('idSesion');
            $numeroSancion=$request->request->get('numeroSancion');
            $archivos=$request->files->all();
            $usuario=$this->getUser();

            $tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
            $sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
            $oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
            $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
            $expediente=$expedienteRepository->find($idExpediente); 
			
            //datos del HCD
            $expediente->setNumeroExpediente($numeroExpediente);
            $expediente->setAño($año);
            $expediente->setFolios($folios);
            $expediente->setCaratula($caratula);
            $sesion=$sesionRepository->find($idSesion);
            $expediente->setSesion($sesion);
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