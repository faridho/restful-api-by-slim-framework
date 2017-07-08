<?php
/**
 * Created by Faridho.
 * User: pc
 * Date: 6/20/2017
 * Time: 9:26 PM
 */
require 'vendor/autoload.php';
include 'config.php';
$app = new Slim\App();

$app->get('/movies', function ($request,$response) {
    try{
        $con = getDB();
        $sql = "SELECT * FROM t_movie";
        foreach ($con->query($sql) as $data) {
            $result[] = array(
                'id_movie'      => $data['id_movie'],
                'movie_title'   => $data['movie_title'],
                'movie_rate'    => $data['movie_rate']
           );
        }
        if($result){
            return $response->withJson(array('status' => 'true','result'=>$result),200);
        }else{
            return $response->withJson(array('status' => 'Movies Not Found'),422);
        }


    }
    catch(\Exception $ex){
        return $response->withJson(array('error' => $ex->getMessage()),422);
    }

});

$app->post('/addmovie', function($request, $response){
   try{
       $con = getDB();
       $sql = "INSERT INTO t_movie (movie_title, movie_rate) VALUES (:movie_title, :movie_rate)";
       $pre = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       $values = array(
           ':movie_title'   => $request->getParam('movie_title'),
           ':movie_rate'    => $request->getParam('movie_rate')
       );
       $result = $pre->execute($values);
       if($result){
           return $response->withJson(array('status' => 'Movie Added'), 200);
       }else{
           return $response->withJson(array('status' => 'Movies Not Added'),422);
       }

   }
   catch(\Exception $ex){
       return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});


$app->get('/getmovie/{id}', function ($request, $response){
    try{
        $id  = $request->getAttribute('id');
        $con = getDB();
        $sql = "SELECT * FROM t_movie WHERE id_movie = :id";
        $pre = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $values = array(
            ':id' => $id
        );
        $pre->execute($values);
        $result = $pre->fetch();

        if($result){
            return $response->withJson(array('status' => 'true','result'=>$result),200);
        }else{
            return $response->withJson(array('status' => 'Movies Not Found'),422);
        }

    }
    catch(\Exception $ex){
        return $response->withJson(array('error' => $ex->getMessage()),422);
    }
});

$app->put('/updatemovie/{id}', function($request, $response){
    try{
        $id  = $request->getAttribute('id');
        $con    = getDB();
        $sql    = "UPDATE t_movie SET movie_title = :movie_title, movie_rate = :movie_rate WHERE id_movie = :id_movie";
        $pre    = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $values = array(
            ':movie_title'  => $request->getParam('movie_title'),
            ':movie_rate'   => $request->getParam('movie_rate'),
            ':id_movie'     => $id
        );
        $result = $pre->execute($values);

        if($result){
            return $response->withJson(array('status' => 'Movie Updated'), 200);
        }else{
            return $response->withJson(array('status' => 'Movies Not Updated'),422);
        }
    }
    catch(\Exception $ex){
        return $response->withJson(array('error' => $ex->getMessage()),422);
    }
});

$app->delete('/deletemovie/{id}', function($request, $response){
    $id     = $request->getAttribute('id');
    $con    = getDB();
    $sql    = "DELETE FROM t_movie WHERE id_movie = :id_movie";
    $pre    = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $values = array(
      ':id_movie' => $id
    );
    $result = $pre->execute($values);

    if($result){
        return $response->withJson(array('status' => 'Movie Deleted'), 200);
    }else{
        return $response->withJson(array('status' => 'Movies Not Deleted'),422);
    }
});

$app->run();




































