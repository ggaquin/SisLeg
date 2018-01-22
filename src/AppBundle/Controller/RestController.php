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
use AppBundle\Entity\Bloque;
use AppBundle\Entity\Comision;
use AppBundle\Entity\Expediente;
use AppBundle\Entity\Oficina;
use AppBundle\Entity\Perfil;
use AppBundle\Entity\PerfilLegislador;
use AppBundle\Entity\Sesion;
use AppBundle\Entity\TipoComision;
use AssistBundle\Entity\AdministracionSesion;
use FOS\RestBundle\Controller\Annotations\Get;
use AppBundle\Entity\PlantillaTexto;
use AppBundle\Entity\VersionTaquigrafica;
use AppBundle\Entity\TipoSpeech;
use AppBundle\Entity\Speech;
use AppBundle\Entity\Autoridad;


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
     * @Rest\Get("/api/usuario/descripcion/getByCriteria")
     */
    public function traerUsuarioDescripcionPorCriterioAction(Request $request)
    {
    	$term=$request->query->get('q');
    	$perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
    	$perfiles=$perfilRepository->findUsuarioByPatronBusqueda($term);
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
    							'abreviacion'=>$bloque->getAbreviacion(),
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
    	$abreviacionBloque=$request->request->get('abreviacionBloque');
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
    	$bloque->setAbreviacion(strtoupper($abreviacionBloque));
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($bloque);
    	$em->flush();
    	
    	return $this->view($mensaje,200);
    	
    }
    
    /**
     * @Rest\Post("/api/autoridad/save")
     */
    public function guardarAutoridades(Request $request)
    {
    	$editaPresidente=$request->request->get('editaPresidente');
    	$editaSecretario=$request->request->get('editaSecretario');
    	$idPresidente=$request->request->get('idPresidente');
    	$idSecretario=$request->request->get('idSecretario');
    	$usuarioSesion=$this->getUser();
    	
    	$autoridadRepository=$this->getDoctrine()->getRepository('AppBundle:Autoridad');
    	$tipoAutoridadRepository=$this->getDoctrine()->getRepository('AppBundle:TipoAutoridad');
    	$perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
    	$em = $this->getDoctrine()->getManager();
    	
    	$nuevoPresidente=null;
    	$nuevoSecretario=null;
    	
    	if ($editaPresidente=='true'){
    		$tipoAutoridad=$tipoAutoridadRepository->find(1);
    		$presidenteActual=$autoridadRepository->findAutoridadByTipo(1);
    		$perfilAutoridad=$perfilRepository->find($idPresidente);
    		$presidenteActual->setActivo(false);
    		$nuevoPresidente=new Autoridad();
    		$nuevoPresidente->setFechaAlta(new \DateTime());
    		$nuevoPresidente->setUsuarioAlta($usuarioSesion->getUsername());
    		$nuevoPresidente->setPerfil($perfilAutoridad);
    		$nuevoPresidente->setTipoAutoridad($tipoAutoridad);
    		$em->persist($presidenteActual);
    		$em->persist($nuevoPresidente);
    	}

    	
    	if ($editaSecretario=='true'){
    		$tipoAutoridad=$tipoAutoridadRepository->find(2);
    		$secretarioActual=$autoridadRepository->findAutoridadByTipo(2);
    		$perfilAutoridad=$perfilRepository->find($idSecretario);
    		$secretarioActual->setActivo(false);
    		$nuevoSecretario=new Autoridad();
    		$nuevoSecretario->setFechaAlta(new \DateTime());
    		$nuevoSecretario->setUsuarioAlta($usuarioSesion->getUsername());
    		$nuevoSecretario->setPerfil($perfilAutoridad);
    		$nuevoSecretario->setTipoAutoridad($tipoAutoridad);
    		$em->persist($secretarioActual);
    		$em->persist($nuevoSecretario);
    	}
    	
    	$em->flush();
    	
    	$datosActuales= array(
    			'id_presidente'=>(!is_null($nuevoPresidente)
    										?$nuevoPresidente->getPerfil()
    													  	 ->getId()
    										:null),
    			'nombre_presidente'=>(!is_null($nuevoPresidente)
    										?$nuevoPresidente->getPerfil()
    														 ->getNombreCompleto()
    										:null),
    			'id_secretario'=>(!is_null($nuevoSecretario)
    										?$nuevoSecretario->getPerfil()
    														 ->getId()
    										:null),
    			'nombre_secretario'=>(!is_null($nuevoSecretario)
    										?$nuevoSecretario->getPerfil()
    														 ->getNombreCompleto()
    										:null)
    			);	
    	
    	return $this->view(array('mensaje'=>"El cambio de autoridades se realizo en forma exitosa",
    							 'datos_actuales'=>$datosActuales
    							),
    					    200);
    	
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
     * @Rest\Get("/api/oficina/getAllByTipo")
     */
    public function traerTodosLasOficinasPorTipoAction(Request $request)
    {
    	$patron=$request->query->get('q');
    	$externas=$request->query->get('r');
    	
    	$expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
    	$oficinas=$expedienteRepository->traerOficinasPorNombreYTipo($patron, $externas);
    	
    	$resultado=[];
    	foreach ($oficinas as $oficina){
    		$resultado[]=array(
    				'id'=>$oficina->getId(),
    				'oficina'=>$oficina->getOficina(),
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
    					 'tipo_comision'=>$comision->getTipoComision()->getId(),
    					 'letra_orden_del_dia'=>$comision->getLetraOrdenDelDia()
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
    	$letra=$request->request->get('letra');
    	$usuarioSesion=$this->getUser();
    	
    	$mensaje="";
    	
    	try{
		    	$comisionReposiory=$this->getDoctrine()->getRepository('AppBundle:Comision');
		    	$perfilReposiory=$this->getDoctrine()->getRepository('AppBundle:Perfil');
		    	$tipoComisionReposiory=$this->getDoctrine()->getRepository('AppBundle:TipoComision');
		    	$tipoComision=$tipoComisionReposiory->find($idTipoComision);
		    	$comisionPorLetra=$comisionReposiory->findOneBy(array('letraOrdenDelDia'=>$letra));
		    	
		    	$comision=null;
		    	
		    	if($idComision!=0){
		    		$comision=$comisionReposiory->find($idComision);
		    		if (preg_match('/^[a-euz][A-EUZ]/', $letra))
		    			return $this->view('La letra ya esta asociada a otras secciones de  '.
		    							   'la orden del día',500);
		    		if(!is_null($comisionPorLetra) && $comisionPorLetra->getId()!=$comision->getId())
		    			return $this->view('La letra ya esta asignada a la comisión de '.
		    							   $comisionPorLetra->getComision(),500);
		    		$comision->setUsuarioModificacion($usuarioSesion->getUsername());
		    		$comision->setFechaModificacion(new \DateTime("now"));
		    		$mensaje="La comisión ".$comision->getComision()." se modificó con éxito";
		    	}
		    	else {
		    			
		    			if (preg_match('/^[a-euzA-EUZ]/', $letra))
		    				return $this->view('La letra ya esta asociada a otras secciones de  '.
		    								   'la orden del día',500);	
		    			if(!is_null($comisionPorLetra))
			    			return $this->view('La letra ya esta asignada a la comisión de'.
			    					$comisionPorLetra->getComision(),500);
		    		
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
		    	$comision->setLetraOrdenDelDia(strtoupper($letra));
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
     * @Rest\Get("/api/comision/getByCriteria")
     */
    public function traerComisionesPorCriterio(Request $request) {
    	$term=$request->query->get('q');
    	$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    	$comisiones=$comisionRepository->findComisionByPatronBusqueda($term);
    	
    	return $this->view($comisiones,200);
    }
    
    /**
     * @Rest\Get("/api/speech/getOne/{id}")
     */
    public function traerPlanillaPorId(Request $request){
    
    	$id=$request->get('id');
    	
    	$speechRepository=$this->getDoctrine()->getRepository('AppBundle:Speech');
    	$speech=$speechRepository->find($id);
    	
    	return $this->view($speech,200);
    }
    
    /**
     * @Rest\Get("/api/speech/getByTitulo")
     */
    public function traerSpeechPorTitulo(Request $request){
    	
    	$q=$request->query->get('q');
    	
    	$listaSpeechs=[];
    	
    	$speechRepository=$this->getDoctrine()->getRepository('AppBundle:Speech'); 	    	
    	$listaSpeechs=$speechRepository->findByTitulo($q);
 
    	return $this->view($listaSpeechs,200);
    }
    
    /**
     * @Rest\Post("/api/speech/save")
     */
    public function guardarSpeech(Request $request){
    	
    	$textoSuperior=$request->request->get("textoSuperior");
    	$textoInferior=$request->request->get("textoInferior");
    	$tituloSpeech=$request->request->get("tituloSpeech");
    	$incluirSancion=$request->request->get("incluirSancion");
    	    	
    	$speech=new Speech();
    	$speech->setTextoSuperior($textoSuperior);
    	$speech->setTextoInferior($textoInferior);
    	$speech->setTituloSpeech($tituloSpeech);
    	$speech->setIncluirSancion($incluirSancion=='true');
    	$em=$this->getDoctrine()->getManager();
    	$em->persist($speech);
    	$em->flush();
    	
    	$respuesta=array('mensaje'=>'El speech de titulo '.chr(39).$tituloSpeech.chr(39).' se guardó en forma exitosa',
    					 'id'=>$speech->getId(),
    					 'titulo'=>$speech->getTituloSpeech()
    					);
    	
    	return $this->view($respuesta,200);
    }
    
   /**
    * @Rest\Get("/api/versionTaquigrafica/getAll")
    */
    public function traerTodasLasVersionesTaquigraficasAction(Request $request)
    {
    	$versionTaquigraficaRepository=$this->getDoctrine()->getRepository('AppBundle:VersionTaquigrafica');
    	$versionesTaquigraficas=$versionTaquigraficaRepository->findBy(array(),array('id'=>'desc'));
    	
    	$resultados=[];
    	foreach ($versionesTaquigraficas as $versionTaquigrafica){
    		$resultado=array(
			    				'id'=>$versionTaquigrafica->getId(),
			    				'descripcion'=>$versionTaquigrafica->getDescripcion(),
			    				'sesion'=>(!is_null($versionTaquigrafica->getSesion())
			    							?$versionTaquigrafica->getSesion()->getFechaMuestra()
			    							:""),
			    				'sesion_id'=>(!is_null($versionTaquigrafica->getSesion())
					    						?$versionTaquigrafica->getSesion()->getId()
					    						:0),
    							'permite_edicion'=>$versionTaquigrafica->getPermiteEdicion()
			    			);
    		$resultados[]=$resultado;
    		
    	}
    	return $this->view($resultados,200);
    }
    
    /**
     * @Rest\Post("/api/versionTaquigrafica/remove/{id}")
     */
    public  function eliminarVersionTaquigraficaAction(Request $request)
    {
    	try {
		    	$id=$request->get('id');
		    	$versionTaquigraficaRepository=$this->getDoctrine()->getRepository('AppBundle:VersionTaquigrafica');
		    	$versionTaquigrafica=$versionTaquigraficaRepository->find($id);
		    	$em = $this->getDoctrine()->getManager();
		    	$em->remove($versionTaquigrafica);
		    	$em->flush();
		    	
		    	return $this->view("La versión taquigráfica se eliminó en forma exitosa",200);
		    	
    	}catch (\Exception $e){
    		return $this->view($e->getMessage(),500);
    	}
    	
    }
    
    /**
     * @Rest\Post("/api/versionTaquigrafica/save")
     */
    public function guardarVersionTaquigraficaAction(Request $request)
    {
    	try {
		    	$id=$request->request->get("id");
		    	$descripcion=$request->request->get("descripcion");
		    	$idSesion=$request->request->get("idSesion");
		    	$usuario=$this->getUser();
		    	
		    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
		    	$versionTaquigraficaRepository=$this->getDoctrine()->getRepository('AppBundle:VersionTaquigrafica');
		    	$versionTaquigrafica=null;
		    	$sesion=null;
		    	
		    	if ($id!=0){
		    		$versionTaquigrafica=$versionTaquigraficaRepository->find($id);
		    		$versionTaquigrafica->setFechaModificacion(new \DateTime("now"));
		    		$versionTaquigrafica->setUsuarioModificacion($usuario->getUsuario());
		    	}
		    	else {
		    			$versionTaquigrafica=new VersionTaquigrafica();
		    			$versionTaquigrafica->setFechaCreacion(new \DateTime("now"));
		    			$versionTaquigrafica->setUsuarioCreacion($usuario->getUsuario());
		    	}
		    	if ($idSesion!=0)
		    		$sesion=$sesionRepository->find($idSesion);
		    	
		    	$versionTaquigrafica->setDescripcion($descripcion);
		    	$versionTaquigrafica->setSesion($sesion);
		    	
		    	$em = $this->getDoctrine()->getManager();
		    	$em->persist($versionTaquigrafica);
		    	$em->flush();
		    	
		    	return $this->view("La versión taquigráfica se generó en forma exitosa",200);
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
     *  @Rest\Get("/api/session/traerAccion")
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

}