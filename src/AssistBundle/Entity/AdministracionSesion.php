<?php

namespace AssistBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdministracionSesion
 *
 * @ORM\Table(name="administracion_sesion")
 * @ORM\Entity
 */
class AdministracionSesion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sectionId", type="integer", nullable=false)
     */
    private $sectionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="elementId", type="integer", nullable=false)
     */
    private $elementId;

    /**
     * @var integer
     *
     * @ORM\Column(name="timeId", type="integer", nullable=false)
     */
    private $timeId;

    /**
     * @var string
     *
     * @ORM\Column(name="idBloque", type="string", length=50)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;



    /**
     * Set sectionId
     *
     * @param int $sectionId
     *
     * @return AdministracionSesion
     */
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;

        return $this;
    }

    /**
     * Get sectionId
     *
     * @return integer
     */
    public function getSectionId()
    {
        return $this->sectionId;
    }

    /**
     * Set elementId
     *
     * @param int $elementId
     *
     * @return AdministracionSesion
     */
    public function setElementId($elementId)
    {
        $this->elementId = $elementId;

        return $this;
    }

    /**
     * Get elementId
     *
     * @return integer
     */
    public function getElementId()
    {
        return $this->elementId;
    }

    /**
     * Set timeId
     *
     * @param int $timeId
     *
     * @return AdministracionSesion
     */
    public function setTimeId($timeId)
    {
        $this->timeId = $timeId;

        return $this;
    }

    /**
     * Get timeId
     *
     * @return integer
     */
    public function getTimeId()
    {
        return $this->timeId;
    }

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
     * Set id
     *
     * @param int $id
     *
     * @return string
     */
    public function setId($id)
    {
        $this->id=$id;

        return $this;
    }
}



