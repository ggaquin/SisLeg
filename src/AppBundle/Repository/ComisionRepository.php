<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ComisionRepository extends EntityRepository{
	
	public function findComisionByPatronBusqueda($patronBusqueda){

		$qb = $this->createQueryBuilder('c');
		$qb ->where($qb->expr()->like('c.comision', '?1'))
			->setParameter(1, '%'.$patronBusqueda.'%');
				
		return $qb->getQuery()->getResult();
	}
}