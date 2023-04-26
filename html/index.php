<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="keywords" content="Регистрация пользователей PHP MySQL, Авторизация пользователей PHP MySQL"/>
    <meta name="description" content="Регистрация пользователей PHP MySQL с активацией письмом"/>
    <title>Регистрация пользователей PHP MySQL с активацией письмом</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src='https://www.google.com/recaptcha/api.js?render=6Lc6jLslAAAAADgPvbuPieAHf_R0lKMIC9Oqq7e4'></script>
</head>
<body>
<div class="container mx-auto w-6/12">
    <div class="flex justify-center m-2">
        <?php if ($_SESSION['user'] === true): ?>
            <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l" href="/">Выйти</a>
            <?php if ($_SERVER['REQUEST_URI'] === '/') {
                unset($_COOKIE['PHPSESSID']);
                setcookie('PHPSESSID', null, -1, '/');
            } ?>
        <?php else: ?>
            <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l" href="/?mode=auth">Войти</a>
            <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r" href="/?mode=reg">Регистрация</a>
        <?php endif; ?>
    </div>
    <div id="content">
        <?php echo $content; ?>
    </div>
</div>
</body>
</html>