<?php
/**
 * holds all status
 */

namespace App\Entity;

use App\Entity\Traits\Id;
use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 * @ORM\Table(name="status")
 */
class Status
{
    /** @var int[] */
    public const STATUS = [
        'active' => 1,
        'inactive' => 2,
        'archived' => 3,
        'deleted' => 4
    ];

    use Id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $name;

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
}
