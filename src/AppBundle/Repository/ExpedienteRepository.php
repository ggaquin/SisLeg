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
	
	public function findNumeroCompletoByNumero($numero){
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idExpediente', 'id');
		$rsm->addScalarResult('numeroExpediente', 'numero');
		$rsm->addScalarResult('letra', 'letra');
		$rsm->addScalarResult('fechaCreacion', 'fecha');
		$rsm->addScalarResult('folios', 'folios');
		
		$query = $this->getEntityManager()
		->createNativeQuery(
				'SELECT e.idExpediente, e.numeroExpediente, t.letra, e.fechaCreacion, e.folios '.
				'FROM expediente e '.
				'inner join tipoExpediente t '.
				'on e.idTipoExpediente=t.idTipoExpediente '.
				'WHERE e.numeroExpediente=:numero'
				,$rsm);
		$query->setParameter('numero',$numero);
		
		return $query->getSingleResult();
		
	}
}