<?php

class Rules {
    public function required($value)
    {
        if (is_null($value) || $value === '' || (isset($value['size']) && $value['size'] <= 0)) {
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

    public function ageWithin($value, $rule){
        $date = new \DateTime($value);
        $today = new \DateTime();
        $difDate = $today->diff($date)->y;
        if($difDate > $rule) {
            return 1;        
        }
        return 0;
    }
    
    public function fileSize($value,$max){
        if($value['size'] > ($max * 1048576)) {
            return 1;
        }
        return 0;
    }

    public function fileType($value,$ruleValueArray){
       // check for image type
        if(!in_array(strtolower(pathinfo($value['name'], PATHINFO_EXTENSION)), $ruleValueArray)) {
           return 1;
        }
        return 0;
    }
    
    public function is_number($value)
    {
        if(is_numeric($value)) {
            return 1;
        }
        return 0;
    }
    public function specialCharacterNotNumber($value)
    {
        if(preg_match('/[0-9]|[^a-zA-Z\s\p{L}\'-]/u', $value)) {
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

}
