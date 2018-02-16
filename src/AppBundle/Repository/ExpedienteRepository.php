<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use AppBundle\Entity\Movimiento;
use AppBundle\Entity\Pase;
use AppBundle\Entity\SolicitudInforme;

class ExpedienteRepository extends EntityRepository{
	
	
	public function searchByHashValue($hashValue){

		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idExpediente', 'idExpediente');
		
		$query = $this->getEntityManager()
            ->createNativeQuery(
            	 'SELECT e.idExpediente FROM expediente e WHERE e.hashId=:hashId'	
            ,$rsm);
        $query->setParameter('hashId',$hashValue);

        return $query->getSingleResult();

	}

	public function findByTipoExpediente_Id($idTipoExpediente){

		$qb = $this->createQueryBuilder('e')
                   ->innerJoin('e.tipoExpediente', 't');
        $qb -> where($qb->expr()->andX(
        								$qb->expr()->isNull('e.fechaArchivo'),
        								$qb->expr()->eq('t.id', ':idTipoExpediente')
        							  )
               		)
            ->setParameter('idTipoExpediente', $idTipoExpediente);

        return $qb->getQuery()->getResult();

	}

	public function findByEstado_Id($idEstadoExpediente){

		$qb = $this->createQueryBuilder('e')
                   ->innerJoin('e.estadoExpediente', 'es');
        $qb -> where($qb->expr()->andX(
        								$qb->expr()->isNull('e.fechaArchivo'),
        								$qb->expr()->eq('es.id', ':idEstadoExpediente')
        								)	
                   	)
             -> setParameter('idEstadoExpediente', $idEstadoExpediente);

        return $qb->getQuery()->getResult();

	}

	public function findByAutor_Nombres($patronBusqueda){

		$qb = $this->createQueryBuilder('e');
		$qb -> innerJoin('e.proyecto','p')
		    -> innerJoin('p.concejal','c',
						'with',$qb->expr()->orX(
								       $qb->expr()->like('c.nombres', '?1'),
								       $qb->expr()->like('c.apellidos','?1')
									)
		   		  		)
   		  	->where($qb->expr()->isNull('e.fechaArchivo'))
		    ->distinct()
  		    ->setParameter(1, '%'.$patronBusqueda.'%');
			
	        return $qb->getQuery()->getResult();
	  
	}
	
	public function findByParticular_Nombres($patronBusqueda){
		
		$qb = $this->createQueryBuilder('e');
		$qb -> innerJoin('e.demandanteParticular','d',
						 'with',$qb->expr()->orX(
								$qb->expr()->like('d.nombres', '?1'),
								$qb->expr()->like('d.apellidos','?1')
								)
						)
		    ->where($qb->expr()->isNull('e.fechaArchivo'))		
			->distinct()
			->setParameter(1, '%'.$patronBusqueda.'%');
			return $qb->getQuery()->getResult();
								
	}
	
	public function findByParticular_DNI($patronBusqueda){
		
		$qb = $this->createQueryBuilder('e');
		$qb -> innerJoin('e.demandanteParticular','d',
						 'with',$qb->expr()->eq('d.documento', '?1')
						)
			->where($qb->expr()->isNull('e.fechaArchivo'))	
			->distinct()
			->setParameter(1, $patronBusqueda);
			return $qb->getQuery()->getResult();
				
	}
	
