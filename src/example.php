<?php
require __DIR__ . '/../vendor/autoload.php';

use LSX\Recaptcha\Recaptcha;

// Ejemplo de uso de la librería PHP
function testRecaptchaV2Checkbox() {
    $recaptcha = new Recaptcha();
    
    // Simular un token (en producción vendría del frontend)
    $token = 'test_token_v2_checkbox';
    
    try {
        $result = $recaptcha->verify($token, 'v2_checkbox');
        echo "reCAPTCHA v2 Checkbox: " . ($result ? "Verificado" : "No verificado") . "\n";
        return $result;
    } catch (Exception $e) {
        echo "Error v2 Checkbox: " . $e->getMessage() . "\n";
        return false;
    }
}

function testRecaptchaV2Badge() {
    $recaptcha = new Recaptcha();
    
    // Simular un token (en producción vendría del frontend)
    $token = 'test_token_v2_badge';
    
    try {
        $result = $recaptcha->verify($token, 'v2_badge');
        echo "reCAPTCHA v2 Badge: " . ($result ? "Verificado" : "No verificado") . "\n";
        return $result;
    } catch (Exception $e) {
        echo "Error v2 Badge: " . $e->getMessage() . "\n";
        return false;
    }
}

function testRecaptchaV3() {
    $recaptcha = new Recaptcha();
    
    // Simular un token (en producción vendría del frontend)
    $token = 'test_token_v3';
    
    try {
        $result = $recaptcha->verify($token, 'v3_score');
        echo "reCAPTCHA v3 Score: " . json_encode($result, JSON_PRETTY_PRINT) . "\n";
        
        if (isset($result['success']) && $result['success']) {
            $score = $result['score'] ?? 0;
            echo "Score: " . $score . " (0.0 = bot, 1.0 = humano)\n";
            
            if ($score >= 0.5) {
                echo "✅ Usuario verificado (score >= 0.5)\n";
            } else {
                echo "❌ Usuario sospechoso (score < 0.5)\n";
            }
        }
        
        return $result;
    } catch (Exception $e) {
        echo "Error v3: " . $e->getMessage() . "\n";
        return false;
    }
}

// Ejecutar ejemplos si se llama directamente
if (basename(__FILE__) == basename($_SERVER['SCRIPT_NAME'])) {
    echo "=== Ejemplos de reCAPTCHA SDK - LSX ===\n\n";
    
    echo "1. Probando reCAPTCHA v2 Checkbox:\n";
    testRecaptchaV2Checkbox();
    echo "\n";
    
    echo "2. Probando reCAPTCHA v2 Badge:\n";
    testRecaptchaV2Badge();
    echo "\n";
    
    echo "3. Probando reCAPTCHA v3 Score:\n";
    testRecaptchaV3();
    echo "\n";
    
    echo "=== Fin de ejemplos ===\n";
}
