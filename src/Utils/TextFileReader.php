<?php

namespace Application\Utils;

use SplFileObject;
use Application\Contracts\FileReaderInterface;

class TextFileReader implements FileReaderInterface
{
    /** @var SplFileObject  */
    private SplFileObject $file;

    /**
     * @param string $filepath
     */
    public function __construct(string $filepath)
    {
        $this->file = new SplFileObject($filepath);
    }

    /**
     * @return array|null
     */
    public function readLine(): ?array
    {
        $currentLine = $this->file->current();

        if (!$currentLine) {
            return null;
        }

        if (!is_array($currentLine)) {
            $currentLine = json_decode($currentLine, true);
        }

        $this->file->next();

        return $currentLine;
    }

    /**
     * @return bool
     */
    public function isEndOfFile(): bool
    {
        return $this->file->eof();
    }
}