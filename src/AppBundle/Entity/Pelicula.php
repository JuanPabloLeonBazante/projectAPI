<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pelicula
 *
 * @ORM\Table(name="pelicula")
 * @ORM\Entity
 */
class Pelicula
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $descripcion;

    /**
     * @var \AppBundle\Entity\Categoria
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categoria", inversedBy="peliculas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * })
     */
    private $categoria;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Actor", inversedBy="peliculas")
     * @ORM\JoinTable(name="pelicula_actor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="pelicula_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="actor_id", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    private $actors;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actors = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     *
     * @return Pelicula
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Pelicula
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
     * Set categoria
     *
     * @param \AppBundle\Entity\Categoria $categoria
     *
     * @return Pelicula
     */
    public function setCategoria(\AppBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \AppBundle\Entity\Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Add actor
     *
     * @param \AppBundle\Entity\Actor $actor
     *
     * @return Pelicula
     */
    public function addActor(\AppBundle\Entity\Actor $actor)
    {
        $this->actors[] = $actor;

        return $this;
    }

    /**
     * Remove actor
     *
     * @param \AppBundle\Entity\Actor $actor
     */
    public function removeActor(\AppBundle\Entity\Actor $actor)
    {
        $this->actors->removeElement($actor);
    }

    /**
     * Get actors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActors()
    {
        return $this->actors;
    }
}

