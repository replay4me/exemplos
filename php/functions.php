<?php
// Captura as credenciais necessárias para autenticar um usuário (via embed).
// https://github.com/replay4me/embed-docs/wiki/2.-Autentica%C3%A7%C3%A3o
function autenticacao($email,$name){
    $ch = curl_init('https://'.AMBIENTE.'/embed/access_token/request');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_POSTFIELDS => http_build_query([
            'client_id' => CLIENT_ID,
            'client_secret' => CLIENT_SECRET,
            'email' => $email,
            'name' => $name
        ])
    ]);
    $response = curl_exec($ch);

    curl_close($ch);

    $credentials = json_decode($response);
    return $credentials;
}

// Exibe todos os módulos cadastrados na empresa
// https://github.com/replay4me/embed-docs/wiki/3.-Como-Listar-M%C3%B3dulos
function modulos(){
    $ch = curl_init('https://'.AMBIENTE.'/embed/modules?client_id='.CLIENT_ID.'&client_secret='.CLIENT_SECRET);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
    ]);

    $response = curl_exec($ch);

    curl_close($ch);

    $credentials = json_decode($response);
    return $credentials;
}

// Exibe todas as playlsits de um determinado módulo cadastrados na empresa.
// https://github.com/replay4me/embed-docs/wiki/4.-Como-Listar-Playlists
function playlist($module_id){
    $ch = curl_init('https://'.AMBIENTE.'/embed/playlists?client_id='.CLIENT_ID.'&client_secret='.CLIENT_SECRET.'&module_id='.$module_id);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false
    ]);

    $response = curl_exec($ch);

    curl_close($ch);

    $playlists = json_decode($response);
    return $playlists;
}