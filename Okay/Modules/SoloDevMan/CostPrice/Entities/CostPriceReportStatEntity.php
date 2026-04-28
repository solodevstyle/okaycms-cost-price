<?php

namespace Okay\Modules\SoloDevMan\CostPrice\Entities;

use Okay\Entities\ReportStatEntity;

class CostPriceReportStatEntity extends ReportStatEntity
{
    protected static $additionalFields = [
        'o.id',
        'SUM(p.price * p.amount) AS sum_price',
        'SUM(p.amount) as amount',
        'SUM(p.cost_price * p.amount) AS sum_cost_price',
        '(SUM(p.price * p.amount) - SUM(p.cost_price * p.amount)) AS profit'
    ];
}