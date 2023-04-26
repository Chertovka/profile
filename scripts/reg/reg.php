<?php
/**
 * Обработчик формы регистрации
 */

require_once 'func/funct.php';

if (isset($_GET['status']) and $_GET['status'] == 'ok'){
    echo '<b>Вы успешно зарегистрировались! Пожалуйста активируйте свой аккаунт!</b><br><a href="/">Вернуться на главную</a>';
}

if (isset($_GET['active']) and $_GET['active'] == 'ok')
    echo '<b>Ваш аккаунт успешно активирован!</b>';

$active_hex = $_GET['key'];
if (isset($active_hex)){
    $sql = pdo()->prepare("SELECT * 
			FROM reg
			WHERE active_hex=:active_hex");
    $sql->execute(['active_hex' => $active_hex]);
    if ($sql->rowCount() == 0)
        $err[] = 'Ключ активации не верен!';

    if (count($err) > 0)
        echo showErrorMessage($err);
    else {
        $row = $sql->fetch();
        foreach ($row as $val) {
            $email = $val['email'];
            $status = 1;

            $data = [
                'status' => $status,
                'email' => $email,
            ];
            $sql = "UPDATE reg SET status=:status WHERE email=:email";
            pdo()->prepare($sql)->execute($data);

            $title = 'Ваш аккаунт успешно активирован';
            $message = 'Поздравляю Вас, Ваш аккаунт успешно активирован';

            sendMessageMail($email, 'no-reply@gmail.com', $title, $message);

            header('Location: ?mode=reg&active=ok');
            exit;
        }
    }
}

if (isset($_POST['submit'])) {
    if (empty($_POST['username']))
        $err[] = 'Поле логин не может быть пустым!';
    else {
        if (!preg_match("/^[a-zA-Z0-9]+$/i", $_POST['username']))
            $err[] = 'Не правильно введен логин' . "\n";
    }

    if (empty($_POST['phone']))
        $err[] = 'Поле телефон не может быть пустым!';
    else {
        if (!preg_match("/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/i", $_POST['phone']))
            $err[] = 'Не правильно введен телефон' . "\n";
    }

    if (empty($_POST['email']))
        $err[] = 'Поле Email не может быть пустым!';
    else {
        if (!preg_match("/^[a-z0-9_.-]+@([a-z0-9]+\.)+[a-z]{2,6}$/i", $_POST['email']))
            $err[] = 'Не правильно введен E-mail' . "\n";
    }

    if (empty($_POST['pass']))
        $err[] = 'Поле Пароль не может быть пустым';

    if (empty($_POST['pass2']))
        $err[] = 'Поле Подтверждения пароля не может быть пустым';

    if (count($err) > 0)
        echo showErrorMessage($err);
    else {
        if ($_POST['pass'] != $_POST['pass2'])
            $err[] = 'Пароли не совподают';

        if (count($err) > 0)
            echo showErrorMessage($err);
        else {
            $email = $_POST['email'];
            $username = $_POST['username'];
            $phone = $_POST['phone'];
            $sql = pdo()->prepare("SELECT email, username, phone from reg WHERE email=:email or username=:username or phone=:phone");
            $sql->execute(['email' => $email, 'username' => $username, 'phone' => $phone]);
            foreach ($sql as $row) {
                if (count($row) > 0)
                    $err[] = 'Такой логин/почта/телефон уже существует. Выберите другой.';
            }

            if (count($err) > 0)
                echo showErrorMessage($err);
            else {
                $salt = salt();

                $pass = md5(md5($_POST['pass']) . $salt);

                $username = $_POST['username'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $active_hex = md5($salt);
                $status = 0;

                $data = [
                    'username' => $username,
                    'phone' => $phone,
                    'email' => $email,
                    'pass' => $pass,
                    'salt' => $salt,
                    'active_hex' => $active_hex,
                    'status' => $status
                ];
                $query = pdo()->prepare("INSERT INTO reg
                        (username, phone, email, pass, salt, active_hex, status)
                        VALUES (:username, :phone, :email, :pass, :salt, :active_hex, :status)");

                $query->execute($data);

                $url = '?mode=reg&key=' . md5($salt);
                $title = 'Регистрация';
                $message = 'Для активации Вашего аккаунта пройдите по ссылке
				<a href="' . $url . '">' . $url . '</a>';

                sendMessageMail($_POST['email'], 'no-reply@gmail.com', $title, $message);

                header('Location: ?mode=reg&status=ok');
                exit;
            }
        }
    }
}
?>