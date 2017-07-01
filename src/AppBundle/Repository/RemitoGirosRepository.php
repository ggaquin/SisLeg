<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
class RemitoGirosRepository extends EntityRepository{
	
	public function findByOficina($oficina,$tipo,$idOficinaFiltro){
		
		$qb = $this->createQueryBuilder('r');
		if (is_null($oficina)) //el rol no posee oficina
		{
			if ($tipo=="in")
			{
				$qb -> innerJoin('r.destino', 'd')
					-> where($qb->expr()->eq('d.id', '?1'))
					->setParameter(1, $idOficinaFiltro);
					
			}
			if ($tipo=="out")
			{
				$qb -> innerJoin('r.origen', 'o')
					-> where($qb->expr()->eq('o.id', '?1'))
					->setParameter(1, $idOficinaFiltro);
			}
			
		}
		else{ //el rol posee oficina
			
			$qb -> innerJoin('r.destino', 'd')
				-> innerJoin('r.origen', 'o');
			
			if ($tipo=="any"){
				$qb -> where($qb->expr()->orX(
												$qb->expr()->eq('d.id', '?1'),
												$qb->expr()->eq('o.id','?1')
											)
							);
				
				$qb	->setParameter(1, $oficina->getId());
			}
			if($tipo=='in'){
				$qb -> where($qb->expr()->andX(
												$qb->expr()->eq('d.id', '?1'),
												$qb->expr()->eq('o.id','?2')
											)
							);
				$qb	->setParameter(1, $idOficinaFiltro);
				$qb	->setParameter(2, $oficina->getId());
			}
			if($tipo=='out'){
				$qb -> where($qb->expr()->andX(
													$qb->expr()->eq('d.id', '?1'),
													$qb->expr()->eq('o.id','?2')
												)
							);
				$qb	->setParameter(1, $oficina->getId());
				$qb	->setParameter(2, $idOficinaFiltro);
			}	
	
		}
		
		return $qb->getQuery()->getResult();
		
	}
	
	public function findByOficinaYFechaCreacion($oficina,$fechaCreacion){
		
		$qb = $this->createQueryBuilder('r');
		if (is_null($oficina)) //el rol no posee oficina
			$qb->where($qb->expr()->eq('r.fechaCreacion', '?1'));
		else //el rol posee oficina
		{
			$qb	-> innerJoin('r.destino', 'd')
				-> innerJoin('r.origen', 'o')
				-> where($qb->expr()->andX(
											$qb->expr()->orX(
																$qb->expr()->eq('d.id', '?2'),
																$qb->expr()->eq('o.id','?2')
															 ),
											$qb->expr()->eq('r.fechaCreacion', '?1')
										)
						);
			$qb	->setParameter(2, $oficina->getId());
		}
		
		$qb	->setParameter(1, $fechaCreacion);
		return $qb->getQuery()->getResult();	
	}
	
	public function findByOficinaYFechaRecepcion($oficina,$fechaRecepcion){
		
		$qb = $this->createQueryBuilder('r');
		if (is_null($oficina)) //el rol no posee oficina
			$qb->where($qb->expr()->eq('r.fechaRecepcion', '?1'));
			else //el rol posee oficina
			{
				$qb	-> innerJoin('r.destino', 'd')
				-> innerJoin('r.origen', 'o')
				-> where($qb->expr()->andX(
											$qb->expr()->orX(
													$qb->expr()->eq('d.id', '?2'),
													$qb->expr()->eq('o.id','?2')
													),
											$qb->expr()->eq('r.fechaRecepcion', '?1')
										  )
						);
				$qb	->setParameter(2, $oficina->getId());
			}
			
			$qb	->setParameter(1, $fechaRecepcion);
			return $qb->getQuery()->getResult();
	}
	
	
}