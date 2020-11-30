<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class FormInput extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'type' => 'text',
        'label' => null,
        'id' => null,
        'name' => null,
        'readonly' => false,
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //

        return view('widgets.form_input', [
            'config' => $this->config,
        ]);
    }
}
