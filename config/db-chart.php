<?php

// config for Dynamik/DbChart

use Dynamik\DbChart\Transformers\ToMermaid;

return [

    /**
     * Set the transformer to use for the database chart.
     *
     * @var class-string<Transformer>
     */
    'transformer' => ToMermaid::class,

    /**
     * Set the route to use for the database chart.
     *
     * @var string
     */
    'route' => '/db-chart',

];
