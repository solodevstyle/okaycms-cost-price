<?php


namespace Okay\Modules\SoloDevMan\CostPrice\Entities;


use Okay\Core\Entity\Entity;

class ExpensesByMonthsEntity extends Entity
{   
    protected static $fields = [
        'id',
        'date',
        'expenses'
    ];

    protected static $defaultOrderFields = [
        'id DESC',
    ];

    protected static $table = 'solo_dev_man__cost_price_expenses_by_month';
    protected static $tableAlias = 'sdm_expenses_by_months';
}
