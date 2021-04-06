<?php

namespace Core\Component\ORM\Utils;

use ReflectionObject;
use InvalidArgumentException;

class ObjectComparator
{
    /**
     * Find the differences between 2 objects using Reflection.
     *
     * @param $object1
     * @param $object2
     * @return array Properties that have changed
     * @throws InvalidArgumentException
     */
    public static function diff($object1, $object2): array
    {
        if (!is_object($object1) || !is_object($object2)) {
            throw new InvalidArgumentException("Parameters should be of object type!");
        }

        $diff = [];
        if (get_class($object1) == get_class($object2)) {
            $object1Properties = (new ReflectionObject($object1))->getProperties();
            $object2Reflected = new ReflectionObject($object2);

            foreach ($object1Properties as $object1Property) {
                $o2Property = $object2Reflected->getProperty($object1Property->getName());
                // Mark private properties as accessible only for reflected class
                $object1Property->setAccessible(true);
                $o2Property->setAccessible(true);
                if (($oldValue = $object1Property->getValue($object1)) != ($newValue = $o2Property->getValue($object2))) {
                    $diff[$object1Property->getName()] = [
                        'old_value' => $oldValue,
                        'new_value' => $newValue
                    ];
                }
            }
        }

        return $diff;
    }
}