<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Weapon.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog weapon object
  $weapon = new Weapon($db);

  // Blog weapon query
  $result = $weapon->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any weapons
  if($num > 0) {
    // weapon array
    $weapons_arr = array();
    // $weapons_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $weapon_item = array(
        'id' => $id,
        'name' => $name,
        'description' => ($description),
        'image' => $image,
        'category' => $category,
        'category_name' => $category_name
      );

      // Push to "data"
      array_push($weapons_arr, $weapon_item);
      // array_push($weapons_arr['data'], $weapon_item);
    }

    // Turn to JSON & output
    echo json_encode($weapons_arr);

  } else {
    // No weapons
    echo json_encode(
      array('message' => 'No weapons Found')
    );
  }
