<h2>Во время выполнения возникла исключительная ситуация.</h2>
<?if(self::$show_debug):?>
<strong>Текст ошибки: </strong><?=$exception->getMessage()?><br />
<strong>Код ошибки: </strong><?=$exception->getCode()?><br />
<strong>Скрипт: </strong><?=$exception->getFile()?><strong> строка: </strong><?=$exception->getLine()?><br /><br />
<strong>Трассировка вызовов: </strong>
<p><?=nl2br($this->getExceptionTraceAsString($exception))?></p>
<?else:?>
Корректная работа страницы невозможна, приносим свои извинения.<br />
Попробуйте обновить страницу через несколько минут или вернитесь позже.<br />
Администратор уведомлен о возникшей проблеме.
<?endif;?>