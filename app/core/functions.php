<?php

function query(string $query, array $data = [])
{
    $string = "mysql:hostname=".DBHOST.";dbname=".DBNAME;
    $con = new PDO($string, DBUSER, DBPASS);

    $stm = $con->prepare($query);
    $stm->execute($data);

    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(is_array($result) && !empty($result))
    {
        return $result;
    }
    return false;
}

function redirect($page)
{ 
    header('Location:'.$page);
    die;
}

function old_value($key)
{
    if(!empty($_POST[$key]))
    return $_POST[$key];
    return "";
}

function old_checked($key)
{
    if(!empty($_POST[$key]))
    return "checked";
    return "";
}

function str_to_url($result)
{
    $url=str_replace("'","",$url);
    $url=preg_replace('~[^\\pL0-9_]+~u','-',$url);
    $url=trim($url,"-");
    $url=iconv("utf-8","us-ascii//TRANSLIT",$url);
    $url=strtolower($url);
    $url=preg_replace('~[^-a-z0-9_]+~','',$url);

    return $url;
}

function authenticate($row)
{
    $_SESSION['USER'] = $row;
}
function logged_in()
{
   if(!empty( $_SESSION['USER']))
      return true;

   return false;
}


//create_tables();
function create_tables()
{
    $string = "mysql:hostname=".DBHOST.";";
    $con = new PDO($string, DBUSER, DBPASS);

    $query = "create database if not exists ". DBNAME;
    $stm = $con->prepare($query);
    $stm->execute();

    $query = "use ". DBNAME;
    $stm = $con->prepare($query);
    $stm->execute();

    //kullanıcılar tablosu 
    $query = "create table if not exists users(
    
        id int primary key auto_increment,
        username nvarchar(50) not null,
        email nvarchar(100) not null,
        password varchar(50) not null,
        image varchar(1024) null,
        date datetime default current_timestamp,
        role varchar(50) not null,
        
        key username (username),
        key email (email)
    
    
    )";
    $stm = $con->prepare($query);
    $stm->execute();

    //kategori tablosu
    $query = "create table if not exists categories(
    
    id int primary key auto_increment,
    category nvarchar(50) not null,
    slug nvarchar(100) not null,
    disabled tinyint default 0,

    
    key slug (slug),
    key category (category)


)";
$stm = $con->prepare($query);
$stm->execute();

//gönderiler 
$query = "create table if not exists posts(
    
id int primary key auto_increment,
user_id int,
category_id int,
title varchar(100) not null,
content text null,
image varchar(1024) null,
date datetime default current_timestamp,
slug varchar(100) not null,

key user_id (user_id),
key category_id (category_id),
key title (title),
key slug (slug),
key date (date)

)";
$stm = $con->prepare($query);
$stm->execute();

}