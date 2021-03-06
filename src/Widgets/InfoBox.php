<?php

namespace Encore\Admin\Widgets;

use Illuminate\Contracts\Support\Renderable;

class InfoBox extends Widget implements Renderable
{
    protected $attributes = [];

    /**
     * InfoBox constructor.
     *
     * @param string $name
     * @param string $icon
     * @param string $color
     * @param string $link
     * @param string $info
     *
     * @return InfoBox
     */
    public function __construct($name, $icon, $color, $link, $info)
    {
        $this->attributes = [
            'name'  => $name,
            'icon'  => $icon,
            'color' => $color,
            'link'  => $link,
            'info'  => $info
        ];

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        return view('admin::widgets.infoBox', $this->attributes)->render();
    }
}
