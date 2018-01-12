<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoPerfil
 *
 * @ORM\Table(name="tipoPerfil")
 * @ORM\Entity
 */
class TipoPerfil
{
    //-----------------------------------------atributos de la clase-------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idTipoPerfil", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoPerfil", type="string", length=50, nullable=false)
     */
    private $tipoPerfil;

   /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Rol",orphanRemoval=true)
     * @ORM\JoinTable(name="tipoPerfil_rol",
     *      joinColumns={@ORM\JoinColumn(name="idTipoPerfil", referencedColumnName="idTipoPerfil")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="idRol", referencedColumnName="idRol")}
     *      )
     */
    private $roles;

    //------------------------------------constructor---------------------------------------------

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    //-------------------------------------setters y getters--------------------------------------

    
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
     * Set tipoPerfil
     *
     * @param string $tipoPerfil
     *
     * @return TipoPerfil
     */
    public function setTipoPerfil($tipoPerfil)
    {
        $this->tipoPerfil = $tipoPerfil;

        return $this;
    }

    /**
     * Get tipoPerfil
     *
     * @return string
     */
    public function getTipoPerfil()
    {
        return $this->tipoPerfil;
    }


    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return TipoPerfil
     */
    public function setRoles($roles)
    {
         $collection= new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($roles as $rol) {
            $collection[]=$rol;
        }
        $this->roles = $collection;

        return $this;
    }

    /**
     * add rol
     *
     * @param \AppBundle\Entity\Rol $rol
     *
     * @return TipoPerfil
     */
    public function addRol($rol)
    {
        $this->roles[] = $rol;

        return $this;
    }

    /**
     * remove rol
     *
     * @param \AppBundle\Entity\Rol $rol
     * @return TipoPerfil
     */
    public function removeRol($rol)
    {
        $this->roles->removeElement($rol);

        return $this;
    }

    /**
     * get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }



}
