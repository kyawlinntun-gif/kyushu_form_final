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
    
    public function notNumber($value)
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
