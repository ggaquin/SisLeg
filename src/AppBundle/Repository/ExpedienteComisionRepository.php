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
	
	public function findVigentesBydExpediente_IdAndFechaActualAndODEStado($idExpediente,$fecha,$estadoOD='todo'){
		
		
			$qb =  $this->createQueryBuilder('ec')
				-> innerJoin('ec.expediente', 'e');
			$qb -> where($qb->expr()->andX(
											$qb->expr()->eq('e.id', ':idExpediente'),
											$qb->expr()->eq('ec.anulado', ':anulado')
										  )
						)
				-> setParameter('anulado', false)
				-> setParameter('idExpediente', $idExpediente);
		
		if($estadoOD=='todo'){
		
			$qb -> leftJoin('ec.sesion', 's')
				-> andWhere($qb->expr()->orX(
												$qb->expr()->isNull('s.id'),
												$qb->expr()->gte('s.fecha', ':fecha')
											)
							)
				-> setParameter('fecha', $fecha);
		}
		
		if ($estadoOD=='sinOD'){
			$qb -> leftJoin('ec.sesion', 's')
				-> andWhere($qb->expr()->orX(
												$qb->expr()->isNull('s.id'),
												$qb->expr()->eq('s.tieneOrdenDelDia', ':tieneOrdenDia')
											  )
						    )
			   ->andWhere($qb->expr()->gte('s.fecha', ':fecha'))
			   ->setParameter('tieneOrdenDia', false)
			   -> setParameter('fecha', $fecha);
		}
		
		if($estadoOD=='conOD'){
			$qb -> innerJoin('ec.sesion', 's')
				-> andWhere($qb->expr()->eq('s.tieneOrdenDelDia', ':tieneOrdenDia'))
				->andWhere($qb->expr()->gte('s.fecha', ':fecha'))
				->setParameter('tieneOrdenDia', true)
				-> setParameter('fecha', $fecha);
		}
			
		return $qb->getQuery()->getResult();
				
	}
	
	public function findByExpediente_Numero($numeroExpediente,$anulados){
		
		
		if(preg_match('/^\d*\-\d{2}/',$numeroExpediente)!==1)
			throw new \Exception('El criterio de busqueda debe tener el formato  #[#..#]-AA (por ejemplo 1-17)');
				
		$numeroExpedienteSeparado=explode('-', $numeroExpediente);
		
// 		if (count($numeroExpediente)!=2)
// 			throw new \Exception('El criterio de busqueda debe tener el formato {numero}-{año} (por ejemplo 1-17)');
			
		$periodo='20'.$numeroExpedienteSeparado[1];
		$numerador=$numeroExpedienteSeparado[0];
			
		$qb = $this->createQueryBuilder('ec')
			->innerJoin('ec.expediente','e')
			->leftJoin('ec.sesion', 's');
		$qb ->where($qb->expr()->andX(
									  $qb->expr()->eq('e.numeroExpediente', ':numerador'),
									  $qb->expr()->eq('e.periodo',':periodo'),
									  $qb->expr()->eq('ec.anulado', ':anulado')
				
									  )
				    )
			->setParameter('numerador', $numerador)
			->setParameter('periodo', $periodo)
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
			->innerJoin('e.estadoExpediente', 'ee');	
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
		
	public function findExpedienteVigenteByNumero($numeroExpediente,$estado=null){
		
		if(preg_match('/^\d*\-\d{2}/',$numeroExpediente)==1){
		
			$numeroSeparado=explode('-', $numeroExpediente);
			
// 			if (count($numeroSeparado)!=2)
// 				throw new \Exception('El criterio de busqueda debe tener el formato {numero}-{año} (por ejemplo 1-17)');
				
			$periodo='20'.$numeroSeparado[1];
			$numerador=$numeroSeparado[0];
			
			$qb = $this->createQueryBuilder('ec')
				->innerJoin('ec.expediente','e')
				->innerJoin('e.estadoExpediente', 'ee')
				->leftJoin('ec.sesion', 's');
			$qb ->where($qb->expr()->andX(
											$qb->expr()->eq('e.numeroExpediente', '?1'),
											$qb->expr()->eq('e.periodo', '?2'),
											$qb->expr()->orX(
																$qb->expr()->isNull('s.id'),
																$qb->expr()->eq('s.tieneOrdenDelDia','?3')
															 ),
											$qb->expr()->orX(
													$qb->expr()->isNull('?6'),
													$qb->expr()->eq('ee.id','?6')
													),
											$qb->expr()->eq('ec.anulado', '?4'),
											$qb->expr()->isNull('e.fechaArchivo'),
											$qb->expr()->eq('e.numeroSancion', '?5')
										 )
					   )
				->setParameter(1, $numerador)
				->setParameter(2, $periodo)
				->setParameter(3, false)
				->setParameter(4, false)
				->setParameter(5,'')
				->setParameter(6,$estado);
				
			return $qb->getQuery()->getResult();
		}
		else			throw new \Exception('El criterio de busqueda debe tener el formato {numero}-{año} (por ejemplo 1-17)');
		
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
			->leftJoin('ec.sesion', 's')
			->where($qb->expr()->andX(
										$qb->expr()->eq('e.id', '?1'),
										$qb->expr()->eq('c.id', '?2'),
										$qb->expr()->orX(
															$qb->expr()->isNull('s.id'),
															$qb->expr()->eq('s.tieneOrdenDelDia', ':tieneOrdenDelDia')
														)
									  )
				   )
			->setParameter(1, $idExpediente)
			->setParameter(2, $idComision)
			->setParameter('tieneOrdenDelDia', false);
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
	
	
	 public  function findByExpediente_Id($idExpediente,$sesioTieneOrdenDelDia=null){
	 
	 $qb = $this->createQueryBuilder('ec');
	 $qb ->innerJoin('ec.expediente', 'e')
	 	 ->leftJoin('ec.sesion', 's')
	 	 ->where($qb->expr()->andX(
	 	 							$qb->expr()->eq('e.id', '?1'),
	 	 							$qb->expr()->orX(
	 	 												$qb->expr()->isNull('?2'),
	 	 												$qb->expr()->eq('s.tieneOrdenDelDia', '?2')
	 	 											)
	 	 						  )
	 	 		)
	   	 ->setParameter(1, $idExpediente)
	   	 ->setParameter(2, $sesioTieneOrdenDelDia);
	 
	 return $qb->getQuery()->getResult();
	 }
	 
	 public function findIntegrantesComisionesByDictamen($patron, $idDictamen){
	 	
	 	$rsm = new ResultSetMapping();
	 	$rsm->addScalarResult('idPerfil', 'id', 'integer');
	 	$rsm->addScalarResult('nombreCompleto', 'nombre_completo', 'string');
	 		 	
	 	$query = $this -> getEntityManager()
	 				   -> createNativeQuery('call traerIntegrantesComisionesPorDictamen(:patron,:idDictamen)',$rsm)
	 				   -> setParameter('patron',$patron)
	 				   -> setParameter('idDictamen',$idDictamen);
	 	
	 	return $query->getResult();
	 }
	
}