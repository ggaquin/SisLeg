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
                   ->innerJoin('e.tipoExpediente', 't')
                   ->where('t.id = :idTipoExpediente')
                   ->setParameter('idTipoExpediente', $idTipoExpediente);

        return $qb->getQuery()->getResult();

	}

	public function findByEstado_Id($idEstadoExpediente){

		$qb = $this->createQueryBuilder('e')
                   ->innerJoin('e.estadoExpediente', 'es')
                   ->where('es.id = :idEstadoExpediente')
                   ->setParameter('idEstadoExpediente', $idEstadoExpediente);

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
						
			->distinct()
			->setParameter(1, '%'.$patronBusqueda.'%');
			return $qb->getQuery()->getResult();
								
	}
	
	public function findByParticular_DNI($patronBusqueda){
		
		$qb = $this->createQueryBuilder('e');
		$qb -> innerJoin('e.demandanteParticular','d',
						 'with',$qb->expr()->eq('d.documento', '?1')
						)
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
			$condition.=' and o.idOficina=:idOficina';
			
			if($oficina->getId()==9 && $destino==3){
				$sql.='inner join sesion s on e.idSesion=s.idSesion ';
				$condition.=' and (e.idTipoExpediente in (2,7,9) or s.fecha<:fechaActual)';
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
		
		
		$periodo='20'.substr($numero, -2);
		$numerador=substr($numero, 0,strlen($numero)-2);
		$inicio= new \DateTime($periodo.'-01-01 00:00:00');
		$fin= new \DateTime($periodo.'-12-31 23:59:59');
		$qb = $this->createQueryBuilder('e');
		$qb -> where($qb->expr()->andX(
										$qb->expr()->eq('e.numeroExpediente', '?1'),
										$qb->expr()->between('e.fechaCreacion','?2','?3')
									  )
				)
			->setParameter(1, $numerador)
			->setParameter(2, $inicio->format('Y-m-d'))
			->setParameter(3, $fin->format('Y-m-d'));
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
		
		$rep = $this->getEntityManager()->getRepository('AppBundle:SolicitudInforme');
		$qb = $rep->createQueryBuilder('m');
		$qb -> innerJoin('m.expediente', 'e')
			-> where($qb->expr()->andX(
										$qb->expr()->eq('e.id', '?1'),
										$qb->expr()->eq('m.anulado', '?2')	
									   )
					)
			->setParameter(1, $idExpediente)
			->setParameter(2, false);
		return $qb->getQuery()->getResult();
	}
}