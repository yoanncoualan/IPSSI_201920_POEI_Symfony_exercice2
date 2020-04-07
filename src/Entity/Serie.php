<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SerieRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Serie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     * @Assert\Length(
     *  min = 1,
     *  max = 255
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     */
    private $debut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *  min = 1,
     *  max = 255
     * )
     */
    private $affiche;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $nb_saisons;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="series")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(?\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    public function getAffiche(): ?string
    {
        return $this->affiche;
    }

    public function setAffiche(?string $affiche): self
    {
        $this->affiche = $affiche;

        return $this;
    }

    public function getNbSaisons(): ?int
    {
        return $this->nb_saisons;
    }

    public function setNbSaisons(int $nb_saisons): self
    {
        $this->nb_saisons = $nb_saisons;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @ORM\PostRemove
     */
    public function deleteAffiche(){
        if(file_exists(__DIR__.'/../../public/uploads/'.$this->affiche)){
            unlink(__DIR__.'/../../public/uploads/'.$this->affiche);
        }
    }
}
