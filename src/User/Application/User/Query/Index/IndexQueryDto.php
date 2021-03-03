<?php

declare(strict_types=1);

namespace App\User\Application\User\Query\Index;

use Spatie\DataTransferObject\DataTransferObject;

final class IndexQueryDto extends DataTransferObject
{
    /** @var UserDto[]|array */
    public array $users;
}
