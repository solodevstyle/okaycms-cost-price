<?php


namespace Okay\Modules\SoloDevMan\CostPrice\Backend\Controllers;

use Okay\Admin\Controllers\IndexAdmin;

use Okay\Modules\SoloDevMan\CostPrice\Requests\CostPriceRequest;
use Okay\Modules\SoloDevMan\CostPrice\Helpers\CostPriceHelper;

class ExpensesByMonthsAdmin extends IndexAdmin
{
    public function fetch(
        CostPriceRequest $costPriceRequest,
        CostPriceHelper $costPriceHelper
    ) {

        if ($this->request->method('post')) {
            $ids = $costPriceRequest->postExpensesByMonthsCheck();
            switch ($costPriceRequest->postExpensesByMonthsAction()) {
                case 'delete': {
                    $costPriceHelper->deleteExpensesByMonths($ids);
                    break;
                }
            }
        }

        $expensesCount = $costPriceHelper->countExpensesByMonths([]);
        $expenses      = $costPriceHelper->findExpensesByMonths([]);

        $this->design->assign('expenses_count', $expensesCount);
        $this->design->assign('expenses', $expenses);

        $this->response->setContent($this->design->fetch('expenses_by_months.tpl'));
    }
}
