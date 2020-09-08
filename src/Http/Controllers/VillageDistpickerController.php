<?php

namespace Dcat\Admin\Extension\VillageDistpicker\Http\Controllers;

use Dcat\Admin\Layout\Content;
use Illuminate\Routing\Controller;

class VillageDistpickerController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Title')
            ->description('Description')
            ->body(view('village-distpicker::index'));
    }
}