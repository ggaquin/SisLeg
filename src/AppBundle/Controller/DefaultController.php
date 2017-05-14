<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;

// use twig\twig;

use AppBundle\Entity\Rol;
use AppBundle\Entity\Usario;
use AppBundle\Entity\Perfil;
use AppBundle\Entity\Bloque;
use AppBundle\Entity\Proyecto;


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

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
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
        $usuario=$this->getUser();
        $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
        $usuario_actual=$usuarioRepository->findOneByUsuario($usuario->getUsername());

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
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
        $tiposExpediente=$tiposExpedienteRepository->findBy(array(),array('tipoExpediente' => 'ASC') );
        $estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
        $estadosExpediente=$estadoExpedienteRepository->findBy(array(),array('estadoExpediente' => 'ASC') );
       
        return $this->render('default/expediente.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'tipos' => $tiposExpediente,'estados'=>$estadosExpediente
        ));
         
    }

     /**
     *  @Route("/mail")
     */
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
    }

     /**
     * @Route("/comisiones", name="Comisiones")
     */
    public function comisionAction(Request $request)
    {
       return $this->render('default/comision.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR
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
     * @Route("/pruebaVistas")
     */
    public function pruebaAction(Request $request){

        $html = $this->renderView('documento/portada.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/../web').DIRECTORY_SEPARATOR));

        $filename = sprintf('test-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html,array(
                'lowquality' => true,
                'encoding' => 'utf-8',
                'images' => true,

                )),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
                'lowquality' => true,
                'encoding' => 'utf-8',
                'images' => true,
            ]
        );
        // return $this->render('documento/portada.html.twig', array(
        //     'base_dir' => realpath($this->getParameter('kernel.root_dir').'/../web')
        // ));

    }

}

