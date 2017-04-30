<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\File\UploadedFile;;

// use twig\twig;

use AppBundle\Entity\Rol;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Perfil;
use AppBundle\Entity\PerfilLegislador;
use AppBundle\Entity\PerfilPublico;
use AppBundle\Entity\Bloque;
use AppBundle\Entity\Expediente;
use AssistBundle\Entity\AdministracionSesion;


class RestController extends FOSRestController{


	/**
	 * @Rest\Get("/api/usuario/getAll")
     */
    public function traerTodosLosUsuariosAction(Request $request)
    {

        $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
        $usuarios=$usuarioRepository->findAll();
        return $this->view($usuarios,200);
    }	

    /**
     * @Rest\Get("/api/usuario/getOne/{id}")
     */
    public function traerUsuarioPorIdAction(Request $request)
    {
        //$id=$request->query->get('id');
        $id=$request->get('id');
        $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
        $usuario=$usuarioRepository->find($id);
        return $this->view($usuario,200);
    }

    /**
     * @Rest\Get("/api/proyecto/getAll")
     */
    public function traerTodosLosProyectosAction(Request $request)
    {

        $proyectoRepository=$this->getDoctrine()->getRepository('AppBundle:proyecto');
        $proyecto=$proyectoRepository->findAll();
        return $this->view($proyecto,200);
         
    }

    /**
     * @Rest\Get("/api/expediente/getAll")
     */
    public function traerTodosLosExpedientesAction(Request $request)
    {

        $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
        $expedientes=$expedienteRepository->findAll();
        return $this->view($expedientes,200);
         
    }

    /**
     * @Rest\Get("/api/expediente/getByCriteria/{tipoCriterio}/{criterio}")
     */
    public function traerExpedientesPorCriterioAction(Request $request)
    {
        $tipoCriterio=$request->get('tipoCriterio');
        $criterio=$request->get('criterio');
        $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
        $expedientes=null;
        if ($tipoCriterio=='todo')
            $expedientes=$expedienteRepository->findAll();
        if($tipoCriterio=='busqueda-1')
            $expedientes=$expedienteRepository->findByAutor_Nombres($criterio);
        if ($tipoCriterio=='busqueda-2')
            $expedientes=$expedienteRepository->findByEstado_Id($criterio);
        if($tipoCriterio=='busqueda-3')
            $expedientes=$expedienteRepository->findBy(array('numeroExpediente'=>$criterio));
        if ($tipoCriterio=='busqueda-4')
            $expedientes=$expedienteRepository->findByTipoExpediente_Id($criterio);

        return $this->view($expedientes,200);
         
    }

    /**
     * @Rest\Get("/api/expediente/getOne/{id}")
     */
    public function traerExpedientePorIdAction(Request $request)
    {
        $id=$request->get('id');
        $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
        $expediente=$expedienteRepository->find($id);
        return $this->view($expediente,200);
    }

    /**
     * @Rest\Get("/api/legislador/getAll")
     */
    public function traerTodosLosLegisladoresAction(Request $request)
    {
        $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
        $perfiles=$perfilRepository->findAll();
        return $this->view($perfiles,200);

    }

     /**
     * @Rest\Get("/api/autor/getByCriteria")
     */
    public function traerAutorPorCriterioAction(Request $request)
    {   
        $term=$request->query->get('q');
        $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
        $perfiles=$perfilRepository->findByNombre_Patron($term);
        return $this->view($perfiles,200);

    }

    /**
     * @Rest\Get("/api/comision/getAll")
     */
    public function traerTodasLasComisionesAction(Request $request)
    {
        
        $comisionRepository=$this->getDoctrine()->getRepository('AppBundle:Comision');
        $comisiones=$comisionRepository->findBy(array(),array('comision' => 'ASC'));
        return $this->view($comisiones,200);

    }

