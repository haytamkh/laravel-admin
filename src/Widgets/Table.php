<?php

namespace Encore\Admin\Widgets;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;

class Table extends Widget implements Renderable
{
    protected $headers = [];

    protected $rows = [];

    protected $style = [];

    public function __construct($headers = [], $rows = [], $style = [])
    {
        $this->setHeaders($headers);
        $this->setRows($rows);
        $this->setStyle($style);
    }

    public function setHeaders($headers = [])
    {
        $this->headers = $headers;

        return $this;
    }

    public function setRows($rows = [])
    {
        if (Arr::isAssoc($rows)) {
            foreach($rows as $key => $item) {
                $this->rows[] = [$key, $item];
            }

            return $this;
        }

        $this->rows = $rows;

        return $this;
    }

    public function setStyle($style = [])
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $vars = [
            'headers' => $this->headers,
            'rows'    => $this->rows,
            'style'   => $this->style
        ];

        return view('admin::widgets.table', $vars)->render();
    }
}
