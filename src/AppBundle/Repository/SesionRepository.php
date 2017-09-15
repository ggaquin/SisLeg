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
		
		/*
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
        */

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
	
	public function createOrdenDelDia($idSesion){
		
		$params['idSesion']=$idSesion;
		$stmt= $this->getEntityManager()->getConnection()->prepare('call crearOrdenDelDia(:idSesion)');
		$stmt->execute($params);
				
	}
	
	public function removeOrdenDelDia($idSesion){
		
		$params['idSesion']=$idSesion;
		$stmt= $this->getEntityManager()->getConnection()->prepare('call borrarOrdenDelDia(:idSesion)');
		$stmt->execute($params);

	}
	
}