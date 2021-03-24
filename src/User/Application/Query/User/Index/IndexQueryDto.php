<?php

declare(strict_types=1);

namespace App\User\Application\Query\User\Index;

use Spatie\DataTransferObject\DataTransferObject;

final class IndexQueryDto extends DataTransferObject
{
    /** @var UserDto[]|array */
    public array $users;
}
