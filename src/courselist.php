<?php
// curl request:
// curl -i -X GET http://localhost/Webbutveckling3/Moment5/courselist.php/courses/
// curl -i -X GET http://localhost/Webbutveckling3/Moment5/courselist.php/courses/1
// curl -i -X POST -d '{"code":"DT057G","name":"Webbutveckling I", "progression":"A", "syllabus":"https://www.miun.se/utbildning/kursplaner-och-utbildningsplaner/Sok-kursplan/kursplan/?kursplanid=17948"}' http://localhost/Webbutveckling3/Moment5/courselist.php/courses/
// curl -i -X PUT -d '{"code":"DT057G","name":"Webbutveckling I", "progression":"A", "syllabus":"https://www.miun.se/utbildning/kursplaner-och-utbildningsplaner/Sok-kursplan/kursplan/?kursplanid=17948"}' http://localhost/Webbutveckling3/Moment5/courselist.php/courses/1
// curl -i -X DELETE http://localhost/Webbutveckling3/Moment5/courselist.php/courses/1
//
// POST            Creates a new resource.
// GET             Retrieves a resource.
// PUT             Updates an existing resource.
// DELETE          Deletes a resource.

//Skickar return header-information
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');

//Inkluderar databaskopplingsfil och klassen CoursesRegister
include("includes/config.php");
include("includes/CoursesRegister.class.php");

//HTTP-metod, path och input av förfrågning
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input'), true);

if ($request[0] != "courses") {
	http_response_code(404);
	exit();
}

$course = new CoursesRegister(); //Instans av klassen CoursesRegister

//Om ett id skrivits med tilldelas detta till en variabel
if(isset($request[1])) {
	$id = $request[1];
}

//Värden som skrivs in som input lagras i variabler
$code = $input["code"];
$name = $input["name"];
$progression = $input["progression"];
$syllabus = $input["syllabus"];

//Kontrollerar HTTP-metod och utför ett case baserat på det
switch ($method){
	case "GET":
		if(isset($id)) {
			//Skriver ut en specifik kurs
			$response = $course->getSpecifikCourse($id);
		}
		else {
			//Skriver ut alla kurser
			$response = $course->getCourses();
		}
		//Returnerar resultat i JSON
		echo json_encode($response, JSON_PRETTY_PRINT);
		break;
	case "PUT":
		//Uppdaterar en kurs
		$course->updateCourse($id, $code, $name, $progression, $syllabus);
    	break;
	case "POST":
		//Lägger till en kurs
		$course->addCourse($code, $name, $progression, $syllabus);
		break;
	case "DELETE":
		//Raderar en kurs
   		$course->deleteCourse($id);
		break;
}

$courseArr = []; //Array för JSON

//Om metoden inte är GET, skrivs kurserna ut ändå
if($method != "GET") {
	//Skriver ut alla kurser
	$courseList = $course->getCourses(); 
	
	//Placeras i en array för att därefter skrivas ut i JSON
	foreach($courseList as $row) {
		$row_arr['id'] = $row['id'];
		$row_arr['code'] = $row['code'];
		$row_arr['name'] = $row['name'];
		$row_arr['progression'] = $row['progression'];
		$row_arr['syllabus'] = $row['syllabus'];
		array_push($courseArr,$row_arr);
	}
	echo json_encode($courseArr);
}
?>