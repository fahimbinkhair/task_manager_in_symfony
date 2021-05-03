<?php
declare(strict_types=1);
/**
 * Description:
 *
 * @package App\Entity\Traits
 */

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait DateUpdated
 *
 * @package App\Entity\Traits
 */
trait DateUpdated
{
    /**
     * @ORM\Column(type="datetime", name="date_updated", nullable=true)
     */
    private $dateUpdated;

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->dateUpdated;
    }

    /**
     * @ORM\PreUpdate()
     * @param \DateTimeInterface|null $dateUpdated
     * @return $this
     */
    public function setDateUpdated(): self
    {
        $this->dateUpdated = new \DateTime();

        return $this;
    }
}
