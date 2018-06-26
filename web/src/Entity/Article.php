<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @ORM\Table(name="article")
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Cette valeur ne doit pas être vide.")
     * @ORM\Column(type="text")
     * @var string
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Page", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @var Page
     */
    private $page;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     * @var \DateTime
     */
    private $createdAt;

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
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
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
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * @param Page $page
     * @return Article
     */
    public function setPage(Page $page): self
    {
        $this->page = $page;

        return $this;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Article
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
