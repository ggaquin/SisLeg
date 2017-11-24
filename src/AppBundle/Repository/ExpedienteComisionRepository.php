<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Select;
use Doctrine\ORM\Query\ResultSetMapping;

class ExpedienteComisionRepository extends EntityRepository{
	
	/*********************************************************************************************
	 * búsqueda de expedientes asignados a comisiones                                            *
	 *********************************************************************************************/
	
	public function findAllActivos(){
		
		$qb = $this->createQueryBuilder('ec')	
			->leftJoin('ec.sesion', 's');
		$qb ->where($qb->expr()->andX(
										$qb->expr()->orX(
															$qb->expr()->isNull('ec.sesion'),
															$qb->expr()->eq('s.tieneOrdenDelDia', ':tieneOrdenDia')
														 ),
										$qb->expr()->eq('ec.anulado', ':anulado')
										
									 )
				   )
			->setParameter('tieneOrdenDia', false)
			->setParameter('anulado', false);
		
		return $qb->getQuery()->getResult();
				
	}
	
	public function findByExpediente_Numero($numeroExpediente,$anulados){
				
		$qb = $this->createQueryBuilder('ec')
			->innerJoin('ec.expediente','e')
			->leftJoin('ec.sesion', 's');
		$qb ->where($qb->expr()->andX(
									  $qb->expr()->eq('e.numeroExpediente', ':numeroExpediente'),
									  $qb->expr()->eq('ec.anulado', ':anulado')
				
									  )
				    )
			->setParameter('numeroExpediente', $numeroExpediente)
			->setParameter('anulado', $anulados);
		
        return $qb->getQuery()->getResult();

	}
	
	public function findByComision_Id($idComision){
		
		$qb = $this->createQueryBuilder('ec')
			->innerJoin('ec.comision','c')
			->leftJoin('ec.sesion', 's');
		$qb ->where($qb->expr()->andX(
										$qb->expr()->eq('c.id', ':idComision'),
										$qb->expr()->eq('ec.anulado', ':anulado')
				                     )
				   )
			->setParameter('idComision', $idComision)
			->setParameter('anulado', false);
		
		return $qb->getQuery()->getResult();
		
	}
	
	public function findExpedienteComisionByExpediente_Estado($idEstadoExpediente){
		
		$qb = $this->createQueryBuilder('ec');
		$qb ->innerJoin('ec.expediente', 'e')
			->innerJoin('e.estadoExpediente', 'ee')
			->leftJoin('ec.sesion', 's');	
		$qb ->where($qb->expr()->andX(
										$qb->expr()->orX(
															 $qb->expr()->eq('ee.id', ':idEstado'),
															 $qb->expr()->eq('ee.id', ':idEsperaRecepcion')
														),
										$qb->expr()->eq('ec.anulado', ':anulado')
									  )
					)
			->setParameter('idEstado', $idEstadoExpediente)
			->setParameter('idEsperaRecepcion', 9)
			->setParameter('anulado', false);
		
		return $qb->getQuery()->getResult();
		
	}
			
	public function findExpedienteVigenteByNumero($numeroExpediente){
		
		$qb = $this->createQueryBuilder('ec')
			->innerJoin('ec.expediente','e')
			->leftJoin('ec.sesion', 's');
		$qb ->where($qb->expr()->andX(
										$qb->expr()->eq('e.numeroExpediente', '?1'),
										$qb->expr()->orX(
															$qb->expr()->isNull('s.id'),
															$qb->expr()->eq('s.tieneOrdenDelDia','?2')
														 ),
										$qb->expr()->eq('ec.anulado', '?3'),
										$qb->expr()->isNull('e.fechaArchivo'),
										$qb->expr()->eq('e.numeroSancion', '?4')
									 )
				   )
			->setParameter(1, $numeroExpediente)
			->setParameter(2, false)
			->setParameter(3, false)
			->setParameter(4,'');
			
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
			->leftJoin('ec.sesion', 's')
			->where($qb->expr()->andX(
										$qb->expr()->eq('e.id', '?1'),
										$qb->expr()->like('c.comision', '?2'),
										$qb->expr()->orX(
															$qb->expr()->isNull('s.id'),
															$qb->expr()->eq('s.tieneUltimoMomento','?3')
														),
										$qb->expr()->neq('c.id', '?4')
									  )
				
			
					)
			->setParameter(1, $idExpediente)
			->setParameter(2, '%'.$nombre.'%')
			->setParameter(3, false)
			->setParameter(4, $filtro);
		return $qb->getQuery()->getResult();
	}
	
