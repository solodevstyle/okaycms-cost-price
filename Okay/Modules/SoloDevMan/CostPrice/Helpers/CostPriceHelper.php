<?php


namespace Okay\Modules\SoloDevMan\CostPrice\Helpers;

use Okay\Core\EntityFactory;
use Okay\Core\QueryFactory;
use Okay\Core\Database;
use Okay\Core\Modules\Extender\ExtenderFacade;
use Okay\Core\Request;
use Okay\Modules\SoloDevMan\CostPrice\Entities\ExpensesCategoriesEntity;
use Okay\Modules\SoloDevMan\CostPrice\Entities\ExpensesByMonthsEntity;

use Okay\Entities\OrdersEntity;

class CostPriceHelper
{
    private $expensesCategoriesEntity;
    private $expensesByMonthsEntity;
    private $request;
    private $db;
    private $queryFactory;

    public function __construct(
        EntityFactory $entityFactory,
        Request       $request,
        Database      $database,
        QueryFactory  $queryFactory

    ) {
        $this->expensesCategoriesEntity = $entityFactory->get(ExpensesCategoriesEntity::class);
        $this->expensesByMonthsEntity = $entityFactory->get(ExpensesByMonthsEntity::class);
        $this->request       = $request;
        $this->db            = $database;
        $this->queryFactory  = $queryFactory;
    }

    public function buildExpensesCategoryFilter()
    {
        $filter = [];
        $filter['page'] = max(1, $this->request->get('page', 'integer'));
        $filter['limit'] = 20;

        if ($f = $this->request->get('filter', 'string'))
        {
            if ($f == 'visible') {
                $filter['visible'] = 1;
            } elseif ($f == 'hidden') {
                $filter['visible'] = 0;
            }
            $filter['filter'] = $f;
        } else {
            $filter['filter'] = null;
        }
        
        return ExtenderFacade::execute(__METHOD__, $filter, func_get_args());
    }

    public function sortExpensesCategoryPositions($positions)
    {
        if (empty($positions) || !is_array($positions)) {
            ExtenderFacade::execute(__METHOD__, null, func_get_args());
            return;
        }

        $ids = array_keys($positions);
        sort($positions);
        $positions = array_reverse($positions);
        foreach ($positions as $i=>$position) {
            $this->expensesCategoriesEntity->update($ids[$i], ['position'=>$position]);
        }

        ExtenderFacade::execute(__METHOD__, null, func_get_args());
    }

    public function enableExpensesCategory($ids)
    {
        if (empty($ids)) {
            ExtenderFacade::execute(__METHOD__, null, func_get_args());
            return;
        }

        $this->expensesCategoriesEntity->update($ids, ['visible' => 1]);
        ExtenderFacade::execute(__METHOD__, null, func_get_args());
    }

    public function disableExpensesCategory($ids)
    {
        if (empty($ids)) {
            ExtenderFacade::execute(__METHOD__, null, func_get_args());
            return;
        }

        $this->expensesCategoriesEntity->update($ids, ['visible' => 0]);
        ExtenderFacade::execute(__METHOD__, null, func_get_args());
    }

    public function deleteExpensesCategory($ids)
    {
        if (empty($ids)) {
            ExtenderFacade::execute(__METHOD__, null, func_get_args());
            return;
        }

        $this->expensesCategoriesEntity->delete($ids);
        ExtenderFacade::execute(__METHOD__, null, func_get_args());
    }

    public function countExpensesCategories($filter)
    {
        $categoriesCount = $this->expensesCategoriesEntity->count($filter);
        return ExtenderFacade::execute(__METHOD__, $categoriesCount, func_get_args());
    }

    public function findExpensesCategories($filter)
    {
        $categories = $this->expensesCategoriesEntity->mappedBy('id')->find($filter);
        return ExtenderFacade::execute(__METHOD__, $categories, func_get_args());
    }

    public function prepareExpensesCategoryAdd($category)
    {
        return ExtenderFacade::execute(__METHOD__, $category, func_get_args());
    }

    public function addExpensesCategory($category)
    {
        $insertId = $this->expensesCategoriesEntity->add($category);
        return ExtenderFacade::execute(__METHOD__, $insertId, func_get_args());
    }

    public function prepareExpensesCategoryUpdate($category)
    {
        return ExtenderFacade::execute(__METHOD__, $category, func_get_args());
    }

    public function updateExpensesCategory($id, $category)
    {
        $this->expensesCategoriesEntity->update($id, $category);
        return ExtenderFacade::execute(__METHOD__, null, func_get_args());
    }

    public function getExpensesCategory($id)
    {
        $category = $this->expensesCategoriesEntity->get($id);
        if (empty($category)) {
            $category = new \stdClass;
            $category->id = null;
            $category->name = '';
            $category->visible = 1;
        }

        return ExtenderFacade::execute(__METHOD__, $category, func_get_args());
    }

    public function deleteExpensesByMonths($ids)
    {
        if (empty($ids)) {
            ExtenderFacade::execute(__METHOD__, null, func_get_args());
            return;
        }

        $this->expensesByMonthsEntity->delete($ids);
        ExtenderFacade::execute(__METHOD__, null, func_get_args());
    }

    public function countExpensesByMonths($filter)
    {
        $expensesCount = $this->expensesByMonthsEntity->count($filter);
        return ExtenderFacade::execute(__METHOD__, $expensesCount, func_get_args());
    }

    public function findExpensesByMonths($filter, $mappedBy = 'id')
    {
        $res = [];
        foreach($this->expensesByMonthsEntity->mappedBy($mappedBy)->find($filter) as $k=>$e) {
            $res[$k] = $e;
            if(!empty($e->expenses))
                $res[$k]->expenses = json_decode($e->expenses, true);
        }
        return ExtenderFacade::execute(__METHOD__, $res, func_get_args());
    }

    public function prepareExpensesByMonthAdd($expenses)
    {
        return ExtenderFacade::execute(__METHOD__, $expenses, func_get_args());
    }

    public function addExpensesByMonth($expenses)
    {
        $insertId = $this->expensesByMonthsEntity->add($expenses);
        return ExtenderFacade::execute(__METHOD__, $insertId, func_get_args());
    }

    public function prepareExpensesByMonthUpdate($expenses)
    {
        return ExtenderFacade::execute(__METHOD__, $expenses, func_get_args());
    }

    public function updateExpensesByMonth($id, $expenses)
    {
        $this->expensesByMonthsEntity->update($id, $expenses);
        return ExtenderFacade::execute(__METHOD__, null, func_get_args());
    }

    public function getExpensesByMonth($id)
    {
        $expense = $this->expensesByMonthsEntity->get($id);
        if (empty($expense)) {
            $expense = new \stdClass;
            $expense->id = null;
            $expense->date = '';
            $expense->expenses = [];
        }

        if(!empty($expense->expenses)) {
            $expense->expenses = json_decode($expense->expenses, true);
            if (!is_array($expense->expenses)) {
                $expense->expenses = [];
            }
        }
        return ExtenderFacade::execute(__METHOD__, $expense, func_get_args());
    }

    public function findExpenseMonths(){
        $sql = $this->queryFactory->newSqlQuery();
        $sql->setStatement("SELECT DATE_FORMAT(date, '%m.%y') as month_year FROM ".OrdersEntity::getTable()." GROUP BY month_year ORDER BY MIN(date)");
        $this->db->query($sql);
        return $this->db->results();
    }
}
