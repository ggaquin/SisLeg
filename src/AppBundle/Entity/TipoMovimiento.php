<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoMovimiento
 *
 * @ORM\Table(name="tipoMovimiento")
 * @ORM\Entity
 */
class TipoMovimiento
{
    //-----------------------------------------atributos de la clase-------------------------------

    /**
     * @var integer
     *
     * @ORM\Column(name="idTipoMovimiento", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoMovimiento", type="string", length=55, nullable=false)
     */
    private $tipoMovimiento;

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
     * Set tipoMovimiento
     *
     * @param string $tipoMovimiento
     *
     * @return TipoMovimiento
     */
    public function setTipoMovimiento($tipoMovimiento)
    {
    	$this->tipoMovimiento = $tipoMovimiento;

        return $this;
    }

    /**
     * Get tipoMovimiento
     *
     * @return string
     */
    public function getTipoMovimiento()
    {
        return $this->tipoMovimiento;
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
