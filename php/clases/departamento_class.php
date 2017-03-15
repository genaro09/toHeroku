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
     * @var string
     *
     * @ORM\Column(name="idCod_Municipio", type="string", length=10, nullable=false)
     */
    private $idCod_Municipio;

    /**
     * @var integer
     *
     * @ORM\Column(name="$idSalario_Minimo", type="integer")
     */
    private $idSalario_Minimo;



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
     * Set idCod_Municipio
     *
     * @param string $idCod_Municipio
     *
     * @return Departamento
     */
    public function setIdCod_Municipio($idCod_Municipio)
    {
        $this->idCod_Municipio = $idCod_Municipio;

        return $this;
    }

    /**
     * Get idCod_Municipio
     *
     * @return string
     */
    public function getIdCod_Municipio()
    {
        return $this->idCod_Municipio;
    }

    /**
     * Set idSalario_Minimo
     *
     * @param integer $idSalario_Minimo
     *
     * @return Departamento
     */
    public function setidSalario_Minimo($idSalario_Minimo)
    {
        $this->idSalario_Minimo = $idSalario_Minimo;

        return $this;
    }

    /**
     * Get idSalario_Minimo
     *
     * @return integer
     */
    public function getidSalario_Minimo()
    {
        return $this->idSalario_Minimo;
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
