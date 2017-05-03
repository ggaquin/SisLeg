<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

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
		$qb -> innerJoin('p.autores',
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
}