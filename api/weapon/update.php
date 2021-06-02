<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Weapon.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate weapon object
  $weapon = new Weapon($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $weapon->id = $data->id;

  $weapon->name = $data->name;
  $weapon->description = $data->description;
  $weapon->image = $data->image;
  $weapon->category = $data->category;

  // Update weapon
  if($weapon->update()) {
    echo json_encode(
      array('message' => 'weapon Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'weapon Not Updated')
    );
  }

