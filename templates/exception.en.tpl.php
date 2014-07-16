<h2>An exception is occured during runtime.</h2>
<?if(self::$show_debug):?>
<strong>Error message: </strong><?=$exception->getMessage()?><br />
<strong>Error code: </strong><?=$exception->getCode()?><br />
<strong>Script path: </strong><?=$exception->getFile()?><strong> line: </strong><?=$exception->getLine()?><br /><br />
<strong>Stack trace: </strong>
<p><?=nl2br($this->getExceptionTraceAsString($exception))?></p>
<?else:?>
We apologize that correctly work is impossible due an error.<br />
Try to refresh this page in a few minutes or come back later.<br />
Site administrator has been notified about this problem.
<?endif;?>