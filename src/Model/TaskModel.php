<?php
declare(strict_types=1);
/**
 * Description:
 * holds business logic related to the task table
 *
 * @package App\Model
 */

namespace App\Model;

use App\Entity\Status;
use App\Entity\Task;
use App\Repository\TaskRepository;

/**
 * Class TaskModel
 *
 * @package App\Model
 */
class TaskModel extends BaseModel
{
    /**
     * @param string $taskType
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function getTaskByType(string $taskType): array
    {
        $status = 0;
        switch ($taskType) {
            case 'upcoming':
                $status = Status::STATUS['active'];
                break;
            case 'archived':
                $status = Status::STATUS['archived'];
                break;
            default:
                throw new \Exception("Can not identify task type '$taskType'");
        }

        /** @var TaskRepository $taskRepository */
        $taskRepository = $this->em->getRepository(Task::class);
        $taskRepository->archiveTask();

        return $taskRepository->getTasksByStatus($status);
    }
}
