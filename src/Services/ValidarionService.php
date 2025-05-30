<?php
// src/Services/ValidationService.php
namespace WPLaravel\Services;

class ValidationService
{
    protected $rules = [];
    protected $messages = [];
    protected $errors = [];
    
    public function validate($data, $rules, $messages = [])
    {
        $this->rules = $rules;
        $this->messages = $messages;
        $this->errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            $this->validateField($field, $data[$field] ?? null, $fieldRules);
        }
        
        return empty($this->errors);
    }
    
    protected function validateField($field, $value, $rules)
    {
        $rulesArray = explode('|', $rules);
        
        foreach ($rulesArray as $rule) {
            $ruleParts = explode(':', $rule);
            $ruleName = $ruleParts[0];
            $ruleParams = isset($ruleParts[1]) ? explode(',', $ruleParts[1]) : [];
            
            $method = 'validate' . ucfirst($ruleName);
            
            if (method_exists($this, $method)) {
                $result = $this->$method($field, $value, $ruleParams);
                
                if (!$result) {
                    $this->addError($field, $ruleName);
                }
            }
        }
    }
    
    protected function validateRequired($field, $value, $params)
    {
        return !empty($value);
    }
    
    protected function validateEmail($field, $value, $params)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    protected function validateMin($field, $value, $params)
    {
        $min = (int) $params[0];
        return strlen($value) >= $min;
    }
    
    protected function validateMax($field, $value, $params)
    {
        $max = (int) $params[0];
        return strlen($value) <= $max;
    }
    
    protected function addError($field, $rule)
    {
        $message = $this->messages[$field . '.' . $rule] ?? $this->getDefaultMessage($field, $rule);
        
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        
        $this->errors[$field][] = $message;
    }
    
    protected function getDefaultMessage($field, $rule)
    {
        $messages = [
            'required' => "The {$field} field is required.",
            'email' => "The {$field} field must be a valid email address.",
            'min' => "The {$field} field must be at least :min characters.",
            'max' => "The {$field} field must not exceed :max characters.",
        ];
        
        return $messages[$rule] ?? "The {$field} field is invalid.";
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
}