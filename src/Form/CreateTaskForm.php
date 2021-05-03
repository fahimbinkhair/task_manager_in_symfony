<?php
declare(strict_types=1);
/**
 * Description:
 * validation routine for user input data to create a new task
 *
 * @package App\Form
 *
 * @copyright 2021 Data Interconnect Ltd.
 */

namespace App\Form;

/**
 * Class CreateTaskForm
 *
 * @package App\Form
 */
class CreateTaskForm extends FormBase
{
    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        /** @var string|null $title */
       $title = $this->request->get('title');

       return empty($title) ? null : $title;
    }
}
