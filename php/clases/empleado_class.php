<?php

class empleado_class
{
    /**
     * @var string
     */
    private $pass;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var string
     */
    private $nup;

    /**
     * @var string
     */
    private $institucionprevisional;

    /**
     * @var string
     */
    private $primernombre;

    /**
     * @var string
     */
    private $segundonombre;

    /**
     * @var string
     */
    private $primerapellido;

    /**
     * @var string
     */
    private $segundoapellido;

    /**
     * @var string
     */
    private $apellidocasada;

    /**
     * @var string
     */
    private $conocidopor;

    /**
     * @var string
     */
    private $tipodocumento;

    /**
     * @var string
     */
    private $numerodocumento;

    /**
     * @var string
     */
    private $nit;

    /**
     * @var string
     */
    private $numeroisss;

    /**
     * @var string
     */
    private $numeroinpep;

    /**
     * @var string
     */
    private $genero;

    /**
     * @var string
     */
    private $nacionalidad;

    /**
     * @var string
     */
    private $salarionominal;

    /**
     * @var string
     */
    private $fechanacimiento;

    /**
     * @var string
     */
    private $estadocivil;

    /**
     * @var string
     */
    private $direccion;

    /**
     * @var string
     */
    private $departamento;

    /**
     * @var string
     */
    private $municipio;

    /**
     * @var string
     */
    private $numerotelefonico;

    /**
     * @var string
     */
    private $correoelectronico;

    /**
     * @var string
     */
    private $tipoempleado;

    /**
     * @var string
     */
    private $fechaingreso;

    /**
     * @var string
     */
    private $fecharetiro;

    /**
     * @var string
     */
    private $fechafallecimiento;

    /**
     * @var integer
     */
    private $idempleado;

    /**
     * @var \AppBundle\Entity\Cargos
     */
    private $idcargos;


    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return Empleado
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Empleado
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set nup
     *
     * @param string $nup
     *
     * @return Empleado
     */
    public function setNup($nup)
    {
        $this->nup = $nup;

        return $this;
    }

    /**
     * Get nup
     *
     * @return string
     */
    public function getNup()
    {
        return $this->nup;
    }

    /**
     * Set institucionprevisional
     *
     * @param string $institucionprevisional
     *
     * @return Empleado
     */
    public function setInstitucionprevisional($institucionprevisional)
    {
        $this->institucionprevisional = $institucionprevisional;

        return $this;
    }

    /**
     * Get institucionprevisional
     *
     * @return string
     */
    public function getInstitucionprevisional()
    {
        return $this->institucionprevisional;
    }

    /**
     * Set primernombre
     *
     * @param string $primernombre
     *
     * @return Empleado
     */
    public function setPrimernombre($primernombre)
    {
        $this->primernombre = $primernombre;

        return $this;
    }

    /**
     * Get primernombre
     *
     * @return string
     */
    public function getPrimernombre()
    {
        return $this->primernombre;
    }

    /**
     * Set segundonombre
     *
     * @param string $segundonombre
     *
     * @return Empleado
     */
    public function setSegundonombre($segundonombre)
    {
        $this->segundonombre = $segundonombre;

        return $this;
    }

    /**
     * Get segundonombre
     *
     * @return string
     */
    public function getSegundonombre()
    {
        return $this->segundonombre;
    }

    /**
     * Set primerapellido
     *
     * @param string $primerapellido
     *
     * @return Empleado
     */
    public function setPrimerapellido($primerapellido)
    {
        $this->primerapellido = $primerapellido;

        return $this;
    }

    /**
     * Get primerapellido
     *
     * @return string
     */
    public function getPrimerapellido()
    {
        return $this->primerapellido;
    }

    /**
     * Set segundoapellido
     *
     * @param string $segundoapellido
     *
     * @return Empleado
     */
    public function setSegundoapellido($segundoapellido)
    {
        $this->segundoapellido = $segundoapellido;

        return $this;
    }

    /**
     * Get segundoapellido
     *
     * @return string
     */
    public function getSegundoapellido()
    {
        return $this->segundoapellido;
    }

    /**
     * Set apellidocasada
     *
     * @param string $apellidocasada
     *
     * @return Empleado
     */
    public function setApellidocasada($apellidocasada)
    {
        $this->apellidocasada = $apellidocasada;

        return $this;
    }

    /**
     * Get apellidocasada
     *
     * @return string
     */
    public function getApellidocasada()
    {
        return $this->apellidocasada;
    }

    /**
     * Set conocidopor
     *
     * @param string $conocidopor
     *
     * @return Empleado
     */
    public function setConocidopor($conocidopor)
    {
        $this->conocidopor = $conocidopor;

        return $this;
    }

    /**
     * Get conocidopor
     *
     * @return string
     */
    public function getConocidopor()
    {
        return $this->conocidopor;
    }

    /**
     * Set tipodocumento
     *
     * @param string $tipodocumento
     *
     * @return Empleado
     */
    public function setTipodocumento($tipodocumento)
    {
        $this->tipodocumento = $tipodocumento;

        return $this;
    }

    /**
     * Get tipodocumento
     *
     * @return string
     */
    public function getTipodocumento()
    {
        return $this->tipodocumento;
    }

    /**
     * Set numerodocumento
     *
     * @param string $numerodocumento
     *
     * @return Empleado
     */
    public function setNumerodocumento($numerodocumento)
    {
        $this->numerodocumento = $numerodocumento;

        return $this;
    }

    /**
     * Get numerodocumento
     *
     * @return string
     */
    public function getNumerodocumento()
    {
        return $this->numerodocumento;
    }

