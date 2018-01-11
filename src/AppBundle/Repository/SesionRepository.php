<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class SesionRepository extends EntityRepository{
	
	public function countByFechaYTipo($fecha,$idTipoSesion){
		
		$qb = $this ->createQueryBuilder('s')
				    ->select('count(s.id)')
				    ->innerJoin('s.tipoSesion', 'ts')
				    ->where('s.fecha >= :fecha and ts.id= :idTipoSesion')
				    ->setParameter('fecha', $fecha)
				    ->setParameter('idTipoSesion', $idTipoSesion);
		return $qb->getQuery()->getResult();
		
	}
	
	public function findLastActivoByTipo(){
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idSesion', 'id');
		$rsm->addScalarResult('descripcion', 'fecha_formateada');
			
		$sql="select idSesion, descripcion ".
			 "FROM 	vw_sesiones_habiles ";
			
		$query=$this->getEntityManager()->createNativeQuery($sql, $rsm);
		return $query->getArrayResult();

	}
	
	public function findByExpediente_Numero($criterio,$idSesion){
		
		$qb = $this->createQueryBuilder('es');
		$qb -> innerJoin('es.expediente', 'e')
			-> innerJoin('es.sesion', 's')
			-> where($qb->expr()->andX(
										$qb->expr()->eq('e.numeroExpediente', '?1'),
										$qb->expr()->eq('s.id', '?1')
									  )
					)
			->setParameter('1', $criterio)
			->setParameter('2', $idSesion);
		
		return $qb->getQuery()->getResult();
		
	}
	
	public function findByTipoExpediente_id($criterio,$idSesion){
		
		$qb = $this->createQueryBuilder('es');
		$qb -> innerJoin('es.expediente', 'e')
			-> innerJoin('e.tipoExpediente', 't')
			-> innerJoin('es.sesion', 's')
			-> where($qb->expr()->andX(
										$qb->expr()->eq('t.id', '?1'),
										$qb->expr()->eq('s.id', '?1')
									  )
					)
			->setParameter('1', $criterio)
			->setParameter('2', $idSesion);
				
		return $qb->getQuery()->getResult();
				
	}
	
	public function findByletraOrdenDia($criterio,$idSesion){
		
		$qb = $this->createQueryBuilder('es');
		$qb -> innerJoin('es.expediente', 'e')
			-> innerJoin('es.tipoExpedienteSesion', 't')
			-> innerJoin('es.sesion', 's')
			-> where($qb->expr()->andX(
										$qb->expr()->eq('t.id', '?1'),
										$qb->expr()->eq('s.id', '?1')
									   )
					)
			->setParameter('1', $criterio)
			->setParameter('2', $idSesion);
			
		return $qb->getQuery()->getResult();
				
	}
	
	public function findOrdenDiaBySesionYApartado($idSesion,$idApartado){
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('apartado', 'textoApartado', 'text');
		
		$query = $this-> getEntityManager()
					  -> createNativeQuery(
										  'call traerApartadoOrdenDelDia(:idSesion,:idApartado)',
										  $rsm)
					  -> setParameter('idSesion',$idSesion)
					  -> setParameter('idApartado',$idApartado);
		return $query->getResult();
		
	}
	
	public function findVersionesTaquigraficasBySesion($idSesion){
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('versiones', 'versiones', 'text');
		
		$query = $this-> getEntityManager()
		-> createNativeQuery(
				'call listadoVersionesTaquigraficas(:idSesion)',
				$rsm)
				-> setParameter('idSesion',$idSesion);
				return $query->getResult();
				
	}
	
	public function createOrdenDelDia($idSesion){
		
		$params=[];
		$params['idSesion']=$idSesion;
		$params['tipo']=0;
		$stmt= $this->getEntityManager()->getConnection()->prepare('call crearOrdenDelDia(:idSesion,:tipo)');
		$stmt->execute($params);
				
	}
	
	public function createUltimoMomento($idSesion){
		
		$params=[];
		$params['idSesion']=$idSesion;
		$params['tipo']=1;
		$stmt= $this->getEntityManager()->getConnection()->prepare('call crearOrdenDelDia(:idSesion,:tipo)');
		$stmt->execute($params);
		
	}
	
	public function removeOrdenDelDia($idSesion){
		
		$params=[];
		$params['idSesion']=$idSesion;
		$stmt= $this->getEntityManager()->getConnection()->prepare('call borrarOrdenDelDia(:idSesion)');
		$stmt->execute($params);

	}
	
	public function findByDistinctPeriodos($tieneOrdenDelDia=null){
		
		$qb = $this->createQueryBuilder('s')
				   -> select('s.periodo');
		if ($tieneOrdenDelDia==true)
			$qb -> where($qb->expr()->eq('s.tieneOrdenDelDia', '?1'))
				->setParameter(1, true);
		$qb -> orderBy('s.periodo','desc')
			-> distinct();


		$resultado = $qb->getQuery()->getResult();
		$periodos=[];

		foreach ($resultado as $valor){
			$periodos[]=$valor['periodo'];
		}

		return  $periodos;
		
	}
	
	public function findActivasByPeriodo($periodo, $tieneOrdenDelDia=true){
		
		$qb = $this->createQueryBuilder('s');
		if ($tieneOrdenDelDia==true){
			$qb	-> where($qb->expr()->andX(
											$qb->expr()->eq('s.periodo', '?1'),
											$qb->expr()->eq('s.tieneOrdenDelDia', '?2')
						                   )
						 ) 
				 ->setParameter('2', true);
		}
		else
			$qb	-> where($qb->expr()->eq('s.periodo', '?1'));
			
		$qb ->orderBy('s.fecha','desc')
			->setParameter('1', $periodo);
					
		return $qb->getQuery()->getResult();
			
	}
	
	public function countSancionesPorSesion($idSesion){
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('cuenta', 'cuenta');
		
		$query = $this->getEntityManager()
		->createNativeQuery('select count(*) as cuenta from expedienteSesion es '.
				'inner join sancion s on es.idSancion=s.idSancion '.
				'where es.idSesion=:idSesion', $rsm);
		
		$query -> setParameter('idSesion', $idSesion);
		return $query->getOneOrNullResult();
		
	}
	
	public function traerTextoSancion($idSancion) {
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('texto', 'textoSancion', 'text');
		$rsm->addScalarResult('expediente', 'expediente', 'string');
		$rsm->addScalarResult('numeroSancion', 'numeroSancion', 'string');
		$rsm->addScalarResult('firmaSecretario', 'firmaSecretario','string');
		$rsm->addScalarResult('firmaPresidente', 'firmaPresidente', 'string');
		
		$query = $this -> getEntityManager()
		-> createNativeQuery('call conformarSancion(:idSancion)',$rsm)
		-> setParameter('idSancion',$idSancion);
		
		return $query->getResult();
	}
				
}