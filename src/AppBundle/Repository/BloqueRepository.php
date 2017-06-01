<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class BloqueRepository extends EntityRepository{

	public function findBloqueByNombre_Patron($patronBusqueda){

		$query = $this->getEntityManager()->createQuery("SELECT b FROM AppBundle:Bloque b WHERE b.bloque like ?1");
		$query->setParameter(1,"%".$patronBusqueda."%");
		return $query->getResult();

	}

	
}

	