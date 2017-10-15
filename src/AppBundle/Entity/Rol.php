<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Rol
 *
 * @ORM\Table(name="rol", indexes={@ORM\Index(name="rol_oficina_idx", columns={"idOficina"})})
 * @ORM\Entity
 */
class Rol
{
    //--------------------------------------atributos de la clase---------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idRol", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="rol", type="string", length=45, nullable=false)
     */
    private $rol;
    
    /**
     * @var \AppBundle\Entity\Oficina
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Oficina")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idOficina", referencedColumnName="idOficina")
     * })
     */
    private $oficina;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="oficinaObligatoria", type="boolean", nullable=false)
     */
    private $oficinaObligatoria;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", nullable=false)
     */
    private $activo;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\MenuItem", orphanRemoval=true )
     * @ORM\JoinTable(name="rol_menuItem",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idRol", referencedColumnName="idRol")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idMenuItem", referencedColumnName="idMenuItem")
     *   }
     * )
     */
    private $menuItems;
    
    //------------------------------------constructor---------------------------------------------
    
    /**
     * Constructor
     */
    public function __construct()
    {
   		$this->activo=true;
   		$this->oficinaObligatoria=true;
    	$this->menuItems= new \Doctrine\Common\Collections\ArrayCollection();
    }

    //------------------------------------setters y getters---------------------------------------

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
     * Set rol
     *
     * @param string $rol
     *
     * @return Rol
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set oficina
     *
     * @param \AppBundle\Entity\Oficina $oficina
     *
     * @return Rol
     */
    public function setOficina($oficina)
    {
    	$this->oficina = $oficina;
    	
    	return $this;
    }
    
    /**
     * Get oficina
     *
     * @return \AppBundle\Entity\Oficina
     */
    public function getOficina()
    {
    	return $this->oficina;
    }

    /**
     * Set oficinaObligatoria
     *
     * @param boolean $oficinaObligatoria
     *
     * @return Rol
     */
    public function setOficinaObligatoria($oficinaObligatoria)
    {
    	$this->oficinaObligatoria= $oficinaObligatoria;
    	
    	return $this;
    }
    
    /**
     * Get oficinaObligatoria
     *
     * @return boolean
     */
    public function getOficinaObligatoria()
    {
    	return $this->oficinaObligatoria;
    }
    
    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Rol
     */
    public function setActivo($activo)
    {
    	$this->activo= $activo;
    	
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
     * Add menuItem
     *
     * @param \AppBundle\Entity\MenuItem $menuItem
     *
     * @return Rol
     */
    public function addMenuItem(\AppBundle\Entity\MenuItem $menuItem)
    {
    	$this->menuItems[] = $menuItem;
    	return $this;
    }
    
    /**
     * Remove menuItem
     *
     * @param \AppBundle\Entity\MenuItem $menuItem
     *
     * @return Rol
     */
    public function removeMenuItem(\AppBundle\Entity\MenuItem $menuItem)
    {
    	$this->menuItems->removeElement($menuItem);
    	return $this;
    }
    
    /**
     * Get menuItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenuItems()
    {
    	return $this->menuItems;
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
        return str_replace("_"," ",substr($this->rol,5,strlen($this->rol)-5));
    }

}
