<?php
class Rules {
    public function required($value)
    {
        if(is_array($value)) {
            if (empty($value) || (isset($value['size']) && $value['size'] <= 0)) {
                return 1;
            }
            return 0; 
        }
        if (is_null(trim($value)) || trim($value) === '' || (isset($value['size']) && $value['size'] <= 0)) {
            return 1;
        }
        return 0; 
    }
    //string length
    public function lengthNotGreaterThan($value, $rule)
    {
        if (strlen($value) > $rule) {
            return 1;
        }
        return 0;
    }
    public function lengthBetween($value,$min,$max){
        if(strlen($value) < $min || strlen($value) > $max) {
           return 1;
        }
        return 0;
    }
    public function date($value)
    {
        if(!preg_match('/^(1\d{3}|2\d{3})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/', $value)) {
            return 1;
        }
        return 0;
    }
    public function notToday($value)
    {
        $date = new \DateTime($value);
        $today = new \DateTime();
        if($date > $today) {
            return 1;            
        }
        return 0;
    }
    public function ageWithin($value,$rule)
    {
        $date = new \DateTime($value);
        $maxInterval = DateInterval::createFromDateString("$rule years");
        $today = new DateTime();
        $limit = (clone $today)->sub($maxInterval);
        if( $limit  >=   $date ) {
            return 1;        
        }
        return 0;        
    }
    public function fileSize($value, $max)
    {
        if($value > ($max * 1048576)) {
            return 1;
        }
        return 0;
    }
    public function fileType($value, $rule)
    {
        if(!in_array(strtolower(pathinfo($value, PATHINFO_EXTENSION)), $rule)) {
           return 1;
        }
        return 0;
    }
    public function isNumber($value)
    {
        if(!is_numeric($value)) {
            return 1;
        }
        return 0;
    }
    public function specialCharacter($value)
    {
        if(preg_match('/[^a-zA-Z0-9\s\p{L}\'-]/u', $value)) {
            return 1;
        }
        return 0;
    }
    public function checkEmail($value)
    {
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 1;
        }
        return 0;
    }
    public function notContainNumber($value)
    {
        
        if(preg_match('/\d/', $value)){
            return 1;
        }
        return 0;
    }

}
