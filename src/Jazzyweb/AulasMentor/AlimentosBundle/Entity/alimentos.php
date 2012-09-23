<?php

namespace Jazzyweb\AulasMentor\AlimentosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @Assert\MaxLength(255)
     */
    private $nombre;

    /**
     * @var decimal $energia
     *
     * @ORM\Column(name="energia", type="decimal")
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $energia;

    /**
     * @var decimal $proteina
     *
     * @ORM\Column(name="proteina", type="decimal")
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $proteina;

    /**
     * @var decimal $hidratocarbono
     *
     * @ORM\Column(name="hidratocarbono", type="decimal")
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $hidratocarbono;

    /**
     * @var decimal $fibra
     *
     * @ORM\Column(name="fibra", type="decimal")
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $fibra;

    /**
     * @var decimal $grasatotal
     *
     * @ORM\Column(name="grasatotal", type="decimal")
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
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

    
    // Campos virtuales para la generación de formularios con horquillas de valores
    
     /**
     * @var decimal $energia_min
     *
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $energia_min;
     /**
     * @var decimal $energia_max
     *
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $energia_max;
     /**
     * @var decimal $proteina_min
     *
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $proteina_min;
     /**
     * @var decimal $proteina_max
     *
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $proteina_max;
     /**
     * @var decimal $hidratocarbono_min
     *
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $hidratocarbono_min;
     /**
     * @var decimal $hidratocarbono_max
     *
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $hidratocarbono_max;
     /**
     * @var decimal $fibra_min
     *
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $fibra_min;
     /**
     * @var decimal $fibra_max
     *
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $fibra_max;
     /**
     * @var decimal $grasatotal_min
     *
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $grasatotal_min;
     /**
     * @var decimal $grasatotal_max
     *
     * @Assert\Type(type="numeric", message="Valor {{ value }} no es un {{ type }}.")
     */
    private $grasatotal_max;

    
    
    
    /**
     * Get energiamin
     *
     * @return decimal 
     */
    public function getEnergiaMin()
    {
        return $this->energia_min;
    }
    public function setEnergiaMin($int)
    {
        $this->energia_min=$int;
    }
    /**
     * Get energiamax
     *
     * @return decimal 
     */
    public function getEnergiaMax()
    {
        return $this->energia_max;
    }
    public function setEnergiaMax($int)
    {
        $this->energia_max=$int;
    }
    /**
     * Get proteinamin
     *
     * @return decimal 
     */
    public function getProteinaMin()
    {
        return $this->proteina_min;
    }
    /**
     * Get proteinamax
     *
     * @return decimal 
     */
    public function getProteinaMax()
    {
        return $this->proteina_max;
    }
    /**
     * Get Hidratocarbonomin
     *
     * @return decimal 
     */
    public function getHidratocarbonoMin()
    {
        return $this->hidratocarbono_min;
    }
    /**
     * Get Hidratocarbonomax
     *
     * @return decimal 
     */
    public function getHidratocarbonoMax()
    {
        return $this->hidratocarbono_max;
    }
    /**
     * Get fibramin
     *
     * @return decimal 
     */
    public function getFibraMin()
    {
        return $this->fibra_min;
    }
    /**
     * Get fibramax
     *
     * @return decimal 
     */
    public function getFibraMax()
    {
        return $this->fibra_max;
    }
    /**
     * Get grasatotalmin
     *
     * @return decimal 
     */
    public function getGrasatotalMin()
    {
        return $this->grasatotal_min;
    }
    /**
     * Get grasatotalmax
     *
     * @return decimal 
     */
    public function getGrasatotalMax()
    {
        return $this->grasatotal_max;
    }
}