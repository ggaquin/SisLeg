<?php

namespace AppBundle\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


// use twig\twig;

use AppBundle\AppBundle;
use AppBundle\Entity\Bloque;
use AppBundle\Entity\Perfil;
use AppBundle\Entity\PerfilLegislador;
use AppBundle\Entity\PerfilPublico;
use AppBundle\Entity\Rol;
use AppBundle\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;

/**
 * @Route("/api/usuario")
 *
 */
class RestUserController extends FOSRestController{


	/**
	 * @Rest\Get("/getAll")
     */
    public function traerTodosLosUsuariosAction(Request $request)
    {

        $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
        $usuarios=$usuarioRepository->findAll();
        $resultado=[];
        foreach ($usuarios as $usuario){
        	$bloque=(($usuario->getPerfil() instanceof PerfilLegislador)
        						?$usuario->getPerfil()->getBloque()->getBloque()
        						:"---");
        	$registro=array('id'=>$usuario->getId(),'activo'=>$usuario->getActivo(),
        					'nombre_completo'=>$usuario->getPerfil()->getNombreCompleto(),
        					'rol_como_string'=>$usuario->getRol()->getRolComoString(),
        					'tipo_perfil'=>$usuario->getPerfil()->getTipoPerfil(),
        					'bloque'=>$bloque, 'usuario'=>$usuario->getUsuario()        					
        					);	
        	$resultado[]=$registro;
        }
        return $this->view($resultado,200);
    }	

    /**
     * @Rest\Get("/getOne/{id}")
     */
    public function traerUsuarioPorIdAction(Request $request)
    {
        $id=$request->get('id');
        $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
        $usuario=$usuarioRepository->find($id);
        return $this->view($usuario,200);
    }

    

    /**
     *  @Rest\Post("/create")
     */
    public function crearUsuarioAction(Request $request)
    {   
        
            $idTipoPerfil=$request->request->get('selTipo');
            $apellidos=$request->request->get('apellidos');
            $nombres=$request->request->get('nombres');
            $login=$request->request->get('login');
            $idRol=$request->request->get('selRol');
            $clave=$request->request->get('clave');
            $eMail=$request->request->get('eMail');
            $telefono=$request->request->get('telefono');
            $domicilio=$request->request->get('domicilio');
            $documento=$request->request->get('documento');
            $idBloque=$request->request->get('selBloque');
            $idPerfil=$request->request->get('selLegislador');
            $permisos=json_decode($request->request->get('permisos'));
            $archivos=$request->files->all();
            $usuarioSesion=$this->getUser();

        try{

            $perfil=null;

            if ($idTipoPerfil==2){
                $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
                $perfil=$perfilRepository->find($idPerfil);
            }
            else {
                    if($idTipoPerfil==1){
                        $perfil=new Perfil();
                    }
                    if($idTipoPerfil==2){
                        $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
                        $perfil=$perfilRepository->find($idBloque);
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
                        $perfil->setPrefijo($usuarioSesion->getUsername());
                    }
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
            $usuario->setPermisos($permisos);
            $usuario->setUsuarioCreacion($usuarioSesion->getUsername());

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->view('El usuario se guardo en forma exitosa',200);

        }catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e){ 
                $mensaje='';
                $perfilRepository=$this->getDoctrine()->getRepository('AppBundle:Perfil');
                if ($idTipoPerfil==2 && !is_null($idPerfil) &&
                    $perfilRepository->perfilPoseeUsuario($idPerfil))
        
                    $mensaje='El legislador ya posee un usuario';
                else
                     $mensaje='El nombre de usuario ya existe';

                return $this->view($mensaje,500);
        }
        catch(\Exception $e){
             return $this->view($e->getMessage());
        }
    }

     /**
     *  @Rest\get("/getRolesByTipoPerfil/{idTipoPerfil}")
     */
     public function traerRolesPorPerfilAction(Request $request)
     {

         $idTipoPerfil=$request->get('idTipoPerfil');
         $tipoPerfilRepository=$this->getDoctrine()->getRepository('AppBundle:TipoPerfil');
         $tipoPerfil=$tipoPerfilRepository->find($idTipoPerfil);

         return $this->view($tipoPerfil,200);
     }

