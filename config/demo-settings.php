<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
ini_set("display_errors",1);

/***************
 Comportamientos temporales
****************/

//Estoy en mantenimiento
define('GOTEO_MAINTENANCE', null);

//secreto interno para generación de ID's CAMBIAR!!!!
define('GOTEO_MISC_SECRET', 'gl,+PQ7`}i8fv}CX0B7qhbqnV[3RHpq0\KPQg|1I|dTz=m=u6BJ;k27mzLuo');

//Estoy en alto rendimiento
define('GOTEO_EASY', null);

// tipo de entorno: local, beta, real
define('GOTEO_ENV', 'local');

// nodo central
define('GOTEO_NODE', 'goteo');


// Metadata
define('GOTEO_META_TITLE', '--meta-title--');
define('GOTEO_META_DESCRIPTION', '--meta-description--');
define('GOTEO_META_KEYWORDS', '--keywords--');
define('GOTEO_META_AUTHOR', '--author--');
define('GOTEO_META_COPYRIGHT', '--copyright--');

//AWS Credentials
define('AWS_KEY', '--------------');
define('AWS_SECRET', '----------------------------------');
define('AWS_REGION', 'eu-west-1');

//Mail management: ses, phpmailer
define('MAIL_HANDLER', 'phpmailer');

// Database
define('GOTEO_DB_DRIVER', 'mysql');
define('GOTEO_DB_HOST', 'localhost');
define('GOTEO_DB_PORT', 3306);
define('GOTEO_DB_CHARSET', 'UTF-8');
define('GOTEO_DB_SCHEMA', 'db-schema');
define('GOTEO_DB_USERNAME', 'db-username');
define('GOTEO_DB_PASSWORD', 'db-password');

//Replica de lectura (opcional)
//define('GOTEO_DB_READ_REPLICA_HOST', 'replica-host');
//si se define una replica de lectura los siguientes parametros son opcionales
//define('GOTEO_DB_READ_REPLICA_PORT', 3307);
//define('GOTEO_DB_READ_REPLICA_USERNAME', 'db-replica-username');
//define('GOTEO_DB_READ_REPLICA_PASSWORD', 'db-replica-password');


//SELECT queries caching
//setup it as 'files', 'memcache'
define('SQL_CACHE_DRIVER', 'memcache'); //dejar vacia para no activar cache
define('SQL_CACHE_TIME', 20); //Segundos de cache para las queries SELECT (puede ser sobreescrito por las query->cacheTime())
define('SQL_CACHE_SERVER', 'localhost'); //Si es memcache, si no será ignorado
define('SQL_CACHE_PORT', '11211'); //Si es memcache, si no será ignorado

// Mail
define('GOTEO_MAIL_FROM', 'noreply@example.com');
define('GOTEO_MAIL_NAME', 'example.com');
define('GOTEO_MAIL_TYPE', 'smtp');
define('GOTEO_MAIL_SMTP_AUTH', true);
define('GOTEO_MAIL_SMTP_SECURE', 'ssl');
define('GOTEO_MAIL_SMTP_HOST', 'smtp--host');
define('GOTEO_MAIL_SMTP_PORT', '--portnumber--');
define('GOTEO_MAIL_SMTP_USERNAME', 'smtp-usermail');
define('GOTEO_MAIL_SMTP_PASSWORD', 'smtp-password');

define('GOTEO_MAIL', 'info@example.com');
define('GOTEO_CONTACT_MAIL', 'info@example.com'); // consulting head
define('GOTEO_MANAGER_MAIL', 'manager@example.com'); // accounts manager
define('GOTEO_FAIL_MAIL', 'dev@example.com'); // dev head
define('GOTEO_LOG_MAIL', 'sitelog@example.com');

//Quota de envio máximo para goteo en 24 horas
define('GOTEO_MAIL_QUOTA', 50000);
//Quota de envio máximo para newsletters para goteo en 24 horas
define('GOTEO_MAIL_SENDER_QUOTA', round(GOTEO_MAIL_QUOTA * 0.8));
//clave de Amazon SNS para recopilar bounces automaticamente: 'arn:aws:sns:us-east-1:XXXXXXXXX:amazon-ses-bounces'
//la URL de informacion debe ser: goteo_url.tld/aws-sns.php
define('AWS_SNS_CLIENT_ID', 'XXXXXXXXX');
define('AWS_SNS_REGION', 'us-east-1');
define('AWS_SNS_BOUNCES_TOPIC', 'amazon-ses-bounces');
define('AWS_SNS_COMPLAINTS_TOPIC', 'amazon-ses-complaints');

// Language
define('GOTEO_DEFAULT_LANG', 'es');

// url
define('GOTEO_URL', 'http://example.com');
// ssl
define('GOTEO_SSL', false);

//Sessions
//session handler: php, dynamodb
define('SESSION_HANDLER', 'php');

//Files management: s3, file
define('FILE_HANDLER', 'file');

//Log file management: s3, file
define('LOG_HANDLER', 'file');


//S3 buckets
define('AWS_S3_BUCKET_STATIC', 'static.example.com');
define('AWS_S3_BUCKET_MAIL', 'mail-archive.example.com');
define('AWS_S3_BUCKET_DOCUMENT', 'document.example.com');
define('AWS_S3_BUCKET_PRESS', 'press.example.com');

// Cron params
define('CRON_PARAM', '--------------');
define('CRON_VALUE', '--------------');



/****************************************************
Paypal constants (sandbox)
****************************************************/
define('PAYPAL_REDIRECT_URL', '---Sandbox/Production-url-----https://www.sandbox.paypal.com/webscr&cmd=');
define('PAYPAL_DEVELOPER_PORTAL', '--developper-domain--');
define('PAYPAL_DEVICE_ID', '--domain--');
define('PAYPAL_APPLICATION_ID', '--PayPal-app-Id---');
define('PAYPAL_BUSINESS_ACCOUNT', '--mail-like-paypal-account--');
define('PAYPAL_IP_ADDRESS', '127.0.0.1');

/****************************************************
TPV [Bank Name]
****************************************************/
define('TPV_MERCHANT_CODE', 'xxxxxxxxx');
define('TPV_REDIRECT_URL', '--bank-rest-api-url--');
define('TPV_ENCRYPT_KEY', 'xxxxxxxxx');

/****************************************************
Social Services constants
****************************************************/
// Credenciales app Facebook
define('OAUTH_FACEBOOK_ID', '-----------------------------------'); //
define('OAUTH_FACEBOOK_SECRET', '-----------------------------------'); //

// Credenciales app Twitter
define('OAUTH_TWITTER_ID', '-----------------------------------'); //
define('OAUTH_TWITTER_SECRET', '-----------------------------------'); //

// Credenciales app Linkedin
define('OAUTH_LINKEDIN_ID', '-----------------------------------'); //
define('OAUTH_LINKEDIN_SECRET', '-----------------------------------'); //

//Un secreto inventado cualquiera para encriptar los emails que sirven de secreto en openid
define('OAUTH_OPENID_SECRET','-----------------------------------');

// recaptcha
define('RECAPTCHA_PUBLIC_KEY','-----------------------------------');
define('RECAPTCHA_PRIVATE_KEY','-----------------------------------');

/****************************************************
Google Analytics
****************************************************/
define('GOTEO_ANALYTICS_TRACKER', '');
