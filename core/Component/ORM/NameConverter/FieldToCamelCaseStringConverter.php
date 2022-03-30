<?php

namespace Core\Component\ORM\NameConverter;

class FieldToCamelCaseStringConverter implements StringConverterInterface
{
    public static function normalize($value): string
    {
        $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
        preg_match_all($pattern, $value, $matches);
        $fieldChunks = $matches[0];

        foreach ($fieldChunks as &$fieldChunk) {
            $fieldChunk = $fieldChunk == strtoupper($fieldChunk) ?
                strtolower($fieldChunk) :
                lcfirst($fieldChunk);
        }

        return implode('_', $fieldChunks);
    }
}
