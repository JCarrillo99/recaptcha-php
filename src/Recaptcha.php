<?php
namespace LSX\Recaptcha;

use GuzzleHttp\Client;
use Dotenv\Dotenv;

class Recaptcha {

    private array $secrets;
    private Client $client;

    public function __construct() {
        $this->client = new Client();

        // Cargar variables de entorno
        if (file_exists(__DIR__ . '/../.env')) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();
        }

        $this->secrets = [
            'v2_checkbox' => $_ENV['APP_RECAPTCHA_2_CHECKBOX_SECRET'] ?? '',
            'v2_badge'    => $_ENV['APP_RECAPTCHA_2_INSIGNIA_SECRET'] ?? '',
            'v3_score'    => $_ENV['APP_RECAPTCHA_3_SCORE_SECRET'] ?? ''
        ];
    }

    /**
     * Verifica un token reCAPTCHA
     * @param string $token Token enviado desde el frontend
     * @param string $version 'v2_checkbox', 'v2_badge' o 'v3_score'
     * @param string|null $remoteIp IP del usuario (opcional)
     * @return bool|array Retorna true si es exitoso (v2) o array completo (v3)
     */
    public function verify(string $token, string $version = 'v2_checkbox', ?string $remoteIp = null) {
        if (!isset($this->secrets[$version])) {
            throw new \Exception("Versión de reCAPTCHA inválida");
        }

        $response = $this->client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret'   => $this->secrets[$version],
                'response' => $token,
                'remoteip' => $remoteIp
            ]
        ]);

        $data = json_decode((string) $response->getBody(), true);

        // v2 devuelve true/false
        if ($version === 'v2_checkbox' || $version === 'v2_badge') {
            return $data['success'] ?? false;
        }

        // v3 devuelve el array completo para revisar score
        return $data;
    }
}
