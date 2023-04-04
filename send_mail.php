<!-- ***--Подключение и настройка PHPMailer--*** -->

<!-- Скачать PHPMailer
Архив распаковываем в папке с вашим проектом.
После создаем новый файл send_mail.php — скрипт для отправки сообщений. 
Внутри него подключаем библиотеку PHPMailer. 
Вставляем код ниже. Важно, чтобы файлы библиотеки находились в папке PHPMailer. -->

<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/Exception.php";

// Далее создадим объект mail для работы с почтой и считаем поля формы с файла index.html. 
// Передаем данные методом POST.
$mail = new PHPMailer(true); /* Создаем объект MAIL */
$mail->CharSet = "UTF-8"; /* Задаем кодировку UTF-8 */
$mail->IsHTML(true); /* Разрешаем работу с HTML */

$name = $_POST["name"]; /* Принимаем имя пользователя с формы .. */ 
$email = $_POST["email"]; /* Почту */
$phone = $_POST["phone"]; /* Телефон */
$message = $_POST["message"]; /* Сообщение с формы */


$body = file_get_contents($email_template);

// Вместо %name% будет вставляться имя пользователя, отправляющего письмо. 
// И так далее. Можно создать ту разметку, которая нужна.

// Чтобы заменить данные в разметке, в файле send_mail.php прописать следующее:
$email_template = "template_mail.html"; // Считываем файл разметки
$body = file_get_contents($email_template); // Сохраняем данные в $body
$body = str_replace('%name%', $name, $body); // Заменяем строку %name% на имя
$body = str_replace('%email%', $email, $body); // строку %email% на почту
$body = str_replace('%phone%', $phone, $body); // строку %phone% на телефон
$body = str_replace('%message%', $message, $body); // строку %message% на сообщение

// $theme = "[Заявка с формы]";

// Отправляем письмо (пока с перезагрузкой)
// Итак теперь все готово, чтобы отправить наше письмо на почту. 
// Здесь задаем адрес email (их может быть несколько), тему письма. 
// В конце возвращаем ответ в формате JSON. 
// Это нужно, чтобы показать пользователю, что сообщение успешно отправлено.

$mail->addAddress("your-name@email.com"); /* Здесь введите Email, куда отправлять */ть */
$mail->setFrom($email);
$mail->Subject = "[Заявка с формы]"; /* Тема письма */
$mail->msgHTML($body);
// $mail->Subject = $theme;

/* Проверяем отправлено ли сообщение */
if (!$mail->send()) {
$message = "Сообщение не отправлено";
} else {
    $message = "Данные отправлены!";
}

/* Возвращаем ответ */	
$response = ["message" => $message];

/* Ответ в формате JSON */
header('Content-type: application/json');
echo json_encode($response);

?>