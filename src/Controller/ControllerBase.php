<?php
declare(strict_types=1);
/**
 * Description:
 * holds common functionalities for controllers
 *
 * @package App\Controller
 *
 * @copyright 2021 Data Interconnect Ltd.
 */

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ControllerBase
 *
 * @package App\Controller
 */
class ControllerBase extends AbstractController
{
    /** @var EntityManagerInterface $em */
    protected $em;

    /**
     * ControllerBase constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}
