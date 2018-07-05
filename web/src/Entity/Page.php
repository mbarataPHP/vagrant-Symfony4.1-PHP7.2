<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 * @ORM\Table(name="page")
 * @ORM\HasLifecycleCallbacks()
 */
class Page
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Cette valeur ne doit pas être vide.")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le titre doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le titre ne peut pas dépasser les {{ limit }} caractères"
     * )
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="page")
     * @var ArrayCollection
     */
    private $articles;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="pages")
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    private $user;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * @VirtualProperty
     * @SerializedName("info")
     *
     * @return null|string
     */
    public function getInfo(){

        if($this->articles->count()>0){

            return $this->articles->get(0)->getDescription();

        }else{

            return null;

        }
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }


    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }


    /**
     * @return Collection
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }




    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}