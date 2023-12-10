<?php

    require 'vendor/autoload.php';
     use Spatie\DbDumper\Databases\MySql;

     try{
        MySql::create()
        ->setDumpBinaryPath('C:\xampp\mysql\bin')
        ->setHost('localhost')
        ->setDbName('assistent_123')
        ->setUserName('assistent_123')
        ->setPassword('JA4bWXhxx4L')
        ->dumpToFile('backups/backup'.date('YmdHis').'.sql');
        echo 'Dump gerado com sucesso!';
    }
     catch(Exception $e){
        echo'Erro ao gerar Dump' . $e->getMessage();
     }







/*
// Configurações do banco de dados
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'erp_123';

// Localização onde o backup será salvo
$backupPath = 'backups/';

// Nome do arquivo de backup
$backupFileName = 'backup_' . date('YmdHis') . '.sql';

// URL para o phpMyAdmin
$phpMyAdminUrl = 'http://localhost/phpmyadmin/index.php?route=/server';

// Construir a URL de exportação
$exportUrl = "{$phpMyAdminUrl}/export.php?export_type=database&db={$database}&server={$host}&token=";

// Iniciar uma sessão cURL
$ch = curl_init();

// Configurar as opções da requisição cURL
curl_setopt($ch, CURLOPT_URL, $exportUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, '');  // Se necessário, configure um arquivo de cookie válido
curl_setopt($ch, CURLOPT_COOKIEJAR, '');   // Se necessário, configure um arquivo para salvar cookies

// Obter o conteúdo da página de exportação
$pageContent = curl_exec($ch);

// Fechar a sessão cURL
curl_close($ch);

// Salvar o conteúdo em um arquivo de backup
if ($pageContent !== false) {
    file_put_contents($backupPath . $backupFileName, $pageContent);
    echo 'Backup gerado com sucesso!';
} else {
    echo 'Erro ao gerar o backup.';
}
*/
?>