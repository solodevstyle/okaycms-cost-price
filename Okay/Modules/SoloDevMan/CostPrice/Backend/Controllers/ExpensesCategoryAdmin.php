<?php

namespace Okay\Modules\SoloDevMan\CostPrice\Backend\Controllers;


use Okay\Admin\Controllers\IndexAdmin;

use Okay\Modules\SoloDevMan\CostPrice\Requests\CostPriceRequest;
use Okay\Modules\SoloDevMan\CostPrice\Helpers\CostPriceHelper;

class ExpensesCategoryAdmin extends IndexAdmin
{
    
    public function fetch(
        CostPriceRequest $costPriceRequest,
        CostPriceHelper $costPriceHelper
    ) {

        if ($this->request->method('post')) {
            $category = $costPriceRequest->postExpensesCategory();
            if (empty($category->id)) {
                $preparedCategory = $costPriceHelper->prepareExpensesCategoryAdd($category);
                $category->id = $costPriceHelper->addExpensesCategory($preparedCategory);
                $this->postRedirectGet->storeMessageSuccess('added');
                $this->postRedirectGet->storeNewEntityId($category->id);
            } else {
                $preparedCategory = $costPriceHelper->prepareExpensesCategoryUpdate($category);
                $costPriceHelper->updateExpensesCategory($preparedCategory->id, $preparedCategory);
                $this->postRedirectGet->storeMessageSuccess('updated');
            }

            $this->postRedirectGet->redirect();
        } else {
            $categoryId = $this->request->get('id', 'integer');
            $category   = $costPriceHelper->getExpensesCategory((int)$categoryId);
        }

        $this->design->assign('category', $category);

        $this->response->setContent($this->design->fetch('expenses_category.tpl'));
    }
}
