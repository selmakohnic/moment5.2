<?php

/* En klass vars uppgift är att hantera kurser i utbildningen. */ 
class CoursesRegister {
    private $db;

    function __construct() {
        //Anslutning till databasen
        $this->db = new mysqli(DBHOST, DBUSER, DBPASSWORD, DBDATABASE); 

        //Felhantering
        if($this->db->connect_errno > 0) {
            die ("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    //Hämtar alla kurser
    function getCourses() {
       //SQL-fråga för att välja allt innehåll i tabellen course
       $sql = "SELECT * FROM course";
       $result = $this->db->query($sql);                    

       //Retunerar resultatet som en array
       return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //Hämtar en specifik kurs
    function getSpecifikCourse($id) {
        $id = intval($id);
        //SQL-fråga för att hämta ut en specifik kurs baserat på id
        $sql = "SELECT * FROM course WHERE id = $id";
        $result = $this->db->query($sql);                    

        //Retunerar resultatet som en array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //Uppdaterar en kurs
    function updateCourse($id, $code, $name, $progression, $syllabus) {
        $id = intval($id);
        //SQL-fråga för att uppdatera en kurs
        $sql = "UPDATE course SET code = '$code', name = '$name', progression = '$progression',
                syllabus = '$syllabus' WHERE id = $id;";
        
        return $this->db->query($sql);
    }

    //Hanterar kurser som läggs till
    function addCourse($code, $name, $progression, $syllabus) {
        //SQL-fråga för att lägga till värden i tabellen course
        $sql = "INSERT INTO course (code, name, progression, syllabus) VALUES ('$code', '$name', '$progression', '$syllabus');";

        return $this->db->query($sql);
    }

    //Raderar valda kurser
    function deleteCourse($id) {
        $id = intval($id);
        //SQL-fråga för att radera den kurs som är kopplad till id:et som är valt
        $sql = "DELETE FROM course WHERE id = $id";
        
        return $this->db->query($sql);
    }
/*
    //Raderar valda inlägg
    function deletePost($id) {
        $id = intval($id);
        //SQL-fråga för att radera den information som är kopplad till id:et som är valt
        $sql = "DELETE FROM blogposts WHERE id = $id";
        
        return $this->db->query($sql);
    }

    //Hanterar en del säkerhet
    function setInput($title, $post) {
        /* Om titeln och inlägget som matas in inte är tomt görs en escape på alla tecken så att ingen 
           kan skriva in exempelvis kod som på något sätt förstör databasen, SQL-frågorna eller liknande. 
        if($title != "" && $post != "") {
            //Tar bort eventuell kod som skulle kunna vara farlig
            $title = strip_tags($title); 
            $post = strip_tags($post);

            $this->title = $this->db->real_escape_string($title);
            $this->post = $this->db->real_escape_string($post);
            return true;
        }
        else {
            return false;
        }
    }*/
} 

?>