<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WhatsAppNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove any non-numeric characters
        $cleaned = preg_replace('/[^0-9]/', '', $value);
        
        // Check if it starts with valid prefixes
        if (!preg_match('/^(08|628|\+628|62)/', $value)) {
            $fail('Format nomor WhatsApp tidak valid. Gunakan format: 08xx, 628xx, atau +628xx.');
            return;
        }
        
        // Check minimum length (10 digits for 08xx format)
        if (strlen($cleaned) < 10) {
            $fail('Nomor WhatsApp terlalu pendek. Minimal 10 digit.');
            return;
        }
        
        // Check maximum length
        if (strlen($cleaned) > 15) {
            $fail('Nomor WhatsApp terlalu panjang. Maksimal 15 digit.');
            return;
        }
        
        // Check if it's a valid Indonesian mobile number
        if (substr($cleaned, 0, 2) === '08') {
            // Check valid Indonesian mobile prefixes
            $validPrefixes = ['0811', '0812', '0813', '0814', '0815', '0816', '0817', '0818', '0819', 
                            '0821', '0822', '0823', '0828', '0831', '0832', '0833', '0838',
                            '0851', '0852', '0853', '0855', '0856', '0857', '0858', '0859',
                            '0877', '0878', '0879', '0881', '0882', '0883', '0884', '0885', 
                            '0886', '0887', '0888', '0889', '0895', '0896', '0897', '0898', '0899'];
            
            $prefix = substr($cleaned, 0, 4);
            if (!in_array($prefix, $validPrefixes)) {
                $fail('Nomor WhatsApp tidak valid. Gunakan nomor operator Indonesia yang valid.');
                return;
            }
        }
    }
}
