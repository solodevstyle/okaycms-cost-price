<?php


namespace Okay\Modules\SoloDevStyle\CostPrice\Backend\Controllers;

use Okay\Admin\Controllers\IndexAdmin;

use Okay\Entities\OrdersEntity;
use Okay\Entities\PurchasesEntity;
use Okay\Entities\OrderStatusEntity;
use Okay\Entities\VariantsEntity;
use Okay\Entities\ProductsEntity;


use Okay\Modules\SoloDevStyle\CostPrice\Helpers\CostPriceHelper;

use DateTime;
use DateInterval;
use DatePeriod;

class ProfitAndExpensesStatsAdmin extends IndexAdmin
{
    private $dateFormat = 'd.m.Y';
    private $completedAndSentStatusIds = [4, 6];

    public function fetch(OrdersEntity $ordersEntity, OrderStatusEntity $orderStatusEntity, CostPriceHelper $costPriceHelper, PurchasesEntity $purchasesEntity, VariantsEntity $variantsEntity, ProductsEntity $productsEntity)
    {
        $orderStatuses = $orderStatusEntity->mappedBy('id')->find();
        $filter = [];

        $productsWithoutCostIds = [];

        if($this->request->post('from_date'))
            $firstDay = new DateTime($this->request->post('from_date'));
        else
            $firstDay = new DateTime('first day of this month');
    
        if($this->request->post('to_date'))
            $lastDay = new DateTime($this->request->post('to_date'));
        else
            $lastDay = new DateTime('last day of this month');

        $filter['from_date']  = $firstDay->format($this->dateFormat);
        $filter['to_date']  = $lastDay->format($this->dateFormat);

        $stats = [];
        $completedAndSent = new \stdClass;
        $completedAndSent->quantity = 0;
        $completedAndSent->total = 0;
        $completedAndSent->cost = 0;
        $completedAndSent->profit = 0;
        $orders = $ordersEntity->find($filter);

        $orderIds = [];
        foreach($orders as $order)
            $orderIds[] = $order->id;
        
        $purchasesByOrder = [];
        $purchaseVariantIds = [];
        $purchases = empty($orderIds) ? [] : $purchasesEntity->find(['order_id' => $orderIds]);
        foreach($purchases as $purchase) {
            $purchasesByOrder[$purchase->order_id][$purchase->id] = $purchase;
            $purchaseVariantIds[$purchase->variant_id] = $purchase->variant_id;
        }

        $variantCostPrices = [];
        $variants = empty($purchaseVariantIds) ? [] : $variantsEntity->find(['id' => $purchaseVariantIds]);
        foreach($variants as $variant)
            $variantCostPrices[$variant->id] = $variant->cost_price;

        foreach($orders as $order) {
            if(!isset($purchasesByOrder[$order->id]))
                continue;

            if(!isset($stats[$order->status_id])) {
                $stats[$order->status_id] = new \stdClass;
                $stats[$order->status_id]->status = isset($orderStatuses[$order->status_id]) ? $orderStatuses[$order->status_id]->name : $order->status_id;
                $stats[$order->status_id]->quantity = 0;
                $stats[$order->status_id]->total = 0;
                $stats[$order->status_id]->cost = 0;
                $stats[$order->status_id]->profit = 0;
            }

            $stats[$order->status_id]->quantity += 1;
            $stats[$order->status_id]->total += $order->total_price;
            $orderCost = 0;
            foreach($purchasesByOrder[$order->id] as $purchase) {
                if($purchase->cost_price < 1 && isset($variantCostPrices[$purchase->variant_id])) {
                    $purchase->cost_price = $variantCostPrices[$purchase->variant_id];
                    if($variantCostPrices[$purchase->variant_id] < 1) {
                        $productsWithoutCostIds[] = $purchase->product_id;
                    } else {
                        $purchasesEntity->update($purchase->id, ['cost_price'=>$variantCostPrices[$purchase->variant_id]]);
                    }
                }

                $stats[$order->status_id]->cost += $purchase->amount * $purchase->cost_price;
                $orderCost += $purchase->amount * $purchase->cost_price;
            }

            $stats[$order->status_id]->profit += ($order->total_price - $orderCost);
            if(in_array($order->status_id, $this->completedAndSentStatusIds)) {
                $completedAndSent->quantity += 1;
                $completedAndSent->total += $order->total_price;
                $completedAndSent->cost += $orderCost;
                $completedAndSent->profit += ($order->total_price - $orderCost);
            }
        }
        $monthsInfo = $this->getMonths($firstDay, $lastDay);
        $monthsList = array_keys($monthsInfo);
        $expenses = $costPriceHelper->findExpensesByMonths(['date'=>$monthsList], 'date');
        $monthsData = [];
        foreach($monthsInfo as $monthKey=>$days) {
            if(isset($expenses[$monthKey])) {
                $monthsData[$monthKey]['expenses'] = $expenses[$monthKey]->expenses;
                $monthsData[$monthKey]['days_in_month'] = $this->getDaysInMonth($monthKey);
                $monthsData[$monthKey]['days'] = $days;
            }
        }
        
        $expensesByMonths = [];
        $totalExpenses = 0;
        foreach($monthsData as $monthData) {
            if (empty($monthData['expenses']) || !is_array($monthData['expenses'])) {
                continue;
            }

            foreach($monthData['expenses'] as $expenseName=>$expenseAmount) {
                $expenseSum = round(($expenseAmount / $monthData['days_in_month']) * $monthData['days']);
                $totalExpenses += $expenseSum;
                if(!isset($expensesByMonths[$expenseName]))
                    $expensesByMonths[$expenseName] = $expenseSum;
                else
                    $expensesByMonths[$expenseName] += $expenseSum;
            }
        }

        $productsWithoutCost = false;
        if(!empty($productsWithoutCostIds)) {
            $productsWithoutCost = $productsEntity->find(['id'=>$productsWithoutCostIds]);
        }
        $this->design->assign('products_without_cost', $productsWithoutCost);

        $this->design->assign('completed_and_sent', $completedAndSent);

        $this->design->assign('total_expenses', $totalExpenses);
        $this->design->assign('expenses_by_months', $expensesByMonths);
        $this->design->assign('stats', $stats);
        $this->design->assign('from_date', $filter['from_date']);
        $this->design->assign('to_date', $filter['to_date']);

        $this->response->setContent($this->design->fetch('profit_and_expenses_stats.tpl'));
    }

    private function getMonths($firstDay, $lastDay) {
        $months = [];
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($firstDay, $interval, (clone $lastDay)->modify('+1 day'));

        foreach ($period as $day) {
            $month = $day->format('m.y');
            if(!isset($months[$month]))
                $months[$month] = 1;
            else
                $months[$month] += 1;
        }
        return $months;
    }
    private function getDaysInMonth($monthYear) {
        list($month, $year) = explode('.', $monthYear);
        $year = '20' . $year;
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        return $daysInMonth;
    }
}
