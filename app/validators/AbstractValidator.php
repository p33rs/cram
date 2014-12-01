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

    const T_A = '{';
    const T_P = '}';

    /**
     * @param array $data Data to validate
     */
    public function __construct(Array $data, array $tokens = [])
    {
        foreach ($tokens as $token => $value) {
            $string = self::T_A . $token . self::T_P;
            foreach ($this->rules as $key => $rule) {
                $this->rules[$key] = str_replace($string, $value, $rule);
            }
        }
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