    /**
     * Set nit
     *
     * @param string $nit
     *
     * @return Empleado
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set numeroisss
     *
     * @param string $numeroisss
     *
     * @return Empleado
     */
    public function setNumeroisss($numeroisss)
    {
        $this->numeroisss = $numeroisss;

        return $this;
    }

    /**
     * Get numeroisss
     *
     * @return string
     */
    public function getNumeroisss()
    {
        return $this->numeroisss;
    }

    /**
     * Set numeroinpep
     *
     * @param string $numeroinpep
     *
     * @return Empleado
     */
    public function setNumeroinpep($numeroinpep)
    {
        $this->numeroinpep = $numeroinpep;

        return $this;
    }

    /**
     * Get numeroinpep
     *
     * @return string
     */
    public function getNumeroinpep()
    {
        return $this->numeroinpep;
    }

    /**
     * Set genero
     *
     * @param string $genero
     *
     * @return Empleado
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return string
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set nacionalidad
     *
     * @param string $nacionalidad
     *
     * @return Empleado
     */
    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    /**
     * Get nacionalidad
     *
     * @return string
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Set salarionominal
     *
     * @param string $salarionominal
     *
     * @return Empleado
     */
    public function setSalarionominal($salarionominal)
    {
        $this->salarionominal = $salarionominal;

        return $this;
    }

    /**
     * Get salarionominal
     *
     * @return string
     */
    public function getSalarionominal()
    {
        return $this->salarionominal;
    }

    /**
     * Set fechanacimiento
     *
     * @param string $fechanacimiento
     *
     * @return Empleado
     */
    public function setFechanacimiento($fechanacimiento)
    {
        $this->fechanacimiento = $fechanacimiento;

        return $this;
    }

    /**
     * Get fechanacimiento
     *
     * @return string
     */
    public function getFechanacimiento()
    {
        return $this->fechanacimiento;
    }

    /**
     * Set estadocivil
     *
     * @param string $estadocivil
     *
     * @return Empleado
     */
    public function setEstadocivil($estadocivil)
    {
        $this->estadocivil = $estadocivil;

        return $this;
    }

    /**
     * Get estadocivil
     *
     * @return string
     */
    public function getEstadocivil()
    {
        return $this->estadocivil;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Empleado
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set departamento
     *
     * @param string $departamento
     *
     * @return Empleado
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return string
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Set municipio
     *
     * @param string $municipio
     *
     * @return Empleado
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return string
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set numerotelefonico
     *
     * @param string $numerotelefonico
     *
     * @return Empleado
     */
    public function setNumerotelefonico($numerotelefonico)
    {
        $this->numerotelefonico = $numerotelefonico;

        return $this;
    }

    /**
     * Get numerotelefonico
     *
     * @return string
     */
    public function getNumerotelefonico()
    {
        return $this->numerotelefonico;
    }

    /**
     * Set correoelectronico
     *
     * @param string $correoelectronico
     *
     * @return Empleado
     */
    public function setCorreoelectronico($correoelectronico)
    {
        $this->correoelectronico = $correoelectronico;

        return $this;
    }

    /**
     * Get correoelectronico
     *
     * @return string
     */
    public function getCorreoelectronico()
    {
        return $this->correoelectronico;
    }

    /**
     * Set tipoempleado
     *
     * @param string $tipoempleado
     *
     * @return Empleado
     */
    public function setTipoempleado($tipoempleado)
    {
        $this->tipoempleado = $tipoempleado;

        return $this;
    }

    /**
     * Get tipoempleado
     *
     * @return string
     */
    public function getTipoempleado()
    {
        return $this->tipoempleado;
    }

    /**
     * Set fechaingreso
     *
     * @param string $fechaingreso
     *
     * @return Empleado
     */
    public function setFechaingreso($fechaingreso)
    {
        $this->fechaingreso = $fechaingreso;

        return $this;
    }

    /**
     * Get fechaingreso
     *
     * @return string
     */
    public function getFechaingreso()
    {
        return $this->fechaingreso;
    }

    /**
     * Set fecharetiro
     *
     * @param string $fecharetiro
     *
     * @return Empleado
     */
    public function setFecharetiro($fecharetiro)
    {
        $this->fecharetiro = $fecharetiro;

        return $this;
    }

    /**
     * Get fecharetiro
     *
     * @return string
     */
    public function getFecharetiro()
    {
        return $this->fecharetiro;
    }

    /**
     * Set fechafallecimiento
     *
     * @param string $fechafallecimiento
     *
     * @return Empleado
     */
    public function setFechafallecimiento($fechafallecimiento)
    {
        $this->fechafallecimiento = $fechafallecimiento;

        return $this;
    }

    /**
     * Get fechafallecimiento
     *
     * @return string
     */
    public function getFechafallecimiento()
    {
        return $this->fechafallecimiento;
    }

    /**
     * Get idempleado
     *
     * @return integer
     */
    public function getIdempleado()
    {
        return $this->idempleado;
    }

    /**
     * Set idempleado
     *
     * @param integer $idempleado
     *
     * @return Empleado
     */
    public function setIdempleado($idempleado)
    {
        $this->idempleado = $idempleado;

        return $this;
    }




    /**
     * Set idcargos
     *
     * @param \AppBundle\Entity\Cargos $idcargos
     *
     * @return Empleado
     */
    public function setIdcargos($idcargos)
    {
        $this->idcargos = $idcargos;

        return $this;
    }

    /**
     * Get idcargos
     *
     * @return \AppBundle\Entity\Cargos
     */
    public function getIdcargos()
    {
        return $this->idcargos;
    }
}
