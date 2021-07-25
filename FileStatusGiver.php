<?php

namespace TestTask;

include_once 'FileRow.php';

class FileStatusGiver
{
    public static function giveStatus($array1, $array2)
    {
        $result = [];
        foreach ($array1 as $index => $element) {
            if (isset($array2[$index])) {
                $element->setStatus(FileRow::$updateStatus);
                $result[] = [$element, $array2[$index]];
                array_splice($array2, $index);
                continue;
            }
            $element->setStatus(FileRow::$deleteStatus);
            $result[] = $element;
        }
        foreach ($array2 as $element) {
            $element->setStatus(FileRow::$addStatus);
            $result[] = $element;
        }
        return $result;
    }
}