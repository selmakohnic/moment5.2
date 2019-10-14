"use strict";

//Variabler
const url = "http://studenter.miun.se/~seko1800/dt173g/moment5.1/courselist.php/courses";

//Händelsehanterare
window.onload = getCourses;
document.getElementById("formBtn").addEventListener("click", addCourse);

//Hämtar alla kurser och skriver ut dessa
function getCourses() {
    //Använder fetch för att hämta JSON
    fetch(url)
        .then((res) => res.json())
        .then((data) => {
            let output = "";    //Variabel till utskrift

            //Varje element i JSON-fil skrivs ut i tabellen med hjälp av en forEach-loop
            data.forEach(function (course) {
                output += `<tr>
                    <td>${course.code}</td>
                    <td>${course.name}</td>
                    <td>${course.progression}</td>
                    <td><a href='${course.syllabus}' title='Kursplan för ${course.code}' target='_blank'>Webblänk</a></td>
                </tr>`;
            })
            document.getElementById("coursesOutput").innerHTML = output;
        })
}

//Lägger till en kurs
function addCourse() {
    //Värden i inmatningsfälten sparas i variabler
    let code = document.getElementById("c_code").value;
    let name = document.getElementById("c_name").value;
    let progression = document.getElementById("c_progression").value;
    let syllabus = document.getElementById("c_syllabus").value;

    //Kontroll av innehållet i inmatningsfälten. Är de tomma skrivs ett felmeddelande ut, är dem inte det sparas informationen
    if (code == "" || code == null && name == "" || name == null && progression == "" || progression == null && syllabus == "" || syllabus == null) {
        document.getElementById("msg").innerHTML = "Fyll i alla fält!";
    }
    else {
        let jsonStr = JSON.stringify({
            "code": code,
            "name": name,
            "progression": progression,
            "syllabus": syllabus
        });

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: jsonStr
        }).then((res) => res.json())
            .then((data) => location.reload(true))
            .catch((err) => console.log(err))
    }
}