<?php

include_once 'FileCompere.php';

use TestTask\FileCompere;

$fileComparer = new FileCompere('files/1.txt', 'files/2.txt');

echo $fileComparer->compare();