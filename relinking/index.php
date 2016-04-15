<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <meta charset="UTF-8">
  <title>Модуль перелинковки</title>
</head>
<body>
  <div class="container">
    <div class="row">
      <h1 class="center">Модуль перелинковки</h1>
      <blockquote>
        <p>
          Загрузите csv-файл следующего формата: 
        </p>
        <ul>
          <li>первый столбец - url страницы донора (в формате "/адрес-страницы", без доменного имени),</li>
          <li>второй столбец - url страницы акцептора (в любом формате),</li>
          <li>третий столбец - анкор ссылки,</li>
          <li>разделитель - точка с запятой.</li>
        </ul>
        <p>Пример:</p>
        <table class="table table-bordered">
          <tr>
            <td>/articles/first-article/</td>
            <td>/remont-kvartir/</td>
            <td>ремонт квартир</td>
          </tr>
          <tr>
            <td>/articles/second-article/</td>
            <td>/remont-kvartir/</td>
            <td>недорогой ремонт квартир</td>
          </tr>
        </table>
      </blockquote>
      <form action="#" method="post" enctype="multipart/form-data" class="form-inline csv-form" role="form">
        <h3 class="form-header">Загрузить файл</h2>
        <div class="form-group">
          <input type="file" name="file" class="form-control" id="file">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Применить</button>
      </form>
      <? include $_SERVER['DOCUMENT_ROOT'].'/relinking/form_handler.php' ?>
    </div>
  </div>
</body>
</html>
