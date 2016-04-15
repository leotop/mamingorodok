<?
$errors = array();

if ($dbconnection = mysql_connect('localhost', 'mamingorodok', 'ZwzKrFkPj4G6')) {
  $db = mysql_select_db('mamingorodok');
  mysql_query("SET NAMES utf8");
}else{
  $errors[] = 'Не удается соединиться с БД';
}


if (isset($_POST['submit'])) {
  $path_info = pathinfo($_FILES['file']['name']);
  if ($path_info['extension'] != 'csv') {
    $errors[] = 'Неправильный формат файла.';
  }

  if ($_FILES['file']['size'] > 10000000) {
    $errors[] = 'Файл превышает допустимый размер в 10 мегабайт.';
  }

  if (empty($errors)) {

    mysql_query("TRUNCATE TABLE `relinking`");

    $counter = 0;

    $csv_lines = file($_FILES['file']['tmp_name']);
    $count = count($csv_lines);
    for ($i = 0; $i < $count; $i++) {

      $cells = explode(';', $csv_lines[$i]);

      $donor = trim($cells[0]);
      $acceptor = trim($cells[1]);
      $anchor = trim($cells[2]);

      if ( $donor != '' && $acceptor != '' && $anchor != '' ) {
        $result = mysql_query("INSERT INTO `relinking` (donor, acceptor, anchor) VALUES ('".$donor."', '".$acceptor."', '".$anchor."' )");
        if ($result) $counter++;
      }
    }
    echo "<p class=\"text-success\">Информация из файла успешно добавлена. Строк в файле: ".$count.". Строк добавлено: ".$counter.".</p>";
  }else{
    echo '<ul>';
    foreach($errors as $error) {
      echo '<li class="text-danger">'.$error.'</li>';
    }
    echo '</ul>';
  }
}
?>