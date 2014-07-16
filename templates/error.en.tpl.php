<h2>An error is occured during runtime.</h2>
<? if(self::$show_debug):?>
<? foreach (self::$app_errors as $app_error):?>
<strong>Error level: </strong><?=$app_error['LEVEL']?><br />
<strong>Error message: </strong><?=$app_error['MESSAGE']?><br />
<strong>Script path: </strong><?=$app_error['FILE']?><strong> line: </strong><?=$app_error['LINE']?><br />
<hr />
<?endforeach;?>
<?else:?>
We apologize that correctly work is impossible due an error.<br />
Try to refresh this page in a few minutes or come back later.<br />
Site administrator has been notified about this problem.
<?endif;?>