	public function findNumeroCompletoByNumero($numero,$oficina,$destino){
		
		if(preg_match('/^\d*\-\d{2}/',$numero)!==1)
			throw new \Exception('El criterio de busqueda debe tener el formato  #[#..#]-AA (por ejemplo 1-17)');
		
		$numeroSeparado=explode('-', $numero);
			
		$periodo='20'.$numeroSeparado[1];
		$numerador=$numeroSeparado[0];
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idExpediente', 'id');
		$rsm->addScalarResult('numeroExpediente', 'numero');
		$rsm->addScalarResult('letra', 'letra');
		$rsm->addScalarResult('periodo', 'periodo');
		$rsm->addScalarResult('folios', 'folios');
		
		$sql='SELECT DISTINCT e.idExpediente, e.numeroExpediente, t.letra, e.periodo, e.folios '.
			 'FROM expediente e '.
			 'inner join tipoExpediente t '.
			 'on e.idTipoExpediente=t.idTipoExpediente ';
		
		$condition='WHERE e.numeroExpediente=:numero and e.periodo=:periodo';
		
		if(!is_null($oficina)){
			$sql.='inner join oficina o on e.idOficina=o.idOficina ';
			$condition.=' and o.idOficina in (:oficinas) and e.fechaArchivo is null ';
			
			if($oficina->getId()==9 && $destino==3){
				$sql.='left join sesion s on e.idSesion=s.idSesion ';
				$condition.=' and (e.idTipoExpediente in (2,7,9) or '.
							' e.idExpediente in (select DISTINCT idExpediente '.
									  			'from expedienteSesion))';
			}
		}
		
		$sql.=$condition;
		
		$query = $this->getEntityManager()
		->createNativeQuery($sql,$rsm);
		$query->setParameter('numero',$numerador);
		$query->setParameter('periodo', $periodo);
		
		if ($oficina->getId()==9){
			$oficinas=array($oficina->getId(),3);
			$query->setParameter('oficinas',$oficinas);
		}
		else
			$query->setParameter('oficinas',$oficina->getId());
		
		return $query->getResult();
		
	}
	
	public function findByNumeroCompleto($numero,$numeroExcluido=null,$tieneSancion=null,$tieneAsignacionComision=null){
		
		if(preg_match('/^\d*\-\d{2}/',$numero)!==1)
			throw new \Exception('El criterio de busqueda debe tener el formato  #[#..#]-AA (por ejemplo 1-17)');
				
		$numeroSeparado=explode('-', $numero);
		$numeroExcluidoSeparado=is_null($numeroExcluido)?$numeroExcluido:explode('-',$numeroExcluido);
				
		$periodo='20'.$numeroSeparado[1];
		$numerador=$numeroSeparado[0];
		$periodoNumeroExcluido=is_null($numeroExcluido)?null:'20'.$numeroExcluidoSeparado[1];
		$numeradorNumeroExcluido=is_null($numeroExcluido)?null:$numeroExcluidoSeparado[0];
		
		$qb1 = $this->createQueryBuilder('esq');
		
		if (!is_null($tieneAsignacionComision)){
			
			if($tieneAsignacionComision==true){
				$qb1 -> select('DISTINCT esq.id')
					 -> innerJoin('esq.asignacionComisiones', 'ecsq')
					 -> innerJoin('esq.estadoExpediente', 'eesq')
					 -> where($qb1->expr()->eq('eesq.id','?8'));
			}
			else{	
					$qb1 -> select('DISTINCT esq.id')
						 -> leftJoin('esq.asignacionComisiones', 'ecsc')
						 -> where($qb1->expr()->isNull('ecsc.id'));
			}
		}
			 
		$qb = $this->createQueryBuilder('e')
				   ->leftJoin('e.asignacionComisiones', 'a');
		$qb -> where($qb->expr()
						->andX(
								$qb->expr()->eq('e.numeroExpediente','?1'),
								$qb->expr()->eq('e.periodo','?2'),
								$qb->expr()->isNull('e.fechaArchivo'),
								$qb->expr()
								   ->orX(
										 $qb->expr()->isNull('?3'),
										 $qb->expr()
								   			->not(
												  $qb->expr()
								   					 ->andX(
															$qb->expr()->eq('e.numeroExpediente','?4'),
															$qb->expr()->eq('e.periodo','?5')
														   )
												 )
										),
								$qb->expr()
							       ->orX(
							       		  $qb->expr()->isNull('?6'),
							       		  $qb->expr()->eq('e.numeroSancion', '?6')
										),
								$qb->expr()
								   ->orX(
								   		  $qb->expr()->isNull('?7'),
								   		  $qb->expr()->in('e.id', $qb1->getDQL())
 								   		)
							  )
					)
			->groupBy('e.id')
			->setParameter(1,$numerador)
			->setParameter(2,$periodo)
			->setParameter(3,$numeroExcluido)
			->setParameter(4,$numeradorNumeroExcluido)
			->setParameter(5,$periodoNumeroExcluido)
			->setParameter(6,$tieneSancion)
 			->setParameter(7,$tieneAsignacionComision);
		
 		if($tieneAsignacionComision==true)
 			$qb->setParameter(8, '2');
		
		return $qb->getQuery()->getResult();
			
	}
	