    /**
     *  @Rest\Post("/updatePerfil")
     */
     public function actualizarPerfilAction(Request $request)
    {   
        try {
                $id=$request->request->get('id');
                $apellidos=$request->request->get('apellidosMod');
                $nombres=$request->request->get('nombresMod');
                $idRol=$request->request->get('selRolMod');
                $conservarClave=$request->request->get('conservaContraseña');
                $clave=$request->request->get('claveMod');
                $eMail=$request->request->get('eMailMod');
                $telefono=$request->request->get('telefonoMod');
                $domicilio=$request->request->get('domicilioMOd');
                $documento=$request->request->get('documentoMod');
                $permisos=json_decode($request->request->get('permisos'));
                $archivos=$request->files->all();
                $usuarioSesion=$this->getUser();

                $em = $this->getDoctrine()->getManager();
             
                $usuarioRepository=$this->getDoctrine()->getRepository('AppBundle:Usuario');
                $usuario=$usuarioRepository->find($id);
                $rolRepository=$this->getDoctrine()->getRepository('AppBundle:Rol');
                $rol=$rolRepository->find($idRol);



                $perfil=$usuario->getPerfil();

                if(!($perfil instanceof PerfilLegislador)){

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
                        $perfil->setPrefijo($usuarioSesion->getUsername());
                    }
                }
                 
                if($conservarClave==false){
                    $encoder = $this->container->get('security.password_encoder');
                    $encoded = $encoder->encodePassword($usuario, $clave);
                    $usuario->setClave($encoded);
                }

                $usuario->setRol($rol);
                $usuario->setPerfil($perfil);
                $usuario->setPermisos($permisos);
                $usuario->setUsuarioModificacion($usuarioSesion->getUsername());
                $usuario->setFechaModificacion(new \DateTime("now"));

                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $em->flush();

                return $this->view('La modificacion del usuario se realizó con éxito',200);
            }
            catch(\Exception $e){
                return $this->view($e->getMessage());
            }
    }

    /**
     * @Rest\Put("/setEstado/{id}/{estado}")
     */
    public function cambiarEstadoAction(Request $request){

        try{
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
        catch(\Exception $e){
            return $this->view($e->getMessage());
        }
    }
    
    /**
     *  @Rest\Get("/getPermisosByRol/{idRol}")
     */
    public function traerPermisosRolAction(Request $request)
    {
    	$idRol=$request->get("idRol");
    	$rolRepository=$this->getDoctrine()->getRepository('AppBundle:Rol');
    	$rol=$rolRepository->find($idRol);
    	
    	return $this->view($rol->getMenus(),200);
    }
        
    /**
     *  @Rest\Post("/createPerfilLegislador")
     */
    public function crearLegisladorAction(Request $request)
    {
    	try{
    		
    		$apellidos=$request->request->get('apellidos');
    		$nombres=$request->request->get('nombres');
    		$eMail=$request->request->get('eMail');
    		$telefono=$request->request->get('telefono');
    		$oficina=$request->request->get('oficina');
    		$idBloque=$request->request->get('selBloque');
    		$desde=$request->request->get('desde');
    		$hasta=$request->request->get('hasta');
    		$archivos=$request->files->all();
    		$usuarioSesion=$this->getUser();
    		
    		$legislador=new PerfilLegislador();
    		$bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
    		$bloque=$bloqueRepository->find($idBloque);
    		$legislador->setBloque($bloque);
    		$legislador->setOficina($oficina);
    		$legislador->setApellidos($apellidos);
    		$legislador->setNombres($nombres);
    		$legislador->setTelefono($telefono);
    		$legislador->setCorreoElectronico($eMail);
    		$fechaDesde=\DateTime::createFromFormat('d/m/Y', $desde);
    		$legislador->setDesde($fechaDesde);
    		$fechaHasta=\DateTime::createFromFormat('d/m/Y', $hasta);
    		$legislador->setHasta($fechaHasta);
    		$legislador->setUsuarioCreacion($usuarioSesion->getUsername());
    		$legislador->setFechaCreacion(new \DateTime("now"));
    		
    		if(count($archivos)>0){
    			$legislador->setArchivo($archivos["uploadedFiles-0"]);
    			$legislador->setPrefijo($usuarioSesion->getUsername());
    		}
    		
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($legislador);
    		$em->flush();
    		
    		return $this->view('El legislador: '.$legislador->getNombreCompleto().', se guardo en forma exitosa',200);
    	}
    	catch(\Exception $e){
    		return $this->view($e->getMessage());
    	}
    }
    
    /**
     *  @Rest\Post("/api/usuario/updatePerfilLegislador")
     */
    public function actualizarLegisladorAction(Request $request)
    {
    	try {
    		$id=$request->request->get('id');
    		$apellidos=$request->request->get('apellidos');
    		$nombres=$request->request->get('nombres');
    		$eMail=$request->request->get('eMail');
    		$telefono=$request->request->get('telefono');
    		$oficina=$request->request->get('oficina');
    		$idBloque=$request->request->get('selBloque');
    		$desde=$request->request->get('desde');
    		$hasta=$request->request->get('hasta');
    		$archivos=$request->files->all();
    		$usuarioSesion=$this->getUser();
    		
    		$em = $this->getDoctrine()->getManager();
    		
    		$legisladorRepository=$this->getDoctrine()->getRepository('AppBundle:PerfilLegislador');
    		$legislador=$legisladorRepository->find($id);
    		$bloqueRepository=$this->getDoctrine()->getRepository('AppBundle:Bloque');
    		$bloque=$bloqueRepository->find($idBloque);
    		$legislador->setBloque($bloque);
    		$legislador->setOficina($oficina);
    		$legislador->setApellidos($apellidos);
    		$legislador->setNombres($nombres);
    		$legislador->setTelefono($telefono);
    		$legislador->setCorreoElectronico($eMail);
    		$fechaDesde=\DateTime::createFromFormat('d/m/Y', $desde);
    		$legislador->setDesde($fechaDesde);
    		$fechaHasta=\DateTime::createFromFormat('d/m/Y', $hasta);
    		$legislador->setHasta($fechaHasta);
    		$legislador->setUsuarioModificacion($usuarioSesion->getUsername());
    		$legislador->setFechaModificacion(new \DateTime("now"));
    		
    		if(count($archivos)>0){
    			$legislador->setArchivo($archivos["uploadedFiles-0"]);
    			$legislador->setPrefijo($usuarioSesion->getUsername());
    		}
    		
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($legislador);
    		$em->flush();
    		
    		return $this->view('La modificacion del usuario: '.$legislador->getNombreCompleto().' se realizó con éxito',200);
    	}
    	catch(\Exception $e){
    		return $this->view($e->getMessage());
    	}
    }
    
    /**
     * @Rest\Post("/removeImagenPerfil")
     */
    public function borrarImagenAction(Request $request)
    {
    	$key=$request->request->get("key");
    	if($key!="no-unlink-preview"){
    		
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
    }
    
}
