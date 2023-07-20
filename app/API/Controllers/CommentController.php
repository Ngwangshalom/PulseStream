<?php
// company: PulseStream
// Developed by: Ngwang Shalom
// Location: Cameroon/Bamenda
// Languages: php/hack/javascript/node(library)
// position: Senior dev
//
//
// Please add your own description if you are a contributor
//
//
//
namespace App\API\Controllers;
use Config\Database;

class CommentController
{
    public static function create()
    {
        $error = '';
        $userId = $POST['user_id'];
        $postId = isset($_POST['post_id']);
        $comment = isset($_POST['comments']);
        // $createdAt = currentdate

        if($userId && $postId && $comment == '' ){
        //   $error[
        //     'message': "Check your details",
        //     'code':'408'

        //   ];
        }else{
           
            $Database = new Database();
            $query = "INSERT INTO pulse_comments ;
            $statement = $database->getConnection()->prepare($query);
            $statement->bindValue('user_id':$userId, 'post_id':$postId,'created_at':'comments':$comments);
            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
    

          }

        }


    }