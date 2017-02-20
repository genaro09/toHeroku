<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity
 */
class Empresa
{
    /**
     * @var string
     *
     * @ORM\Column(name="NombreEmpresa", type="string", length=255, nullable=false)
     */
    private $nombreempresa;

    /**
     * @var string
     *
     * @ORM\Column(name="Direccion", type="string", length=255, nullable=false)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="Telefono", type="string", length=80, nullable=false)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="Telefono2", type="string", length=30, nullable=false)
     */
    private $telefono2;

    /**
     * @var string
     *
     * @ORM\Column(name="NRegistro", type="string", length=40, nullable=false)
     */
    private $nregistro;

    /**
     * @var string
     *
     * @ORM\Column(name="Giro", type="string", length=255, nullable=false)
     */
    private $giro;

    /**
     * @var string
     *
     * @ORM\Column(name="NPatronalSS", type="string", length=13, nullable=false)
     */
    private $npatronalss;

    /**
     * @var string
     *
     * @ORM\Column(name="NPatronalAFP", type="string", length=30, nullable=false)
     */
    private $npatronalafp;

    /**
     * @var string
     *
     * @ORM\Column(name="RepresentanteLegal", type="string", length=255, nullable=false)
     */
    private $representantelegal;

    /**
     * @var string
     *
     * @ORM\Column(name="NitEmpresa", type="string", length=14)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nitempresa;



    /**
     * Set nombreempresa
     *
     * @param string $nombreempresa
     *
     * @return Empresa
     */
    public function setNombreempresa($nombreempresa)
    {
        $this->nombreempresa = $nombreempresa;

        return $this;
    }

    /**
     * Get nombreempresa
     *
     * @return string
     */
    public function getNombreempresa()
    {
        return $this->nombreempresa;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Empresa
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Empresa
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set telefono2
     *
     * @param string $telefono2
     *
     * @return Empresa
     */
    public function setTelefono2($telefono2)
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    /**
     * Get telefono2
     *
     * @return string
     */
    public function getTelefono2()
    {
        return $this->telefono2;
    }

    /**
     * Set nregistro
     *
     * @param string $nregistro
     *
     * @return Empresa
     */
    public function setNregistro($nregistro)
    {
        $this->nregistro = $nregistro;

        return $this;
    }

    /**
     * Get nregistro
     *
     * @return string
     */
    public function getNregistro()
    {
        return $this->nregistro;
    }

    /**
     * Set giro
     *
     * @param string $giro
     *
     * @return Empresa
     */
    public function setGiro($giro)
    {
        $this->giro = $giro;

        return $this;
    }

    /**
     * Get giro
     *
     * @return string
     */
    public function getGiro()
    {
        return $this->giro;
    }

    /**
     * Set npatronalss
     *
     * @param string $npatronalss
     *
     * @return Empresa
     */
    public function setNpatronalss($npatronalss)
    {
        $this->npatronalss = $npatronalss;

        return $this;
    }

    /**
     * Get npatronalss
     *
     * @return string
     */
    public function getNpatronalss()
    {
        return $this->npatronalss;
    }

    /**
     * Set npatronalafp
     *
     * @param string $npatronalafp
     *
     * @return Empresa
     */
    public function setNpatronalafp($npatronalafp)
    {
        $this->npatronalafp = $npatronalafp;

        return $this;
    }

    /**
     * Get npatronalafp
     *
     * @return string
     */
    public function getNpatronalafp()
    {
        return $this->npatronalafp;
    }

    /**
     * Set representantelegal
     *
     * @param string $representantelegal
     *
     * @return Empresa
     */
    public function setRepresentantelegal($representantelegal)
    {
        $this->representantelegal = $representantelegal;

        return $this;
    }

    /**
     * Get representantelegal
     *
     * @return string
     */
    public function getRepresentantelegal()
    {
        return $this->representantelegal;
    }

    /**
     * Get nitempresa
     *
     * @return string
     */
    public function getNitempresa()
    {
        return $this->nitempresa;
    }
}
