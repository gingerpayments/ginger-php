<?php

namespace GingerPayments\Payment\Tests\Order\Transaction;

use GingerPayments\Payment\Order\Transaction\Status;

final class StatusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldBeNew()
    {
        $status = Status::fromString(Status::BRAND_NEW);

        $this->assertTrue($status->isNew());
        $this->assertFalse($status->isPending());
        $this->assertFalse($status->isProcessing());
        $this->assertFalse($status->isError());
        $this->assertFalse($status->isCompleted());
        $this->assertFalse($status->isCancelled());
        $this->assertFalse($status->isExpired());
    }

    /**
     * @test
     */
    public function itShouldBePending()
    {
        $status = Status::fromString(Status::PENDING);

        $this->assertFalse($status->isNew());
        $this->assertTrue($status->isPending());
        $this->assertFalse($status->isProcessing());
        $this->assertFalse($status->isError());
        $this->assertFalse($status->isCompleted());
        $this->assertFalse($status->isCancelled());
        $this->assertFalse($status->isExpired());
    }

    /**
     * @test
     */
    public function itShouldBeProcessing()
    {
        $status = Status::fromString(Status::PROCESSING);

        $this->assertFalse($status->isNew());
        $this->assertFalse($status->isPending());
        $this->assertTrue($status->isProcessing());
        $this->assertFalse($status->isError());
        $this->assertFalse($status->isCompleted());
        $this->assertFalse($status->isCancelled());
        $this->assertFalse($status->isExpired());
    }

    /**
     * @test
     */
    public function itShouldBeError()
    {
        $status = Status::fromString(Status::ERROR);

        $this->assertFalse($status->isNew());
        $this->assertFalse($status->isPending());
        $this->assertFalse($status->isProcessing());
        $this->assertTrue($status->isError());
        $this->assertFalse($status->isCompleted());
        $this->assertFalse($status->isCancelled());
        $this->assertFalse($status->isExpired());
    }

    /**
     * @test
     */
    public function itShouldBeCompleted()
    {
        $status = Status::fromString(Status::COMPLETED);

        $this->assertFalse($status->isNew());
        $this->assertFalse($status->isPending());
        $this->assertFalse($status->isProcessing());
        $this->assertFalse($status->isError());
        $this->assertTrue($status->isCompleted());
        $this->assertFalse($status->isCancelled());
        $this->assertFalse($status->isExpired());
    }

    /**
     * @test
     */
    public function itShouldBeCancelled()
    {
        $status = Status::fromString(Status::CANCELLED);

        $this->assertFalse($status->isNew());
        $this->assertFalse($status->isPending());
        $this->assertFalse($status->isProcessing());
        $this->assertFalse($status->isError());
        $this->assertFalse($status->isCompleted());
        $this->assertTrue($status->isCancelled());
        $this->assertFalse($status->isExpired());
    }

    /**
     * @test
     */
    public function itShouldBeExpired()
    {
        $status = Status::fromString(Status::EXPIRED);

        $this->assertFalse($status->isNew());
        $this->assertFalse($status->isPending());
        $this->assertFalse($status->isProcessing());
        $this->assertFalse($status->isError());
        $this->assertFalse($status->isCompleted());
        $this->assertFalse($status->isCancelled());
        $this->assertTrue($status->isExpired());
    }
}
