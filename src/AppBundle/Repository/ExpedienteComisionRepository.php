<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class ExpedienteComisionRepository extends EntityRepository{
	
	public function findByExpediente_Numero($numeroExpediente,$anulados){

		$qb = $this->createQueryBuilder('ec')
				   ->innerJoin('ec.expediente','e')
                   ->where('e.numeroExpediente = :numeroExpediente and e.numeroSancion is null and ec.anulado = :anulado')
                   ->setParameter('numeroExpediente', $numeroExpediente)
                   ->setParameter('anulado', $anulados);

        return $qb->getQuery()->getResult();

	}
	
	public function findExpedienteVigenteByNumero($numeroExpediente){
		
		$qb = $this->createQueryBuilder('ec')
			->innerJoin('ec.expediente','e')
			->innerJoin('e.estadoExpediente', 'es');
		$qb ->where($qb->expr()->andX(
										$qb->expr()->eq('e.numeroExpediente', '?1'),
										$qb->expr()->orX(
															$qb->expr()->eq('es.id','?2'),
															$qb->expr()->eq('es.id','?3')
														 ),
										$qb->expr()->eq('ec.anulado', '?5')
									 )
				   )
			->setParameter(1, $numeroExpediente)
			->setParameter(2, 2)
			->setParameter(3, 3)
			->setParameter(5, false);
			
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
	
	public  function findByExpediente_IdAndComision_NombreAndFiltro($nombre,$idExpediente,$filtro){
		
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
	
	public  function findByExpediente_IdAndComision_Nombre($nombre,$idExpediente){
		
		$qb1 = $this->createQueryBuilder('ecs');
		$qb1 -> select('ecsc.id')
			 -> innerJoin('ecs.comision', 'ecsc')
			 -> innerJoin('ecs.expediente', 'ecse')
			 -> innerJoin('ecse.estadoExpediente', 'es')
			 -> where($qb1->expr()->andX(
								 		$qb1->expr()->eq('ecse.id', '?1'),
								 		$qb1->expr()->orX(
											 				$qb1->expr()->eq('es.id','?3'),
											 				$qb1->expr()->eq('es.id','?4')
											 			  )
								 	   )
				 	);
		$rep = $this->getEntityManager()->getRepository('AppBundle:Comision');
		$qb = $rep->createQueryBuilder('c');
		$qb	-> where($qb->expr()->andX(
										$qb->expr()->like('c.comision', '?2'),
										$qb->expr()->notIn('c.id', $qb1->getDQL())
									 )				
					)
			-> setParameter(1, $idExpediente)
			-> setParameter(2, '%'.$nombre.'%')
			-> setParameter(3, 2)
			-> setParameter(4, 3);
		
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
	/*
	public function findDictamenByExpediente_Id($idExpediente){
			
		$rep = $this->getEntityManager()->getRepository('AppBundle:Dictamen');
		$qb = $rep->createQueryBuilder('d');
		$qb -> leftJoin('d.asignacionesPorMayoria', 'm')
			-> leftJoin('m.expediente', 'em')
			-> leftJoin('d.asignacionesPorPrimeraMinoria', 'pm')
			-> leftJoin('pm.expediente', 'epm')
			-> leftJoin('d.asignacionesPorSegundaMinoria', 'sm')
			-> leftJoin('sm.expediente', 'esm')
			-> distinct();
		$qb -> where(
					 $qb->expr()->orX(
					 					$qb->expr()->andX(
					 									  $qb->expr()->isNotNull('m'),
					 									  $qb->expr()->eq('em.id', '?1'),
					 									  $qb->expr()->isNull('m.numeroSancion')
					 									 ),
								 		$qb->expr()->andX(
								 						  $qb->expr()->isNotNull('pm'),
								 						  $qb->expr()->eq('epm.id', '?1'),
								 						  $qb->expr()->isNull('epm.numeroSancion')	
								 						 ),
								 		$qb->expr()->andX(
											 			  $qb->expr()->isNotNull('sm'),
											 			  $qb->expr()->eq('esm.id', '?1'),
								 						  $qb->expr()->isNull('esm.numeroSancion')
											 			 )
					 				 )
				  )
			-> setParameter(1, $idExpediente);
		
		return $qb->getQuery()->getResult();
				
	}
	*/
	
}