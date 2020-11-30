<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Button extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'type' => null,
        'buttontype' => null,
        'id' => null,
        'name' => null,
        'size' => null,
        'theme' => null,
        'class' => null,
        'data-toggle' => null,
        'data-target' => null,
        'data-dismiss' => null,
        'value' => null,
        'icon' => null,
        'iconclass' => null,
        'text' => null,
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //

        return view('widgets.button', [
            'config' => $this->config,
        ]);
    }
}
