<?php 
  class Weapon {
    // DB stuff
    private $conn;
    private $table = 'weapons';

    // Weapon Properties
    public $id;
    public $name;
    public $description;
    public $image;
    public $category;
    public $category_name;
    

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Weapons
    public function read() {
      // Create query
      $query = 'SELECT c.name as category_name, w.id, w.category, w.name, w.description, w.image
                                FROM ' . $this->table . ' w
                                LEFT JOIN
                                  categories c ON w.category = c.id
                                ORDER BY w.name ASC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Weapon
    public function read_single() {
          // Create query
          $query = 'SELECT c.name as category_name, w.id, w.category, w.name, w.description, w.image
                                    FROM ' . $this->table . ' w
                                    LEFT JOIN
                                      categories c ON w.category = c.id
                                    WHERE
                                      w.id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->name = $row['name'];
          $this->id = $row['id'];
          $this->description = $row['description'];
          $this->image = $row['image'];
          $this->category = $row['category'];
          $this->category_name = $row['category_name'];
    }

    // Create Weapon
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET name = :name, description = :description, image = :image, category = :category';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->description = htmlspecialchars(strip_tags($this->description));
          $this->image = htmlspecialchars(strip_tags($this->image));
          $this->category = htmlspecialchars(strip_tags($this->category));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':description', $this->description);
          $stmt->bindParam(':image', $this->image);
          $stmt->bindParam(':category', $this->category);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Weapon
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET name = :name, description = :description, image = :image, category = :category
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->description = htmlspecialchars(strip_tags($this->description));
          $this->image = htmlspecialchars(strip_tags($this->image));
          $this->category = htmlspecialchars(strip_tags($this->category));
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':description', $this->description);
          $stmt->bindParam(':image', $this->image);
          $stmt->bindParam(':category', $this->category);
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Weapon
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }