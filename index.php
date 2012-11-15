<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
          include 'Services/Service.php';
          $s = new Services\Service();
          echo $db = $s->getService("Db/Database");
        ?>
    </body>
</html>
