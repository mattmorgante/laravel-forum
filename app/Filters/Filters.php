<?php

namespace App\Filters;

use Illuminate\Http\Request;

// abstract class is never instantiated. it is only called by subclasses
abstract class Filters
{
    protected $request, $builder;

    protected $filters = [];

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function apply($builder) {
        // apply filters to the builder
        $this->builder = $builder;

        foreach($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function getFilters() {
        return $this->request->intersect($this->filters);
    }

}