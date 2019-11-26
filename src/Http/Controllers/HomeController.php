<?php

namespace Davidhsianturi\Compass\Http\Controllers;

class HomeController
{
    /**
     * Display the Compass view.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('compass::layout', [
            'compassScriptVariables' => app('compass')->scriptVariables(),
            'assetsAreCurrent' => app('compass')->assetsAreCurrent(),
        ]);
    }
}