    /**
     *  @Rest\Post("/api/expediente/create")
     */
    public function crearExpedienteAction(Request $request)
    {   
        try{               
            $numeroExpediente=$request->request->get('numeroExpediente');
            $idTipoExpediente=$request->request->get('selTipoExpediente');
            $asunto=$request->request->get('asunto');
            $extracto=$request->request->get('extracto');
            $archivos=$request->files->all();
            $usuario=$this->getUser();

            $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
            $tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
            $tipoExpediente=$tipoExpedienteRepository->find($idTipoExpediente);
            $estadoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:EstadoExpediente');
            $estadoExpediente=$estadoExpedienteRepository->find(1);

            $expediente=new Expediente();
            $expediente->setArchivos($archivos);
            $expediente->setNumeroExpediente($numeroExpediente);
            $expediente->setTipoExpediente($tipoExpediente);
            $expediente->setAsunto($asunto);
            $expediente->setExtracto($extracto);

            $expediente->setUsuarioCreacion($usuario->getUsername());
            $expediente->setFechaCreacion(new \DateTime("now"));
            $expediente->setEstadoExpediente($estadoExpediente);

            $em = $this->getDoctrine()->getManager();
            $em->persist($expediente);
            $em->flush();

            return $this->view('El expediente '.$numeroExpediente.' se guardó en forma exitosa',200);

        }catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e){ 
            throw new \Exception('El expediente '.numeroExpediente.' ya existe');
        }catch(\Exception $e){
            throw $e;
            
        }

    }

    /**
     *  @Rest\Post("/api/expediente/update")
     */
    public function actualizarProyectoAction(Request $request)
    {   
        try{
            $id=$request->request->get('id');
            $numeroExpediente=$request->request->get('numeroExpedienteMod');
            $idTipoExpediente=$request->request->get('selTipoExpedienteMod');
            $asunto=$request->request->get('asuntoMod');
            $extracto=$request->request->get('extractoMod');
            $archivos=$request->files->all();
            $usuario=$this->getUser();

             $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
            $tipoExpedienteRepository=$this->getDoctrine()->getRepository('AppBundle:TipoExpediente');
            $tipoExpediente=$tipoExpedienteRepository->find($idTipoExpediente); 
            $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
            $expediente=$expedienteRepository->find($id); 

            $expediente->setArchivos($archivos);
            $expediente->setNumeroExpediente($numeroExpediente);
            $expediente->setTipoExpediente($tipoExpediente);
            $expediente->setAsunto($asunto);
            $expediente->setExtracto($extracto);

            $expediente->setUsuarioModificacion($usuario->getUsername());
            $expediente->setFechaModificacion(new \DateTime("now"));

            $em = $this->getDoctrine()->getManager();
            $em->persist($expediente);
            $em->flush();

            return $this->view('El expediente '.$numeroExpediente.' se modificó en forma exitosa',200);

         }catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e){ 
            throw new \Exception('El expediente '.numeroExpediente.' ya existe');
        }catch(\Exception $e){
            throw $e;
            
        }
    }

    /**
     *  @Rest\Post("/api/expediente/archivo/remove")
     */
    public function borrarArchivoAction(Request $request)
    { 
        
        try {
            $claveBorrado=$request->request->get("key");
            $usuario=$this->getUser();
            
            $stripPath=explode("/",$claveBorrado);

            $expedienteRepository=$this->getDoctrine()->getRepository('AppBundle:Expediente');
            $result=$expedienteRepository->searchByHashValue($stripPath[0]); 

            $expediente=$expedienteRepository->find($result["idExpediente"]);
            
            $expediente->setArchivoBorrado($stripPath[1]);

            $expediente->setUsuarioModificacion($usuario->getUsername());
            $expediente->setFechaModificacion(new \DateTime("now"));

            $em = $this->getDoctrine()->getManager();
            $em->persist($expediente);
            $em->flush();

            return $this->view('La imagen se eliminó en forma exitosa',200);   
            
        } catch (Exception $e) {
            throw $e;
            
        }
        

    }
    /**
     *  @Rest\Post("/api/usuario/create")
     */
    public function crearUsuarioAction(Request $request)
    {   
        try{

            $idTipoPerfil=$request->request->get('selTipo');
            $apellidos=$request->request->get('apellidos');
            $nombres=$request->request->get('nombres');
            $login=$request->request->get('login');
            $idRol=$request->request->get('selRol');
            $clave=$request->request->get('clave');
            $eMail=$request->request->get('eMail');
            $telefono=$request->request->get('telefono');
            $oficina=$request->request->get('oficina');
            $domicilio=$request->request->get('domicilio');
            $documento=$request->request->get('documento');
            $idBloque=$request->request->get('idBloque');
            $archivos=$request->files->all();
            $usuarioSesion=$this->getUser();

            $perfil=null;

            if($idTipoPerfil==1){
                $perfil=new Perfil();
            }
            if($idTipoPerfil==2){
                $perfil=new PerfilLegislador();

                $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
                $bloque=$bloqueRepository->find($idBloque);

                $perfil->setBloque($bloque);
                $perfil->setOficina($oficina);
            }
            if($idTipoPerfil==3){
                $perfil=new PerfilPublico();
                $perfil->setDocumento($documento);
                $perfil->setDomcilio($domicilio);
            }

            $perfil->setApellidos($apellidos);
            $perfil->setNombres($nombres);
            $perfil->setTelefono($telefono);
            $perfil->setCorreoElectronico($eMail);
            $perfil->setUsuarioCreacion($usuarioSesion->getUsername());
            $perfil->setFechaCreacion(new \DateTime("now"));


            if(count($archivos)>0){
                $perfil->setArchivo($archivos["uploadedFiles-0"]);
                $perfil->setPrefijo($login);
            }
            $rolRepository=$this->getDoctrine()->getRepository('AppBundle:Rol');
            $rol=$rolRepository->find($idRol);

            $usuario=new Usuario();
            $usuario->setUsuario($login);
            $usuario->setFechaCreacion(new \DateTime("now"));
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($usuario, $clave);
            $usuario->setClave($encoded);
            $usuario->setRol($rol);
            $usuario->setPerfil($perfil);
            $usuario->setUsuarioCreacion($usuarioSesion->getUsername());

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->view('El usuario se guardo en forma exitosa',200);

        }catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e){ 
            throw new \Exception('El nombre de usuario ya existe');
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    /**
     *  @Rest\Post("/api/usuario/perfil/update")
     */
     public function actualizarPerfilAction(Request $request)
    {   
        $id=$request->request->get('id');
        $apellidos=$request->request->get('apellidosMod');
        $nombres=$request->request->get('nombresMod');
        $idRol=$request->request->get('selRolMod');
        $conservarClave=$request->request->get('conservaContraseña');
        $clave=$request->request->get('claveMod');
        $eMail=$request->request->get('eMailMod');
        $telefono=$request->request->get('telefonoMod');
        $oficina=$request->request->get('oficinaMod');
        $domicilio=$request->request->get('domicilioMOd');
        $documento=$request->request->get('documentoMod');
        $idBloque=$request->request->get('idBloqueMod');
        $archivos=$request->files->all();
        $usuarioSesion=$this->getUser();

        $em = $this->getDoctrine()->getManager();
     
        $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
        $usuario=$usuarioRepository->find($id);
        $rolRepository=$this->getDoctrine()->getRepository('AppBundle:Rol');
        $rol=$rolRepository->find($idRol);



        $perfil=$usuario->getPerfil();

        if($perfil instanceof PerfilLegislador){

            $bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
            $bloque=$bloqueRepository->find($idBloque);
            $perfil->setBloque($bloque);
            $perfil->setOficina($oficina);
        }
        if($perfil instanceof PerfilPublico){

            $perfil->setDocumento($documento);
            $perfil->setDomcilio($domicilio);
        }

        $perfil->setApellidos($apellidos);
        $perfil->setNombres($nombres);
        $perfil->setTelefono($telefono);
        $perfil->setCorreoElectronico($eMail);
        $perfil->setUsuarioModificacion($usuarioSesion->getUsername());
        $perfil->setFechaModificacion(new \DateTime("now"));

        if(count($archivos)>0){
            $perfil->setArchivo($archivos["uploadedFiles-0"]);
            $perfil->setPrefijo($usuario->getUsuario());
        }
         
        if($conservarClave==false){
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($usuario, $clave);
            $usuario->setClave($encoded);
        }

        $usuario->setRol($rol);
        $usuario->setPerfil($perfil);
        $usuario->setUsuarioModificacion($usuarioSesion->getUsername());
        $usuario->setFechaModificacion(new \DateTime("now"));

        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();

        return $this->view('La modificacion del usuario se realizó con éxito',200);
    }

    /**
     * @Rest\Post("/api/usuario/imagen/remove")
     */
    public function borrarImagenAction(Request $request)
    {
        $key=$request->request->get("key");
        if($key=="no-unlink-preview")
            throw new \Exception("No se puede remover la imagen por defecto");

        $stripPath=explode("/",$key);
        $claveBorrado=$stripPath[2];
        $usuarioSesion=$this->getUser();

        

        $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
        $perfil=$perfilRepository->findOneBy(array('imagen'=>$claveBorrado));
        $perfil->setBorrarImagen();

        $perfil->setUsuarioModificacion($usuarioSesion->getUsername());
        $perfil->setFechaModificacion(new \DateTime("now"));
    

        $em = $this->getDoctrine()->getManager();
        $em->persist($perfil);
        $em->flush();
    }

    /**
     * @Rest\Put("/api/usuario/estado/{id}/{estado}")
     */
    public function cambiarEstadoAction(Request $request){

        $id=$request->get('id');
        $estado=$request->get('estado');

        $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
        $usuario=$usuarioRepository->find($id);
        $mensaje='El usuario '.$usuario->getUsuario().' se '.(($estado==0)?'desactivó':'activó').' con exito';

        $usuario->setActivo($estado);

        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();

        return $this->view($mensaje,200);
    }

    /**
     *  @Rest\Get("/api/session/getId")
     */
    public function getSessionIdAction(Request $request)
    {   
        
        $seccion=$request->query->get('seccion');
        $session = $this->get('session');

        $administracionSesion = new AdministracionSesion();
        $administracionSesion->setId($session->getId());
        $administracionSesion->setSectionId($seccion);
        $administracionSesion->setElementId(5);
        $administracionSesion->setTimeId(1);

        $em=$this->get('doctrine')->getManager('sqlite');
        $em->persist($administracionSesion);
        $em->flush();

        return $this->view($administracionSesion,200);

    }

    /**
     *  @Rest\Get("/api/sesion/traerAccion")
     */
    public function traerAccionIdAction(Request $request)
    {   
        return $this->view($this->getUser(),200);
    
        /*
        $mensaje;
        $session = $this->get('session');
        $administracionSesionRepository=$this->get('doctrine')->getRepository('AssistBundle:AdministracionSesion', 'sqlite');
        $id=$session->getId();
        $administracionSesion=$administracionSesionRepository->findOneBy(array('id' => $id));

        if(is_null($administracionSesion)){
            $administracionSesion = new AdministracionSesion();
            $administracionSesion->setId($id);
            $administracionSesion->setSectionId(0);
            $administracionSesion->setElementId(0);
            $administracionSesion->setTimeId(0);
            $mensaje='crea nuevo';
        }
        else{
            $em=$this->get('doctrine')->getManager('sqlite');
            $em->remove($administracionSesion);
            $em->flush();
            $mensaje='borrar existente';
        }

        return $this->view($administracionSesion,200);
*/
    }

    /**
     *  @Rest\Get("/api/expediente/ejemplo/{patron}")
     */
    public function ejemploAction(Request $request){

        $patron=$request->get('patron');
        $expedienteRepository=$this->get('doctrine')->getRepository('AppBundle:Perfil');
        $expedientes=$expedienteRepository->findByNombre_Patron($patron);
        
        return $this->view($expedientes,200);
    }


}