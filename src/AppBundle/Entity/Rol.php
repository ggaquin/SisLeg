<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Rol
 *
 * @ORM\Table(name="rol")
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Menu", orphanRemoval=true )
     * @ORM\JoinTable(name="rol_menu",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idRol", referencedColumnName="idRol")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idMenu", referencedColumnName="idMenu")
     *   }
     * )
     */
    private $menus;

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
    
    
    //-------------------------
    
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
    
    
    //------------------------
    
    /**
     * Add Menu
     *
     * @param \AppBundle\Entity\Menu $menu
     *
     * @return Rol
     */
    public function addMenu(\AppBundle\Entity\Rol $menu)
    {
    	$this->menus[] = $menu;
    	return $this;
    }
    
    /**
     * Remove menu
     *
     * @param \AppBundle\Entity\Menu $menu
     *
     * @return Rol
     */
    public function removeMenu(\AppBundle\Entity\Menu $menu)
    {
    	$this->menus->removeElement($menu);
    	return $this;
    }
    
    /**
     * Get menus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenus()
    {
    	return $this->menus;
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
