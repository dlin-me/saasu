<?php
/**
 * 
 * User: davidlin
 * Date: 28/07/13
 * Time: 11:20 PM
 * 
 */

namespace Dlin\Saasu\Util;


class Throttler
{

    //throttle
    private $requestAllowed = 0;

    private $withinSeconds = 60;

    //internal request counter
    private $requestCounter = 0;

    //internal timer
    private $timeStart = 0;

    private $averageTime = 0;


    //Constructor
    public function __construct($requestAllowed, $withinSeconds)
    {
        if(!$requestAllowed || !$withinSeconds){
            throw new \Exception('invalie parameters');
        }
        $this->requestAllowed = $requestAllowed;
        $this->withinSeconds = $withinSeconds;
        $this->averageTime = $this->withinSeconds/$this->requestAllowed;
    }


    /**
     * This function apply time delay if required
     */
    public function throttle()
    {
        $i = explode(' ',microtime());
        $now =  floatval($i[0]) + floatval($i[1])%10000;
        $elasped = $now - $this->timeStart;

        if ($elasped >= $this->withinSeconds) {
            $this->timeStart = $now;
            $this->requestCounter = 0;
        }
        $this->requestCounter++;

        $margin = $this->requestCounter * $this->averageTime - $elasped;
        if($margin > 0){
            usleep($margin*1000000);

        }
    }

}