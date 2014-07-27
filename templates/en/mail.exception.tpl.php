<h2>An exception is occured during runtime.</h2>
<strong>Error message: </strong><?php echo $exception->getMessage()?><br />
<strong>Error code: </strong><?php echo $exception->getCode()?><br />
<strong>Script path: </strong><?php echo $exception->getFile()?><strong> line: </strong><?php echo $exception->getLine()?><br /><br />
<strong>Stack trace: </strong>
<p><?php echo nl2br($this->getExceptionTraceAsString($exception))?></p>