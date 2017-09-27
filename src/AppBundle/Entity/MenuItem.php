<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuItem
 *
 * @ORM\Table(name="menuItem", indexes={@ORM\Index(name="menuitem_menu_idx",columns={"idMenu"})})
 * @ORM\Entity()
 */
class MenuItem
{
	//-----------------------------------------atributos de la clase-------------------------------
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idMenuItem", type="smallint")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @var \AppBundle\Entity\Menu
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Menu", inversedBy="items")
	 * @ORM\JoinColumns({
	 *  @ORM\JoinColumn(name="idMenu", referencedColumnName="idMenu")
	 * })
	 */
	private $menu;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="menuItem", type="string", length=50, nullable=false)
	 */
	private $menuItem;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="abreviacion", type="string", length=70, nullable=false)
	 */
	private $abreviacion;
	
	
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
	 * Set menu
	 *
	 * @param \AppBundle\Entity\Menu
	 *
	 * @return MenuItem
	 */
	public function setMenu($menu)
	{
		$this->menu = $menu;
		
		return $this;
	}
	
	/**
	 * Get menu
	 *
	 * @return string
	 */
	public function getMenu()
	{
		return $this->menu;
	}
	
	/**
	 * Set menuItem
	 *
	 * @param string $menuItem
	 *
	 * @return MenuItem
	 */
	public function setMenuItem($menuItem)
	{
		$this->menuItem = $menuItem;
		
		return $this;
	}
	
	/**
	 * Get menuItem
	 *	
	 * @return string
	 */
	public function getMenuItem()
	{
		return $this->menuItem;
	}
	
	/**
	 * Set abreviacion
	 *
	 * @param string $abreviacion
	 *
	 * @return MenuItem
	 */
	public function setAbreviacion($abreviacion)
	{
		$this->abreviacion= $abreviacion;
		
		return $this;
	}
	
	/**
	 * Get abreviacion
	 *
	 * @return string
	 */
	public function getAbreviacion()
	{
		return $this->abreviacion;
	}
	
}
