<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
        <?php
        echo Config::get('app_name');
        if (isset($pageTitle)) {
            echo ' - ' . $pageTitle;
        }
        ?>
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="/public/css/dropzone.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <?php include_once 'menu.php'; ?>
        <div class="container mt-5">

        <?php
            if (Session::has('message')) {
                $message = Session::get('message');
                Session::unset('message');
            echo '<div class="row">';
                echo '<div class="col-12 pt-2">';
                if ($message['type'] == 'success') {
                    echo '<div class="alert alert-success" role="alert">';
                } elseif ($message['type'] == 'error') {
                    echo '<div class="alert alert-danger" role="alert">';
                }
                echo $message['text'];
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        ?>
