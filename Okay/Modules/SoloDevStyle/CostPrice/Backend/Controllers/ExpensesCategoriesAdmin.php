<?php


namespace Okay\Modules\SoloDevStyle\CostPrice\Backend\Controllers;

use Okay\Admin\Controllers\IndexAdmin;

use Okay\Modules\SoloDevStyle\CostPrice\Requests\CostPriceRequest;
use Okay\Modules\SoloDevStyle\CostPrice\Helpers\CostPriceHelper;

class ExpensesCategoriesAdmin extends IndexAdmin
{
    public function fetch(
        CostPriceRequest $costPriceRequest,
        CostPriceHelper $costPriceHelper
    ) {
        $filter = $costPriceHelper->buildExpensesCategoryFilter();
        $this->design->assign('filter',         $filter['filter']);


        if ($this->request->method('post')) {
            $positions = $costPriceRequest->postExpensesCategoryPositions();
            $costPriceHelper->sortExpensesCategoryPositions($positions);

            $ids = $costPriceRequest->postExpensesCategoryCheck();
            switch ($costPriceRequest->postExpensesCategoryAction()) {
                case 'enable': {
                    $costPriceHelper->enableExpensesCategory($ids);
                    break;
                }
                case 'disable': {
                    $costPriceHelper->disableExpensesCategory($ids);
                    break;
                }
                case 'delete': {
                    $costPriceHelper->deleteExpensesCategory($ids);
                    break;
                }
            }
        }

        $categoriesCount = $costPriceHelper->countExpensesCategories($filter);
        $categories      = $costPriceHelper->findExpensesCategories($filter);

        $this->design->assign('categories_count', $categoriesCount);
        $this->design->assign('categories', $categories);

        $this->response->setContent($this->design->fetch('expenses_categories.tpl'));
    }
}
