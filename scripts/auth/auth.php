<?php
/**
 * Авторизация пользователя
 */

require_once 'func/funct.php';

$privatekey = "6Lc6jLslAAAAAKLb8mPW3G1B2wUdZQ3JeYJbmja0";

if (isset($_POST['submit'])) {
    if (empty($_POST['text'])) {
        $err[] = 'Не введена почта/телефон';
    }

    if (empty($_POST['pass']))
        $err[] = 'Не введен пароль';

    if (count($err) > 0)
        echo showErrorMessage($err);
    else {
        $text = $_POST['text'];
        $status = 1;
        $sql = pdo()->prepare("SELECT * FROM reg WHERE (email=:email or phone=:phone) and status=:status");
        $sql->execute(['email' => $text, 'phone' => $text, 'status' => $status]);
        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();
            if (md5(md5($_POST['pass']) . $row['salt']) === $row['pass']) {
                if ($_POST['token']) {
                    $response = returnReCaptcha($_POST['token'], $privatekey);
                    if ($response['success'] == 1) {
                        $_SESSION['user'] = true;
                        header('Location: /?mode=lk&id=' . $row['id']);
                        exit;
                    } else {
                        echo showErrorMessage('reCaptcha не пройдена!');
                    }
                } else {
                    echo showErrorMessage('Неверный токен!');
                }

            } else {
                echo showErrorMessage('Неверный пароль!');
            }
        } else
            echo showErrorMessage('Почта/телефон <b>' . $text . '</b> не найден!');
    }
}
?>