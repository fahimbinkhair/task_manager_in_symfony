<?php

namespace App\Entity;

use App\Entity\Traits\DateCreated;
use App\Entity\Traits\DateUpdated;
use App\Entity\Traits\Id;
use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="task",
 *     indexes={@ORM\Index(name="index_title", columns={"title"})}
 * )
 */
class Task
{
    use Id, DateCreated, DateUpdated;

    /**
     * @ORM\Column(type="string", name="title", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", name="description", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", name="date_from")
     */
    private $dateFrom;

    /**
     * @ORM\Column(type="datetime", name="date_to", nullable=true)
     */
    private $dateTo;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class)
     * @ORM\JoinColumn(nullable=false, name="status_id")
     */
    private $statusId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false, name="user_id")
     */
    private $userId;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateFrom(): ?\DateTimeInterface
    {
        return $this->dateFrom;
    }

    /**
     * @param \DateTimeInterface $dateFrom
     * @return $this
     */
    public function setDateFrom(\DateTimeInterface $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateTo(): ?\DateTimeInterface
    {
        return $this->dateTo;
    }

    /**
     * @param \DateTimeInterface|null $dateTo
     * @return $this
     */
    public function setDateTo(?\DateTimeInterface $dateTo): self
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    public function getStatusId(): ?Status
    {
        return $this->statusId;
    }

    public function setStatusId(?Status $statusId): self
    {
        $this->statusId = $statusId;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
