<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class PerfilRepository extends EntityRepository{


	public function findByNombre_Patron($patronBusqueda){

		$qb = $this->createQueryBuilder('p');
		$qb ->where($qb->expr()->orX(
								       $qb->expr()->like('p.nombres', '?1'),
								       $qb->expr()->like('p.apellidos','?1')
									)
		   		  	)
  		    ->setParameter(1, '%'.$patronBusqueda.'%');
	        return $qb->getQuery()->getResult();
	}
}

	