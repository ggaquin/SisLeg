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
        $qb-> where($qb->expr()->isNull('ec.dictamen'));
                   
        return $qb->getQuery()->getResult();

	}

	public function findByComision_Id($idComision){

		$qb = $this->createQueryBuilder('ec')
				   ->innerJoin('ec.comision','c')
                   ->where('c.id = :idComision and ec.anulado=false')
                   ->setParameter('idComision', $idComision);

        return $qb->getQuery()->getResult();

	}

	
}