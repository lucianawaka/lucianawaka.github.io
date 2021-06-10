<?php

class Post{
    //DB Config
    private $conn;
    private $table = 'posts';

    // Post Properties

    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // Constructor with DB

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get Posts

    public function get() {
        // Create query
        $query = 'SELECT 
                    cat.name  as category_name,
                    post.id,
                    post.category_id,
                    post.title,
                    post.body,
                    post.author,
                    post.created_at
                  FROM '. $this->table.' post
                  LEFT JOIN categories cat ON post.category_id = cat.id
                  ORDER BY
                    post.created_at DESC';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Execute query
        $stmt->execute();

        return $stmt;
    }

    public function getsingle() {
        // Create query
        $query = 'SELECT 
                    cat.name  as category_name,
                    post.id,
                    post.category_id,
                    post.title,
                    post.body,
                    post.author,
                    post.created_at
                  FROM '. $this->table.' post
                    LEFT JOIN categories cat ON post.category_id = cat.id
                    WHERE post.id = ? 
                    LIMIT 0,1
                   ';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        // Execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    public function create()
    {
        // Create query
        $query = 'INSERT INTO '. $this->table.'
        SET 
            title  = :title,
            body   = :body,
            author = :author,
            category_id = :category_id';
            
        //Prepare statement

        $stmt = $this->conn->prepare($query);
        $this->title  = htmlspecialchars(strip_tags($this->title));
        $this->body  = htmlspecialchars(strip_tags($this->body));
        $this->author  = htmlspecialchars(strip_tags($this->author));
        $this->category_id  = htmlspecialchars(strip_tags($this->category_id));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        
        // Execute query
        if($stmt->execute()){
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n",$stmt->error);
        return false;

    }

    public function update()
    {
        // Create query
        $query = 'UPDATE '. $this->table.'
        SET 
            title  = :title,
            body   = :body,
            author = :author,
            category_id = :category_id
        WHERE
            id= :id ';
            
        //Prepare statement

        $stmt = $this->conn->prepare($query);
        $this->title  = htmlspecialchars(strip_tags($this->title));
        $this->body  = htmlspecialchars(strip_tags($this->body));
        $this->author  = htmlspecialchars(strip_tags($this->author));
        $this->category_id  = htmlspecialchars(strip_tags($this->category_id));
        $this->id  = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);
        
        // Execute query
        if($stmt->execute()){
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n",$stmt->error);
        return false;

    }

    public function delete()
    {
        //create query
        $query = 'DELETE FROM '. $this->table.' WHERE id = :id';
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        //Clean data
        $this->id  = htmlspecialchars(strip_tags($this->id));
        //Bind data
        $stmt->bindParam(':id', $this->id);
        // Execute query
        if($stmt->execute()){
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n",$stmt->error);
        return false;


    }

}