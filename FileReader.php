<?php

namespace TestTask;

include_once 'FileRow.php';

class FileReader
{
    /**
     * @var false|resource
     */
    private $handler;

    /**
     * @var array
     */
    private $stack = [];


    public function __construct(string $pathToFile)
    {
        $this->handler = fopen($pathToFile, 'r');
    }

    public function readNextRow(): ?FileRow
    {
        if ($this->alreadyEnd()) return null;
        $row = new FileRow(rtrim(fgets($this->handler)));
        return $this->stack[] = $row;
    }

    public function alreadyEnd(): bool
    {
        return feof($this->handler);
    }

    public function findValue(string $value): ?int
    {
        foreach ($this->stack as $index => $element) {
            if ($element->compareText($value)) {
                return $index;
            }
        }
        return null;
    }

    public function findInFileReader(FileReader $fileReader): ?array
    {
        $stack = $fileReader->getStack();
        foreach (array_reverse($stack) as $index => $element) {
            $result = $this->findValue($element->getText());

            if (!is_null($result))
                return [$result, count($stack) - $index - 1];
        }
        return null;
    }

    public function getStack(): array
    {
        return $this->stack;
    }

    public function popStackToIndex(?int $index = null): array
    {
        $result = [];
        if (is_null($index)) $index = count($this->stack);
        if ($index <= 0) return [];
        foreach (range(1, $index) as $item) {

            $result[] = array_shift($this->stack);
        }
        return $result;
    }
}