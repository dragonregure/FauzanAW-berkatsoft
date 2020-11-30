<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class ViewTable extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'data' => [
            'example1' => 'Example 1',
            'example2' => 'Example 2'
        ]
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //

        return view('widgets.view_table', [
            'config' => $this->config,
        ]);
    }
}
