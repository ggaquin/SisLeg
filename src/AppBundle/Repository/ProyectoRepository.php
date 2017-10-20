<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ProyectoRepository extends EntityRepository{
	
	public function findByTipoProyecto_Id($idTipoProyecto,$filtroPerfil){

		$qb = $this->createQueryBuilder('p')
                   ->innerJoin('p.tipoProyecto', 't')
                   ->innerJoin('p.concejal', 'c');
        $qb ->where($qb->expr()->andX(
				                   		$qb->expr()->eq('t.id', ':idTipoProyecto'),
				                   		$qb->expr()->orX(
							                   				$qb->expr()->isNull(':filtroPerfil'),
							                   				$qb->expr()->eq('c.id', ':filtroPerfil')
						                   				)
				                   		)
                    )
            ->setParameter('idTipoProyecto', $idTipoProyecto)
        	->setParameter('filtroPerfil', $filtroPerfil);

        return $qb->getQuery()->getResult();

	}

	public function findByExpediente_Numero($numeroExpediente,$filtroPerfil){

		$qb = $this->createQueryBuilder('p')
				   ->innerJoin('p.expediente','e')
				   ->innerJoin('p.concejal', 'c');
		$qb ->where($qb->expr()->andX(
								   		$qb->expr()->eq('e.numeroExpediente', ':numeroExpediente'),
								   		$qb->expr()->orX(
											   				$qb->expr()->isNull(':filtroPerfil'),
											   				$qb->expr()->eq('c.id', ':filtroPerfil')
										   				)
								   		)
				   	)
                   
       	   ->setParameter('numeroExpediente', $numeroExpediente)
       	   ->setParameter('filtroPerfil', $filtroPerfil);;

        return $qb->getQuery()->getResult();

	}

	public function findByExpediente_Null($filtroPerfil){

		$qb = $this->createQueryBuilder('p')
        	-> innerJoin('p.concejal', 'c');
        $qb ->where($qb->expr()->andX(
        								$qb->expr()->isNull('p.expediente'),
						        		$qb->expr()->orX(
									        				$qb->expr()->isNull(':filtroPerfil'),
									        				$qb->expr()->eq('c.id', ':filtroPerfil')
								        				)
						        	  )
        			)
  			->setParameter('filtroPerfil', $filtroPerfil);
                   
        return $qb->getQuery()->getResult();

	}
	
	public  function findAllByFiltro($filtroPerfil){
		$qb = $this->createQueryBuilder('p')
				   ->innerJoin('p.expediente','e')
				   ->innerJoin('p.concejal', 'c');
		$qb ->where($qb->expr()->orX(
									 $qb->expr()->isNull(':filtroPerfil'),
									 $qb->expr()->eq('c.id', ':filtroPerfil')
									)			
					)
			->setParameter('filtroPerfil', $filtroPerfil);
							
		return $qb->getQuery()->getResult();
	}
	
	public function findByExpediente_Estado_Id($idEstadoExpediente,$filtroPerfil){

		$qb = $this->createQueryBuilder('p')
				   ->innerJoin('p.expediente','e')
				   ->innerJoin('p.concejal', 'c')
                   ->innerJoin('e.estadoExpediente', 'es');
        $qb ->where($qb->expr()->andX(
                   						$qb->expr()->eq('es.id', ':idEstadoExpediente'),
                   						$qb->expr()->orX(
                   							 				$qb->expr()->isNull(':filtroPerfil'),
                   							 				$qb->expr()->eq('c.id', ':filtroPerfil')
                   							 			 )
                   						)
        			)                   
                   ->setParameter('idEstadoExpediente', $idEstadoExpediente)
                   ->setParameter('filtroPerfil', $filtroPerfil);

        return $qb->getQuery()->getResult();

	}

	public function findByAutor_Nombres($patronBusqueda,$filtroPerfil){

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
	
	public function findRevisionesByProyecto($proyecto){
		
		$rep = $this->getEntityManager()->getRepository('AppBundle:ProyectoRevision');
		$qb = $rep->createQueryBuilder('pr');
		$qb -> innerJoin('pr.proyecto', 'p')
			-> where($qb->expr()->eq('p.id', '?1'))
			-> setParameter(1, $proyecto->getId());
		return $qb->getQuery()->getResult();
	}
}