<?php
/**
 * Файл с пользовательскими функциями
 */

/**
 * @return mixed|PDO
 */
function pdo()
{
    static $pdo;

    if(!$pdo){
        $config = include 'config.php';
        $sql = 'mysql:dbname='.$config['DATABASE'].';host='.$config['DBSERVER'];
        $pdo = new PDO($sql, $config['DBUSER'], $config['DBPASSWORD']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $pdo;
}

/**
 * @param string $to
 * @param string $from
 * @param string $title
 * @param string $message
 */
function sendMessageMail($to, $from, $title, $message)
{
    $subject = $title;
    $subject = '=?utf-8?b?' . base64_encode($subject) . '?=';

    $headers = "Content-type: text/html; charset=\"utf-8\"\r\n";
    $headers .= "From: " . $from . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Date: " . date('D, d M Y h:i:s O') . "\r\n";

    if (!mail($to, $subject, $message, $headers))
        return 'Ошибка отправки письма!';
    else
        return true;
}

/**
 * @param array $data
 */
function showErrorMessage($data)
{
    $err = '<ul>' . "\n";

    if (is_array($data)) {
        foreach ($data as $val)
            $err .= '<li style="color:red;">' . $val . '</li>' . "\n";
    } else
        $err .= '<li style="color:red;">' . $data . '</li>' . "\n";

    $err .= '</ul>' . "\n";

    return $err;
}

/**
 * @param string $sql
 */
function salt()
{
    $salt = substr(md5(uniqid()), -8);
    return $salt;
}

/**
 * @param $token
 * @param $sicret_key
 * @return mixed
 */
function returnReCaptcha($token, $secret_key) {
    $url = 'https://www.google.com/recaptcha/api/siteverify';

    $params = [
        'secret' => $secret_key,
        'response' => $token,
        'remoteip' => $_SERVER['REMOTE_ADDR'],
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    return json_decode($response, true);
}