	public function findGirosByExpediente_Id($idExpediente){
		
		$rep = $this->getEntityManager()->getRepository('AppBundle:Pase');
		$qb = $rep->createQueryBuilder('m');
		$qb ->innerJoin('m.expediente', 'e')
		    -> where($qb->expr()->andX(
							    		$qb->expr()->eq('e.id', '?1'),
		    							$qb->expr()->eq('m.anulado', '?2')
							    		)
		    		)
		    ->setParameter(1, $idExpediente)
		    ->setParameter(2, false);
		return $qb->getQuery()->getResult();
	}
		
	public function findInformesByExpediente_Id($idExpediente){
			
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idMovimiento', 'id');
		$rsm->addScalarResult('tipo', 'tipo');
		$rsm->addScalarResult('numero_remito', 'numero_remito');
		$rsm->addScalarResult('destino', 'destino');
		$rsm->addScalarResult('fecha_envio', 'fecha_envio');
		$rsm->addScalarResult('observacion', 'observacion');
		$rsm->addScalarResult('fecha_recepcion', 'fecha_recepcion');
		$rsm->addScalarResult('fecha_respuesta', 'fecha_respuesta');
		$rsm->addScalarResult('remito_retorno', 'remito_retorno');
		$rsm->addScalarResult('comision', 'comision');
		
		$sql="select m.idMovimiento, upper(m.discriminador) as tipo, r.numeroRemito as numero_remito, ".
			 		 "o.oficina as destino, DATE_FORMAT(r.fechaCreacion, '%d/%m/%Y') as fecha_envio, ".
					 "ifnull(m.observacion,'') as observacion, ifnull(DATE_FORMAT(r.fechaRecepcion, '%d/%m/%Y'),'') as fecha_recepcion, ".
					 "ifnull(DATE_FORMAT(m.fechaRespuesta, '%d/%m/%Y'),'') as fecha_respuesta, ".
					 "m.remitoRetorno as remito_retorno, ifnull(upper(c.comision),'') as comision ".
			 "from 	movimiento m ".
			 "inner join	remito r on	m.idRemito=r.idRemito ".
			 "inner join oficina o on r.idDestino=o.IdOficina ".
			 "left join comision c on m.idComision=c.idComision ".
			 "where   m.discriminador<> :pase and  m.idExpediente=:idExpediente";
		
		$query = $this -> getEntityManager() -> createNativeQuery($sql, $rsm);
		$query -> setParameter('idExpediente', $idExpediente)
			   -> setParameter('pase', 'pase');

		return  $query->getResult();
		
	}
	
	public function findAllInformes()
	{
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idMovimiento', 'id');
		$rsm->addScalarResult('numeroExpediente', 'numero_expediente');
		$rsm->addScalarResult('tipo', 'tipo');
		$rsm->addScalarResult('destino', 'destino');
		$rsm->addScalarResult('fecha_envio', 'fecha_envio');
		$rsm->addScalarResult('observacion', 'observacion');
		$rsm->addScalarResult('fechaRespuesta', 'fecha_respuesta');
		$rsm->addScalarResult('comision', 'comision_reserva');
		
		
		$sql="select m.idMovimiento, concat(e.numeroExpediente,'-',t.letra,'-',e.periodo) as numeroExpediente, ".
					"m.discriminador as tipo, o.oficina as destino, DATE_FORMAT(r.fechaCreacion, '%d/%m/%Y') as fecha_envio, ".
					"ifnull(m.observacion,'') as observacion, ifnull(DATE_FORMAT(m.fechaRespuesta, '%d/%m/%Y'),'') as fechaRespuesta, ".
					"ifnull(upper(c.comision),'') as comision ".
			"from 	movimiento m ".
			"inner join	remito r on	m.idRemito=r.idRemito ".
			"inner join oficina o on r.idDestino=o.IdOficina ".
			"inner join expediente e on e.idExpediente=m.idExpediente ".
			"inner join tipoExpediente t on e.idTipoExpediente=t.idTipoExpediente ".
			"left join comision c on m.idComision=c.idComision ".
			"where   m.discriminador<>:pase";
		
		$query = $this -> getEntityManager() -> createNativeQuery($sql, $rsm);
		$query -> setParameter('pase', 'pase');
			
		return $query->getResult();
		
	}
	
