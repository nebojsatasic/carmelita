<?php

class Validator
{
    /**
     * @var array $_errors
     */
    private $_errors = array();

    /**
     * @var string $fieldName
     */
    public $fieldName;

    /**
     * Define validate rules
     *
     * @param array $src
     * @param array $rules
     * @return void
     */
    public function validate(array $src, array $rules = []): void
    {
        foreach ($src as $item => $item_value) {
            if (key_exists($item, $rules)) {
                foreach ($rules[$item] as $rule => $rule_value) {

                    if (is_int($rule)) {
                        $rule = $rule_value;
                    }

                    switch ($rule) {
                        case 'required':
                        if (empty($item_value) && $rule_value) {
                            $this->addError($item, ucwords($item) . ' is required.');
                        }
                        break;

                        case 'minLen':
                        if (strlen($item_value) < $rule_value) {
                            $this->addError($item, ucwords($item) . ' should be minimum ' . $rule_value . ' characters.');
                        }       
                        break;

                        case 'maxLen':
                        if (strlen($item_value) > $rule_value) {
                            $this->addError($item, ucwords($item) . ' should be maximum ' . $rule_value . ' characters.');
                        }
                        break;
/*
                        case 'numeric':
                        if (!ctype_digit($item_value) && $rule_value) {
                            $this->addError($item, ucwords($item) . ' should be numeric type of data.');
                        }
                        break;
*/
                        case 'alpha':
                        if (!ctype_alpha($item_value) && $rule_value) {
                            $this->addError($item, ucwords($item) . ' should be alphabetic characters.');
                            }
                            break;

                        case 'email':
                        if (!filter_var($item_value, FILTER_VALIDATE_EMAIL)) {
                            $this->addError($item, ucwords($item) . ' should be a valid email address.');
                        }
                        break;

                        case 'unique':
                        $db_items = $rule_value::all()->where($item, $item_value)->fetch();
                        if (count($db_items) > 0) {
                            $this->addError($item, ucwords($item) . ' already exists.');
                        }
                        break;

                        case 'confirmation':
                        if ($item_value != $src[$rule_value]) {
                            $this->addError($item, ucwords($item) . ' confirmation does not match.');
                        }       
                        break;

                        case 'checkboxRequired':
                        if ($item_value != 'yes') {
                            $this->addError($item, ucwords($item) . ' is required.');
                        }
                        break;

                        case 'maxFileSize':
                        if ($item_value > $rule_value) {
                            $this->addError($item, ucwords($item) . ' is too large.');
                        }
                        break;

                        case 'allowedFileTypes':
                        if ($item_value) {                                           
                            if (($item_value == "jpg") || ($item_value == "jpeg") || ($item_value == "png")) {
                                // do nothing
                            } else {                            
                                $this->addError($item,ucwords($item). ' is not allowed.');
                            }
                        }
                        break;

                        case 'image':
                        if ($item_value) {                   
                            if (getimagesize($item_value) === false) {
                                $this->addError($item, ucwords($item) . ' must be an image.');
                            }                        
                        }
                        break;

                        case 'string':
                        if (!is_string($item_value)) {
                            $this->addError($item, ucwords($item) . ' must be of string type.');
                        }
                        break;

                        case 'numeric':
                        if (!is_numeric($item_value)) {
                            $this->addError($item, ucwords($item) . ' must be of numeric type.');
                        }
                        break;

                        case 'int':
                        if (!filter_var($item_value, FILTER_VALIDATE_INT)) {
                            $this->addError($item, ucwords($item) . ' must be of integer type.');
                        }
                        break;

                        case 'higherThan':
                        if ($item_value <= $rule_value) {
                            $this->addError($item, ucwords($item) . ' must be higher than ' . $rule_value . '.');
                        }
                        break;

                    }
                }
            }
        }    
    }

    /**
     * Add an error to the array of errors
     *
     * @param string $item
     * @param string $error
     * @return void
     */
    public function addError($item, $error): void
    {
        $this->_errors[$item][] = $error;
    }

    /**
     * Get errors
     *
     * @return bool|array
     */
    public function getErrors(): bool | array
    {
        if (empty($this->_errors)) {
            return false;
        }
        return $this->_errors;
    }

    /**
     * Add errors to the session
     *
     * @return void
     */
    public function showErrors(): void
    {
        Session::set('validErrors', $this->_errors);
    }
}
