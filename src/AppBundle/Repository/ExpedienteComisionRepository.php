<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ExpedienteComisionRepository extends EntityRepository{
	
	public function findByExpediente_Numero($numeroExpediente){

		$qb = $this->createQueryBuilder('ec')
				   ->innerJoin('ec.expediente','e')
                   ->where('e.numeroExpediente = :numeroExpediente and ec.anulado=false')
                   ->setParameter('numeroExpediente', $numeroExpediente);

        return $qb->getQuery()->getResult();

	}

	public function findByDictamen_Null(){

		$qb = $this->createQueryBuilder('ec');
        $qb-> where($qb->expr()->isNull('ec.dictamenMayoria'));
                   
        return $qb->getQuery()->getResult();

	}

	public function findByComision_Id($idComision){

		$qb = $this->createQueryBuilder('ec')
				   ->innerJoin('ec.comision','c')
                   ->where('c.id = :idComision and ec.anulado=false')
                   ->setParameter('idComision', $idComision);

        return $qb->getQuery()->getResult();

	}
	
	public  function findByDictamen($idDictamen){
		
		$qb = $this->createQueryBuilder('ec');
		$qb-> where($qb->expr()->orX(
									 $qb->expr()->isNull('ec.dictamenMayoria'),
									 $qb->expr()->isNull('ec.dictamenPrimeraMinoria'),
									 $qb->expr()->isNull('ec.dictamenSegundaMinoria')
									)
					);
		
		return $qb->getQuery()->getResult();
	}
	
	public  function findByExpediente_IdAndComision_Nombre($nombre,$idExpediente,$filtro){
		
		$qb = $this->createQueryBuilder('ec');
		$qb ->innerJoin('ec.expediente', 'e')
			->innerJoin('ec.comision', 'c')
			->innerJoin('e.estadoExpediente', 'es')
			->where($qb->expr()->andX(
										$qb->expr()->eq('e.id', '?1'),
										$qb->expr()->like('c.comision', '?2'),
										$qb->expr()->orX(
														 $qb->expr()->eq('es.id','?3'),
														 $qb->expr()->eq('es.id','?4')
												),
										$qb->expr()->neq('c.id', '?5')
									  )
				
			
					)
			->setParameter(1, $idExpediente)
			->setParameter(2, '%'.$nombre.'%')
			->setParameter(3, 2)
			->setParameter(4, 3)
			->setParameter(5, $filtro);
		return $qb->getQuery()->getResult();
	}
	
	public  function findByExpediente_IdAndComision_Id($idExpediente,$idComision){
		
		$qb = $this->createQueryBuilder('ec');
		$qb ->innerJoin('ec.expediente', 'e')
		->innerJoin('ec.comision', 'c')
		->innerJoin('e.estadoExpediente', 'es')
		->where($qb->expr()->andX(
				$qb->expr()->eq('e.id', '?1'),
				$qb->expr()->like('c.id', '?2'),
				$qb->expr()->orX(
						$qb->expr()->eq('es.id','?3'),
						$qb->expr()->eq('es.id','?4')
						)
				
				)
				
				
				)
				->setParameter(1, $idExpediente)
				->setParameter(2, $idComision)
				->setParameter(3, 2)
				->setParameter(4, 3);
				return $qb->getQuery()->getSingleResult();
	}

	
}