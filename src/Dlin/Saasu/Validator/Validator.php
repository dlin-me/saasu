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

    protected $value; //holder for value to be validated
    protected $field; //holder for the name of the date being examined
    protected $errors; //holder for any errors

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
        if($condition && ($this->value !==null || !$unlessNull)){
            list(, $caller) = debug_backtrace(false);
            $this->errors[$this->field] = $caller['function'];
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

    /**
     * Verify if a required value is set.
     * @param bool $yes  If true, a non-null value is required
     *
     * @return $this|Validator
     */
    public function required($yes=false)
    {
        return $yes ? $this->markErrorIf($this->value===null, false) : $this;
    }

    /**
     * Verify if the value is one of the parameter
     * @return $this
     */
    public function enum()
    {
        return $this->markErrorIf(!in_array($this->value, func_get_args()));
    }

    /**
     * Verify if the value exist in the given array
     *
     * @param $array
     * @return $this
     */
    public function inArray($array)
    {
        return $this->markErrorIf(!in_array($this->value, $array));
    }

    /**
     * Verify numeric (numeric string)
     * @return $this
     */
    public function numeric()
    {
        return $this->markErrorIf(!is_numeric($this->value));
    }

    /**
     * Verify a integer value (integer string)
     * @return $this
     */
    public function int()
    {
        return $this->markErrorIf(!is_numeric($this->value) || strval(intval($this->value)) != strval($this->value) );
    }

    /**
     * Verify a boolean value ( boolean string, i.e. 'true' and 'false' )
     *
     * @return $this
     */
    public function bool()
    {
        return $this->markErrorIf(!in_array(strtoupper($this->value), array('TRUE','FALSE')));
    }



    /**
     * Verify the length of the value is within the range
     *
     * @param $min
     * @param int $max
     * @return $this
     */
    public function length($min, $max = PHP_INT_MAX)
    {
        return $this->markErrorIf(strlen($this->value) < $min || strlen($this->value) > $max);
    }


    /**
     * Verify a email string value
     *
     * @return $this
     */
    public function email()
    {
        return $this->markErrorIf(!filter_var($this->value, FILTER_VALIDATE_EMAIL));
    }

    /**
     * Verify a URL string
     * @return $this
     */
    public function url()
    {
        return $this->markErrorIf(!filter_var($this->value, FILTER_VALIDATE_URL)) ;
    }

    /**
     * Verify the string value matches the regular expression pattern
     *
     *
     * @param $regex
     * @return $this
     */
    public function regex($regex)
    { //e.g. "/^M(.*)/"
        return $this->markErrorIf(!filter_var($this->value, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $regex)))) ;
    }

    /**
     * Verify the string complies with ISO 8061 date string
     *
     * @return $this
     */
    public function date(){
        return $this->markErrorIf(!$this->validateDate($this->value));
    }

    /**
     * Verify the string complies with ISO 8061 date string with time part
     *
     * @return $this
     */
    public function dateTime(){
        return $this->markErrorIf(!$this->validateDateTime($this->value));
    }

    /**
     * Internally used for matching date/time string
     * @param $datetime
     * @return bool
     */
    private function validateDateTime($datetime)
    {
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})$/', $datetime, $parts) == true) {
            $time = gmmktime($parts[4], $parts[5], $parts[6], $parts[2], $parts[3], $parts[1]);

            $input_time = strtotime($date);
            if ($input_time === false) return false;

            return $input_time == $time;
        } else {
            return false;
        }
    }

    /**
     *
     * Internally used for matching date string
     * @param $date
     * @return bool
     */
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

    /**
     * Verifying the value is within given range
     *
     * @param $min
     * @param $max
     * @return $this
     */
    public function minMax($min, $max=PHP_INT_MAX){
        return $this->markErrorIf($this->value < $min || $this->value > $max);
    }


    /**
     * Verify greater than
     *
     * @param $value
     */
    public function gt($value){
        return $this->markErrorIf($this->value <= $value);
    }

    /**
     * Verify not greater than
     * @param $value
     */
    public function nqt($value){
        return $this->markErrorIf($this->value > $value);
    }


    /**
     * Verify not equal
     *
     * @param $value
     */
    public function neq($value){
        return $this->markErrorIf($this->value == $value);
    }



    /**
     * Verify less than
     *
     * @param $value
     */
    public function lt($value){
        return $this->markErrorIf($this->value >= $value);
    }

    /**
     * Verify not less than
     *
     * @param $value
     */
    public function nlt($value){
        return $this->markErrorIf($this->value < $value);
    }




    /**
     * Verify the value and given value is exclusive. (at least one of them must be null, but they can both be none)
     * @param $value
     */
    public function exor($value){
        if($this->value !== null){
            return $this->markErrorIf($value !== null);
        }
        if($value !== null){
            return $this->markErrorIf($this->value !== null);
        }
        return $this;
    }

    /**
     * Verify the value and given value are both not null or both null.
     * @param $value
     */
    public function exnor($value) {
        if($this->value !== null){
            return $this->markErrorIf($value === null);
        }
        if($value !== null){
            return $this->markErrorIf($this->value === null);
        }
        return $this;
    }


}