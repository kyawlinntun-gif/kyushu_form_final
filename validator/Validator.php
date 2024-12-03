<?php
require (VALIDATOR . 'Rules.php');
class Validator {
    protected $data;
    protected $errors = [];
    protected $rules = [];
    protected $customMessages = [];

    // Constructor to initialize data, rules, and custom messages
    public function __construct($data, $rules, $customMessages = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->customMessages = $customMessages;
    }

    // Start validating the data
    public function validate()
    {
        foreach ($this->rules as $field => $rules) {
            $value = isset($this->data[$field]) ? $this->data[$field] : null;
            $rulesArray = explode('|', $rules);

            // Check for input
            $field = $field === 'nationalityInput' ? 'nationality' : $field;
            $field = $field === 'tNationalityInput' ? 'tNationality' : $field;
            $field = $field === 'campaignInput' ? 'campaign' : $field;

            foreach ($rulesArray as $rule) {
                $this->applyRule($field, $rule, $value);
            }
        }

        return empty($this->errors); // Return true if no errors, false if errors exist
    }

    // Apply individual rule to the field
    protected function applyRule($field, $rule, $value)
    {
        // Dyanmic Error field
        $fieldName = strtolower(trim(preg_replace('/([a-z])([A-Z])|_/', '$1 $2', $field)));
        $field === 'gRadio' ? $fieldName = "gender" : '';
        $field === 'tFirstName' ? $fieldName = "first name" : '';
        $field === 'tLastName' ? $fieldName = "last name" : '';
        $field === 'gFirstName' ? $fieldName = "first name" : '';
        $field === 'gLastName' ? $fieldName = 'last name' : '';
        $field === 'tDob' ?  $fieldName = 'dob' : '';
        $field === 'sgRadio' ? $fieldName = 'sgRadio' : ''; 
        $field === 'tNationality' ? $fieldName = 'nationality' : '';
        $field === 'tDietary' ? $fieldName = 'dietary' : '';
        $field === 'tPeriod' ? $fieldName = 'period' : '';
        $field === 'uVideo' ? $fieldName = 'upload video' : '';

        // Dynamic rule
        $parts = explode(':', $rule);
        $rule = $parts[0];
        if(count($parts) > 1) {
            $ruleValueArray = explode(',', $parts[1]);
        }

        // Check for custom error message for the field and rule
        $customMessage = $this->getCustomErrorMessage($field, $rule);

        $ruleFunction = new Rules();

        // Check for required field
        if($rule === 'required' && $ruleFunction->required($value)) {
            if($ruleFunction->required($value)) {
                $this->addError($field, $customMessage ?: "This " . $fieldName . " is required!");
            }
        }

        // Custom nationality validation: "Other" selected but input is empty
        if ($rule === 'nationalityOtherRequired') {
            if (isset($this->data['nationality']) && $this->data['nationality'] === 'other' && $ruleFunction->required($value)) {
                $this->addError($field, $customMessage ?: "This other " . $fieldName . " is required!");
            }
            if (isset($this->data['tNationality']) && $this->data['tNationality'] === 'other' && $ruleFunction->required($value)) {
                $this->addError($field, $customMessage ?: "This other" . $fieldName . " is required!");
            }
        }

        // Check for length should not greater than variable number field
        if($rule === 'lengthNotGreaterThan' && $ruleFunction->lengthNotGreaterThan($value, $rule))
        {
            $this->addError($field, $customMessage ?: "This " . $fieldName . " must not be exceed " . $ruleValueArray[0] . " characters!");

        }

        // Check for length of years should not greater than 4 field
        if($rule === 'year') {
            if (!preg_match('/^(1\d{3}|2\d{3})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/', $value)) {
                $this->addError($field, $customMessage ?: "Year must be valid!");
            }
        }
            
        // Check for date should not greater than today field
        if($rule === 'now') {
            $date = new \DateTime($value);
            $today = new \DateTime();
            if($date > $today) {
                $this->addError($field, $customMessage ?: "This " . $fieldName . " should not be greater than today!");
            }
        }
        
        // Check for age should not greater than variable age field
        if($rule === 'ageNotGreaterThan') {
            $date = new \DateTime($value);
            $today = new \DateTime();
            $difDate = $today->diff($date)->y;
            if($difDate > $ruleValueArray[0]) {
                $this->addError($field, $customMessage ?: "This " . $fieldName ." must be within " . $ruleValueArray[0] . " years!");
            }
        }

        // Check for specialchars and numbers field
        if ($rule === 'specialCharacter&notNumber') {
            if (preg_match('/[0-9]/', $value)) {
                $this->addError($field, $customMessage ?: "This " . $fieldName . " can't contain numbers!");
            }
            elseif (preg_match('/[^a-zA-Z\s\p{L}\'-]/u', $value)) {
                $this->addError($field, $customMessage ?: "This " . $fieldName . " can't contain special characters!");
            }
        }
        
        // Check for username should not be a number
        if($rule === 'notNumber' && is_numeric($value)) {
            $this->addError($field, $customMessage ?: "This " . $fieldName . " should not be number!");
        }

        // Check if jpRadio is not never, region must be required
        if($rule === 'regionCheckNotNever' && $this->data['jpRadio'] !== 'never' && (is_null($value) || $value === '')) {
            $this->addError($field, $customMessage ?: "This ". $fieldName ." is required!");
        }

        // Check for email should be email format
        if($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, $customMessage ?: "This " . $fieldName . " must be a valid email address!");
        }

        // Check for phone field
        if($field === 'phone') {
            $formatValue = str_replace(['+', ' '], '', $value);
            // Check for phone should be number only
            if($rule === 'phoneNumber' && $ruleFunction->numberOnly($formatValue)) {
                $this->addError($field, $customMessage ?: "This " . $fieldName . " must contain only numbers!");
            } 
            // Check for phone number should be 7 and 25 digits
            if($rule === 'phoneBetween' && $ruleFunction->lengthBetween($formatValue,$ruleValueArray[0] ,$ruleValueArray[1]) ) {
                $this->addError($field, $customMessage ?: "This " . $fieldName . " must be between " . $ruleValueArray[0] . " and " . $ruleValueArray[1] . " digits!");
            }
        }

        // Check for image file size should not greater than variable value
        if($rule === 'fileSize' && $value['size'] > ($ruleValueArray[0] * 1048576)) {
            $this->addError($field, $customMessage ?: "This " . $fieldName . " must not be exceed " . $ruleValueArray[0] . "mb!");
        }

        // Custom campaign validation: "Other" selected but input is empty
        if ($rule === 'campaignOtherRequired') {
            if(isset($this->data['campaign']) && $this->data['campaign']) {
                if(in_array('other', $this->data['campaign']) && $ruleFunction->required($value)) {
                    $this->addError($field, $customMessage ?: "This other " . $fieldName . " is required");
                } 
            }
        }
    }

    // Add error message for a field
    protected function addError($field, $message)
    {
        if(!isset($this->errors[$field])) {
            $this->errors[$field] = $message;
        }
    }

    // Get the custom error message for a specific rule and field
    protected function getCustomErrorMessage($field, $rule)
    {
        if (isset($this->customMessages[$field][$rule])) {
            return $this->customMessages[$field][$rule];
        }

        // Return null if no custom message is set
        return null;
    }

    // Get all validation errors
    public function errors()
    {
        return $this->errors;
    }

    // Display errors for a specific field
    public function displayErrorsForField($fieldName)
    {
        return isset($this->errors[$fieldName]) ? $this->errors[$fieldName] : [];
    }
}

