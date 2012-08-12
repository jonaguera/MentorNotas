<?php

namespace Jazzyweb\AulasMentor\AlimentosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jazzyweb\AulasMentor\AlimentosBundle\Entity\alimentos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Jazzyweb\AulasMentor\AlimentosBundle\Entity\alimentosRepository")
 */
class alimentos
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var decimal $energia
     *
     * @ORM\Column(name="energia", type="decimal")
     */
    private $energia;

    /**
     * @var decimal $proteina
     *
     * @ORM\Column(name="proteina", type="decimal")
     */
    private $proteina;

    /**
     * @var decimal $hidratocarbono
     *
     * @ORM\Column(name="hidratocarbono", type="decimal")
     */
    private $hidratocarbono;

    /**
     * @var decimal $fibra
     *
     * @ORM\Column(name="fibra", type="decimal")
     */
    private $fibra;

    /**
     * @var decimal $grasatotal
     *
     * @ORM\Column(name="grasatotal", type="decimal")
     */
    private $grasatotal;


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
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set energia
     *
     * @param decimal $energia
     */
    public function setEnergia($energia)
    {
        $this->energia = $energia;
    }

    /**
     * Get energia
     *
     * @return decimal 
     */
    public function getEnergia()
    {
        return $this->energia;
    }

    /**
     * Set proteina
     *
     * @param decimal $proteina
     */
    public function setProteina($proteina)
    {
        $this->proteina = $proteina;
    }

    /**
     * Get proteina
     *
     * @return decimal 
     */
    public function getProteina()
    {
        return $this->proteina;
    }

    /**
     * Set hidratocarbono
     *
     * @param decimal $hidratocarbono
     */
    public function setHidratocarbono($hidratocarbono)
    {
        $this->hidratocarbono = $hidratocarbono;
    }

    /**
     * Get hidratocarbono
     *
     * @return decimal 
     */
    public function getHidratocarbono()
    {
        return $this->hidratocarbono;
    }

    /**
     * Set fibra
     *
     * @param decimal $fibra
     */
    public function setFibra($fibra)
    {
        $this->fibra = $fibra;
    }

    /**
     * Get fibra
     *
     * @return decimal 
     */
    public function getFibra()
    {
        return $this->fibra;
    }

    /**
     * Set grasatotal
     *
     * @param decimal $grasatotal
     */
    public function setGrasatotal($grasatotal)
    {
        $this->grasatotal = $grasatotal;
    }

    /**
     * Get grasatotal
     *
     * @return decimal 
     */
    public function getGrasatotal()
    {
        return $this->grasatotal;
    }
}