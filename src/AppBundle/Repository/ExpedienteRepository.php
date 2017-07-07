<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

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
		$qb -> innerJoin('e.proyecto',
						'p')
		    ->innerJoin('p.autores',
						'a',
						'with',$qb->expr()->orX(
								       $qb->expr()->like('a.nombres', '?1'),
								       $qb->expr()->like('a.apellidos','?1')
									)
		   		  		)
		    ->distinct()
  		    ->setParameter(1, '%'.$patronBusqueda.'%');
	        return $qb->getQuery()->getResult();
	  
	}
	
	public function findNumeroCompletoByNumero($numero,$oficina){
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idExpediente', 'id');
		$rsm->addScalarResult('numeroExpediente', 'numero');
		$rsm->addScalarResult('letra', 'letra');
		$rsm->addScalarResult('fechaCreacion', 'fecha');
		$rsm->addScalarResult('folios', 'folios');
		
		$sql='SELECT e.idExpediente, e.numeroExpediente, t.letra, e.fechaCreacion, e.folios '.
			 'FROM expediente e '.
			 'inner join tipoExpediente t '.
			 'on e.idTipoExpediente=t.idTipoExpediente ';
		
		$condition='WHERE e.numeroExpediente=:numero';
		
		if(!is_null($oficina)){
			$sql.='inner join oficina o on e.idOficina=o.idOficina ';
			$condition.=' and o.idOficina=:idOficina';
		}
		
		$sql.=$condition;
		
		$query = $this->getEntityManager()
		->createNativeQuery($sql,$rsm);
		$query->setParameter('numero',$numero);
		
		if(!is_null($oficina))
			$query->setParameter('idOficina',$oficina->getId());
		
		return $query->getSingleResult();
		
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
}