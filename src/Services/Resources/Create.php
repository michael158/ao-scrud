<?php

namespace AoScrud\Services\Resources;

use AoScrud\Utils\Interceptors\SaveInterceptor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use PhpSpec\Exception\Exception;

trait Create
{

    /**
     * The allow fields to create.
     *
     * @var array
     */
    protected $createFillable = [];

    /**
     * The interceptor class to registry in the repository.
     *
     * @var SaveInterceptor[]
     */
    protected $createInterceptors = [];

    //------------------------------------------------------------------------------------------------------------------
    // MAIN METHOD
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Main method to registry in the repository.
     *
     * @param Collection|null $data
     * @return Model
     * @throws Exception
     */
    public function create(Collection $data = null)
    {
        $this->createPrepare(is_null($data) ? $data = $this->createParams() : $data);

        $this->tBegin();
        try {
            $obj = $this->createExecute($data);
        } catch (Exception $e) {
            $this->tRollBack();
            throw $e;
        }
        $this->tCommit();

        return $obj;
    }

    //------------------------------------------------------------------------------------------------------------------
    // AUXILIARY METHODS
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Return the data of request to registry.
     *
     * @return Collection
     */
    protected function createParams()
    {
        return collect(array_merge(request()->all(), request()->route()->parameters()));
    }

    /**
     * Run all preparations before create.
     *
     * @param Collection $data
     */
    protected function createPrepare(Collection $data)
    {
        $this->createFillable();
        $this->createInterceptors($data);
    }

    /**
     * Define the allow fields to create.
     */
    protected function createFillable()
    {
        //$this->rep->modelCurrent()->fillable($this->createFillable);
    }

    /**
     * Apply the interceptors in data before create.
     *
     * @param Collection $data
     * @return array
     */
    protected function createInterceptors(Collection $data)
    {
        foreach ($this->createInterceptors as $key => $interceptor) {
            if (is_string($interceptor) && is_subclass_of($interceptor, SaveInterceptor::class)) {
                $this->createInterceptors[$key] = $interceptor = app($interceptor);
            }
            is_object($interceptor) && $interceptor instanceof SaveInterceptor ? $interceptor->apply($data) : null;
        }
    }

    /**
     * Run create command in the repository.
     *
     * @param Collection $data
     * @return Model
     */
    protected function createExecute(Collection $data)
    {
        return $this->rep->create($data->all());
    }

}