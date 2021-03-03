<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared;

use Codeception\Test\Unit;
use InvalidArgumentException;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * @internal
 * Class SomeTest
 */
final class SomeTest extends Unit
{
    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testSomething(): void
    {
        self::assertTrue(true);
    }
}
