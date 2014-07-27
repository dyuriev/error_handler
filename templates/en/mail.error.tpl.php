<h2>An error is occured during runtime.</h2>
<? foreach (self::$app_errors as $app_error):?>
    <strong>Error level: </strong><?php echo $app_error['LEVEL']?><br />
    <strong>Error message: </strong><?php echo $app_error['MESSAGE']?><br />
    <strong>Script path: </strong><?php echo $app_error['FILE']?><strong> line: </strong><?php echo $app_error['LINE']?><br />
    <hr />
<?endforeach;?>
