<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Username implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check minimum length
        if (strlen($value) < 5) {
            $fail('Username minimal 5 karakter.');
            return;
        }
        
        // Check maximum length
        if (strlen($value) > 30) {
            $fail('Username maksimal 30 karakter.');
            return;
        }
        
        // Check if alphanumeric with underscore only
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $value)) {
            $fail('Username hanya boleh mengandung huruf, angka, dan underscore (_).');
            return;
        }
        
        // Check if starts with letter
        if (!preg_match('/^[a-zA-Z]/', $value)) {
            $fail('Username harus dimulai dengan huruf.');
            return;
        }
        
        // Check for consecutive underscores
        if (strpos($value, '__') !== false) {
            $fail('Username tidak boleh mengandung underscore berturut-turut.');
            return;
        }
        
        // Check for reserved usernames
        $reserved = ['admin', 'administrator', 'root', 'system', 'user', 'guest', 'test', 'demo'];
        if (in_array(strtolower($value), $reserved)) {
            $fail('Username ini tidak dapat digunakan karena sudah direservasi.');
            return;
        }
    }
}
