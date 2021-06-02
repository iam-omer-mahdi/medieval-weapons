<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Weapon.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $weapon = new Weapon($db);

  // Get ID
  $weapon->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get weapon
  $weapon->read_single();

  // Create array
  $weapon_arr = array(
    'id' => $weapon->id,
    'name' => $weapon->name,
    'description' => $weapon->description,
    'image' => $weapon->image,
    'category' => $weapon->category,
    'category_name' => $weapon->category_name
  );

  // Make JSON
  print_r(json_encode($weapon_arr));