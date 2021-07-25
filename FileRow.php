<?php

namespace TestTask;

class FileRow
{
    /**
     * @var string
     */
    private $text;
    /**
     * @var int
     */
    private $status;

    public static $defaultStatus = 0;
    public static $updateStatus = 1;
    public static $deleteStatus = 2;
    public static $addStatus = 3;

    private static $statusToSymbol = [
        '', '*', '-', '+'
    ];

    public function __construct(string $text, int $status = 0)
    {
        $this->text = $text;
        $this->status = $status;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $value): void
    {
        $this->text = $value;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $value): void
    {
        $this->status = $value;
    }

    public function compareText(string $value): bool
    {
        return $this->text === $value;
    }

    public function symbolStatus()
    {
        return self::$statusToSymbol[$this->status] ?? self::$statusToSymbol[0];
    }

    public function toString(int $rowCount, FileRow $secondRow = null): string
    {
        $result = $rowCount . ' ' . $this->symbolStatus() . ' ' . $this->getText();
        if ($secondRow) $result .= '|' . $secondRow->getText();
        return $result;
    }

}