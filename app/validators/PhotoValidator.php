<?php
namespace cram\validators;
class PhotoValidator extends AbstractValidator
{

    protected $rules = [
        'photo' => 'required|image|max:2000',
        'title' => 'required|min:4|max:140',
        'caption' => 'max:2048'
    ];

}