<?php

namespace App\Admin\Extension\Form;

use Encore\Admin\Form\Field\ImageField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Image extends File
{
    use ImageField;

    /**
     * {@inheritdoc}
     */
    protected $view = 'admin::form.file';

    /**
     *  Validation rules.
     *
     * @var string
     */
    protected $rules = 'image';

    /**
     * @param array|UploadedFile $image
     *
     * @return string
     */
    public function prepare($image)
    {
        if (is_string($image)) {
            return $image;
        }

        if ($this->picker) {
            return parent::prepare($image);
        }

        if (request()->has(static::FILE_DELETE_FLAG)) {
            return $this->destroy();
        }


        if (is_null($image)) {
            return $image;
        }elseif (is_string($image)) {
            return $image;
        }else{
           $this->name = $this->getStoreName($image);

           $this->callInterventionMethods($image->getRealPath());

           $path = $this->uploadAndDeleteOriginal($image);

           $this->uploadAndDeleteOriginalThumbnail($image);

           return $path;
        }


        return $image;
        
    }
}
