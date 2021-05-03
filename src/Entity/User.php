<?php
/**
 * User entity
 *
 * @package App\Entity
 */
namespace App\Entity;

use App\Entity\Traits\DateCreated;
use App\Entity\Traits\DateUpdated;
use App\Entity\Traits\Id;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="user")
 */
class User
{
    use Id, DateCreated, DateUpdated;

    /**
     * @ORM\Column(type="string", name="email", length=99)
     */
    private $email;

    /**
     * @ORM\Column(type="string", name="name", length=99)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="userId")
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    /**
     * @param Task $task
     * @return $this
     */
    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setUserId($this);
        }

        return $this;
    }

    /**
     * @param Task $task
     * @return $this
     */
    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getUserId() === $this) {
                $task->setUserId(null);
            }
        }

        return $this;
    }
}
