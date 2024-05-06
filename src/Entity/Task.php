<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\TodolistController;





/**
 *
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={
 *         "get", 
 *         "put", 
 *         "delete",
 *         "updatestatus"={
 *             "method"="PUT",
 *             "path"="/tasks/{id}/status",
  *             "swagger_context"={
 *                 "summary"="Update the status of a Task",
 *                 "responses"={
 *                     "200"={
 *                         "description"="Task status updated successfully"
 *                     },
 *                     "404"={
 *                         "description"="Task not found"
 *                     }
 *                 }
 *             }
 *         }
 *     }
 * )
 * 
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * 
 * 
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deadline;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }
}
