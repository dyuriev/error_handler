<h2>Во время выполнения произошла неисправимая ошибка.</h2>
<? if($this->config['show_debug']):?>
<? foreach (self::$app_errors as $app_error):?>
<strong>Уровень ошибки: </strong><?php echo $app_error['LEVEL']?><br />
<strong>Текст ошибки: </strong><?php echo $app_error['MESSAGE']?><br />
<strong>Скрипт: </strong><?php echo $app_error['FILE']?><strong> строка: </strong><?php echo $app_error['LINE']?><br />
<hr />
<?endforeach;?>
<?else:?>
Корректная работа страницы невозможна, приносим свои извинения.<br />
Попробуйте обновить страницу через несколько минут или вернитесь позже.<br />
Администратор уведомлен о возникшей проблеме.
<?endif;?>