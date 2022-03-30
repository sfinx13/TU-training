<?php

namespace Core\Tests\Component\ORM;

use Core\Component\ORM\EntityInterface;

trait RandomUserTrait
{
    public function getRandomUser()
    {
        return new class () implements EntityInterface {
            public $fullname = "Saidi AHAMADA";
            public $createdAt = "2022-03-30";

            public function getId(): int
            {
                return 1;
            }
        };
    }
}
