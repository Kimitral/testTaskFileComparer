<?php

namespace TestTask;

include_once 'FileReader.php';
include_once 'FileStatusGiver.php';

class FileCompere
{

    /**
     * @var string
     */
    private $file1;
    /**
     * @var string
     */
    private $file2;

    public function __construct(string $file1, string $file2)
    {
        $this->file1 = new FileReader($file1);
        $this->file2 = new FileReader($file2);
    }

    public function compare()
    {
        $result = [];
        while (!$this->file1->alreadyEnd() || !$this->file2->alreadyEnd()) {
            $this->file1->readNextRow();
            $this->file2->readNextRow();

            $searchResult = $this->file1->findInFileReader($this->file2);

            if ($searchResult) {
                $result = $this->convertSearched($searchResult, $result);
            }

        }
        $result = $this->lastPopup($result);
        return $this->arrayWithStrings($result);
    }

    public function convertSearched(array $searchResult, array $result): array
    {

        $firstArrayStatusProblem = $this->file1->popStackToIndex($searchResult[0]);
        $secondArrayToStatusProblem = $this->file2->popStackToIndex($searchResult[1]);

        $result = array_merge($result, FileStatusGiver::giveStatus($firstArrayStatusProblem, $secondArrayToStatusProblem));

        $result[] = $this->file1->popStackToIndex(1)[0];
        $this->file2->popStackToIndex(1);

        return $result;
    }

    public function lastPopup(array $result): array
    {
        return array_merge($result, FileStatusGiver::giveStatus($this->file1->popStackToIndex(), $this->file2->popStackToIndex()));
    }

    public function arrayWithStrings($result): array
    {
        return array_map(function ($element, $index) {
            if (is_array($element)) {
                return $element[0]->toString($index, $element[1]);
            }
            return $element->toString($index);
        }, $result, array_keys($result));
    }

}