<?php

namespace Core\Component\ORM;
 
interface EntityInterface 
{
    const FIELD_ID = 'id';

    public function getId(): int;
}