	public function findInformeByNumeroExpediente($numero)
	{
		if(preg_match('/^\d*\-\d{2}/',$numero)!==1)
			throw new \Exception('El criterio de busqueda debe tener el formato  #[#..#]-AA (por ejemplo 1-17)');
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idMovimiento', 'id');
		$rsm->addScalarResult('numeroExpediente', 'numero_expediente');
		$rsm->addScalarResult('tipo', 'tipo');
		$rsm->addScalarResult('destino', 'destino');
		$rsm->addScalarResult('fecha_envio', 'fecha_envio');
		$rsm->addScalarResult('observacion', 'observacion');
		$rsm->addScalarResult('fechaRespuesta', 'fecha_respuesta');
		$rsm->addScalarResult('comision', 'comision_reserva');
	
		$numeroSeparado=explode('-', $numero);
					
		$periodo='20'.$numeroSeparado[1];
		$numerador=$numeroSeparado[0];
		
		$sql="select m.idMovimiento, concat(e.numeroExpediente,'-',t.letra,'-',e.periodo) as numeroExpediente, ".
					"m.discriminador as tipo, o.oficina as destino, DATE_FORMAT(r.fechaCreacion, '%d/%m/%Y') as fecha_envio, ".
					"ifnull(m.observacion,'') as observacion, ifnull(DATE_FORMAT(m.fechaRespuesta, '%d/%m/%Y'),'') as fechaRespuesta, ".
					"ifnull(upper(c.comision),'') as comision ".
			 "from 	movimiento m ".
			 "inner join	remito r on	m.idRemito=r.idRemito ".
			 "inner join oficina o on r.idDestino=o.IdOficina ".
			 "inner join expediente e on e.idExpediente=m.idExpediente ".
			 "inner join tipoExpediente t on e.idTipoExpediente=t.idTipoExpediente ".
			 "left join comision c on m.idComision=c.idComision ".
			 "where   m.discriminador<>:pase and e.numeroExpediente=:numeroExpediente and e.periodo=:periodo";
		
		$query = $this -> getEntityManager() -> createNativeQuery($sql, $rsm);
		$query -> setParameter('pase', 'pase')
			   -> setParameter('numeroExpediente', $numerador)
			   -> setParameter('periodo', $periodo);
				
		return $query->getResult();
	}

	public function findInformeByTipo($tipo)
	{
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idMovimiento', 'id');
		$rsm->addScalarResult('numeroExpediente', 'numero_expediente');
		$rsm->addScalarResult('tipo', 'tipo');
		$rsm->addScalarResult('destino', 'destino');
		$rsm->addScalarResult('fecha_envio', 'fecha_envio');
		$rsm->addScalarResult('observacion', 'observacion');
		$rsm->addScalarResult('fechaRespuesta', 'fecha_respuesta');
		$rsm->addScalarResult('comision', 'comision_reserva');
		
		$sql="select m.idMovimiento, concat(e.numeroExpediente,'-',t.letra,'-',e.periodo) as numeroExpediente, ".
					"m.discriminador as tipo, o.oficina as destino, DATE_FORMAT(r.fechaCreacion, '%d/%m/%Y') as fecha_envio, ".
					"ifnull(m.observacion,'') as observacion, ifnull(DATE_FORMAT(m.fechaRespuesta, '%d/%m/%Y'),'') as fechaRespuesta, ".
					"ifnull(upper(c.comision),'') as comision ".
				"from 	movimiento m ".
				"inner join	remito r on	m.idRemito=r.idRemito ".
				"inner join oficina o on r.idDestino=o.IdOficina ".
				"inner join expediente e on e.idExpediente=m.idExpediente ".
				"inner join tipoExpediente t on e.idTipoExpediente=t.idTipoExpediente ".
				"left join comision c on m.idComision=c.idComision ".
				"where   m.discriminador=:tipo";
			
		$query = $this -> getEntityManager() -> createNativeQuery($sql, $rsm);
		$query -> setParameter('tipo', $tipo);
			
		return $query->getResult();
	
	}
	
