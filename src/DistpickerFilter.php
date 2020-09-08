<?php

namespace Dcat\Admin\Extension\VillageDistpicker;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Filter\AbstractFilter;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Dcat\Admin\Grid\Filter;

class DistpickerFilter extends AbstractFilter
{
    /**
     * @var array
     */
    protected $column = '';
    protected $field_name = '';

    protected static $js = [
        'vendors/dcat-admin-extensions/village-distpicker/dist/distpicker.js'
    ];

    /**
     * @var array
     */
    protected $value = [];

    /**
     * @var array
     */
    protected $defaultValue = [];

    /**
     * DistpickerFilter constructor.
     *
     * @param string $province
     * @param string $city
     * @param string $district
     * @param string $label
     */
    public function __construct($province, $city, $district,$town,$village, $label = '')
    {
        $this->field_name= compact('province', 'city', 'district','town','village');

        $this->label  = $label;

        $this->setPresenter(new FilterPresenter());
    }

    public function setParent(Filter $filter)
    {
        $this->parent = $filter;

        $this->id = $this->formatId($this->column);
    }


    /**
     * {@inheritdoc}
     */
    public function getColumn()
    {
        $columns = [];

        $parentName = $this->parent->getName();

        foreach ($this->column as $column) {
            $columns[] = $parentName ? "{$parentName}_{$column}" : $column;
        }

        return $columns;
    }

    /**
     * {@inheritdoc}
     */
    public function condition($inputs)
    {
        $value = array_filter([
            $this->field_name['province'] => Arr::get($inputs, $this->field_name['province']),
            $this->field_name['city']     => Arr::get($inputs, $this->field_name['city']),
            $this->field_name['district'] => Arr::get($inputs, $this->field_name['district']),
            $this->field_name['town']     => Arr::get($inputs, $this->field_name['town']),
            $this->field_name['village'] => Arr::get($inputs, $this->field_name['village']),
        ]);

        if (!isset($value)) {
            return;
        }

        $this->value = $value;

         if (!$this->value) {
            return [];
        }


        if (Str::contains(key($value), '.')) {
            return $this->buildRelationQuery($value);
        }

        return [$this->query => [$value]];
    }

    /**
     * {@inheritdoc}
     */
    protected function buildRelationQuery(...$columns)
    {
        $data = [];

        foreach ($columns as $column => $value) {
            Arr::set($data, $column, $value);
        }

        $relation = key($data);

        $args = $data[$relation];

        return ['whereHas' => [$relation, function ($relation) use ($args) {
            call_user_func_array([$relation, $this->query], [$args]);
        }]];
    }

    /**
     * {@inheritdoc}
     */
    public function formatName($column)
    {
        $columns = [];

        foreach ($column as $col => $name) {
            $columns[$col] = parent::formatName($name);
        }

        return $columns;
    }

    protected function formatId($columns)
    {
        return str_replace('.', '_', $columns);
    }

    /**
     * Setup js scripts.
     */
    protected function setupScript()
    {
        $province = old($this->field_name['province'], Arr::get($this->value, $this->field_name['province']));
        $city     = old($this->field_name['city'], Arr::get($this->value, $this->field_name['city']));
        $district = old($this->field_name['district'], Arr::get($this->value, $this->field_name['district']));
        $town = old($this->field_name['town'], Arr::get($this->value, $this->field_name['town']));
        $village = old($this->field_name['village'], Arr::get($this->value, $this->field_name['village']));



        $script = <<<JS
$("#{$this->id}").distpicker({
  province: '$province',
  city: '$city',
  district: '$district',
  town: '$town',
  village: '$village',
});
JS;
        Admin::script($script);
        Admin::js(static::$js);
    }

    /**
     * {@inheritdoc}
     */
    protected function variables()
    {
        $this->id = 'distpicker-filter-' . uniqid();

        $this->setupScript();

        return array_merge([
            'id'        => $this->id,
            'name'      => $this->formatName($this->field_name),
            'label'     => $this->label,
            'value'     => $this->value ?: $this->defaultValue,
            'presenter' => $this->presenter(),
        ], $this->presenter()->variables());
    }

    public function render()
    {
        return view('village-distpicker::filter', $this->variables());
    }
}
