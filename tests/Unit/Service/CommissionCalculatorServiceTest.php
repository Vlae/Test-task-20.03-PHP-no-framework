<?php

namespace Application\Tests\Unit\Service;
use PHPUnit\Framework\TestCase;
use Application\DTO\CardMetaDataDTO;
use Application\Service\CommissionCalculatorService;
use Application\Contracts\FileReaderInterface;
use Application\Contracts\BinProviderInterface;
use Application\Contracts\CurrencyRateProviderInterface;

class CommissionCalculatorServiceTest extends TestCase
{
    private $fileReaderMock;
    private $binProviderMock;
    private $rateProviderMock;

    protected function setUp(): void
    {
        $this->fileReaderMock = $this->createMock(FileReaderInterface::class);
        $this->binProviderMock = $this->createMock(BinProviderInterface::class);
        $this->rateProviderMock = $this->createMock(CurrencyRateProviderInterface::class);
    }

    public function test_get_euro_commissions(): void
    {
        $this->fileReaderMock->method('isEndOfFile')
            ->willReturnOnConsecutiveCalls(false, true);
        $this->fileReaderMock->method('readLine')
            ->willReturn(['amount' => '100.00', 'currency' => 'EUR', 'bin' => '123456']);

        $this->binProviderMock->method('getCardMetaData')
            ->willReturn(new CardMetaDataDTO('scheme', 'visa', 'AT'));
        $this->rateProviderMock->method('getRateByCurrency')->willReturn(1.0);

        $service = new CommissionCalculatorService($this->fileReaderMock, $this->binProviderMock, $this->rateProviderMock);

        $commissions = $service->getCommissions();

        $this->assertNotEmpty($commissions);
        $this->assertEquals(1.00, $commissions[0]);
    }
}