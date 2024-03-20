<?php

namespace Application\Tests\Unit\Utils;

use PHPUnit\Framework\TestCase;
use Application\Utils\TextFileReader;

class TextFileReaderTest extends TestCase
{
    private $filePath = 'test.txt';

    protected function setUp(): void
    {
        // write temporary in file
        file_put_contents($this->filePath, '{"key":"value"}' . PHP_EOL . '{"key2":"value2"}');
    }

    protected function tearDown(): void
    {
        unlink($this->filePath); // delete the temporary file after the test
    }

    public function test_read_line_returns_array(): void
    {
        $reader = new TextFileReader($this->filePath);
        $line = $reader->readLine();
        $this->assertIsArray($line);
        $this->assertEquals(['key' => 'value'], $line);
    }

    public function test_read_line_goes_to_next_line(): void
    {
        $reader = new TextFileReader($this->filePath);
        $reader->readLine(); // Read first line
        $secondLine = $reader->readLine(); // Read second line
        $this->assertEquals(['key2' => 'value2'], $secondLine);
    }

    public function test_is_end_of_file(): void
    {
        $reader = new TextFileReader($this->filePath);
        $reader->readLine(); // Read first line
        $reader->readLine(); // Try to read beyond the last line
        $this->assertTrue($reader->isEndOfFile());
    }
}