<?php

namespace Redundans\WeeklyPopular\Api\Sort;

use Flarum\Api\Sort\SortColumn;

final class WeeklyPopularSort extends SortColumn
{
    public static function make(string $name): static
    {
        return new static($name);
    }
}
