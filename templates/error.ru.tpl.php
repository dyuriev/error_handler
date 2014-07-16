<h2>Во время выполнения произошла неисправимая ошибка.</h2>
<? if(self::$show_debug):?>
<? foreach ($this->app_errors as $app_error):?>
<strong>Уровень ошибки: </strong><?=$app_error['LEVEL']?><br />
<strong>Текст ошибки: </strong><?=$app_error['MESSAGE']?><br />
<strong>Скрипт: </strong><?=$app_error['FILE']?><strong> строка: </strong><?=$app_error['LINE']?><br />
<hr />
<?endforeach;?>
<?else:?>
Корректная работа страницы невозможна, приносим свои извинения.<br />
Попробуйте обновить страницу через несколько минут или вернитесь позже.<br />
Администратор уведомлен о возникшей проблеме.
<?endif;?>