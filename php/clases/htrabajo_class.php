<?php


/**
 * Htrabajo
 */
class htrabajo_class
{
    /**
     * @var string
     */
    private $desde;

    /**
     * @var string
     */
    private $hasta;

    /**
     * @var integer
     */
    private $idhtrabajo;

    /**
     * @var \AppBundle\Entity\Turno
     */
    private $idturno;

    /**
     * @var \AppBundle\Entity\Empleado
     */
    private $numerodocumento;


    /**
     * Set desde
     *
     * @param string $desde
     *
     * @return Htrabajo
     */
    public function setDesde($desde)
    {
        $this->desde = $desde;

        return $this;
    }

    /**
     * Get desde
     *
     * @return string
     */
    public function getDesde()
    {
        return $this->desde;
    }

    /**
     * Set hasta
     *
     * @param string $hasta
     *
     * @return Htrabajo
     */
    public function setHasta($hasta)
    {
        $this->hasta = $hasta;

        return $this;
    }

    /**
     * Get hasta
     *
     * @return string
     */
    public function getHasta()
    {
        return $this->hasta;
    }

    /**
     * Get idhtrabajo
     *
     * @return integer
     */
    public function getIdhtrabajo()
    {
        return $this->idhtrabajo;
    }

    /**
     * Set idturno
     *
     * @param \AppBundle\Entity\Turno $idturno
     *
     * @return Htrabajo
     */
    public function setIdturno($idturno)
    {
        $this->idturno = $idturno;

        return $this;
    }

    /**
     * Get idturno
     *
     * @return \AppBundle\Entity\Turno
     */
    public function getIdturno()
    {
        return $this->idturno;
    }

    /**
     * Set numerodocumento
     *
     * @param \AppBundle\Entity\Empleado $numerodocumento
     *
     * @return Htrabajo
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
}

