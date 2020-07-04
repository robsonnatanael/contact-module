<?php

/**
 * 2020 - RN Comunicação & Marketing
 * 
 * * AVISO DE LICENÇA
 * 
 * Este arquivo de origem está sujeito à Licença ...
 * incluído neste pacote no arquivo LICENSE.txt.
 * Também está disponível na Internet neste URL:
 * https://opensource.org/licenses/MIT
 * 
 * @author Robson Natanael <contato@robsonnatanael.com.br>
 * @copyright 2020 - RN Comunicação & Marketing
 * @license MIT
 * 
 * @package Contact Module
 */

// Conexão ao banco de dados (MySQL)
define("USUARIO", "devrobson");
define("SENHA", "robson");
define("DSN", "mysql:dbname=portfolio_painel_mensagem;host=127.0.0.1:3308");

// URI Base
define("URI", "http://projects/portfolio/contact_module/");

// Configuração SMTP
define("HOST", "smtp.hostinger.com.br");
define("PORT", 587);
define("SECURITY", "tls");
define("SMTP_AUTH", true);
define("USERNAME", "dev@robsonnatanael.com.br");
define("PASSWORD", "#281885z##d");
define("NAME", "Painel de Mensagens");

// E-mail para notificação
define("EMAIL_NOTIFICACAO", "natanaelrobson@gmail.com");

// Chaves de reCAPTCHA
define("SITE_KEY", "6Le0tAEVAAAAAJQHu_B0BexyPy1uZI7rsyWeQQuM");
define("SECRET_KEY", "6Le0tAEVAAAAAJAkxtDRmWCQSeezY_aUAbvR_y29");
