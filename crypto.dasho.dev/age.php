<?php

// An implementation of the AGE encryption algorithm in PHP

// Made by Dasho

// https://crypto.dasho.dev

// This is a simple PHP script that will encrypt and decrypt files using AGE, and allow key generation.

function key_generation(){
    shell_exec("age-keygen -o upload/key.txt");
    echo '<a href="/upload/key.txt">Download</a>';
}

function encrypt($file, $key){
    shell_exec("age -r $key upload/$file -o upload/$file.age");
}

function decrypt($file){
    shell_exec("age -d upload/key.txt upload/$file -o upload/$file.decrypted");
}

function encrypt_with_passphrase($file, $passphrase){
    shell_exec("age -p $passphrase upload/$file -o upload/$file.age");
}

function decrypt_with_passphrase($file, $passphrase){
    shell_exec("age -d -p $passphrase upload/$file -o upload/$file.decrypted");
}

function html_form(){
    echo '<html>
    <head>
        <title>PHP AGE</title>
    </head>
    <body>
        <h1>PHP AGE</h1>
        <form action="age.php" method="post">
            <input type="submit" name="key_gen" value="Generate Key">
        </form>
        <form action="age.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" placeholder="File">
            <input type="text" name="key" placeholder="Key">
            <input type="submit" name="encrypt" value="Encrypt">
        </form>
        <form action="age.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" placeholder="File">
            <input type="text" name="key" placeholder="Key">
            <input type="submit" name="decrypt" value="Decrypt">
        </form>
        <form action="age.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" placeholder="File">
            <input type="text" name="passphrase" placeholder="Passphrase">
            <input type="submit" name="encrypt_with_passphrase" value="Encrypt with Passphrase">
        </form>
        <form action="age.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" placeholder="File">
            <input type="text" name="passphrase" placeholder="Passphrase">
            <input type="submit" name="decrypt_with_passphrase" value="Decrypt with Passphrase">
        </form>
    </body>
</html>';
}

html_form();
if(isset($_POST['key_gen'])){
    key_generation();
}

// Check
if(isset($_POST['encrypt'])){
    $file = sanatise_filename($_FILES['file']['name']);
    $temp_location = $_FILES['file']['tmp_name'];
    $destination = "upload/{$file}";
    move_uploaded_file($temp_location, $destination);
    $key = $_POST['key'];
    encrypt($file, $key);
    // send file to user
    echo '<a href="/upload/' . $_FILES['file']['name'] . '.age">Download</a>';
}

if(isset($_POST['decrypt'])){
    $file = sanatise_filename($_FILES['file']['name']);
    $temp_location = $_FILES['file']['tmp_name'];
    $destination = "upload/{$file}";
    move_uploaded_file($temp_location, $destination);
    $key = $_POST['key'];
    decrypt($file);
    echo '<a href="/upload/' . $_FILES['file']['name'] . '.decrypted">Download</a>';
}

if(isset($_POST['encrypt_with_passphrase'])){
    $file = sanatise_filename($_FILES['file']['name']);
    $temp_location = $_FILES['file']['tmp_name'];
    $destination = "upload/{$file}";
    move_uploaded_file($temp_location, $destination);
    $passphrase = $_POST['passphrase'];
    encrypt_with_passphrase($file, $passphrase);
    // send file to user
    echo '<a href="/upload/' . $_FILES['file']['name'] . '.age">Download</a>';
}

if(isset($_POST['decrypt_with_passphrase'])){
    $file = sanatise_filename($_FILES['file']['name']);
    $temp_location = $_FILES['file']['tmp_name'];
    $destination = "upload/{$file}";
    move_uploaded_file($temp_location, $destination);
    $passphrase = $_POST['passphrase'];
    decrypt_with_passphrase($file, $passphrase);
    echo '<a href="/upload/' . $_FILES['file']['name'] . '.decrypted">Download</a>';
}

function sanatise_filename($filename){
    $filename = preg_replace('/[^a-zA-Z0-9_.]/', '', $filename);
    return $filename;
}
