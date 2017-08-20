<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ProyectoRepository extends EntityRepository{
	
	public function findByTipoProyecto_Id($idTipoProyecto){

		$qb = $this->createQueryBuilder('p')
                   ->innerJoin('p.tipoProyecto', 't')
                   ->where('t.id = :idTipoProyecto')
                   ->setParameter('idTipoProyecto', $idTipoProyecto);

        return $qb->getQuery()->getResult();

	}

	public function findByExpediente_Numero($numeroExpediente){

		$qb = $this->createQueryBuilder('p')
				   ->innerJoin('p.expediente','e')
                   ->where('e.numeroExpediente = :numeroExpediente')
                   ->setParameter('numeroExpediente', $numeroExpediente);

        return $qb->getQuery()->getResult();

	}

	public function findByExpediente_Null(){

		$qb = $this->createQueryBuilder('p');
        $qb-> where($qb->expr()->isNull('p.expediente'));
                   
        return $qb->getQuery()->getResult();

	}

	public function findByExpediente_Estado_Id($idEstadoExpediente){

		$qb = $this->createQueryBuilder('p')
				   ->innerJoin('p.expediente','e')
                   ->innerJoin('e.estadoExpediente', 'es')
                   ->where('es.id = :idEstadoExpediente')
                   ->setParameter('idEstadoExpediente', $idEstadoExpediente);

        return $qb->getQuery()->getResult();

	}

	public function findByAutor_Nombres($patronBusqueda){

		$qb = $this->createQueryBuilder('p');
		$qb -> innerJoin('p.concejal','c')
			->where($qb->expr()->orX(
								       $qb->expr()->like('c.nombres', '?1'),
								       $qb->expr()->like('c.apellidos','?1')
									)
		   		  	)
  		    ->setParameter(1, '%'.$patronBusqueda.'%');
	        return $qb->getQuery()->getResult();
	  
	}
}