<?php


namespace Okay\Modules\SoloDevMan\CostPrice\Backend\Controllers;

use Okay\Admin\Controllers\IndexAdmin;

class CostPriceAdmin extends IndexAdmin
{
    public function fetch()
    {
        $this->response->setContent($this->design->fetch('module_page.tpl'));
    }
}