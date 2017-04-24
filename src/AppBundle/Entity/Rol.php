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
