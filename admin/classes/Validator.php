<?php

namespace Admin\Classes;

class Validator
{
    private $inputs;
    private $rules;
    private $errors = [];

    /**
     * Validator constructor.
     *
     * @param $inputs
     * @param $rules
     */
    public function __construct($inputs, $rules)
    {
        $this->inputs = $inputs;
        $this->rules = $rules;
    }

    /**
     * Validate inputs.
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function validate()
    {
        $positive = true;

        foreach ($this->rules as $inputName => $rules) {
            $rules = explode('|', $rules);
            $found = false;

            foreach ($this->inputs as $name => $value)
                if ($name == $inputName) {
                    $found = true;
                    break;
                }

            if ($found) {
                foreach ($rules as $rule) {
                    $param = null;

                    if (strpos($rule, ':') !== false) {
                        $ruleInfo = explode(':', $rule);
                        $rule = $ruleInfo[0];
                        $param = $ruleInfo[1];
                    }

                    if (method_exists($this, $rule)) {
                        if (!$this->$rule($name, $value, $param))
                            $positive = false;
                    } else
                        throw new \Exception("Rule: ".$rule." is invalid");

                }
            } else if (!$found && in_array('required', $rules)) {
                $positive = false;
                $this->addError($name, ':name', $name, 'required');
            }
        }

        return $positive;
    }

    /**
     * Return validation errors;
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Add validation error.
     *
     * @param $name
     * @param $search
     * @param $replace
     * @param string $rule
     *
     * @throws \Exception
     */
    private function addError($name, $search, $replace, $rule = '')
    {
        if ($rule == '')
            $rule = $this->getPreviousMethod();
        $this->errors[$name][] = ['error' => $this->getErrorInfo($rule, $search, $replace), 'rule' => $rule];
    }

    /**
     * Get info for validation error.
     *
     * @param $rule
     * @param $search
     * @param $replace
     *
     * @return mixed
     *
     * @throws \Exception
     */
    private function getErrorInfo($rule, $search, $replace)
    {
        $info = [
            'required'      => 'Pole :name jest wymagane',
            'minLength'     => 'Pole :name musi posiadać przynajmniej :x znaków',
            'maxLength'     => 'Pole :name musi posiadać maksymalnie :x znaków',
            'number'        => 'Pole :name musi być liczbą',
            'min'           => 'Pole :name nie może być mniejsze niż :x',
            'max'           => 'Pole :name nie może być większe niż :x',
            'inArray'       => 'Pole :name musi mieć wartość z podanych: :x',
        ];

        if (!isset($info[$rule]))
            throw new \Exception('No error info for rule: '.$rule);
        else
            return str_replace($search, $replace, $info[$rule]);
    }

    /**
     * Get previous method name.
     *
     * @return mixed
     */
    private function getPreviousMethod()
    {
        return debug_backtrace()[2]['function'];
    }

    /**
     * Check if isset param.
     *
     * @param $param
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function isParam($param)
    {
        if (!$param)
            throw new \Exception('Rule '.$this->getPreviousMethod().' must contain parameter.');
        else
            return true;
    }

    /**
     * Required validation rule.
     * Check if value is passed.
     *
     * @param $name
     * @param $value
     * @param $param
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function required($name, $value, $param)
    {
        $this->getPreviousMethod();

        if (is_null($value) || strlen($value) == 0) {
            $this->addError($name, ':name', $name);
            return false;
        } else
            return true;
    }

    /**
     * Min length validation rule. (needs one param)
     * Check if value has no less than :x characters.
     *
     * @param $name
     * @param $value
     * @param $param
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function minLength($name, $value, $param)
    {
        if ($this->isParam($param)) {
            if (strlen($value) < $param) {
                $this->addError($name, [':name', ':x'], [$name, $param]);
                return false;
            } else
                return true;
        } else
            return false;
    }

    /**
     * Max length validation rule. (needs one param)
     * Check if value has no more than :x characters.
     *
     * @param $name
     * @param $value
     * @param $param
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function maxLength($name, $value, $param)
    {
        if ($this->isParam($param)) {
            if (strlen($value) > $param) {
                $this->addError($name, [':name', ':x'], [$name, $param]);
                return false;
            } else
                return true;
        } else
            return false;
    }

    /**
     * Number validation rule.
     * Check if value is a number.
     *
     * @param $name
     * @param $value
     * @param $param
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function number($name, $value, $param)
    {
        if (!is_numeric($value)) {
            $this->addError($name, ':name', $name);
            return false;
        } else
            return true;
    }

    /**
     * Min validation rule.
     * Check if value is no less than :x.
     *
     * @param $name
     * @param $value
     * @param $param
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function min($name, $value, $param)
    {
        if ($this->isParam($param)) {
            if ($value < $param) {
                $this->addError($name, [':name', ':x'], [$name, $param]);
                return false;
            } else
                return true;
        } else
            return false;
    }

    /**
     * Max validation rule.
     * Check if value is no more than :x.
     *
     * @param $name
     * @param $value
     * @param $param
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function max($name, $value, $param)
    {
        if ($this->isParam($param)) {
            if ($value > $param) {
                $this->addError($name, [':name', ':x'], [$name, $param]);
                return false;
            } else
                return true;
        } else
            return false;
    }

    /**
     * In array validation rule.
     * Check if value is in param array.
     *
     * @param $name
     * @param $value
     * @param $param
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function inArray($name, $value, $param)
    {
        if ($this->isParam($param)) {
            $array = explode(',', $param);
            if (!in_array($value, $array)) {
                $this->addError($name, [':name', ':x'], [$name, $param]);
                return false;
            } else
                return true;
        } else
            return false;
    }
}