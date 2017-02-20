<?php

class cargos_class
{
    /**
     * @var string
     *
     * @ORM\Column(name="NombreCargo", type="string", length=155, nullable=false)
     */
    private $nombrecargo;

    /**
     * @var string
     *
     * @ORM\Column(name="Descripcion", type="string", length=255, nullable=false)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="PEmpleado", type="integer", nullable=true)
     */
    private $pempleado;

    /**
     * @var integer
     *
     * @ORM\Column(name="PPlanilla", type="integer", nullable=true)
     */
    private $pplanilla;

    /**
     * @var integer
     *
     * @ORM\Column(name="PJefe", type="integer", nullable=true)
     */
    private $pjefe;

    /**
     * @var integer
     *
     * @ORM\Column(name="idCargos", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcargos;

    /**
     * @var \AppBundle\Entity\Departamento
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Departamento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idDepartamento", referencedColumnName="idDepartamento")
     * })
     */
    private $iddepartamento;



    /**
     * Set nombrecargo
     *
     * @param string $nombrecargo
     *
     * @return Cargos
     */
    public function setNombrecargo($nombrecargo)
    {
        $this->nombrecargo = $nombrecargo;

        return $this;
    }

    /**
     * Get nombrecargo
     *
     * @return string
     */
    public function getNombrecargo()
    {
        return $this->nombrecargo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Cargos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set pempleado
     *
     * @param integer $pempleado
     *
     * @return Cargos
     */
    public function setPempleado($pempleado)
    {
        $this->pempleado = $pempleado;

        return $this;
    }

    /**
     * Get pempleado
     *
     * @return integer
     */
    public function getPempleado()
    {
        return $this->pempleado;
    }

    /**
     * Set pplanilla
     *
     * @param integer $pplanilla
     *
     * @return Cargos
     */
    public function setPplanilla($pplanilla)
    {
        $this->pplanilla = $pplanilla;

        return $this;
    }

    /**
     * Get pplanilla
     *
     * @return integer
     */
    public function getPplanilla()
    {
        return $this->pplanilla;
    }

    /**
     * Set pjefe
     *
     * @param integer $pjefe
     *
     * @return Cargos
     */
    public function setPjefe($pjefe)
    {
        $this->pjefe = $pjefe;

        return $this;
    }

    /**
     * Get pjefe
     *
     * @return integer
     */
    public function getPjefe()
    {
        return $this->pjefe;
    }

    /**
     * Get idcargos
     *
     * @return integer
     */
    public function getIdcargos()
    {
        return $this->idcargos;
    }

    /**
     * Set iddepartamento
     *
     * @param \AppBundle\Entity\Departamento $iddepartamento
     *
     * @return Cargos
     */
    public function setIddepartamento($iddepartamento)
    {
        $this->iddepartamento = $iddepartamento;

        return $this;
    }

    /**
     * Get iddepartamento
     *
     * @return \AppBundle\Entity\Departamento
     */
    public function getIddepartamento()
    {
        return $this->iddepartamento;
    }
}