	public function findInformeByDestino($idDestino)
	{
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idMovimiento', 'id');
		$rsm->addScalarResult('numeroExpediente', 'numero_expediente');
		$rsm->addScalarResult('tipo', 'tipo');
		$rsm->addScalarResult('destino', 'destino');
		$rsm->addScalarResult('fecha_envio', 'fecha_envio');
		$rsm->addScalarResult('observacion', 'observacion');
		$rsm->addScalarResult('fechaRespuesta', 'fecha_respuesta');
		$rsm->addScalarResult('comision', 'comision_reserva');
			
		$sql="select m.idMovimiento, concat(e.numeroExpediente,'-',t.letra,'-',e.periodo) as numeroExpediente, ".
					"m.discriminador as tipo, o.oficina as destino, DATE_FORMAT(r.fechaCreacion, '%d/%m/%Y') as fecha_envio, ".
					"ifnull(m.observacion,'') as observacion, ifnull(DATE_FORMAT(m.fechaRespuesta, '%d/%m/%Y'),'') as fechaRespuesta, ".
					"ifnull(upper(c.comision),'') as comision ".
					"from 	movimiento m ".
			"inner join	remito r on	m.idRemito=r.idRemito ".
			"inner join oficina o on r.idDestino=o.IdOficina ".
			"inner join expediente e on e.idExpediente=m.idExpediente ".
			"inner join tipoExpediente t on e.idTipoExpediente=t.idTipoExpediente ".
			"left join comision c on m.idComision=c.idComision ".
			"where   m.discriminador<>:pase and o.idOficina=:idDestino";
		
		$query = $this -> getEntityManager() -> createNativeQuery($sql, $rsm);
		$query -> setParameter('pase', 'pase')
			   -> setParameter('idDestino', $idDestino);
		
		return $query->getResult();
	}
	
	public function findInformeByComisionReserva($idComisionReserva)
	{
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idMovimiento', 'id');
		$rsm->addScalarResult('numeroExpediente', 'numero_expediente');
		$rsm->addScalarResult('tipo', 'tipo');
		$rsm->addScalarResult('destino', 'destino');
		$rsm->addScalarResult('fecha_envio', 'fecha_envio');
		$rsm->addScalarResult('observacion', 'observacion');
		$rsm->addScalarResult('fechaRespuesta', 'fecha_respuesta');
		$rsm->addScalarResult('comision', 'comision_reserva');
		
		$sql="select m.idMovimiento, concat(e.numeroExpediente,'-',t.letra,'-',e.periodo) as numeroExpediente, ".
				"m.discriminador as tipo, o.oficina as destino, DATE_FORMAT(r.fechaCreacion, '%d/%m/%Y') as fecha_envio, ".
				"ifnull(m.observacion,'') as observacion, ifnull(DATE_FORMAT(m.fechaRespuesta, '%d/%m/%Y'),'') as fechaRespuesta, ".
				"ifnull(upper(c.comision),'') as comision ".
				"from 	movimiento m ".
				"inner join	remito r on	m.idRemito=r.idRemito ".
				"inner join oficina o on r.idDestino=o.IdOficina ".
				"inner join expediente e on e.idExpediente=m.idExpediente ".
				"inner join tipoExpediente t on e.idTipoExpediente=t.idTipoExpediente ".
				"inner join comision c on m.idComision=c.idComision ".
				"where   m.discriminador<>:pase and c.idComision=:idComisionReserva";
		
		$query = $this -> getEntityManager() -> createNativeQuery($sql, $rsm);
		$query -> setParameter('pase', 'pase')
		-> setParameter('idComisionReserva', $idComisionReserva);
		
		return $query->getResult();
		
	}
	
