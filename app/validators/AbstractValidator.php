<?php
namespace cram\validators;
use Illuminate\Support\Facades\Validator;
abstract class AbstractValidator {

    /**
     * Instantiated here.
     * @var \Illuminate\Validation\Validator
     */
    private $validator;

    /**
     * @var array
     */
    protected $rules;

    /**
     * @param array $data Data to validate
     */
    public function __construct(Array $data)
    {
        $this->validator = Validator::make($data, $this->rules);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->validator->passes();
    }

    /**
     * @return array
     */
    public function errors()
    {
        $this->validator->passes();
        return $this->validator->errors();
    }

}