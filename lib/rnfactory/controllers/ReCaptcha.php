<?php

namespace rnfactory\controllers;

final class ReCaptcha
{
    public static function reCAPTCHA()
    {
        require_once 'app/config/config.php';

        $secretKey = SECRET_KEY;
        $responseKey = $_POST['g-recaptcha-response'];
        $userIP = $_SERVER['REMOTE_ADDR'];

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
        $response = file_get_contents($url);
        $response = json_decode($response);

        return $response->success;
    }
}
