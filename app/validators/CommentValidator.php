<?php
namespace cram\validators;
class CommentValidator extends AbstractValidator
{

    protected $rules = [
        'text' => 'required|max:2048',
        'id' => 'exists:photos'
    ];

}