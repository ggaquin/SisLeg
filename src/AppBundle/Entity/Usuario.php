<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario",
 *            indexes={@ORM\Index(name="usuario_rol_idx", columns={"idRol"})},
 *            uniqueConstraints={
 *                                @ORM\UniqueConstraint(name="UNIQ_usuario_idx", columns={"usuario"}),
 *                                @ORM\UniqueConstraint(name="UNIQ_usuario_perfil_idx", columns={"idPerfil"})
 *                      }
 *             )
 * @ORM\Entity
 */
class Usuario implements AdvancedUserInterface, EquatableInterface ,\Serializable
{
    //---------------------------------atributos de la clase-------------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idUsuario", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=70, nullable=false)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="clave", type="string", length=100, nullable=false)
     */
    private $clave;

    /**
     * @var \AppBundle\Entity\Perfil
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Perfil",cascade={"persist"}, fetch="EAGER" )
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="idPerfil", referencedColumnName="idPerfil")
     * })
     */
    private $perfil;

    /**
     * @var \AppBundle\Entity\Rol
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Rol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRol", referencedColumnName="idRol")
     * })
     */
    private $rol;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", nullable=false)
     */
    private $activo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=false)
     */
    private $fechaCreacion;


    /**
     * @var string
     *
     * @ORM\Column(name="usuarioCreacion", type="string", length=70, nullable=false)
     */
    private $usuarioCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaModificacion", type="datetime", nullable=true)
     */
    private $fechaModificacion;


    /**
     * @var string
     *
     * @ORM\Column(name="usuarioModificacion", type="string", length=70, nullable=false)
     */
    private $usuarioModificacion;

    //----------------------------------------constructor----------------------------------------

    public function __construct()
    {
        $this->activo = true;
        $this->fechaCreacion=new \DateTime("now");
    }

    //------------------------------------setters y getters--------------------------------------

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     *
     * @return Usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return Usuario
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set perfil
     *
     * @param \AppBundle\Entity\Perfil $perfil
     *
     * @return Usuario
     */
    public function setPerfil(\AppBundle\Entity\Perfil $perfil = null)
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * Get perfil
     *
     * @return \AppBundle\Entity\Perfil
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * Set rol
     *
     * @param \AppBundle\Entity\Rol $rol
     *
     * @return Usuario
     */
    public function setRol(\AppBundle\Entity\Rol $rol = null)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return \AppBundle\Entity\Rol
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Usuario
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Usuario
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Get usuarioCreacion
     *
     * @return string
     */
    public function getUsuarioCreacion()
    {
        return $this->usuarioCreacion;
    }

    /**
     * Set usuarioCreacion
     *
     * @param string $usuarioCreacion
     *
     * @return Usuario
     */
    public function setUsuarioCreacion($usuarioCreacion)
    {
        $this->usuarioCreacion = $usuarioCreacion;

        return $this;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     *
     * @return Usuario
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    /**
     * Get usuarioModificacion
     *
     * @return string
     */
    public function getUsuarioModificacion()
    {
        return $this->usuarioModificacion;
    }

    /**
     * Set usuarioModificacion
     *
     * @param string $usuarioModificacion
     *
     * @return Usuario
     */
    public function setUsuarioModificacion($usuarioModificacion)
    {
        $this->usuarioModificacion = $usuarioModificacion;

        return $this;
    }

     /**
     * Get NombreCompleto
     *
     * @return string
     */
    public function getNombreCompleto()
    {
        $objetoPerfil=$this->perfil;
        return $objetoPerfil->getNombreCompleto();
    }

    //----------------------------------propiedades virtuales------------------------------------

    /**
     * Get RolComoArray
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRolComoArray()
    {
        $objetoRol=$this->rol;
        $roles = ["0"=>$objetoRol->getRol()];
        return $roles;
    }

     /**
     * Get RolComoString
     *
     * @return string
     *
     * @VirtualProperty
     */
    public function getRolComoString()
    {
        // $objetoRol=$this->rol;
        // return substr($objetoRol->getRol(),5,strlen($objetoRol->getRol())-5);
        return $this->rol->getRolComoString();
    }
   
    // Métodos de la interfáz AdvancedUserInterface


    public function getRoles(){

    }

    public function getPassword(){
        return $this->clave;
    }

    public function getSalt(){
        return null;
    }

    public function getUsername(){
        return $this->usuario;
    }

    public function eraseCredentials(){

    }

     public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->activo;
    }

    // Método de la interfáz EquatableInterface

     public function isEqualTo(AdvancedUserInterface $usuario)
    {
        if (!$usuario instanceof Usuario) {
            return false;
        }

        if ($this->getPassword() !== $usuario->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $usuario->getSalt()) {
            return false;
        }

        if ($this->getUsername() !== $usuario->getUsername()) {
            return false;
        }

        return true;
    }

    // Métodos de la interfáz Serializable

     public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->usuario,
            $this->clave,
            $this->activo
        ));
    }
    public function unserialize($serialized)
    {
        list (
                $this->id,
                $this->usuario,
                $this->clave,
                $this->activo
        ) = unserialize($serialized);
    }



}
