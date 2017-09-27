<?php


namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use AppBundle\Entity\ResolucionBasicaSinSancion;

class ExpedienteSesionRepository extends EntityRepository{

	public function findDictamenesByExedienteYSesion($idExpediente, $idSesion){
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idDictamen', 'id');
		$rsm->addScalarResult('idExpediente', 'id_expediente');
		$rsm->addScalarResult('comisiones', 'comisiones');
		$rsm->addScalarResult('redaccion', 'redaccion');
		$rsm->addScalarResult('resuelve_por', 'resuelve_por');
		$rsm->addScalarResult('fecha_creacion', 'fecha_creacion');
		$rsm->addScalarResult('usuario_creacion', 'usuario_creacion');

		$query = $this->getEntityManager()
					  ->createNativeQuery('call listadoDictamenesExpedienteSesion(:idExpediente,:idSesion)', $rsm);
		$query -> setParameter('idExpediente', $idExpediente);
		$query -> setParameter('idSesion', $idSesion);
		
		$resultado = $query->getResult();
		
		return  $resultado;
	}
	
	public function findDistinctBySesion_Id($idSesion){
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idExpediente', 'id_expediente');
		$rsm->addScalarResult('idProyecto', 'id_proyecto');
		$rsm->addScalarResult('numero_expediente', 'numero_expediente');
		$rsm->addScalarResult('tipoExpediente', 'tipo_expediente');
		$rsm->addScalarResult('letrasOD', 'letras_o_d');
		$rsm->addScalarResult('tiene_resolucion', 'tiene_resolucion');
		$rsm->addScalarResult('idResolucion', 'id_resolucion');
		$rsm->addScalarResult('idDictamen', 'id_dictamen');
		$rsm->addScalarResult('numero_sancion', 'numero_sancion');
		$rsm->addScalarResult('tiene_notificacion', 'tiene_notificacion');
		$rsm->addScalarResult('dictamenes', 'dictamenes');
		
		
		$query = $this->getEntityManager()
					  ->createNativeQuery('call listadoExpedientesPorSesion(:idSesion,:numeroExpediente,'.
					  					  ':tipoExpediente, :letraOD)', $rsm);
		$query -> setParameter('idSesion', $idSesion);
		$query -> setParameter('numeroExpediente', null);
		$query -> setParameter('tipoExpediente', null);
		$query -> setParameter('letraOD', null);
		
		$resultado = $query->getResult();
		
		return  $resultado;
		
	}
	
	public function findDistinctByExpediente_Numero($criterio,$idSesion){
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idExpediente', 'id_expediente');
		$rsm->addScalarResult('idProyecto', 'id_proyecto');
		$rsm->addScalarResult('numero_expediente', 'numero_expediente');
		$rsm->addScalarResult('tipoExpediente', 'tipo_expediente');
		$rsm->addScalarResult('letrasOD', 'letras_o_d');
		$rsm->addScalarResult('tiene_resolucion', 'tiene_resolucion');
		$rsm->addScalarResult('idResolucion', 'id_resolucion');
		$rsm->addScalarResult('idDictamen', 'id_dictamen');
		$rsm->addScalarResult('numero_sancion', 'numero_sancion');
		$rsm->addScalarResult('tiene_notificacion', 'tiene_notificacion');
		$rsm->addScalarResult('dictamenes', 'dictamenes');
		
		$query = $this->getEntityManager()
					  ->createNativeQuery('call listadoExpedientesPorSesion(:idSesion,:numeroExpediente,'.
				':tipoExpediente, :letraOD)', $rsm);
		$query -> setParameter('idSesion', $idSesion);
		$query -> setParameter('numeroExpediente', $criterio);
		$query -> setParameter('tipoExpediente', null);
		$query -> setParameter('letraOD', null);
		
		$resultado = $query->getResult();
		
		return  $resultado;
		
	}
	
	public function findDistinctByTipoExpediente_Id($criterio,$idSesion){
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idExpediente', 'id_expediente');
		$rsm->addScalarResult('idProyecto', 'id_proyecto');
		$rsm->addScalarResult('numero_expediente', 'numero_expediente');
		$rsm->addScalarResult('tipoExpediente', 'tipo_expediente');
		$rsm->addScalarResult('letrasOD', 'letras_o_d');
		$rsm->addScalarResult('tiene_resolucion', 'tiene_resolucion');
		$rsm->addScalarResult('idResolucion', 'id_resolucion');
		$rsm->addScalarResult('idDictamen', 'id_dictamen');
		$rsm->addScalarResult('numero_sancion', 'numero_sancion');
		$rsm->addScalarResult('tiene_notificacion', 'tiene_notificacion');
		$rsm->addScalarResult('dictamenes', 'dictamenes');
		
		$query = $this->getEntityManager()
					  ->createNativeQuery('call listadoExpedientesPorSesion(:idSesion,:numeroExpediente,'.
				':tipoExpediente, :letraOD)', $rsm);
		$query -> setParameter('idSesion', $idSesion);
		$query -> setParameter('numeroExpediente', null);
		$query -> setParameter('tipoExpediente', $criterio);
		$query -> setParameter('letraOD', null);
		
		$resultado = $query->getResult();
		
		return  $resultado;
				
	}
	
	public function findDistinctByletraOrdenDia($criterio,$idSesion){
		
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('idExpediente', 'id_expediente');
		$rsm->addScalarResult('idProyecto', 'id_proyecto');
		$rsm->addScalarResult('numero_expediente', 'numero_expediente');
		$rsm->addScalarResult('tipoExpediente', 'tipo_expediente');
		$rsm->addScalarResult('letrasOD', 'letras_o_d');
		$rsm->addScalarResult('tiene_resolucion', 'tiene_resolucion');
		$rsm->addScalarResult('idResolucion', 'id_resolucion');
		$rsm->addScalarResult('idDictamen', 'id_dictamen');
		$rsm->addScalarResult('numero_sancion', 'numero_sancion');
		$rsm->addScalarResult('tiene_notificacion', 'tiene_notificacion');
		$rsm->addScalarResult('dictamenes', 'dictamenes');
		
		$query = $this->getEntityManager()
					  ->createNativeQuery('call listadoExpedientesPorSesion(:idSesion,:numeroExpediente,'.
				':tipoExpediente, :letraOD)', $rsm);
		$query -> setParameter('idSesion', $idSesion);
		$query -> setParameter('numeroExpediente', null);
		$query -> setParameter('tipoExpediente', null);
		$query -> setParameter('letraOD', $criterio);
		
		$resultado = $query->getResult();
		
		return  $resultado;
				
	}
	
}