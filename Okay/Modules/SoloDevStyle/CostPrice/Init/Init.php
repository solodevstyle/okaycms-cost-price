<?php

namespace Okay\Modules\SoloDevStyle\CostPrice\Init;

use Okay\Core\Modules\AbstractInit;
use Okay\Core\Modules\EntityField;
use Okay\Entities\VariantsEntity;
use Okay\Entities\PurchasesEntity;
use Okay\Entities\ReportStatEntity;

use Okay\Modules\SoloDevStyle\CostPrice\Extenders\BackendExtender;
use Okay\Modules\SoloDevStyle\CostPrice\Entities\ExpensesCategoriesEntity;
use Okay\Modules\SoloDevStyle\CostPrice\Entities\ExpensesByMonthsEntity;

use Okay\Admin\Helpers\BackendVariantsHelper;

class Init extends AbstractInit
{
    const PERMISSION = 'sds_cost_price';

    const VARIANT_COST_PRICE = 'cost_price';

    public function install()
    {
        $this->setBackendMainController('CostPriceAdmin');
        
        $this->migrateEntityField(VariantsEntity::class, (new EntityField(self::VARIANT_COST_PRICE))->setTypeDecimal('14,2')->setDefault(0));
        $this->migrateEntityField(PurchasesEntity::class, (new EntityField(self::VARIANT_COST_PRICE))->setTypeDecimal('14,2')->setDefault(0));

        $this->migrateEntityTable(ExpensesCategoriesEntity::class, [
            (new EntityField('id'))->setTypeInt(11)->setAutoIncrement(),
            (new EntityField('position'))->setTypeInt(11)->setDefault(0)->setIndex(),
            (new EntityField('visible'))->setTypeTinyInt(1, true)->setDefault(1)->setIndex(),
            (new EntityField('name'))->setTypeVarchar(255)->setDefault('')->setIsLang(),
        ]);

        $this->migrateEntityTable(ExpensesByMonthsEntity::class, [
            (new EntityField('id'))->setTypeInt(11)->setAutoIncrement(),
            (new EntityField('date'))->setTypeVarchar(5)->setDefault(''),
            (new EntityField('expenses'))->setTypeLongText(),
        ]);
    }

    public function init()
    {

        $this->registerEntityField(VariantsEntity::class, self::VARIANT_COST_PRICE);
        $this->registerEntityField(PurchasesEntity::class, self::VARIANT_COST_PRICE);

        $this->addPermission(self::PERMISSION);

        $this->registerBackendController('CostPriceAdmin');
        $this->addBackendControllerPermission('CostPriceAdmin', self::PERMISSION);

        $this->registerBackendController('ProfitAndExpensesStatsAdmin');
        $this->addBackendControllerPermission('ProfitAndExpensesStatsAdmin', self::PERMISSION);

        $this->registerBackendController('ExpensesCategoriesAdmin');
        $this->addBackendControllerPermission('ExpensesCategoriesAdmin', self::PERMISSION);

        $this->registerBackendController('ExpensesCategoryAdmin');
        $this->addBackendControllerPermission('ExpensesCategoryAdmin', self::PERMISSION);

        $this->registerBackendController('ExpensesByMonthsAdmin');
        $this->addBackendControllerPermission('ExpensesByMonthsAdmin', self::PERMISSION);

        $this->registerBackendController('ExpensesByMonthAdmin');
        $this->addBackendControllerPermission('ExpensesByMonthAdmin', self::PERMISSION);

        $this->registerChainExtension(
            [ReportStatEntity::class, 'find'],
            [BackendExtender::class, 'find']
        );
        
        $this->registerQueueExtension(
            ['class' => BackendVariantsHelper::class, 'method' => 'updateStocksAndPrices'],
            ['class' => BackendExtender::class, 'method' => 'updateStocksAndPrices']
        );

        $this->extendBackendMenu('left_stats', [
            'sds_profit_and_expenses__title' => ['ProfitAndExpensesStatsAdmin','ExpensesCategoriesAdmin','ExpensesCategoryAdmin','ExpensesByMonthsAdmin','ExpensesByMonthAdmin'],
        ]);

        $this->extendUpdateObject('solo_dev_style__expenses_category', self::PERMISSION, ExpensesCategoriesEntity::class);
    }

}
