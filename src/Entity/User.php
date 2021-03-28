<?php

namespace App\Entity;

use Core\Component\ORM\EntityInterface;

class User implements EntityInterface
{
    private $id;

    private $fullname;

    private $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function setFullname($fullname): self
    {
        $this->fullname = $fullname;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}