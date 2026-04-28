<?php


namespace Okay\Modules\SoloDevMan\CostPrice\Entities;


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

    protected static $table = 'solo_dev_man__cost_price_expenses_categories';
    protected static $langObject = 'sdm_expenses_category';
    protected static $langTable = 'solo_dev_man__cost_price_expenses_categories';
    protected static $tableAlias = 'sdm_expenses_categories';
}
