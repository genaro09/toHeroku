<?php

/**
 * Turno
 */
class turno_class
{
    /**
     * @var string
     */
    private $nombreturno;

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
    private $descanso;

    /**
     * @var string
     */
    private $hDescanso;

    /**
     * @var integer
     */
    private $idturno;

    /**
     * @var \AppBundle\Entity\Empresa
     */
    private $nitempresa;

    /**
     * @var integer
     *
     * @ORM\Column(name="$Periodo_Pago", type="integer")
     */
    private $Periodo_Pago;

    /**
     * Set nombreturno
     *
     * @param string $nombreturno
     *
     * @return Turno
     */
    public function setNombreturno($nombreturno)
    {
        $this->nombreturno = $nombreturno;

        return $this;
    }

    /**
     * Get nombreturno
     *
     * @return string
     */
    public function getNombreturno()
    {
        return $this->nombreturno;
    }



        /**
         * Set Periodo_Pago
         *
         * @param integer $Periodo_Pago
         *
         * @return Turno
         */
        public function setperiodo_Pago($Periodo_Pago)
        {
            $this->Periodo_Pago = $Periodo_Pago;

            return $this;
        }

        /**
         * Get Periodo_Pago
         *
         * @return integer
         */
        public function getperiodo_Pago()
        {
            return $this->Periodo_Pago;
        }


    /**
     * Set desde
     *
     * @param string $desde
     *
     * @return Turno
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
     * @return Turno
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
     * Set descanso
     *
     * @param integer $descanso
     *
     * @return Turno
     */
    public function setDescanso($descanso)
    {
        $this->descanso = $descanso;

        return $this;
    }

    /**
     * Get descanso
     *
     * @return integer
     */
    public function getDescanso()
    {
        return $this->descanso;
    }

    /**
     * Set hDescanso
     *
     * @param string $hDescanso
     *
     * @return Turno
     */
    public function setHDescanso($hDescanso)
    {
        $this->hDescanso = $hDescanso;

        return $this;
    }

    /**
     * Get hDescanso
     *
     * @return string
     */
    public function getHDescanso()
    {
        return $this->hDescanso;
    }

    /**
     * Get idturno
     *
     * @return integer
     */
    public function getIdturno()
    {
        return $this->idturno;
    }

    /**
     * Set nitempresa
     *
     * @param \AppBundle\Entity\Empresa $nitempresa
     *
     * @return Turno
     */
    public function setNitempresa($nitempresa)
    {
        $this->nitempresa = $nitempresa;

        return $this;
    }

    /**
     * Get nitempresa
     *
     * @return \AppBundle\Entity\Empresa
     */
    public function getNitempresa()
    {
        return $this->nitempresa;
    }
}
