<?php
/**
 * Description
 * handles db communication with the task table
 */
namespace App\Repository;

use App\Entity\Status;
use App\Entity\Task;
use App\Entity\User;
use App\Form\CreateTaskForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Statement;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    /**
     * TaskRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param CreateTaskForm $createTaskForm
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createOrUpdateTask(CreateTaskForm $createTaskForm): void
    {
        /** @var string|null $title */
        $title = $createTaskForm->getTitle();
        /** @var Status $statusActive */
        $statusActive = $this->_em->getReference(Status::class, Status::STATUS['active']);
        /** @var Task $task */
        $task = $this->findOneBy(['title' => $title, 'statusId' => $statusActive]);

        if ($task instanceof Task) {
            $task->setTitle($title)
                ->setDescription($createTaskForm->description)
                ->setDateFrom($createTaskForm->getDateTime('startFrom'))
                ->setDateTo($createTaskForm->getDateTime('finishAt'));
            $this->_em->flush($task);

            return;
        }

        $task = new Task();
        $task->setUserId($this->_em->getReference(User::class, 1))
             ->setTitle($title)
            ->setDescription($createTaskForm->description)
            ->setDateFrom($createTaskForm->getDateTime('startFrom'))
            ->setDateTo($createTaskForm->getDateTime('finishAt'))
            ->setStatusId($this->_em->getReference(Status::class, Status::STATUS['active']));
        $this->_em->persist($task);
        $this->_em->flush($task);
    }

    /**
     * @param int $statusId
     * @return array
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function getTasksByStatus(int $statusId): array
    {
        $conn = $this->getEntityManager()->getConnection();
        //note: running native query to make the query faster as the dql does not date-time as string
        $sql = "SELECT title, description, concat(date_from, ' to ', date_to) AS taskTime,
                IF (status_id = :status_active, 'upcoming', 'archive') AS taskAction, id
                FROM task WHERE status_id = :status_id ORDER BY date_from ASC";
        /** @var Statement $stmt */
        $stmt = $conn->prepare($sql);
        $stmt->execute(['status_active' => Status::STATUS['active'], 'status_id' => $statusId]);

        return $stmt->fetchAllAssociative();
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function archiveTask(): void
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'UPDATE task SET status_id = :archived WHERE date_to <= NOW() AND status_id = :statusActive';
        /** @var Statement $stmt */
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'archived' => Status::STATUS['archived'],
            'statusActive' => Status::STATUS['active']
        ]);
    }
}
