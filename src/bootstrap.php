<?php

// Register the extension.
//Dcat\Admin\Admin::extension(Dcat\Admin\Extension\VillageDistpicker\VillageDistpicker::class);

Dcat\Admin\Grid\Filter::extend('village_distpicker', \Dcat\Admin\Extension\VillageDistpicker\DistpickerFilter::class);

Dcat\Admin\Form::extend('village_distpicker', \Dcat\Admin\Extension\VillageDistpicker\Form\Distpicker::class);
