<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use AppBundle\Entity\Movimiento;
use AppBundle\Entity\Pase;

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
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idExpediente', 'id');
		$rsm->addScalarResult('numeroExpediente', 'numero');
		$rsm->addScalarResult('letra', 'letra');
		$rsm->addScalarResult('periodo', 'periodo');
		$rsm->addScalarResult('folios', 'folios');
		
		$fechaActual=new \DateTime('now');
		
		$sql='SELECT e.idExpediente, e.numeroExpediente, t.letra, e.periodo, e.folios '.
			 'FROM expediente e '.
			 'inner join tipoExpediente t '.
			 'on e.idTipoExpediente=t.idTipoExpediente ';
		
		$condition='WHERE e.numeroExpediente=:numero';
		
		if(!is_null($oficina)){
			$sql.='inner join oficina o on e.idOficina=o.idOficina ';
			$condition.=' and o.idOficina=:idOficina and e.fechaArchivo is null ';
			
			if($oficina->getId()==9 && $destino==3){
				$sql.='inner join sesion s on e.idSesion=s.idSesion ';
				$condition.=' and (e.idTipoExpediente in (2,7,9) or s.tieneEdicionBloqueada=1)';
			}
		}
		
		$sql.=$condition;
		
		$query = $this->getEntityManager()
		->createNativeQuery($sql,$rsm);
		$query->setParameter('numero',$numero);
		
		if(!is_null($oficina)){
			$query->setParameter('idOficina',$oficina->getId());
			if ($oficina->getId()==9)
				$query->setParameter('fechaActual',$fechaActual);
		}
		return $query->getResult();
		
	}
	
	public function findByNumeroCompleto($numero,$oficina){
		
		$numeroSeparado=explode('-', $numero);
		
		if (count($numeroSeparado)!=2)
			throw new \Exception('El criterio de busqueda debe tener el formato {numero}-{año} (por ejemplo 1-17)');
		
		$periodo='20'.$numeroSeparado[1];
		$numerador=$numeroSeparado[0];
		$qb = $this->createQueryBuilder('e');
		$qb -> where($qb->expr()->andX(
										$qb->expr()->eq('e.numeroExpediente', '?1'),
										$qb->expr()->eq('e.periodo','?2'),
										$qb->expr()->isNull('e.fechaArchivo')
									  )
				)
			->setParameter(1, $numerador)
			->setParameter(2,$periodo);
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
	
// 	public function findInformesByExpediente_Id($idExpediente){
		
// 		$rep = $this->getEntityManager()->getRepository('AppBundle:SolicitudInforme');
// 		$qb = $rep->createQueryBuilder('m');
// 		$qb -> innerJoin('m.expediente', 'e')
// 			-> where($qb->expr()->andX(
// 										$qb->expr()->eq('e.id', '?1'),
// 										$qb->expr()->eq('m.anulado', '?2')	
// 									   )
// 					)
// 			->setParameter(1, $idExpediente)
// 			->setParameter(2, false);
// 		return $qb->getQuery()->getResult();
// 	}
	
	public function findInformesByExpediente_Id($idExpediente){
			
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idMovimiento', 'id');
		$rsm->addScalarResult('tipo', 'tipo');
		$rsm->addScalarResult('numero_Remito', 'numero_remito');
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
		
		if (count($numeroSeparado)!=2)
			throw new \Exception('El criterio de busqueda debe tener el formato {numero}-{año} (por ejemplo 1-17)');
			
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
	/*
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
	}*/
}