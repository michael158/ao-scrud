<?php

namespace AoScrud\Controllers\Site\Actions;


trait Delete
{

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function delete()
    {
        try {
            $data = $this->api->delete();
        } catch (\Exception $e) {
            alert()->danger($e->getMessage());
            return redirect()->route($this->routes . '.index', params()->forget('id'));
        }

        return view($this->views . '.delete', compact('data'));
    }

}