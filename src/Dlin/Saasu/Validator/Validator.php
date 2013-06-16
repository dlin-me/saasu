<?php

namespace Dlin\Saasu\Validator;
/**
 *
 * User: davidlin
 * Date: 6/06/13
 * Time: 11:43 PM
 *
 */

class Validator
{

    protected $value;
    protected $field;
    protected $errors;

    /**
     * Static instance generator
     * @return Validator
     */
    public static function instance()
    {
        return new Validator();
    }

    /**
     * Change the value currently being validated
     * @param $value
     * @return $this
     */
    public function lookAt($value, $field)
    {
        $this->value = $value;
        $this->field = $field;
        return $this;

    }

    /**
     * Simple record the error, the error is just the function name
     */
    public function markErrorIf($condition, $unlessNull=true){
        if($condition && (!is_null($this->value) || $unlessNull)){
            list(, $caller) = debug_backtrace(false);
            $this->errors[$this->field] = $caller;
        }
        return $this;
    }



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->errors = array();
    }

    /**
     * Return all validation error
     * @return array
     */
    public function getErrors(){
        return $this->errors;
    }



    /***************************************
     *
     * General Validation
     *
     **************************************/
    public function required($yes=false)
    {
        return $yes ? $this->markErrorIf(is_null($this->value), false) : $this;
    }

    public function enum()
    {
        return $this->markErrorIf(!in_array($this->value, func_get_args()));
    }

    public function enumArray($array)
    {
        return $this->markErrorIf(!in_array($this->value, $array));
    }

    public function numeric()
    {
        return $this->markErrorIf(!is_numeric($this->value));
    }

    public function int()
    {
        return $this->markErrorIf(!is_numeric($this->value) || strval(intval($this->value)) != strval($this->value) );
    }

    public function bool()
    {
        return $this->markErrorIf(!in_array(strtoupper($this->value), array('TRUE','FALSE')));
    }


    /***************************************
     *
     * String Validation
     *
     **************************************/


    public function length($min, $max = PHP_INT_MAX)
    {
        return $this->markErrorIf(strlen($this->value) < $min || strlen($this->value) > $max);
    }

    public function email()
    {
        return $this->markErrorIf(!filter_var($this->value, FILTER_VALIDATE_EMAIL));
    }


    public function url()
    {
        return $this->markErrorIf(!filter_var($this->value, FILTER_VALIDATE_URL)) ;
    }

    public function regex($regex)
    { //e.g. "/^M(.*)/"
        return $this->markErrorIf(!filter_var($this->value, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $regex)))) ;
    }

    public function date(){
        return $this->markErrorIf(!$this->validateDate($this->value));
    }

    public function dateTime(){
        return $this->markErrorIf(!$this->validateDateTime($this->value));
    }

    private function validateDateTime($datetime)
    {
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})$/', $date, $parts) == true) {
            $time = gmmktime($parts[4], $parts[5], $parts[6], $parts[2], $parts[3], $parts[1]);

            $input_time = strtotime($date);
            if ($input_time === false) return false;

            return $input_time == $time;
        } else {
            return false;
        }
    }

    private function validateDate($date)
    {
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $parts) == true) {
            $time = gmmktime(0, 0, 0, $parts[2], $parts[3], $parts[1]);

            $input_time = strtotime($date);
            if ($input_time === false) return false;

            return $input_time == $time;
        } else {
            return false;
        }
    }

    /***************************************
     *
     * Int Validation
     *
     **************************************/
    public function size($min, $max){
        return $this->markErrorIf($this->value < $min || $this->value > $max);
    }




}