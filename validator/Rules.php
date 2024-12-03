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
    public function specialCharacter($value)
    {
        if (preg_match('/[0-9]/', $value)) {
            $this->addError($field, $customMessage ?: "This " . $fieldName . " can't contain numbers!");
        }
    }
}

if ($rule === 'specialCharacter&notNumber') {
    elseif (preg_match('/[^a-zA-Z\s\p{L}\'-]/u', $value)) {
        $this->addError($field, $customMessage ?: "This " . $fieldName . " can't contain special characters!");
    }
}