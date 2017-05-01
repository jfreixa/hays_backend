<?php

namespace AppBundle\Controller\api;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends FOSRestController
{
    /**
     * @return array
     *
     * @Get("/tasks")
     */
    public function getSectionsAction()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Task')->findAll();

    }

    /**
     * @param Task $task
     * @return Task
     * @internal param Section $section
     * @Get("/tasks/{id}")
     */
    public function getSectionAction(Task $task)
    {
        return $task;
    }

    /**
     * @param Task $task
     * @return array
     *
     * @Delete("/tasks/{id}")
     */
    public function deleteSectionAction(Task $task)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($task);
        $em->flush();

        return ['successful' => true];
    }

    /**
     * @param Request $request
     * @return Task|Form
     *
     * @Post("/tasks")
     */
    public function newSectionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
        $this->processForm($request, $form);

        if($form->isValid()) {
            $em->persist($task);
            $em->flush();

            return $task;
        }

        return $form;
    }

    /**
     * @param Request $request
     * @param Task $task
     * @return Task|Form
     *
     * @Put("/tasks/{id}")
     */
    public function updateSectionAction(Request $request, Task $task)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(TaskType::class, $task
        );
        $this->processForm($request, $form);

        if($form->isValid()) {
            $em->persist($task);
            $em->flush();

            return $task;
        }

        return $form;
    }

    private function processForm(Request $request, Form $form)
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
    }

    /**
     * @param Task $task
     * @return Task
     *
     * @Patch("/tasks/{id}")
     */
    public function completeTaskAction(Task $task)
    {
        $em = $this->getDoctrine()->getManager();
        $task->changeStateTask();

        $em->persist($task);
        $em->flush();

        return $task;
    }
}
