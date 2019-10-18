<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Shared;

use ArrayIterator;
use Faker\Factory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\AggregateRoot;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;

abstract class UnitTestCase extends TestCase
{
    /**
     * @var AggregateTranslator
     */
    private $aggregateTranslator;

    protected $fake;

    /** @return \Faker\Generator */
    protected function fake()
    {
        return $this->fake = $this->fake ?: Factory::create();
    }

    protected function mock($className): MockObject
    {
        return $this->createMock($className);
    }

    protected function popRecordedEvent(AggregateRoot $aggregateRoot): array
    {
        return $this->getAggregateTranslator()->extractPendingStreamEvents($aggregateRoot);
    }

    protected function reconstituteAggregateFromHistory(string $aggregateRootClass, array $events)
    {
        return $this->getAggregateTranslator()->reconstituteAggregateFromHistory(
            AggregateType::fromAggregateRootClass($aggregateRootClass),
            new ArrayIterator($events)
        );
    }

    private function getAggregateTranslator(): AggregateTranslator
    {
        if (null === $this->aggregateTranslator) {
            $this->aggregateTranslator = new AggregateTranslator();
        }
        return $this->aggregateTranslator;
    }
}
