<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Weapon.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog weapon object
  $weapon = new Weapon($db);

  // Get raw weaponed data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $weapon->id = $data->id;

  // Delete weapon
  if($weapon->delete()) {
    echo json_encode(
      array('message' => 'Weapon Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Weapon Not Deleted')
    );
  }

