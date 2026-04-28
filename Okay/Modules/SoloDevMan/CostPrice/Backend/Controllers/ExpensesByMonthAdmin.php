<?php

namespace Okay\Modules\SoloDevMan\CostPrice\Backend\Controllers;


use Okay\Admin\Controllers\IndexAdmin;

use Okay\Modules\SoloDevMan\CostPrice\Requests\CostPriceRequest;
use Okay\Modules\SoloDevMan\CostPrice\Helpers\CostPriceHelper;

class ExpensesByMonthAdmin extends IndexAdmin
{
    
    public function fetch(
        CostPriceRequest $costPriceRequest,
        CostPriceHelper $costPriceHelper
    ) {
        if ($this->request->method('post')) {
            $expense = $costPriceRequest->postExpensesByMonth();
            $existingExpenses = $costPriceHelper->findExpensesByMonths(['date'=>$expense->date]);
            $hasDuplicateDate = false;
            foreach ($existingExpenses as $existingExpense) {
                if ((int)$existingExpense->id !== (int)$expense->id) {
                    $hasDuplicateDate = true;
                    break;
                }
            }

            if($hasDuplicateDate) {
                $error = 'date_exists';
                $this->design->assign('message_error', $error);
            } else {
                if (empty($expense->id)) {
                    $preparedExpense = $costPriceHelper->prepareExpensesByMonthAdd($expense);
                    $expense->id = $costPriceHelper->addExpensesByMonth($preparedExpense);
                    $this->postRedirectGet->storeMessageSuccess('added');
                    $this->postRedirectGet->storeNewEntityId($expense->id);
                } else {
                    $preparedExpense = $costPriceHelper->prepareExpensesByMonthUpdate($expense);
                    $costPriceHelper->updateExpensesByMonth($preparedExpense->id, $preparedExpense);
                    $this->postRedirectGet->storeMessageSuccess('updated');
                }

                $this->postRedirectGet->redirect();
            }
        } else {
            $expenseId = $this->request->get('id', 'integer');
            $expense   = $costPriceHelper->getExpensesByMonth((int)$expenseId);
        }

        $categories = $costPriceHelper->findExpensesCategories(['visible'=>1]);
        $this->design->assign('categories', $categories);

        $months = $costPriceHelper->findExpenseMonths();
        $this->design->assign('months', $months);
        

        $this->design->assign('expense', $expense);

        $this->response->setContent($this->design->fetch('expenses_by_month.tpl'));
    }
}
