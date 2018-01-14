<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class AutoridadRepository extends EntityRepository{

	public function findAutoridadByTipo($tipoAutoridad){

		$qb = $this->createQueryBuilder('a');
		$qb -> innerJoin('a.tipoAutoridad', 't')
			-> where($qb->expr()->andX(
										$qb->expr()->eq('t.id', ':tipoAutoridad'),
										$qb->expr()->eq('a.activo', ':activo')
									  )
					)
			-> setParameter('tipoAutoridad', $tipoAutoridad)
			-> setParameter('activo', true);
		
		return $qb->getQuery()->getOneOrNullResult();

	}

	
}

	