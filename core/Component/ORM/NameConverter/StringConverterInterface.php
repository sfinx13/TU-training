<?php

namespace Core\Component\ORM\NameConverter;

interface StringConverterInterface
{
    public static function normalize(string $value);
}
