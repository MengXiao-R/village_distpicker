<?php

namespace Dcat\Admin\Extension\VillageDistpicker;

use Dcat\Admin\Extension;

class VillageDistpicker extends Extension
{
    const NAME = 'village-distpicker';
    public $name = 'village-distpicker';

    protected $serviceProvider = VillageDistpickerServiceProvider::class;

    protected $composer = __DIR__.'/../composer.json';

    protected $assets = __DIR__.'/../resources/assets';

    protected $views = __DIR__.'/../resources/views';

//    protected $lang = __DIR__.'/../resources/lang';
}
