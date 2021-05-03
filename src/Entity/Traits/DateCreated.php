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
 * Trait DateCreated
 *
 * @package App\Entity\Traits
 */
trait DateCreated
{
    /**
     * @ORM\Column(type="datetime", name="date_created")
     */
    private $dateCreated;

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    /**
     * @ORM\PrePersist()
     * @param \DateTimeInterface $dateCreated
     * @return $this
     */
    public function setDateCreated(): self
    {
        $this->dateCreated = new \DateTime();

        return $this;
    }
}
