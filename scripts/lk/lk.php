<?php
require_once 'func/funct.php';
require_once 'scripts/auth/auth.php';

$id = $_GET['id'];
$sql = pdo()->prepare("SELECT * FROM reg WHERE id=:id");
$sql->execute(['id' => $id]);
$res = $sql->fetch();
?>
<?php if ($_SESSION['user'] === true) { ?>
    <?php if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($id)) { ?>
        <h2>Личный кабинет</h2>
        <p>Добро пожаловать!</p>
        <p class="text-lg font-medium">Обновить данные</p>
        <form action="" method="post">
            <div class="grid gap-3 mb-12 md:grid-cols-1">
                <input type='hidden' name='id' value='<?= $id ?>'/>
                <div>
                    <label for="username"
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Логин</label>
                    <input type="text"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           id="username" name="username" value="<?= $res['username'] ?>">
                </div>
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Номер
                        телефона</label>
                    <input type="text"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           id="phone" name="phone" value="<?= $res['phone'] ?>">
                </div>
                <div>
                    <label for="email"
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-mail</label>
                    <input type="text"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           id="email" name="email" value="<?= $res['email'] ?>">
                </div>
                <div>
                    <label for="pass"
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Пароль</label>
                    <input type="password"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           id="pass" name="pass" value="<?= $res['pass'] ?>">
                </div>
            </div>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit"
                    name="submit2" value="submit">Сохранить
            </button>
        </form>
    <?php }
    if (isset($_POST['submit2']) && isset($_POST["username"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["pass"])) {
        $username = $_POST["username"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $pass = $_POST["pass"];

        $data = [
            'id' => $id,
            'username' => $username,
            'phone' => $phone,
            'email' => $email,
            'pass' => $pass
        ];
        $sql = "UPDATE reg SET username=:username, phone=:phone, email=:email, pass=:pass WHERE id=:id";
        $res = pdo()->prepare($sql)->execute($data);

        if ($res === true) {
            header('Location: /?mode=lk&id=' . $id);
            exit;
        } else {
            echo "Ошибка: нельзя сделать редирект";
        }
    }
}?>

