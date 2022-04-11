<?php

declare(strict_types=1);

namespace omnilight\scheduling\Tests;

use PHPUnit\Framework\TestCase;
use omnilight\scheduling\Event;
use yii\mutex\Mutex;

class EventTest extends TestCase
{
    public function buildCommandData()
    {
        return [
            [false, 'php -i', '/dev/null', 'php -i > /dev/null'],
            [false, 'php -i', '/my folder/foo.log', 'php -i > /my folder/foo.log'],
            [true, 'php -i', '/dev/null', 'php -i > /dev/null 2>&1 &'],
            [true, 'php -i', '/my folder/foo.log', 'php -i > /my folder/foo.log 2>&1 &'],
        ];
    }

    /**
     * @dataProvider buildCommandData
     * @param bool $omitErrors
     * @param string $command
     * @param string $outputTo
     * @param string $result
     */
    public function testBuildCommandSendOutputTo($omitErrors, $command, $outputTo, $result): void
    {
        $event = new Event($this->createMock(Mutex::class), $command);
        $event->omitErrors($omitErrors);
        $event->sendOutputTo($outputTo);
        $this->assertSame($result, $event->buildCommand());
    }
}
