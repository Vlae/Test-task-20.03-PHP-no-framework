<?php

namespace Application\Contracts;

interface FileReaderInterface
{
    public function __construct(string $filename);

    public function readLine(): ?array;

    public function isEndOfFile(): bool;
}