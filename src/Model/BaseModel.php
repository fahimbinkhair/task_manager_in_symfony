<?php
declare(strict_types=1);
/**
 * Description:
 * holds common functionalities for models
 *
 * @package App\Model
 *
 * @copyright 2021 Data Interconnect Ltd.
 */

namespace App\Model;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class BaseModel
 *
 * @package App\Model
 */
class BaseModel
{
    /** @var EntityManagerInterface $em */
    protected $em;

    /**
     * BaseModel constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}
