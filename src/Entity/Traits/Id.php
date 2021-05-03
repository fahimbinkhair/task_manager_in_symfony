<?php
declare(strict_types=1);
/**
 * Description:
 *
 * @package App\Entity\Traits
 */

namespace App\Entity\Traits;

/**
 * Trait Id
 *
 * @package App\Entity\Traits
 */
trait Id
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
