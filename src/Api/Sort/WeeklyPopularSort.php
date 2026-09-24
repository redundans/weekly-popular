<?php

namespace Redundans\WeeklyPopular\Api\Sort;

use Flarum\Api\Sort\SortColumn;

/**
 * Publishes the weekly-popular alias in Flarum's sort map. The actual query
 * rewrite is performed by WeeklyPopularSearchMutator because discussion index
 * requests run through Flarum's search driver.
 */
final class WeeklyPopularSort extends SortColumn
{
    public static function make(string $name): static
    {
        return new static($name);
    }
}
