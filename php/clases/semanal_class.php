<?php


/**
 * Semanal
 */
class semanal_class
{
    /**
     * @var integer
     */
    private $idturno;

    /**
     * @var integer
     */
    private $nsemana;

    /**
     * @var \DateTime
     */
    private $anno;

    /**
     * @var integer
     */
    private $idsemanal;

    /**
     * @var \AppBundle\Entity\Empresa
     */
    private $nitempresa;


    /**
     * Set idturno
     *
     * @param integer $idturno
     *
     * @return Semanal
     */
    public function setIdturno($idturno)
    {
        $this->idturno = $idturno;

        return $this;
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
     * Set nsemana
     *
     * @param integer $nsemana
     *
     * @return Semanal
     */
    public function setNsemana($nsemana)
    {
        $this->nsemana = $nsemana;

        return $this;
    }

    /**
     * Get nsemana
     *
     * @return integer
     */
    public function getNsemana()
    {
        return $this->nsemana;
    }

    /**
     * Set anno
     *
     * @param \DateTime $anno
     *
     * @return Semanal
     */
    public function setAnno($anno)
    {
        $this->anno = $anno;

        return $this;
    }

    /**
     * Get anno
     *
     * @return \DateTime
     */
    public function getAnno()
    {
        return $this->anno;
    }

    /**
     * Get idsemanal
     *
     * @return integer
     */
    public function getIdsemanal()
    {
        return $this->idsemanal;
    }

    /**
     * Set nitempresa
     *
     * @param \AppBundle\Entity\Empresa $nitempresa
     *
     * @return Semanal
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

