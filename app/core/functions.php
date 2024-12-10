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
    $query = "create table if not exists kullanicilar(
    
        id int primary key auto_increment,
        kullanici_adi nvarchar(50) not null,
        e_mail nvarchar(100) not null,
        sifre varchar(50) not null,
        kullanici_resmi varchar(1024) null,
        tarih datetime default current_timestamp,
        rol varchar(50) not null,
        
        key kullanici_adi (kullanici_adi),
        key e_mail (e_mail)
    
    
    )";
    $stm = $con->prepare($query);
    $stm->execute();

    //kategori tablosu
    $query = "create table if not exists kategoriler(
    
    id int primary key auto_increment,
    kategori nvarchar(50) not null,
    slug nvarchar(100) not null,
    devre_disi tinyint default 0,

    
    key slug (slug),
    key kategori (kategori)


)";
$stm = $con->prepare($query);
$stm->execute();

//gönderiler 
$query = "create table if not exists gonderiler(
    
id int primary key auto_increment,
kullanici_id int,
kategori_id int,
baslik nvarchar(100) not null,
icerik text null,
resim varchar(1024) null,
tarih datetime default current_timestamp,
slug varchar(100) not null,
key kullanici_id (kullanici_id),
key kategori_id (kategori_id),
key baslik (baslik),
key slug (slug),
key date (tarih)

)";
$stm = $con->prepare($query);
$stm->execute();

}