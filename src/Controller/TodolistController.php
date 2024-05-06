<?php 

namespace App\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;

class TodolistController extends AbstractController
{
    /**
     * Update the status of a Task.
     *
     * @Route("/tasks/{id}/status", methods={"PUT"})
     */
     public function updateStatus(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = $entityManager->getRepository(Task::class)->find($id);

        if (!$task) {
            return new Response('Task not found', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $status = $data['status'] ?? null;

        if ($status === null) {
            return new Response('Invalid request body', Response::HTTP_BAD_REQUEST);
        }

        $task->setStatus($status);
        $entityManager->flush();

        return new Response('Task status updated successfully');
    }

    // ...
}