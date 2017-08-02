<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class SesionRepository extends EntityRepository{
	
	public function findLastActivoByTipo(){
		
		$fechactual=new \DateTime('now');

		$qb1 = $this->createQueryBuilder('s')
				    ->select('MIN(s.id)')
                    ->where('s.fecha > :fecha')
                    ->groupBy('s.tipoSesion');
                    
		
        $qb =$this->createQueryBuilder('ss');
        $qb->where(
        		  	$qb->expr()->in('ss.id', $qb1->getDQL())
        		  )
           ->setParameter('fecha', $fechactual);

        return $qb->getQuery()->getResult();

	}
	
}