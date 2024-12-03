<?php

class Rules {
    public function required($value)
    {
        if (is_null($value) || $value === '' || (isset($value['size']) && $value['size'] <= 0)) {
            return 1;
        }
        return 0; 
    }
    public function lengthNotGreaterThan($value, $rule)
    {
        if (strlen($value) > $rule) {
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
