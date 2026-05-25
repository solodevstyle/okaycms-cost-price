<?php


namespace Okay\Modules\SoloDevStyle\CostPrice\Extenders;

use Okay\Core\Modules\Extender\ExtenderFacade;
use Okay\Core\Modules\Extender\ExtensionInterface;
use Okay\Core\EntityFactory;
use Okay\Entities\VariantsEntity;

use Okay\Modules\SoloDevStyle\CostPrice\Requests\CostPriceRequest;
use Okay\Modules\SoloDevStyle\CostPrice\Entities\CostPriceReportStatEntity;

class BackendExtender implements ExtensionInterface
{

    private $entityFactory;
    private $costPriceRequest;

    public function __construct(
        EntityFactory     $entityFactory,
        CostPriceRequest  $costPriceRequest
    )
    {
        $this->entityFactory = $entityFactory;
        $this->costPriceRequest = $costPriceRequest;
    }

    public function updateStocksAndPrices() {
        if($costPrices = $this->costPriceRequest->postCostPrices()) {
            $variantsEntity = $this->entityFactory->get(VariantsEntity::class);
            foreach($costPrices as $id=>$price) {
                $variantsEntity->update($id, ['cost_price'=>str_replace(',', '.', $price)]);
            }
        }
    }
    public function find($result, $filter) {
        $costPriceReportStatEntity = $this->entityFactory->get(CostPriceReportStatEntity::class);
        $result = $costPriceReportStatEntity->find($filter);
        return ExtenderFacade::execute(__METHOD__, $result, func_get_args());
    }
}
