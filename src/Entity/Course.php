<?php

namespace App\Entity;

use App\Entity\Base\EntityInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Course implements EntityInterface
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @var Language
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="courses")
     * @ORM\JoinColumn()
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="courses")
     * @ORM\JoinColumn()
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="course")
     * @ORM\JoinColumn()
     */
    private $users;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    /**
     * @param bool $isPublished
     */
    public function setIsPublished(bool $isPublished): void
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

    /**
     * @return Language
     */
    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    /**
     * @param Language $language
     */
    public function setLanguage(?Language $language): void
    {
        $this->language = $language;
    }
}
