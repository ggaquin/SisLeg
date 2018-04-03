<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use AppBundle\AppBundle;
use AppBundle\Entity\PerfilLegislador;
use Doctrine\ORM\Query\ResultSetMapping;

class PerfilRepository extends EntityRepository{

	/**
	 * <p>Recupera una lista de legisladores <strong>activos</strong> que coinciden con un patrón. 
	 * Los atributos a comparar con el patrón son:</p>
	 * <ul><li>apellidos</li><li>nombres</li>
	 * <li>opcionalmente tambien el nombre de bloque si $incluirBloque es verdadero (true)</ul>
	 * @param string $patronBusqueda 
	 * @param boolean $incluirBloque  
	 * @return array
	 */
	public function findLegisladorByPatronBusqueda($patronBusqueda,$incluirBloque=false){

		$fechaActual=new \DateTime('now');
		$rep = $this->getEntityManager()->getRepository('AppBundle:PerfilLegislador');
		$qb = $rep->createQueryBuilder('p')
			->innerJoin('p.bloque','b');
		$qb ->where($qb->expr()->andX(
										$qb->expr()->orX(
													       $qb->expr()->like('p.nombres', '?1'),
													       $qb->expr()->like('p.apellidos','?1'),
														   $qb->expr()->andX(
														   					$qb->expr()->eq('?2', true),
														   					$qb->expr()->like('b.bloque','?1')
														   				   )
														),
										$qb->expr()->orX(
															$qb->expr()->isNull('p.hasta'),
															$qb->expr()->gte('p.hasta','?3')
														)
									 )	
				   )	
  		    ->setParameter(1, '%'.$patronBusqueda.'%')
  		    ->setParameter(2, $incluirBloque)
  		    ->setParameter(3, $fechaActual);
	        return $qb->getQuery()->getResult();
	}
	
	public function findUsuarioByPatronBusqueda($patronBusqueda,$forzarALegislador=0){
				
		$rep=$this->getEntityManager()->getRepository('AppBundle:Usuario');
		$qb = $rep->createQueryBuilder('u');
		$qb->innerJoin('u.perfil','p');
		if ($forzarALegislador==1)
			$qb->innerJoin('AppBundle\Entity\PerfilLegislador', 'pl', 'with','p.id=pl.id');
		$qb ->where($qb->expr()->andX(
										$qb->expr()->orX(
															$qb->expr()->like('p.nombres', '?1'),
															$qb->expr()->like('p.apellidos','?1')	
									                     ),
										$qb->expr()->eq('u.activo','?2')
									  )
				)
	
			 ->setParameter(1, '%'.$patronBusqueda.'%')
			 ->setParameter(2, true);
		return $qb->getQuery()->getResult();
	}
	
  	
	/**
	 * <p>Indica si un determinado perfil posee un usuario ya generado</p>
	 * @param int $id
	 * @return boolean
	 */
	public function perfilPoseeUsuario($id){

		$rep=$this->getEntityManager()->getRepository('AppBundle:Usuario');
		$qb = $rep->createQueryBuilder('u');
		$qb = $qb->innerJoin('u.perfil','p');
		$qb ->where('p.id = ?1')
  		    ->setParameter(1,$id);
  		$usuario = $qb->getQuery()->getResult();
	    return !empty((array)$usuario);
	}

	/**
	 * <p>Retorna un string con la concatenación de los nombres de los concejales pertenecientes
	 * al bloque con el id provisto en $idBloque.</p>
	 * <p><strong>NOTA:</strong> Los concejales <strong><em>no son necesariamente los activos</em></strong></p>
	 * @param int $idBloque
	 * @return string
	 */
	public function findLegisladorByBloque_Id($idBloque){
		$rep=$this->getEntityManager()->getRepository('AppBundle:PerfilLegislador');
		$qb = $rep->createQueryBuilder('p');
		$qb = $qb->innerJoin('p.bloque','b');
		$qb ->where('b.id = ?1')
  		    ->setParameter(1, $idBloque);
	    $concejales=$qb->getQuery()->getResult();
	    $listaConcejales="";
	    foreach ($concejales as $concejal) {
	    	$listaConcejales.=($listaConcejales!=""?" - ":"").$concejal->getNombreCompleto();
	    }
	    return $listaConcejales;
	}
	
	/**
	 * <p>Retorna un array con todos los legisladores activos a la fecha actual</p>
	 * @return array
	 */
	public function findLegisladoresActivos(){
	
		$fechaActual=new \DateTime('now');
		$rep=$this->getEntityManager()->getRepository('AppBundle:PerfilLegislador');
		$qb = $rep->createQueryBuilder('p');
		$qb -> where($qb->expr()->orX(
										$qb->expr()->isNull('p.hasta'),
										$qb->expr()->gte('p.hasta','?1')
									)
					)
			->setParameter(1, $fechaActual);
		
		return $qb->getQuery()->getResult();
	}
	
	public function findPermisosByIdRol($idRol){
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('menu', 'menu');
		$rsm->addScalarResult('menuItem', 'menu_item');
		$rsm->addScalarResult('abreviacion', 'abreviacion');
		
		$query = $this->getEntityManager()
					  ->createNativeQuery('SELECT m.menu, mi.menuItem, mi.abreviacion '.
										  'FROM menu m inner join menuItem mi on mi.idMenu=m.idMenu '.
										  'inner join rol_menuItem rmi on mi.idMenuItem=rmi.idMenuItem '.
										  'where rmi.idRol=:idRol order by 1,2', $rsm);
		
		$query -> setParameter('idRol', $idRol);
		
		$resultado = $query->getResult();
		return  $resultado;
		
	}
}

	