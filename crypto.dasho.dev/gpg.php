<?php

// Made by Dasho
// https://crypto.dasho.dev

// This is a simple PHP script that will encrypt and decrypt files using GPG, and allow key generation.

function key_generation(){
    $key = shell_exec("gpg --gen-key");
    echo $key;
}

function encrypt($file, $key){
    $encrypt = shell_exec("gpg --encrypt --recipient $key $file");
    echo $encrypt;
}

function decrypt($file, $key){
    $decrypt = shell_exec("gpg --decrypt --recipient $key $file");
    echo $decrypt;
}

?>

<html>
    <head>
        <title>PHP GPG</title>
    </head>
    <body>
        <h1>PHP GPG</h1>
        <form action="gpg.php" method="post">
            <input type="submit" name="key" value="Generate Key">
        </form>
        <form action="gpg.php" method="post">
            <input type="upload" name="file" placeholder="File">
            <input type="text" name="key" placeholder="Key">
            <input type="submit" name="encrypt" value="Encrypt">
        </form>
        <?php
            if(isset($_POST['key'])){
                key_generation();
            }
            if(isset($_POST['encrypt'])){
                $file = $_POST['file'];
                $key = $_POST['key'];
                encrypt($file, $key);
            }
            if(isset($_POST['decrypt'])){
                $file = $_POST['file'];
                $key = $_POST['key'];
                decrypt($file, $key);
            }
        ?>
    </body>
</html>