	public function findByArchivo() {
		
		$qb = $this->createQueryBuilder('e');
		$qb -> where($qb->expr()->isNotNull('e.fechaArchivo'));
				
		return $qb->getQuery()->getResult();
	}
		
	public function traerExpedienteParaImpresion($idExpediente)
	{
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('caratula', 'caratula');
		$rsm->addScalarResult('numeroExpediente', 'numeroExpediente');
		$rsm->addScalarResult('letra', 'letra');
		$rsm->addScalarResult('periodo', 'periodo');
		$rsm->addScalarResult('fechaIngreso', 'fechaIngreso');
		$rsm->addScalarResult('origen', 'origen');
		$rsm->addScalarResult('textoProyecto', 'textoProyecto');
		
		$query = $this -> getEntityManager()
					   -> createNativeQuery('call conformarExpediente(:idExpediente)',$rsm)
					   -> setParameter('idExpediente',$idExpediente);
		
		return $query->getResult();
	}
	
	public function traerESinCuerpo($fechaDesde, $fechaHasta){
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('texto', 'texto', 'text');
		
		$query = $this-> getEntityManager()
		-> createNativeQuery(
				'call listadoESinCuerpo(:fechaDesde,:fechaHasta)',
				$rsm)
				-> setParameter('fechaDesde',$fechaDesde)
				-> setParameter('fechaHasta',$fechaHasta);
				
				return $query->getResult();
				
	}
	
	public function traerDatosRemito($idRemito)
	{
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('Destino', 'destino');
		$rsm->addScalarResult('Numero', 'numero');
		$rsm->addScalarResult('Pases', 'pases');
		$rsm->addScalarResult('Informes', 'informes');
		$rsm->addScalarResult('Notificaciones', 'notificaciones');
		
		$query = $this -> getEntityManager()
					   -> createNativeQuery('call conformarRemito(:idRemito)',$rsm)
					   -> setParameter('idRemito',$idRemito);
		
		return $query->getResult();
	}
	
	public function traerOficinasPorNombreYTipo($patronNombre,$externas)
	{
		$idTipoOficina=(($externas=='true')?2:1);
		$rep = $this->getEntityManager()->getRepository('AppBundle:Oficina');
		$qb	= $rep->createQueryBuilder('o')
			-> innerJoin('o.tipoOficina', 't');
		$qb -> where($qb->expr()->andX(
									  $qb->expr()->like('o.oficina', '?1'),
									  $qb->expr()->eq('t.id', '?2')
				
									  )
					)
			->  setParameter(1, '%'.$patronNombre.'%')
			->setParameter(2, $idTipoOficina);
		return $qb->getQuery()->getResult();
	}
	
	public function findBySesion_Id($idSesion)
	{
		$qb	= $this -> createQueryBuilder('e');
		$qb -> innerJoin('e.sesion', 's')
		 	-> where($qb->expr()->eq('s.id', '?1'))
			->  setParameter(1, $idSesion);
		
		return $qb->getQuery()->getResult();
	}
	
	
	public function findLastMovimientoByIdExpediente($idExpediente)
	{
		$rep = $this->getEntityManager()->getRepository('AppBundle:Movimiento');
		$qb1 = $rep->createQueryBuilder('msq');
		$qb1 ->select('MAX(msq.id)')
			 ->innerJoin('msq.expediente', 'esq')
			 ->where($qb1->expr()->andX(
			 							$qb1->expr()->eq('esq.id', ':idExpediente'),
			 							$qb1->expr()->eq('msq.anulado', ':anulado')
			 						  )
			 		)
			 ->groupBy('esq.id');
		
		$qb = $rep->createQueryBuilder('m');
		$qb ->innerJoin('m.expediente', 'e')
			->where($qb->expr()->in('m.id', $qb1->getDQL()))
			->setParameter(':idExpediente', $idExpediente)
			->setParameter(':anulado', false);
			
			
		return $qb->getQuery()->getOneOrNullResult();
	}
}