	public  function countComisionesByExpediente_IdAndFiltro($idExpediente,$filtro){
		
		$qb = $this->createQueryBuilder('ec');
		$qb ->select('count(ec.id)')
			->innerJoin('ec.expediente', 'e')
			->innerJoin('ec.comision', 'c')
			->leftJoin('ec.sesion', 's')
			->where($qb->expr()->andX(
										$qb->expr()->eq('e.id', '?1'),
										$qb->expr()->orX(
															$qb->expr()->isNull('s.id'),
															$qb->expr()->eq('s.tieneOrdenDelDia','?2')
														),
										$qb->expr()->neq('c.id', '?3')
									  )
					)
			->setParameter(1, $idExpediente)
			->setParameter(2, false)
			->setParameter(3, $filtro);
			return $qb->getQuery()->getSingleResult();
		}
	
	public  function findByExpediente_IdAndComision_Nombre($nombre,$idExpediente){
		
		$qb1 = $this->createQueryBuilder('ecs');
		$qb1 -> select('ecsc.id')
			 -> innerJoin('ecs.comision', 'ecsc')
			 -> innerJoin('ecs.expediente', 'ecse')
			 ->leftJoin('ecs.sesion', 's')
			 -> where($qb1->expr()->andX(
								 		$qb1->expr()->eq('ecse.id', '?1'),
								 		$qb1->expr()->orX(
											 				$qb1->expr()->isNull('s.id'),
											 				$qb1->expr()->eq('s.tieneOrdenDelDia','?3')
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
			-> setParameter(3, false);
		
		return $qb->getQuery()->getResult();
	}
	
	public  function findByExpediente_IdAndComision_Id($idExpediente,$idComision){
		
		$qb = $this->createQueryBuilder('ec');
		$qb ->innerJoin('ec.expediente', 'e')
			->innerJoin('ec.comision', 'c')
			->innerJoin('e.estadoExpediente', 'es')
			->where($qb->expr()->andX(
										$qb->expr()->eq('e.id', '?1'),
										$qb->expr()->like('c.id', '?2')										
									  )
				   )
			->setParameter(1, $idExpediente)
			->setParameter(2, $idComision);
		return $qb->getQuery()->getOneOrNullResult();
	}
	
	
	public function findPrimerAsignacionByExpediente_Id($idExpediente){
			
		$qb1 = $this->createQueryBuilder('ec');
		$qb1 ->select('MIN(ec.id) as primerAsignacion')
			 ->innerJoin('ec.expediente', 'e')
			 ->leftJoin('ec.sesion', 's')
			 ->where($qb1->expr()->andX(
										$qb1->expr()->eq('e.id', '?1'),
										$qb1->expr()->orX(
															$qb1->expr()->isNull('s.id'),
															$qb1->expr()->eq('s.tieneOrdenDelDia','?2')
														 )
										)
					)
			->groupBy('e.id');
			
		$qb = $this->createQueryBuilder('ecp');
		$qb -> where($qb->expr()->in('ecp.id', $qb1->getDQL()))
			->setParameter(1, $idExpediente)
			->setParameter(2, false);
		
		return $qb->getQuery()->getResult();
				
	}
	
	public function traerTextoDictamen($idDictamen) {
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('texto', 'textoDictamen', 'text');
		$rsm->addScalarResult('expediente', 'expediente', 'string');
		$rsm->addScalarResult('comisiones', 'comisiones', 'string');
		
		$query = $this -> getEntityManager()
					   -> createNativeQuery('call conformarDictamen(:idDictamen)',$rsm)
					   -> setParameter('idDictamen',$idDictamen);
		
		return $query->getResult();
	}
	
	
	 public  function findByExpediente_Id($idExpediente){
	 
	 $qb = $this->createQueryBuilder('ec');
	 $qb ->innerJoin('ec.expediente', 'e')
	 	 ->where($qb->expr()->eq('e.id', '?1'))
	   	 ->setParameter(1, $idExpediente);
	 
	 return $qb->getQuery()->getResult();
	 }
	
	/*
	public  function findByDictamenMayoria($idDictamen){
		
		$qb = $this->createQueryBuilder('ec');
		$qb ->innerJoin('ec.dictamenMayoria', 'd')
			->where($qb->expr()->eq('d.id', '?1'))
			->setParameter(1, $idDictamen);
			
		return $qb->getQuery()->getResult();
	}
	
	public  function findByDictamenPrimeraMinoria($idDictamen){
		
		$qb = $this->createQueryBuilder('ec');
		$qb ->innerJoin('ec.dictamenPrimeraMinoria', 'd')
			->where($qb->expr()->eq('d.id', '?1'))
			->setParameter(1, $idDictamen);
		
		return $qb->getQuery()->getResult();
	}
	
	public  function findByDictamenSegundaMinoria($idDictamen){
		
		$qb = $this->createQueryBuilder('ec');
		$qb ->innerJoin('ec.dictamenSegundaMinoria', 'd')
			->where($qb->expr()->eq('d.id', '?1'))
			->setParameter(1, $idDictamen);
		
		return $qb->getQuery()->getResult();
	}
	*/
	
}