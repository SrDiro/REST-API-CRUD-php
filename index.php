<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>cURL</title>
  </head>
  <body>
    <form class="form" method="post">
      <input type="text" name="id">
      <input type="text" name="name" placeholder="nombre">
      <input type="text" name="direction" placeholder="direccion">
      <input type="text" name="telephone" placeholder="telefono">
      <section class="buttons">
        <input type="submit" name="get" value="GET">
        <input type="submit" name="post" value="POST">
        <input type="submit" name="put" value="PUT">
        <input type="submit" name="delete" value="DELETE">
      </section>
    </form>
  </body>
</html>
<?php
  if (isset($_POST['get'])) {
    if (!empty($_POST['id'])) {
      $url = 'http://localhost/REST-API-CRUD-php/centros/' . $_POST['id'];
    } else {
      $url = 'http://localhost/REST-API-CRUD-php/centros';
    }
    $ch = curl_init($url);
    $options = array(CURLOPT_RETURNTRANSFER => true,
                     CURLOPT_HTTPHEADER => array('Accept: application/json'),
                    );
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);

    foreach ($data as $key => $value) {
      echo '<b>CAMPO ' . $key . '</b><br>';
      foreach ($value as $campo => $valor) {
        echo $campo . ':' . $valor . '<br>' ;
      }
    }
  }

  if (isset($_POST['post'])) {
    $name = $_POST['name'];
    $direction = $_POST['direction'];
    $telephone = $_POST['telephone'];
    $json = '{"name" : "'.$name.'", "direction" : "'.$direction.'", "telephone" : '.$telephone.'}';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/REST-API-CRUD-php/centros');
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    print_r($data['message']);
  }

  if (isset($_POST['put'])) {
    $name = $_POST['name'];
    $direction = $_POST['direction'];
    $telephone = $_POST['telephone'];
    $json = '{"name" : "'.$name.'", "direction" : "'.$direction.'", "telephone" : '.$telephone.'}';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/REST-API-CRUD-php/centros/' . $_POST['id']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    print_r($data['message']);
  }

  if (isset($_POST['delete'])) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/REST-API-CRUD-php/centros/' . $_POST['id']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    print_r($response);
  }

?>
