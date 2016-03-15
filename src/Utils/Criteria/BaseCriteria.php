<?php

namespace AoScrud\Utils\Criteria;

abstract class BaseCriteria
{

    /**
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Query\Builder $query
     * @param \Illuminate\Support\Collection $data
     * @param \AoScrud\Services\ScrudService $service
     * @return mixed
     */
    abstract public function apply($query, $data, $service);

}