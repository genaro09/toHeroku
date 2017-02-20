<?php


/**
 * ColSemanal
 */
class colSemanal_class
{
    /**
     * @var string
     */
    private $lunes;

    /**
     * @var string
     */
    private $martes;

    /**
     * @var string
     */
    private $miercoles;

    /**
     * @var string
     */
    private $jueves;

    /**
     * @var string
     */
    private $viernes;

    /**
     * @var string
     */
    private $sabado;

    /**
     * @var string
     */
    private $domingo;

    /**
     * @var integer
     */
    private $idcolSemanal;

    /**
     * @var \AppBundle\Entity\Empleado
     */
    private $numerodocumento;

    /**
     * @var \AppBundle\Entity\Semanal
     */
    private $idsemanal;


    /**
     * Set lunes
     *
     * @param string $lunes
     *
     * @return ColSemanal
     */
    public function setLunes($lunes)
    {
        $this->lunes = $lunes;

        return $this;
    }

    /**
     * Get lunes
     *
     * @return string
     */
    public function getLunes()
    {
        return $this->lunes;
    }

    /**
     * Set martes
     *
     * @param string $martes
     *
     * @return ColSemanal
     */
    public function setMartes($martes)
    {
        $this->martes = $martes;

        return $this;
    }

    /**
     * Get martes
     *
     * @return string
     */
    public function getMartes()
    {
        return $this->martes;
    }

    /**
     * Set miercoles
     *
     * @param string $miercoles
     *
     * @return ColSemanal
     */
    public function setMiercoles($miercoles)
    {
        $this->miercoles = $miercoles;

        return $this;
    }

    /**
     * Get miercoles
     *
     * @return string
     */
    public function getMiercoles()
    {
        return $this->miercoles;
    }

    /**
     * Set jueves
     *
     * @param string $jueves
     *
     * @return ColSemanal
     */
    public function setJueves($jueves)
    {
        $this->jueves = $jueves;

        return $this;
    }

    /**
     * Get jueves
     *
     * @return string
     */
    public function getJueves()
    {
        return $this->jueves;
    }

    /**
     * Set viernes
     *
     * @param string $viernes
     *
     * @return ColSemanal
     */
    public function setViernes($viernes)
    {
        $this->viernes = $viernes;

        return $this;
    }

    /**
     * Get viernes
     *
     * @return string
     */
    public function getViernes()
    {
        return $this->viernes;
    }

    /**
     * Set sabado
     *
     * @param string $sabado
     *
     * @return ColSemanal
     */
    public function setSabado($sabado)
    {
        $this->sabado = $sabado;

        return $this;
    }

    /**
     * Get sabado
     *
     * @return string
     */
    public function getSabado()
    {
        return $this->sabado;
    }

    /**
     * Set domingo
     *
     * @param string $domingo
     *
     * @return ColSemanal
     */
    public function setDomingo($domingo)
    {
        $this->domingo = $domingo;

        return $this;
    }

    /**
     * Get domingo
     *
     * @return string
     */
    public function getDomingo()
    {
        return $this->domingo;
    }

    /**
     * Get idcolSemanal
     *
     * @return integer
     */
    public function getIdcolSemanal()
    {
        return $this->idcolSemanal;
    }

    /**
     * Set numerodocumento
     *
     * @param \AppBundle\Entity\Empleado $numerodocumento
     *
     * @return ColSemanal
     */
    public function setNumerodocumento($numerodocumento)
    {
        $this->numerodocumento = $numerodocumento;

        return $this;
    }

    /**
     * Get numerodocumento
     *
     * @return \AppBundle\Entity\Empleado
     */
    public function getNumerodocumento()
    {
        return $this->numerodocumento;
    }

    /**
     * Set idsemanal
     *
     * @param \AppBundle\Entity\Semanal $idsemanal
     *
     * @return ColSemanal
     */
    public function setIdsemanal($idsemanal)
    {
        $this->idsemanal = $idsemanal;

        return $this;
    }

    /**
     * Get idsemanal
     *
     * @return \AppBundle\Entity\Semanal
     */
    public function getIdsemanal()
    {
        return $this->idsemanal;
    }
}

