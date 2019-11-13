<?php

namespace Jaffa\Builders;

interface DataBaseQueryBuilder
{
    public function select(string $table, string $columns): DataBaseQueryBuilder;
}