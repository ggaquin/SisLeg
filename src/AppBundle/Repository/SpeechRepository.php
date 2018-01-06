<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class SpeechRepository extends EntityRepository{

	public function findByTitulo($term){

		$qb = $this->createQueryBuilder('s');
		$qb -> where($qb->expr()->like('s.tituloSpeech', ':tituloSpeech'))
			-> setParameter('tituloSpeech','%'.$term.'%');
		
		return $qb->getQuery()->getResult();

	}

	
}

	