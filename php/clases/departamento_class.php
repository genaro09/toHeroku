<?php

class departamento_class
{
    /**
     * @var string
     *
     * @ORM\Column(name="NombreDepartamento", type="string", length=255, nullable=false)
     */
    private $nombredepartamento;

    /**
     * @var string
     *
     * @ORM\Column(name="CuentaContable", type="string", length=255, nullable=false)
     */
    private $cuentacontable;

    /**
     * @var integer
     *
     * @ORM\Column(name="idDepartamento", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddepartamento;

    /**
     * @var \AppBundle\Entity\Empresa
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Empresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="NitEmpresa", referencedColumnName="NitEmpresa")
     * })
     */
    private $nitempresa;



    /**
     * Set nombredepartamento
     *
     * @param string $nombredepartamento
     *
     * @return Departamento
     */
    public function setNombredepartamento($nombredepartamento)
    {
        $this->nombredepartamento = $nombredepartamento;

        return $this;
    }

    /**
     * Get nombredepartamento
     *
     * @return string
     */
    public function getNombredepartamento()
    {
        return $this->nombredepartamento;
    }

    /**
     * Set cuentacontable
     *
     * @param string $cuentacontable
     *
     * @return Departamento
     */
    public function setCuentacontable($cuentacontable)
    {
        $this->cuentacontable = $cuentacontable;

        return $this;
    }

    /**
     * Get cuentacontable
     *
     * @return string
     */
    public function getCuentacontable()
    {
        return $this->cuentacontable;
    }

    /**
     * Get iddepartamento
     *
     * @return integer
     */
    public function getIddepartamento()
    {
        return $this->iddepartamento;
    }

    /**
     * Set nitempresa
     *
     * @param \AppBundle\Entity\Empresa $nitempresa
     *
     * @return Departamento
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
