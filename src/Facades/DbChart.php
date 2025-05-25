<?php

namespace Dynamik\DbChart\Facades;

use DynamikDev\DbChart\DbChart as DbChartClass;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Dynamik\DbChart\DbChart
 */
class DbChart extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DbChartClass::class;
    }
}
