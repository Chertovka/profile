<p class="text-lg font-medium">Введите свой Логин и Пароль для входа</p>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="grid gap-3 mb-12 md:grid-cols-1">
        <div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-mail или телефон:</label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    type="text" size="30" name="text">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Пароль:</label>
                <input
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    type="password" size="30" maxlength="20" name="pass">
            </div>
        </div>
<!--        <div class="g-recaptcha"-->
<!--             data-sitekey="6Lc6jLslAAAAADgPvbuPieAHf_R0lKMIC9Oqq7e4">-->
<!--        </div>-->
        <input id="token" type="hidden" name="token">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit" value="Войти"
                name="submit">Войти
        </button>
    </div>
</form>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6Lc6jLslAAAAADgPvbuPieAHf_R0lKMIC9Oqq7e4', {action: 'homepage'}).then(function(token) {
            document.getElementById('token').value = token
        });
    });
</script>
