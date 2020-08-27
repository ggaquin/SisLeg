<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity()
 */
class Menu
{
	//-----------------------------------------atributos de la clase-------------------------------
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="idMenu", type="smallint")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="menu", type="string", length=50, nullable=false)
	 */
	private $menu; 
	
	
	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection
	 * 
	 * @ORM\OneToMany(targetEntity="\AppBundle\Entity\MenuItem", mappedBy="menu")
	 */
	private $items;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="abreviacion", type="string", length=70, nullable=false)
	 */
	private $abreviacion;
	
	//------------------------------------constructor---------------------------------------------
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->items = new \Doctrine\Common\Collections\ArrayCollection();
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
	 * Set menu
	 *
	 * @param string $menu
	 *
	 * @return Menu
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
	 * Add item
	 *
	 * @param \AppBundle\Entity\MenuItem $item
	 *
	 * @return Menu
	 */
	public function addItem(\AppBundle\Entity\MenuItem $item)
	{
		$item->setMenu($this);
		$this->items[] = $item;
		
		return $this;
	}
	
	/**
	 * Remove item
	 *
	 * @param \AppBundle\Entity\MenuItem $item
	 */
	public function removeItem(\AppBundle\Entity\MenuItem $item)
	{
		$this->items->removeElement($item);
	}
	
	/**
	 * Get items
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getItems()
	{
		return $this->items;
	}
	
	/**
	 * Set abreviacion
	 *
	 * @param string $abreviacion
	 *
	 * @return Menu
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
