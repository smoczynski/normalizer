<?php

namespace App\Entity;

use App\Entity\Base\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Category implements EntityInterface
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
     * @var int
     * @ORM\Column(type="integer")
     */
    private $courseCount;

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="category")
     */
    private $courses;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

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
     * @return int
     */
    public function getCourseCount(): int
    {
        return $this->courseCount;
    }

    /**
     * @param int $courseCount
     */
    public function setCourseCount(int $courseCount): void
    {
        $this->courseCount = $courseCount;
    }

    /**
     * @return mixed
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param mixed $courses
     */
    public function setCourses($courses): void
    {
        $this->courses = $courses;
    }
}
