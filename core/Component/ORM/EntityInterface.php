<?php

namespace Core\Component\ORM;

interface EntityInterface
{
    public const FIELD_ID = 'id';

    public function getId(): int;
}
