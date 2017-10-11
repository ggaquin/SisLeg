<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use twig\twig;

use AppBundle\Entity\Rol;
use AppBundle\Entity\Bloque;
use AppBundle\Entity\Proyecto;
use AppBundle\Entity\Comision;
use AppBundle\Entity\TipoSesion;
use AppBundle\Entity\TipoExpedienteSesion;
use AppBundle\Entity\Oficina;


class DefaultController extends Controller
{
    
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $version=$this->getParameter('project_version'); 

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'version'       =>$version
        ));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {    }

    /**
     * @Route("/accessDenied", name="accessDenied")
     */
    public function accessDeniedAction()
    {  
        return $this->render('error/accesoDenegado.html.twig');

    }

    /**
     * @Route("/cambioClave", name="cambioClave")
     */
    public function cambioClaveAction()
    {  
        return $this->render('security/change_password.html.twig');

    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
 		$array=[];
 		
 		$usuario=$this->getUser();
 		$menus=$usuario->getRol()->getMenus();
 		foreach ($menus as $menu){
 			$array[$menu->getAbreviacion()]=true;
 		}
//  		$permisos=$usuario->getPermisos();
//  		foreach ($permisos as $permiso){
//  			$array[$permiso]=true;
//  		}
 		$array['base_dir']=realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR;
 		
        return $this->render('default/index.html.twig', $array);
        
    }

    /**
     * @Route("/usuarios", name="usuarios")
     */
    public function usuarioAction(Request $request)
    {
        $rolRepository=$this->getDoctrine()->getRepository('AppBundle:Rol');
        $roles=$rolRepository->findAll();
        $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
        $usuarios=$usuarioRepository->findAll();
        $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
        $bloques=$bloqueRepository->findAll();
        return $this->render('default/usuario.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'roles'  => $roles,'usuarios' => $usuarios,'bloques' => $bloques, 'status' => 'render'
        ));
         
    }

    /**
     * @Route("/legisladores", name="legisladores")
     */
    public function legisladoresAction(Request $request)
    {
        $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
        $bloques=$bloqueRepository->findBy(array(), array('bloque' => 'ASC'));
        return $this->render('default/legisladores.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'bloques' => $bloques));
         
    }

    /**
     * @Route("/proyectos", name="proyectos")
     */
    public function proyectoAction(Request $request)
    {
        $tiposProyectoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoProyecto');
        $tiposProyecto=$tiposProyectoRepository->findBy(array(),array('tipoProyecto' => 'ASC') );
        $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
        $bloques=$bloqueRepository->findBy(array(),array('bloque' => 'ASC') );
        $estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
        $estadosExpediente=$estadoExpedienteRepository->findBy(array(),array('estadoExpediente' => 'ASC') );
       
        return $this->render('default/proyecto.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'tipos' => $tiposProyecto,'estados'=>$estadosExpediente,'bloques'=>$bloques
        ));
         
    }

    /**
     * @Route("/expedientes", name="expedientes")
     */
    public function expedienteAction(Request $request)
    {
        $tiposExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
        $estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
        $tipoOficinaRepository=$this->getDoctrine()->getRepository('AppBundle:TipoOficina');
        $oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
        $tipoSesionRepository=$this->getDoctrine()->getRepository('AppBundle:TipoSesion');
        $idOficinaExterna=$this->getParameter('id_oficina_externa');
        
        $tiposExpediente=$tiposExpedienteRepository->findBy(array(),array('tipoExpediente' => 'ASC'));
        $estadosExpediente=$estadoExpedienteRepository->findBy(array(),array('estadoExpediente' => 'ASC'));
        $tipoOficinaExterna=$tipoOficinaRepository->find($idOficinaExterna);
        $oficinasExternas=$oficinaRepository->findBy(array('tipoOficina' => $tipoOficinaExterna));
        $usuario=$this->getUser();    
        
        $array=[];
        $permisos=$usuario->getPermisos();
        foreach ($permisos as $permiso){
        	$array[$permiso]=true;
        }
        $array['base_dir']=realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR;
        $array['tipos']=$tiposExpediente;
        $array['estados']=$estadosExpediente;
        $array['oficinasExternas']=$oficinasExternas;
        $array['tiposSesion']=$tipoSesionRepository->findAll();
        return $this->render('default/expediente.html.twig', $array);
    }
    
    /**
     * @Route("/expedientesComisiones", name="expedientesComisiones")
     */
    public function expedientesComisionesAction(Request $request)
    {
    	$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    	$tipoProyectoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoProyecto');
    	/*
    	 dictaminantes_en_mayoria: 1
    	 dictaminantes_en_primer_minoria: 2  
    	 dictaminantes_en_segunda_minoria: 
    	*/
    	
    	$comisiones=$comisionRepository->findBy(array('activa' => true));
    	$tipoProyectos=$tipoProyectoRepository->findAll();
    	return $this->render('default/expedientes_comisiones.html.twig',array(
    		   'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    		   'comisiones' => $comisiones, 'tipoProyectos'=> $tipoProyectos,
    		   'MAYORIA' => $this->getParameter('dictaminantes_en_mayoria'),
    		   'PRIMERA_MINORIA' => $this->getParameter('dictaminantes_en_primer_minoria'),
    		   'SEGUNDA_MINORIA' => $this->getParameter('dictaminantes_en_segunda_minoria')
    	));
    }
    
    
    /**
     * @Route("/seleccionSesion", name="seleccionSesion")
     */
    public function seleccionSesionAction(Request $request)
    {
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$años=$sesionRepository->findByDistinctPeriodos();
    	
    	return $this->render('default/seleccion_sesion.html.twig',array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    			'años'=> $años
    	));
    }
    
    /**
     * @Route("/expedientesOrdenDia", name="expedientesOrdenDia")
     */
    public function traerExpedientesOrdenDiaAction(Request $request)
    {
    	$idSesion=$request->query->get('idSesion');
    	$tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
    	$tipoProyectoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoProyecto');
    	$tipoExpedienteSesionRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpedienteSesion');
    	$tipoOficinaRepository=$this->getDoctrine()->getRepository('AppBundle:TipoOficina');
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    	$comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	
    	$tipoOficina=$tipoOficinaRepository->find(2);
    	$oficinas=$oficinaRepository->findBy(array('tipoOficina' => $tipoOficina));
    	$tiposExpediente=$tipoExpedienteRepository->findAll();
    	$tiposExpedienteSesion=$tipoExpedienteSesionRepository->findAll();
    	$tiposProyecto=$tipoProyectoRepository->findAll();
    	$comisiones=$comisionRepository->findAll();
    	$sesion=$sesionRepository->find($idSesion);
    	$nombreSesion=$sesion->getFechaFormateada().' ( '.($sesion->getTipoSesion()->getTipoSesion()).' )';
    	return $this->render('default/expedientes_orden_dia.html.twig',array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    			'tiposExpediente'=> $tiposExpediente, 'tiposExpedienteSesion'=>$tiposExpedienteSesion,
    			'idSesion'=>$idSesion, 'nombreSesion'=>$nombreSesion, 
    			'permiteEdicion'=>(($sesion->getTieneEdicionBloqueada()==true)?0:1),
    			'tiposProyecto'=>$tiposProyecto, 'comisiones'=>$comisiones,
    			'oficinas'=>$oficinas, 
    	));
    }
    
    /**
     * @Route("/movimientos", name="movimientos")
     */
    public function movimientosAction(Request $request)
    {
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    	$tipoOficinaRepository=$this->getDoctrine()->getRepository('AppBundle:TipoOficina');
    	$idOficinaInterna=$this->getParameter('id_oficina_interna');
    	$tipoOficina= $tipoOficinaRepository->find($idOficinaInterna);
    	$oficinaRepository=$this->getDoctrine()->getRepository('AppBundle:Oficina');
    	$tipoMovimientoRepository=$this->getDoctrine()->getRepository('AppBundle:TipoMovimiento');
    	$comisionesRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
    	
    	$usuario=$this->getUser();
    	$oficinaUsuario=$usuario->getRol()->getOficina();
    	$idMesaEntradas=$this->getParameter('id_mesa_entradas');
    	$oficinas=null;
    	$tiposMovimientos=null;    	
    	
    	if ($oficinaUsuario!=null && $oficinaUsuario->getId()!=$idMesaEntradas){
    		$oficinas=$oficinaRepository->findBy(array('tipoOficina' => $tipoOficina));
    		$tiposMovimientos=$tipoMovimientoRepository->findBy(array('tipoMovimiento' => 'Pase'));
    		$muestra_comisiones=0;
    		$muestra_remitos=0;
    	}
    	else{
    		$oficinas=$oficinaRepository->findAll();
    		$tiposMovimientos=$tipoMovimientoRepository->findAll();
    		$muestra_comisiones=1;
    		$muestra_remitos=1;
    	}
  
    	$movimientosCompletosHTML="";
    	foreach ($tiposMovimientos as $tipoMovimiento){
    		$movimientosCompletosHTML.="<option value='".$tipoMovimiento->getId().
    		"'>".$tipoMovimiento->getTipoMovimiento().
    		"</option>";
    	}
    	
    	$movimientoPase=$tipoMovimientoRepository->findBy(array('tipoMovimiento' => 'Pase'));
    	foreach ($movimientoPase as $tipoMovimiento){
    		$movimientosPaseHTML="<option value='".$tipoMovimiento->getId().
    		"' selected>".$tipoMovimiento->getTipoMovimiento().
	    	"</option>";
    	}
    	
    	$comisiones=$comisionesRepository->findAll();
    	$comisionesHTML="";
    	foreach ($comisiones as $comision){
    		$comisionesHTML.="<option value='".$comision->getId().
    		"'>".$comision->getComision().
    		"</option>";
    	}
    	
    	return $this->render('default/movimientos.html.twig', array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    			'oficinas' => $oficinas, 'movimientosCompletos' => $movimientosCompletosHTML,
    			'movimientoPase' => $movimientosPaseHTML, 'comisiones' => $comisionesHTML,
    			'muestra_comisiones' => $muestra_comisiones,'muestra_remitos' => $muestra_remitos
    	));
    	
    }

    /*
     *  @Route("/mail")
     *
    public function traerMailAction(Request $request)
    {
        $idProyecto=$request->query->get("idProyecto");
        // $idProyecto=$request->request->get("idProyecto");
        $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:Proyecto');
        $proyecto=$proyectoRepository->find($idProyecto);


        $subject=$proyecto->getTipoProyecto()->getTipoProyecto().' - '.substr($proyecto->getAsuntoSinHtml(),0,20).'...';
        $articulos=$proyecto->getArticulos();

        var_dump($articulos);
        die();

        $quienSanciona=($proyecto->getQuienSanciona()==1)
            ?'<p class="ident"><strong>EL HONORABLE CONCEJO DELIBERANTE EN USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA LA SIGUIENTE:</strong></p>'
            :'<p class="ident"><strong>EL SR. PRESIDENTE DE ESTE HONORABLE CONCEJO DELIBERANTE, EN USO DE ATRIBUCIONES QUE LE SON PROPIAS, SANCIONA LA SIGUIENTE:</strong></p>';

        $htmlArticulos='';//<ul style="list-style-type: none;">';
        
        foreach ($articulos as $articulo) {
             $htmlArticulos.='<strong><u>Artículo '.$articulo['numero'].'°</u>.- </strong>'.str_replace('</p>', '<br>',strip_tags($articulo['texto'],'</p>'));
            if(count($articulo['incisos'])>0){
                //recordar setear ul{list-style-type: none;}
                $htmlArticulos.='<ul style="list-style-type: none;">';
                foreach ($articulo['incisos'] as $inciso) {
                    $htmlArticulos.='<li>'.$inciso['orden'].' '.strip_tags($inciso['texto'],'<br>').'</li>';
                }
                $htmlArticulos.='</ul>';
            }
            //$htmlArticulos.='</li>';
        }

        $htmlArticulos.='</ul>';

        return $this->render('emails/notificacionProyecto.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'asunto' => strip_tags($proyecto->getAsunto(),'<p>'),
            'visto'=>str_replace('<p>','<p class="ident">',strip_tags($proyecto->getVisto(),'<p>')),
            'considerando'=>str_replace('<p>','<p class="ident">',strip_tags($proyecto->getConsiderandos(),'<p>')),
            'articulos'=>$htmlArticulos,
            'tipo'=>$proyecto->getTipoProyecto()->getTipoProyecto(),
            'quienSanciona'=>$quienSanciona
        ));
    }*/

     /**
     * @Route("/comisiones", name="Comisiones")
     */
    public function comisionAction(Request $request)
    {
    	$tipoComisionRepository=$this->getDoctrine()->getRepository('AppBundle:TipoComision');
    	$tiposComision=$tipoComisionRepository->findAll();
    	return $this->render('default/comision.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    		'tiposComision'=>$tiposComision
        ));   
    }
    
    /**
     * @Route("/bloques", name="bloques")
     */
    public function bloquesAction(Request $request)
    {
    	return $this->render('default/bloques.html.twig', array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR
    	));  
    }
    
    /**
     * @Route("/oficinas", name="oficinas")
     */
    public function oficinasAction(Request $request)
    {
    	$tipoOficinaRepository=$this->getDoctrine()->getRepository('AppBundle:TipoOficina');
    	$tiposOficina=$tipoOficinaRepository->findAll();
    	return $this->render('default/oficinas.html.twig', array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    			'tiposOficina'=>$tiposOficina
    	));
    }
    
    /**
     * @Route("/votacion")
     */
    public function votacionAction(Request $request){

        return $this->render('base_session.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR
        ));

    }
    
    /**
     * @Route("/sesion", name="sesiones")
     */
    public function sesionAction(Request $request){
    	
    	$tipoSeionRepository=$this->getDoctrine()->getRepository('AppBundle:TipoSesion');
    	$tiposSesion=$tipoSeionRepository->findAll();
    	
    	return $this->render('default/sesion.html.twig', array(
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    			'tiposSesion' => $tiposSesion
    	));
    }
    
    
    /**
     * @Route("/imprimir/remito")
     */
    public function impresionRemitoAction(Request $request)
    {
    	
 
    }

    /**
     * @Route("/imprimir")
     */
    public function impresionAction(Request $request)
    {
        $tipoDocumento = $request->query->get('tipoDocumento');
        $id = $request->query->get('id');

        $idExpediente=(($tipoDocumento=='expediente')?$id:null);
        $idProyecto=(($tipoDocumento=='proyecto')?$id:null);
        $parametrosCaratula=null;
        $parametrosProyecto=null;

        $parametrosCaratula=$this->get('impresion_servicio')->traerParametrosCaratula($idExpediente);

        $idProyecto=((!is_null($parametrosCaratula))?$parametrosCaratula["idProyecto"]: $idProyecto);

        $parametrosProyecto=$this->get('impresion_servicio')->traerParametrosProyecto($idProyecto);
        
        $tipo = (!is_null($parametrosCaratula)?$parametrosCaratula["tipo"]:$parametrosProyecto["tipo"]);

        $nombre = (!is_null($parametrosCaratula)?$parametrosCaratula["nombreArchivo"]:$parametrosProyecto["nombreArchivo"]);

        $titulo = (!is_null($parametrosCaratula)?$parametrosCaratula["titulo"]:$parametrosProyecto["titulo"]);

        $pdf = $this->get('white_october.tcpdf')->create();
        
        // activa o desactiva encabezado de página
        $pdf ->SetPrintHeader(true);
        // activa o desactiva el pie de página
        if ($tipoDocumento=='proyecto') $pdf ->SetPrintFooter(true); else $pdf ->SetPrintFooter(false);
        //$base=$request->getSchemeAndHttpHost().$request->getBasePath();
        //$pdf->setBaseImagePath($base);
        $urlImage='/web/document_bootstrap/escudopng2_mini.png';
        // set default header data
        $pdf ->SetAuthor('SisLeg');
        $pdf ->SetTitle($titulo);
        $pdf ->SetSubject($nombre);
        $pdf ->SetHeaderData($urlImage, 8, $titulo, $tipo, array(0,0,0), array(0,0,0));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        /*---------------------------------------------------------------------------------------
          --------------------------------------Caratula-----------------------------------------
          ---------------------------------------------------------------------------------------*/

        if (!is_null($parametrosCaratula))
        {
            $documento=$parametrosCaratula["documento"];
            $pdf->AddPage('P','LEGAL');
            $pdf->Ln(10);
            $html='<h1>CONSEJO DELIBERANTE</h1><h3>DE</h3><h3>LOMAS DE ZAMORA</h3>';
            $pdf->writeHTMLCell(185, '', '', '', $html, 0, 1, 0, true, 'C', true);
            $html='<table style="margin-top:15px;background-color:white">
                      <tr style="height:20px">
                        <td style="width:30%;vertical-align: bottom;">
                          Expediente N°:
                        </td>
                        <td style="width:15%;font-size:x-large;vertical-align: bottom;">
                          <strong><i>'.$documento["numeroExp"].'</i></strong>
                        </td>
                        <td style="width:20%;vertical-align: bottom;">
                          Letra:
                        </td>
                        <td style="width:8%;vertical-align: bottom;font-size:x-large;">
                          <strong><i>'.$documento["letra"].'</i></strong>
                        </td>
                        <td style="width:15%;vertical-align: bottom;">
                          Año:
                        </td>
                        <td style="width:8%;vertical-align: bottom;font-size:x-large;">
                          <strong><i>'.$documento["ejercicio"].'</i></strong>
                        </td>
                      </tr>
                    </table>';
            $pdf->Ln(15);
            $pdf->writeHTMLCell(185, '', '', '', $html, 0, 1, 0, true, 'C', true);
            $pdf->Ln(15);
            $pdf->writeHTMLCell(10, 80, '', '', '', 0, 0, 0, true, 'C', true);
            $pdf->SetDrawColor(0, 0, 0, 3);
            $pdf->SetFillColor(0, 0, 0, 3);
            $html=$documento["caratula"];
            $pdf->writeHTMLCell(165, 100, '', '', $html, 1, 1, 1, true, 'L', true);
            $pdf->Ln(10);
            $pdf->SetDrawColor(0, 0, 0, 100);
            $pdf->SetFillColor(0, 0, 0, 0);
            $html='<table style="background-color:white">
                      <tr>
                        <td style="width:140px;text-align: left;">Fecha Entrada:</td>
                        <td style="text-align: left"><strong><i>'.$documento["entrada"].'</i></strong></td>
                        </tr>
                    </table>';
            $pdf->writeHTMLCell(165, '', '', '', $html, 0, 1, 1, true, 'L', true);
            $pdf->Ln(10);
            $referencia=(($documento["tieneProyecto"]==false)?'Origen':'Autores');
            $html='<table style="background-color:white">
                      <tr>
                        <td style="width:140px;text-align: left;">'.$referencia.':</td>
                        <td style="width:500px;text-align: justify"><strong><i>'.$documento["origen"].'</i></strong>
                        </td>
                        </tr>
                    </table>';
            $pdf->writeHTMLCell(165, '', '', '', $html, 0, 1, 1, true, 'L', true);
            $pdf->Ln(10);
            $html='<table style="background-color:white">
                      <tr>
                        <td style="width:140px;">Observaciones:</td>
                        </tr>
                    </table>';
            $pdf->writeHTMLCell(40, '', '', '', $html, 0, 0, 1, true, 'L', true);
            $html='<hr><hr>';
            $pdf->SetFillColor(0, 0, 0, 3);
            $pdf->writeHTMLCell(135, 10, '' , '', '', 0, 1, 1, true, 'L', true);
            $pdf->SetFillColor(0, 0, 0, 0);
            $pdf->writeHTMLCell(40, '', '', '', '', 0, 0, 1, true, 'L', true);
            $pdf->SetFillColor(0, 0, 0, 3);
            $pdf->writeHTMLCell(135, '', '' , '', $html, 0, 1, 1, true, 'L', true);
            $pdf->SetFillColor(0, 0, 0, 0);
            $pdf->writeHTMLCell(40, '', '', '', '', 0, 0, 1, true, 'L', true);
            $pdf->SetFillColor(0, 0, 0, 3);
            $pdf->writeHTMLCell(135, '', '' , '', $html, 0, 1, 1, true, 'L', true);
            $pdf->SetFillColor(0, 0, 0, 0);
            $pdf->writeHTMLCell(40, '', '', '', '', 0, 0, 1, true, 'L', true);
            $pdf->SetFillColor(0, 0, 0, 3);
            $pdf->writeHTMLCell(135, '', '' , '', $html, 0, 1, 1, true, 'L', true);
            $pdf->SetFillColor(0, 0, 0, 0);
            $pdf->writeHTMLCell(40, '', '', '', '', 0, 0, 1, true, 'L', true);
            $pdf->SetFillColor(0, 0, 0, 3);
            $pdf->writeHTMLCell(135, '', '' , '', $html, 0, 1, 1, true, 'L', true);
        }

        /*---------------------------------------------------------------------------------------
          --------------------------------------Proyecto-----------------------------------------
          ---------------------------------------------------------------------------------------*/

        if (!is_null($parametrosProyecto))
        {
            $documento=$parametrosProyecto["documento"];
            $max_pint_area=356-25;
            $pdf->AddPage('P','LEGAL');
            $pdf->Ln(5);
            $html='<h3><strong><u>PROYECTO DE '. strtoupper($tipo).'</u></strong></h3>';
            $pdf->writeHTMLCell(185, '', '', '', $html, 0, 1, 0, true, 'C', true);
            $pdf->Ln(15);           
            $html='<h4><u>VISTO:</u></h4>';
            $pdf->writeHTMLCell(185, '', '', '', $html, 0, 1, 0, true, 'L', true);
            if($pdf->getY()+5>$max_pint_area || $pdf->getY()>28)
                $pdf->Ln(5);
            $html=$documento["visto"]; 
            $pdf->writeHTMLCell(185, '', '', '', $html, 0, 1, 0, true, 'J', true);
            if($pdf->getY()+15<$max_pint_area || $pdf->getY()>28)
                $pdf->Ln(15);
            $html='<h4><u>CONSIDERANDO:</u></h4>';
            $pdf->writeHTMLCell(185, '', '', '', $html, 0, 1, 0, true, 'L', true);
            if($pdf->getY()+5<$max_pint_area || $pdf->getY()>28)
                $pdf->Ln(5);
            $html=$documento["considerando"];
            $pdf->writeHTMLCell(185, '', '', '', $html, 0, 1, 0, true, 'J', true);
            if($pdf->getY()+15<$max_pint_area || $pdf->getY()>28)
                $pdf->Ln(15);
            $html=$documento["quienSanciona"];
            $pdf->writeHTMLCell(185, '', '', '', $html, 0, 1, 0, true, 'C', true);
            if($pdf->getY()+15<$max_pint_area || $pdf->getY()>28)  
                $pdf->Ln(15);
            $html='<h4><u>'.strtoupper($tipo).'</u></h4>';
            $pdf->writeHTMLCell(185, '', '', '',$html, 0, 1, 0, true, 'C', true);
            if($pdf->getY()+15<$max_pint_area || $pdf->getY()>28)
                $pdf->Ln(15);
            $html=$documento["articulos"];
            $pdf->writeHTMLCell(185, '', '', '', $html, 0, 1, 0, true, 'J', true);
                  
        } 

        return new Response(
           $pdf->Output($nombre, 'D'),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $nombre),
            ]
        );
    }

     /**
     * @Route("/imprimirOrdenDelDia")
     */
    public function pruebaAction(Request $request){
       
    	$idSesion = $request->query->get('idSesion');
    	$sesionRepository=$this->getDoctrine()->getRepository('AppBundle:Sesion');
    	$sesion=$sesionRepository->find($idSesion);
    	$tipoExpedienteSesionRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpedienteSesion');
    	$tiposExpedientesSesion=$tipoExpedienteSesionRepository->findAll();
    	 
    	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    	
    	$fecha=$sesion->getFecha()->format('d')." de ".$meses[$sesion->getFecha()->format('n')-1].
    		   " de ".$sesion->getFecha()->format('Y') ;
    	
    	$basepath=realpath($this->getParameter('kernel.root_dir').'/..');
    	$pdf = $this->get('white_october.tcpdf')->create();
    	
    	// activa o desactiva encabezado de página
    	$pdf ->SetPrintHeader(false);
    	// activa o desactiva el pie de página
    	
    	$pdf ->SetPrintFooter(false);
    	//$base=$request->getSchemeAndHttpHost().$request->getBasePath();
    	//$pdf->setBaseImagePath($base);
    	$urlImage='/web/document_bootstrap/escudopng2_mini.png';
    	// set default header data
    	$pdf ->SetAuthor('SisLeg');
    	$pdf ->SetTitle('HCD Lomas de Zamora');
    	$pdf ->SetSubject('Orden del Día '.$fecha);
    	$pdf ->SetHeaderData($urlImage, 8, 'HCD Lomas de Zamora - Orden del Día','Sesión: '.$fecha, array(0,0,0), array(0,0,0));
    	// set default monospaced font
    	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    	// set margins
    	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    	// set auto page breaks
    	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    	
    	$pdf->AddPage('P','LEGAL');
    	
    	$pdf->ln(15);
    	
    	
    	$imagenpath=$basepath.'/web/document_bootstrap/portada_orden_dia.png';
    	
    	//$pdf->writeHTMLCell(170, '', 25, '', '<H1>'.$imagenpath.'</H1>', 0, 1, 0, true, 'C', true);
    	
    	$pdf->Image($imagenpath, 25, '', 170, '', '', '', 'M', 
    				true, 700, '', false, false, 1, false, false, false);
    	  	
    	//$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    	   	
    	$pdf->ln(80);
    	$pdf->SetFont('times', 'I', 18);
    	$html_caratula='<H1>SESION '.strtoupper($sesion->getTipoSesion()->getTipoSesion()). ' A CELEBRARSE</H1>'.
    				   '<H1>EL DÍA '.strtoupper($fecha).'</H1>';
    	
    	$pdf->writeHTMLCell(170, '', 25, '', $html_caratula, 0, 1, 0, true, 'C', true);
    	
    	$pdf->ln(50);
    	$pdf->SetFont('times', '', 20);
    	$pdf->writeHTMLCell(170, '', 25, '', '<H1><u>ORDEN DEL DÍA</u></H1>', 0, 1, 0, true, 'C', true);
    	 
    	$pdf ->SetPrintHeader(true);
    	$pdf->AddPage('P','LEGAL');
    	$pdf->SetFont('times', '', 12);
    	
    	
    	foreach ($tiposExpedientesSesion as $tipoExpedienteSesion){
    		//$html='';
    		$content=$sesionRepository->findOrdenDiaBySesionYApartado($idSesion, $tipoExpedienteSesion->getId());
    		
    		if (count($content)>0){
    			$html='<div style="text-align:center"><h1>'.$tipoExpedienteSesion->getLetra().')'.
      				   $tipoExpedienteSesion->getTipoExpedienteSesion().'</h1></div>';
	    		$html.=($content[0]["textoApartado"]);
		    	$pdf->writeHTMLCell(170, '', 25, '', $html, 0, 1, 0, true, 'J', true);
// 		    	$pdf->Ln(1);
    		}
    		
    	}
    	
//     	$pdf->writeHTMLCell(170, '', 25, '', $html, 0, 1, 0, true, 'J', true);
//     	$pdf->Ln(1);
    		    	
    	return new Response(
    			$pdf->Output('Orden del Día '.$fecha, 'D'),
    			200,
    			[
    					'Content-Type'        => 'application/pdf',
    					'Content-Disposition' => sprintf('attachment; filename="%s"', 'SisLeg'),
    			]
    			);
    }

}

