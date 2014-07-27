<h2>Во время выполнения возникла исключительная ситуация.</h2>
<strong>Текст ошибки: </strong><?php echo $exception->getMessage()?><br />
<strong>Код ошибки: </strong><?php echo $exception->getCode()?><br />
<strong>Скрипт: </strong><?php echo $exception->getFile()?><strong> строка: </strong><?php echo $exception->getLine()?><br /><br />
<strong>Трассировка вызовов: </strong>
<p><?php echo nl2br($this->getExceptionTraceAsString($exception))?></p>