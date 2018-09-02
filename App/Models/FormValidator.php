<?php

namespace App\Models;

/**
 * Form Validator
 *
 * PHP version 7.0
 */
class FormValidator {
    
    public static function isValidDate($date, $strict = true)
    { 
        
    $dateTime = \DateTime::createFromFormat('Y-m-d', $date);
    
    if ($strict) {
        $errors = \DateTime::getLastErrors();
        if (!empty($errors['warning_count'])) {
            return false;
        }
    }
    
    return $dateTime !== false;
    
    }

}
