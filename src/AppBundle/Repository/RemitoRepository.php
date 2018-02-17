<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
class RemitoRepository extends EntityRepository{
	
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
		
		if(preg_match('/^\d*\-\d{2}/',$numero)!==1)
			throw new \Exception('El criterio de busqueda debe tener el formato  #[#..#]-AA (por ejemplo 1-17)');
		
		$numeroSeparado=explode('-', $numero);
		
// 		if (count($numeroSeparado)!=2)
// 			throw new \Exception('El criterio de busqueda debe tener el formato {numero}-{año} (por ejemplo 1-17)');
			
		$periodo='20'.$numeroSeparado[1];
		$numerador=$numeroSeparado[0];
		
		$qb = $this->createQueryBuilder('r')
			-> innerJoin('r.movimientos', 'm')
			-> innerJoin('m.expediente', 'e');
		$qb -> where($qb->expr()->andX(
										$qb->expr()->eq('e.numeroExpediente', '?1'),
										$qb->expr()->eq('e.periodo','?2')
									)
					)
				->setParameter(1, $numerador)
				->setParameter(2, $periodo);
		
		return $qb->getQuery()->getResult();
	}
	
	
}