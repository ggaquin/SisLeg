<?php
namespace AppBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\Common\Annotations\Annotation\Attributes;
use AppBundle\Entity\ExpedienteComision;

/**
 * <p>Lógica del negocio en manejo de <em>expedientes</em></p>
 * @author gustavo 
 */
class ExpedienteServicio{
	
	protected $em;
	private $container;

	/**
	 * Constructor 
	 * 
	 * @param EntityManager $entityManager
	 * @param Container $container
	 */
	public function __construct(EntityManager $entityManager, Container $container)
	{
		$this->em = $entityManager;
		$this->container = $container;
	}
	
	public function  findByNumeroYAño($numero, $oficina,$destino){
		
		if(preg_match('/^\d*\-\d{2}/',$numero)!==1)
			throw new \Exception('El criterio de busqueda debe tener el formato  #[#..#]-AA (por ejemplo 1-17)');
		
		
		$numeroSeparado=explode('-', $numero);
		$periodo='20'.$numeroSeparado[1];
		$numerador=$numeroSeparado[0];
		
		//obtención de los resultados
		$expedienteRepository=$this->container->get('doctrine')->getRepository('AppBundle:Expediente');
		$expedienteSesionRepository=$this->container->get('doctrine')->getRepository('AppBundle:ExpedienteSesion');
		$resultados = $expedienteRepository->findNumeroCompletoByNumero($numerador,$periodo,$oficina,$destino);
		
		$valorRetorno=[];
		
		//existe el expediente
		if (count($resultados)>0){
			
			//hay más de un resultado: error
			if (count($resultados)>1)
				throw new \Exception('Error en la numeración de expedientes existen mas de un expediente con el número '.
									 $numerador.' para el ejercicio '. $periodo);
			else { //resultado único: se crea la estructura de respuesta
				
					$expediente=$resultados[0];
					$idEstadoEsperaRecepcion=$this->container->getParameter('id_estado_espera_recepcion');
					
					if($expediente['idEstado']==$idEstadoEsperaRecepcion)
						throw new \Exception('El expediente esta en estado de espera de recepcion, no puede ser girado');
					
						
					$idOficinaDespacho=$this->container->getParameter('id_despacho');
					if($oficina->getId()==$idOficinaDespacho){
						$sancionesPendientes=$expedienteSesionRepository->findSancionesPendientesByExpediente_Id($expediente["id"]);
						if (count($sancionesPendientes)>0)
							throw new \Exception('El expediente tiene sanciones pendientes, no puede ser girado');
					}
						
					$ejercicio=substr($expediente['periodo'],2);
					$numeroCompleto=$expediente["numero"].'-'.$expediente["letra"].'-'.
									$ejercicio.'('.$expediente["folios"].')';
					$valorRetorno[]=array(
											'id' => $expediente["id"],
											'numeroCompleto' => $numeroCompleto
										  );
			}
		}
		
		return $valorRetorno;
			
	}
	
	
}
