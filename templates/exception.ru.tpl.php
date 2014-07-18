<h2>Во время выполнения возникла исключительная ситуация.</h2>
<?if(self::$show_debug):?>
<strong>Текст ошибки: </strong><?php echo $exception->getMessage()?><br />
<strong>Код ошибки: </strong><?php echo $exception->getCode()?><br />
<strong>Скрипт: </strong><?php echo $exception->getFile()?><strong> строка: </strong><?php echo $exception->getLine()?><br /><br />
<strong>Трассировка вызовов: </strong>
<p><?php echo nl2br($this->getExceptionTraceAsString($exception))?></p>
<?else:?>
Корректная работа страницы невозможна, приносим свои извинения.<br />
Попробуйте обновить страницу через несколько минут или вернитесь позже.<br />
Администратор уведомлен о возникшей проблеме.
<?endif;?>