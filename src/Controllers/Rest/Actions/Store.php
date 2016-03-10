<?php

namespace AoScrud\Controllers\Rest\Actions;

trait Store
{

    public function store()
    {
        try {
            $data = $this->api->create();
        } catch (\Exception $e) {
            throw $e;
        }

        return response()->json($this->toArray($data), 201);
    }

}