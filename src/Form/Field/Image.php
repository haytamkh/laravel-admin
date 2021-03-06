<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;
use Intervention\Image\ImageManagerStatic;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Image extends File
{
    protected $rules = 'image';

    protected $calls = [];

    public function prepare(UploadedFile $image = null)
    {
        if (is_null($image)) {
            if ($this->isDeleteRequest()) {
                return '';
            }

            return $this->original;
        }

        $this->directory = $this->directory ? $this->directory : config('admin.upload.image');

        $this->name = $this->name ? $this->name : $image->getClientOriginalName();

        $target = $this->uploadAndDeleteOriginal($image);

        $target = $this->executeCalls($target);

        return trim(str_replace(public_path(), '', $target->__toString()), '/');
    }

    /**
     * @param $target
     * @return mixed
     */
    public function executeCalls($target)
    {
        if (! empty($this->calls)) {

            $image = ImageManagerStatic::make($target);

            foreach ($this->calls as $call) {
                call_user_func_array([$image, $call['method']], $call['arguments'])->save($target);
            }
        }

        return $target;
    }

    protected function preview()
    {
        return '<img src="/' . $this->value . '" class="file-preview-image">';
    }

    public function render()
    {
        $this->options(['allowedFileTypes' => ['image']]);

        return parent::render();
    }

    public function __call($method, $arguments)
    {
        $this->calls[] = [
            'method' => $method,
            'arguments' => $arguments
        ];

        return $this;
    }
}
