<?php

namespace RNFactory\Controller;

final class ReCaptcha
{
    public static function reCAPTCHA()
    {
        $secretKey = "6Le0tAEVAAAAAJAkxtDRmWCQSeezY_aUAbvR_y29"; // OBS.: Definer SecretKey como constate posteriormente ou recuperar do banco de dados
        $responseKey = $_POST['g-recaptcha-response'];
        $userIP = $_SERVER['REMOTE_ADDR'];

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
        $response = file_get_contents($url);
        $response = json_decode($response);

        return $response->success;
    }
}
