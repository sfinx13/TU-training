<?php

namespace Core\Component\ORM\Transformer;

interface DataTranformerInterface
{
    static public function transform($value): string;
}