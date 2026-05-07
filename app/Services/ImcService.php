<?php

namespace App\Services;

class ImcService
{
    // /**
    //  * Calculate IMC (Indice de Masse Corporelle)
    //  * Formula: weight (kg) / (height (m))²
    //  * @param float $poids Weight in kilograms
    //  * @param float $taille Height in centimeters
    //  * @return float IMC rounded to 2 decimal places
    //  */
    public static function calculateImc($poids, $taille)
    {
        if ($taille == 0 || $poids == 0) {
            return 0;
        }
        
        $tailleM = $taille / 100; // Convert cm to meters
        return round(($poids / ($tailleM ** 2)), 2);
    }

    /**
     * Get IMC category based on calculated IMC value
     * Categories per WHO standards
     * 
     * @param float $imc IMC value
     * @return string Category name
     */
    public static function getImcCategory($imc)
    {
        if ($imc < 18.5) {
            return 'Underweight';
        } elseif ($imc < 25) {
            return 'Normal';
        } elseif ($imc < 30) {
            return 'Overweight';
        } else {
            return 'Obese';
        }
    }

    /**
     * Get IMC status with color/styling hint
     * 
     * @param float $imc IMC value
     * @return array ['category' => string, 'status' => string, 'color' => string]
     */
    public static function getImcStatus($imc)
    {
        $category = self::getImcCategory($imc);
        
        $statuses = [
            'Underweight' => ['status' => 'Underweight', 'color' => 'blue'],
            'Normal' => ['status' => 'Normal Weight', 'color' => 'green'],
            'Overweight' => ['status' => 'Overweight', 'color' => 'orange'],
            'Obese' => ['status' => 'Obese', 'color' => 'red'],
        ];
        
        return [
            'category' => $category,
            'status' => $statuses[$category]['status'] ?? 'Unknown',
            'color' => $statuses[$category]['color'] ?? 'gray',
        ];
    }
}
