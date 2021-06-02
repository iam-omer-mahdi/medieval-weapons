<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Weapon.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate weapon object
  $post = new Weapon($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $post->name = $data->name;
  $post->description = $data->description;
  $post->image = $data->image;
  $post->category = $data->category;

  // Create post
  if($post->create()) {
    echo json_encode(
      array('message' => 'Weapon Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Weapon Not Created')
    );
  }

