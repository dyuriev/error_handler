<h2>Во время выполнения произошла неисправимая ошибка.</h2>
<? foreach (self::$app_errors as $app_error):?>
    <strong>Уровень ошибки: </strong><?php echo $app_error['LEVEL']?><br />
    <strong>Текст ошибки: </strong><?php echo $app_error['MESSAGE']?><br />
    <strong>Скрипт: </strong><?php echo $app_error['FILE']?><strong> строка: </strong><?php echo $app_error['LINE']?><br />
    <hr />
<?endforeach;?>
