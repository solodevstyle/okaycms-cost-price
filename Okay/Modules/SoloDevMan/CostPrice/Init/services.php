<?php


namespace Okay\Modules\SoloDevMan\CostPrice;


use Okay\Core\OkayContainer\Reference\ServiceReference as SR;
use Okay\Core\Request;
use Okay\Core\EntityFactory;
use Okay\Core\QueryFactory;
use Okay\Core\Database;
use Okay\Modules\SoloDevMan\CostPrice\Extenders\BackendExtender;
use Okay\Modules\SoloDevMan\CostPrice\Requests\CostPriceRequest;
use Okay\Modules\SoloDevMan\CostPrice\Helpers\CostPriceHelper;


return [
    CostPriceRequest::class => [
        'class' => CostPriceRequest::class,
        'arguments' => [
            new SR(Request::class),
        ],
    ],
    BackendExtender::class => [
        'class' => BackendExtender::class,
        'arguments' => [
            new SR(EntityFactory::class),
            new SR(CostPriceRequest::class),
        ],
    ],
    CostPriceHelper::class => [
        'class' => CostPriceHelper::class,
        'arguments' => [
            new SR(EntityFactory::class),
            new SR(Request::class),
            new SR(Database::class),
            new SR(QueryFactory::class),
        ],
    ],
];
