<?php


namespace Okay\Modules\SoloDevStyle\CostPrice\Requests;


use Okay\Core\Modules\Extender\ExtenderFacade;
use Okay\Core\Request;

class CostPriceRequest
{

    /** @var Request */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function postCostPrices()
    {
        $costPrices = $this->request->post('cost_price');
        return ExtenderFacade::execute(__METHOD__, $costPrices, func_get_args());
    }

    public function postExpensesCategory()
    {
        $category = new \stdClass;
        $category->id = $this->request->post('id', 'integer');
        $category->name = $this->request->post('name');
        $category->visible = $this->request->post('visible', 'boolean');

        return ExtenderFacade::execute(__METHOD__, $category, func_get_args());
    }

    public function postExpensesCategoryPositions()
    {
        $positions = $this->request->post('positions');
        return ExtenderFacade::execute(__METHOD__, $positions, func_get_args());
    }
    public function postExpensesCategoryCheck()
    {
        $check = (array) $this->request->post('check');
        return ExtenderFacade::execute(__METHOD__, $check, func_get_args());
    }
    public function postExpensesCategoryAction()
    {
        $action = $this->request->post('action');
        return ExtenderFacade::execute(__METHOD__, $action, func_get_args());
    }


    public function postExpensesByMonthsCheck()
    {
        $check = (array) $this->request->post('check');
        return ExtenderFacade::execute(__METHOD__, $check, func_get_args());
    }
    public function postExpensesByMonthsAction()
    {
        $action = $this->request->post('action');
        return ExtenderFacade::execute(__METHOD__, $action, func_get_args());
    }


    public function postExpensesByMonth()
    {
        $expensesByMonth = new \stdClass;
        $expensesByMonth->id = $this->request->post('id', 'integer');
        $expensesByMonth->date = $this->request->post('date');
        $expensesByMonth->expenses = (!empty($this->request->post('expenses')) ? json_encode($this->request->post('expenses')) : '');

        return ExtenderFacade::execute(__METHOD__, $expensesByMonth, func_get_args());
    }

    
}
