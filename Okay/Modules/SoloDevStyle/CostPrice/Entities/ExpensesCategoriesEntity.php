<?php


namespace Okay\Modules\SoloDevStyle\CostPrice\Entities;


use Okay\Core\Entity\Entity;

class ExpensesCategoriesEntity extends Entity
{   
    protected static $fields = [
        'id',
        'position',
        'visible',
    ];

    protected static $langFields = [
        'name',
    ];

    protected static $defaultOrderFields = [
        'position DESC',
    ];

    protected static $table = 'solo_dev_style__cost_price_expenses_categories';
    protected static $langObject = 'sds_expenses_category';
    protected static $langTable = 'solo_dev_style__cost_price_expenses_categories';
    protected static $tableAlias = 'sds_expenses_categories';
}
