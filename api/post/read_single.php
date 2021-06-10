<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Post.php');

//Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object

$post = new Post($db);

// GET ID
$post->id = isset($_GET['id'])? $_GET['id']:die();
// Blog post query

$post->getsingle();
// Get row count
//Check if any posts

 
       $post_arr = array(
            'id' => $post->id,
            'title'=> $post->title,
            'body' =>html_entity_decode($post->body),
            'author'=>$post->author,
            'category_id' =>$post->category_id,
            'category_name' =>$post->category_name
        );
       
      echo json_encode($post_arr,JSON_PRETTY_PRINT);
