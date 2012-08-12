<?php

namespace Jazzyweb\AulasMentor\NotasFrontendBundle\Entity;

use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Nota
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\NotaRepository")
 */
class Nota {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $titulo
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string $texto
     *
     * @ORM\Column(name="texto", type="string", length=255)
     */
    private $texto;

    /**
     * @var datetime $fecha
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     */
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Set texto
     *
     * @param string $texto
     */
    public function setTexto($texto) {
        $this->texto = $texto;
    }

    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto() {
        return $this->texto;
    }

    /**
     * Set fecha
     *
     * @param datetime $fecha
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    /**
     * Get fecha
     *
     * @return datetime 
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path) {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->path;
    }

////ASOCIACIONES////

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     */
    private $usuario;

    /**
     * @ORM\ManyToMany(targetEntity="Etiqueta", inversedBy="notas")
     */
    private $etiquetas;

    ////FIN ASOCIACIONES////

    public function __construct() {
        $this->etiquetas = new ArrayCollection();
    }


    /**
     * Set usuario
     *
     * @param Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Usuario $usuario
     */
    public function setUsuario(\Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Add etiquetas
     *
     * @param Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Etiqueta $etiquetas
     */
    public function addEtiqueta(\Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Etiqueta $etiquetas)
    {
        $this->etiquetas[] = $etiquetas;
    }

    /**
     * Get etiquetas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEtiquetas()
    {
        return $this->etiquetas;
    }
}