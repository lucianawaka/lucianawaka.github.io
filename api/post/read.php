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

// Blog post query

$result = $post->get();
// Get row count
$num = $result->rowCount();
//Check if any posts
if($num > 0) {
    $post_arr = array('error'=>'', 'data' => array());

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
       $post_item = array(
            'id' => $id,
            'title'=> $title,
            'body' =>html_entity_decode($body),
            'author'=>$author,
            'category_id' =>$category_id,
            'category_name' =>$category_name
        );
       
      array_push($post_arr['data'],$post_item);
    }
    echo json_encode($post_arr,JSON_PRETTY_PRINT);
    
} else {
    //No Posts
    $posts_arr['error'] = 'Error, No Posts Found'; 
    echo json_encode($post_arr);
}