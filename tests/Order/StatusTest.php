<?php

namespace GingerPayments\Payment\Tests\Order;

use GingerPayments\Payment\Order\Status;

final class StatusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldBeNew()
    {
        $status = Status::fromString(Status::BRAND_NEW);

        $this->assertTrue($status->isNew());
        $this->assertFalse($status->isProcessing());
        $this->assertFalse($status->isError());
        $this->assertFalse($status->isCompleted());
        $this->assertFalse($status->isCancelled());
        $this->assertFalse($status->isExpired());
        $this->assertFalse($status->isSeeTransactions());
    }

    /**
     * @test
     */
    public function itShouldBeProcessing()
    {
        $status = Status::fromString(Status::PROCESSING);

        $this->assertFalse($status->isNew());
        $this->assertTrue($status->isProcessing());
        $this->assertFalse($status->isError());
        $this->assertFalse($status->isCompleted());
        $this->assertFalse($status->isCancelled());
        $this->assertFalse($status->isExpired());
        $this->assertFalse($status->isSeeTransactions());
    }

    /**
     * @test
     */
    public function itShouldBeError()
    {
        $status = Status::fromString(Status::ERROR);

        $this->assertFalse($status->isNew());
        $this->assertFalse($status->isProcessing());
        $this->assertTrue($status->isError());
        $this->assertFalse($status->isCompleted());
        $this->assertFalse($status->isCancelled());
        $this->assertFalse($status->isExpired());
        $this->assertFalse($status->isSeeTransactions());
    }

    /**
     * @test
     */
    public function itShouldBeCompleted()
    {
        $status = Status::fromString(Status::COMPLETED);

        $this->assertFalse($status->isNew());
        $this->assertFalse($status->isProcessing());
        $this->assertFalse($status->isError());
        $this->assertTrue($status->isCompleted());
        $this->assertFalse($status->isCancelled());
        $this->assertFalse($status->isExpired());
        $this->assertFalse($status->isSeeTransactions());
    }

    /**
     * @test
     */
    public function itShouldBeCancelled()
    {
        $status = Status::fromString(Status::CANCELLED);

        $this->assertFalse($status->isNew());
        $this->assertFalse($status->isProcessing());
        $this->assertFalse($status->isError());
        $this->assertFalse($status->isCompleted());
        $this->assertTrue($status->isCancelled());
        $this->assertFalse($status->isExpired());
        $this->assertFalse($status->isSeeTransactions());
    }

    /**
     * @test
     */
    public function itShouldBeExpired()
    {
        $status = Status::fromString(Status::EXPIRED);

        $this->assertFalse($status->isNew());
        $this->assertFalse($status->isProcessing());
        $this->assertFalse($status->isError());
        $this->assertFalse($status->isCompleted());
        $this->assertFalse($status->isCancelled());
        $this->assertTrue($status->isExpired());
        $this->assertFalse($status->isSeeTransactions());
    }

    /**
     * @test
     */
    public function itShouldBeSeeTransactions()
    {
        $status = Status::fromString(Status::SEE_TRANSACTIONS);

        $this->assertFalse($status->isNew());
        $this->assertFalse($status->isProcessing());
        $this->assertFalse($status->isError());
        $this->assertFalse($status->isCompleted());
        $this->assertFalse($status->isCancelled());
        $this->assertFalse($status->isExpired());
        $this->assertTrue($status->isSeeTransactions());
    }
}
