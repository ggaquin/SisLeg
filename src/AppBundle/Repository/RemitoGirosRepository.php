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
		
		$desde=$fechaCreacion." 00:00:00";
		$hasta=$fechaCreacion." 23:59:59";
		
		$qb = $this->createQueryBuilder('r');
		if (is_null($oficina)) //el rol no posee oficina
			$qb->where($qb->expr()->between('r.fechaCreacion', '?2', '?3'));
		else //el rol posee oficina
		{
			$qb	-> innerJoin('r.destino', 'd')
				-> innerJoin('r.origen', 'o')
				-> where($qb->expr()->andX(
											$qb->expr()->orX(
																$qb->expr()->eq('d.id', '?1'),
																$qb->expr()->eq('o.id','?1')
															 ),
											$qb->expr()->between('r.fechaCreacion', '?2', '?3')
										)
						);
			$qb	->setParameter(1, $oficina->getId());
		}
		
		$qb	->setParameter(2, $desde);
		$qb	->setParameter(3, $hasta);
		return $qb->getQuery()->getResult();	
	}
	
	public function findByOficinaYFechaRecepcion($oficina,$fechaRecepcion){
		
		$desde=$fechaRecepcion." 00:00:00";
		$hasta=$fechaRecepcion." 23:59:59";
		
		$qb = $this->createQueryBuilder('r');
		if (is_null($oficina)) //el rol no posee oficina
			$qb->where($qb->expr()->between('r.fechaRecepcion', '?2', '?3'));
			else //el rol posee oficina
			{
				$qb	-> innerJoin('r.destino', 'd')
				-> innerJoin('r.origen', 'o')
				-> where($qb->expr()->andX(
											$qb->expr()->orX(
													$qb->expr()->eq('d.id', '?1'),
													$qb->expr()->eq('o.id','?1')
													),
											$qb->expr()->between('r.fechaRecepcion', '?2', '?3')
										  )
						);
				$qb	->setParameter(1, $oficina->getId());
			}
			
			$qb	->setParameter(2, $desde);
			$qb	->setParameter(3, $hasta);
			return $qb->getQuery()->getResult();
	}
	
	public function findByNumeroCompleto($oficina,$numero){
		
		
		$periodo='20'.substr($numero, -2);
		$numerador=substr($numero, 0,strlen($numero)-2);
		$inicio= new \DateTime($periodo.'-01-01 00:00:00');
		$fin= new \DateTime($periodo.'-12-31 23:59:59');
		$qb = $this->createQueryBuilder('r')
			-> innerJoin('r.giros', 'g')
			-> innerJoin('g.expediente', 'e');
		$qb -> where($qb->expr()->andX(
										$qb->expr()->eq('e.numeroExpediente', '?1'),
										$qb->expr()->between('e.fechaCreacion','?2','?3')
									)
					)
				->setParameter(1, $numerador)
				->setParameter(2, $inicio->format('Y-m-d'))
				->setParameter(3, $fin->format('Y-m-d'));
		return $qb->getQuery()->getResult();
	}
	
	
}