<?php
declare(strict_types=1);
/**
 * Description:
 * holds common functionalities for all forms
 *
 * @package App\Form
 *
 * @copyright 2021 Data Interconnect Ltd.
 */

namespace App\Form;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class FormBase
 *
 * @package App\Form
 */
class FormBase
{
    /** @var Request $request */
    protected $request;

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->request->get($name);
    }

    /**
     * @param string $userInputName
     * @return \DateTime|null
     * @throws \Exception
     */
    public function getDateTime(string $userInputName): ?\DateTime
    {
        /** @var string|null $userDateTime */
        $userDateTime = $this->request->get($userInputName);

        if (empty($userDateTime)) {
            return null;
        }

        return new \DateTime($userDateTime);
    }
}
