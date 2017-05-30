<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class PerfilRepository extends EntityRepository{


	public function findLegisladorByNombre_Patron($patronBusqueda){

		$rep=$this->getEntityManager()->getRepository('AppBundle:perfilLegislador');
		$qb = $rep->createQueryBuilder('p');
		$qb ->where($qb->expr()->orX(
								       $qb->expr()->like('p.nombres', '?1'),
								       $qb->expr()->like('p.apellidos','?1')
									)
		   		  	)
  		    ->setParameter(1, '%'.$patronBusqueda.'%');
	        return $qb->getQuery()->getResult();
	}

	public function findLegisladorByDescripcion_Patron($patronBusqueda){

		$query = $this->getEntityManager()->createQuery("SELECT p FROM AppBundle:PerfilLegislador p inner join p.bloque b WHERE p.nombres like ?1 or p.apellidos like ?1 or b.bloque like ?1");
		$query->setParameter(1,"%".$patronBusqueda."%");
		return $query->getResult();

	}

	public function perfilPoseeUsuario($id){

		$rep=$this->getEntityManager()->getRepository('AppBundle:Usuario');
		$qb = $rep->createQueryBuilder('u');
		$qb = $qb->innerJoin('u.perfil','p');
		$qb ->where('p.id = ?1')
  		    ->setParameter(1,$id);
  		$usuario = $qb->getQuery()->getResult();
	    return !empty((array)$usuario);
	}
}

	