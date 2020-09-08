<?php

namespace Dcat\Admin\Extension\VillageDistpicker;

use Dcat\Admin\Grid\Filter\Presenter\Presenter;

class FilterPresenter extends Presenter
{
    public function view() : string
    {
        return 'village-distpicker::filter';
    }
}
