<?php
require (VALIDATOR . 'Rules.php');
class Validator {
    protected $data;
    protected $errors = [];
    protected $rules = [];
    protected $customMessages = [];
    // Constructor to initialize data, rules, and custom messages
    public function __construct($data = null, $rules = null, $customMessages = [])
    {
        $this->data = $data ?? [];
        $this->rules = $rules ?? [];
        $this->customMessages = $customMessages;
    }
    // Start validating the data
    public function validate()
    {
        foreach ($this->rules as $field => $rules) {
            $value = isset($this->data[$field]) ? $this->data[$field] : null;
            $rulesArray = explode('|', $rules);
            // Check for input
            $field = $field === 'tNationalityInput' ? 'tNationality' : $field;
            $field = $field === 'nationalityInput' ? 'nationality' : $field;
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
        // Dynamic rule
        $parts = explode(':', $rule);
        $rule = $parts[0];
        $ruleValueArray = (count($parts) > 1) ? explode(',', $parts[1]) : [];
        // Check for custom error message for the field and rule
        $customMessage = $this->getCustomErrorMessage($field, $rule);
        $ruleFunction = new Rules();
        switch ($rule) {
            case 'required':
                if ($ruleFunction->required($value)) {
                    $this->addError($field, $customMessage ?: "This field is required!");
                }
                break;
            case 'nationalityOtherRequired':
                if (($this->data['nationality'] === 'other' && $field === 'nationality') || 
                    ($this->data['tNationality'] === 'other' && $field === 'tNationality')) {
                    if ($ruleFunction->required($value)) {
                        $this->addError($field, $customMessage ?: "This other field is required!");
                    }
                }
                break;
            case 'lengthNotGreaterThan':
                if ($ruleFunction->lengthNotGreaterThan($value, $ruleValueArray[0])) {
                    $this->addError($field, $customMessage ?: "This field must not exceed " . $ruleValueArray[0] . " characters!");
                }
                break;
            case 'year':
                if ($ruleFunction->date($value)) {
                    $this->addError($field, $customMessage ?: "Year must be valid!");
                }
                break;
            case 'now':
                if ($ruleFunction->notToday($value)) {
                    $this->addError($field, $customMessage ?: "Your field should not older than today !");
                }
                break;
            case 'ageNotGreaterThan':
                if ($ruleFunction->ageWithin($value, $ruleValueArray[0])) {
                    $this->addError($field, $customMessage ?: "This field must be within " . $ruleValueArray[0] . " years!");
                }
                break;
            case 'notNumber': 
                if (!$ruleFunction->isNumber($value)) {
                    $this->addError($field, $customMessage ?: "This field must not be numbers!");
                }
                break;
            case 'notContainNumber':
                if ($ruleFunction->notContainNumber($value)) {
                    $this->addError($field, $customMessage ?: "This field should not contain numbers!");
                }
                break;
            case 'specialCharacter':
                if ($ruleFunction->specialCharacter($value)) {
                    $this->addError($field, $customMessage ?: "This field should not include special characters!");
                }
                break;
            case 'regionCheckNotNever':
                if ($this->data['jpRadio'] !== 'never') {
                    if($ruleFunction->required($value)) {
                        $this->addError($field, $customMessage ?: "This field is required!");
                    }
                }
                break;
            case 'email':
                if ($ruleFunction->checkEmail($value)) {
                    $this->addError($field, $customMessage ?: "This field must be a valid email address!");
                }
                break;
            case 'phoneNumber':
                $formatValue = preg_replace('/\s+/', ' ', $value);
                if ($ruleFunction->isNumber($formatValue)) {
                    $this->addError($field, $customMessage ?: "This field must be only numbers!");
                }
                break;
            case 'phoneBetween':
                $formatValue = preg_replace('/\s+/', ' ', $value);
                if ($ruleFunction->lengthBetween($formatValue, $ruleValueArray[0], $ruleValueArray[1])) {
                    $this->addError($field, $customMessage ?: "This field must be between " . $ruleValueArray[0] . " and " . $ruleValueArray[1] . " digits!");
                }
                break;
            case 'fileSize':
                if ($ruleFunction->fileSize($value['size'],$ruleValueArray[0])) {
                    $this->addError($field, $customMessage ?: "This field must not exceed " . $ruleValueArray[0] . " MB!");
                }
                break;
            case 'image':
                if($ruleFunction->fileType($value['name'], $ruleValueArray)) {
                    $this->addError($field, $customMessage ?: "This field does not support this extension!");
                }
                break;
            case 'campaignOtherRequired':
                if ($this->data['campaign'] && in_array('other', $this->data['campaign'])) {
                    if($ruleFunction->required($value)) {
                        $this->addError($field, $customMessage ?: "This other field is required");
                    }
                }
                break;
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

