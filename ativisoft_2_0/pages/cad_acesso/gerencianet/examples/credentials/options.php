<?php

/**
 * Environment
 */
$sandbox = false; // false = Production | true = Homologation

/**
 * Credentials of Production
 */
$clientIdProd = "Client_Id_8b085a8c354d05041340679d8bcb79cf5e6c0ada";
$clientSecretProd = "Client_Secret_fe1c58a06bc9de4f42e85ce0adea3b8f7bc99799";
$pathCertificateProd = realpath(__DIR__ . "/producao-567916-AtiviSoft_123.pem"); // Absolute path to the certificate in .pem or .p12 format

/**
 * Credentials of Homologation
 */
$clientIdHomolog = "Client_Id_0e0501494653f99978e68b626503d257bcd4f9a1";
$clientSecretHomolog = "Client_Secret_beeb6b3ccc2b0630fe6badcf932ae6ea6ab87a2b";
$pathCertificateHomolog = realpath(__DIR__ . "/homologacao-567916-AtiviSoft_123.pem"); // Absolute path to the certificate in .pem or .p12 format

/**
 * Array with credentials for sending requests
 */
return [
	"clientId" => ($sandbox) ? $clientIdHomolog : $clientIdProd,
	"clientSecret" => ($sandbox) ? $clientSecretHomolog : $clientSecretProd,
	"certificate" => ($sandbox) ? $pathCertificateHomolog : $pathCertificateProd,
	"pwdCertificate" => "", // Optional | Default = ""
	"sandbox" => $sandbox, // Optional | Default = false
	"debug" => false, // Optional | Default = false
	"timeout" => 30, // Optional | Default = 30
];
