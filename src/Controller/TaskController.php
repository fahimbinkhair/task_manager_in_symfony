<?php
/**
 * controller for managing tasks
 *
 * @package App\Controller
 *
 * @copyright TBP
 */

namespace App\Controller;

use App\Entity\Status;
use App\Entity\Task;
use App\Form\CreateTaskForm;
use App\Model\TaskModel;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 *
 * @package App\Controller
 */
class TaskController extends ControllerBase
{
    /** @var TaskRepository $taskRepository */
    private $taskRepository;

    /**
     * TaskController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
        $this->taskRepository = $this->em->getRepository(Task::class);
    }

    /**
     * @Route("/create-task", methods={"post", "get"}, name="createTask")
     * @param Request $request
     * @param CreateTaskForm $createTaskForm
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createTask(Request $request, CreateTaskForm $createTaskForm): Response
    {
        $createTaskForm->setRequest($request);

        if ($createTaskForm->getTitle()) {
            $this->taskRepository->createOrUpdateTask($createTaskForm);
        }

        /** @var string $route */
        $route = $this->get('router')->generate('createTask', array(), false);

        return $this->render('task/createTask.html.twig', ['route' => $route]);
    }

    /**
     * @Route("/manage-task/{taskType}", methods={"get"}, name="manageTask")
     * @param string $taskType
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function manageTask(string $taskType): Response
    {
        /** @var string $route */
        $route = $this->get('router')->generate('createTask', array(), false);

        return $this->render('task/manageTask.html.twig', [
            'route' => $route,
            'taskType' => $taskType
        ]);
    }

    /**
     * @Route("/get-task/{taskType}", methods={"get"}, name="getTasks")
     * @param TaskModel $taskModel
     * @param string $taskType
     * @return array
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\ORM\ORMException
     */
    public function getTasks(TaskModel $taskModel, string $taskType): JsonResponse
    {
        /** @var array $tasks */
        $tasks = $taskModel->getTaskByType($taskType);

        return new JsonResponse(['data' => $tasks]);
    }

    /**
     * @Route("/delete-task/{id}", methods={"get"}, name="deleteTask")
     * @param int $id
     * @throws \Doctrine\ORM\ORMException
     */
    public function deleteTask(string $id): Response
    {
        /** @var Task $task */
        $task = $this->taskRepository->find((int)$id);

        if ($task instanceof Task) {
            /** @var Status $statusDeleted */
            $statusDeleted = $this->em->getReference(Status::class, Status::STATUS['deleted']);
            $task->setStatusId($statusDeleted);
            $this->em->flush();

            return new Response('deleted', Response::HTTP_OK);
        }

        return new Response('deleted', Response::HTTP_NOT_FOUND);
    }
}
