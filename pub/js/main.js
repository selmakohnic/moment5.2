"use strict";const url="http://studenter.miun.se/~seko1800/dt173g/moment5.1/courselist.php/courses";function getCourses(){fetch(url).then(e=>e.json()).then(e=>{let t="";e.forEach(function(e){t+=`<tr>\n                    <td>${e.code}</td>\n                    <td>${e.name}</td>\n                    <td>${e.progression}</td>\n                    <td><a href='${e.syllabus}' title='Kursplan för ${e.code}' target='_blank'>Webblänk</a></td>\n                </tr>`}),document.getElementById("coursesOutput").innerHTML=t})}function addCourse(){let e=document.getElementById("c_code").value,t=document.getElementById("c_name").value,n=document.getElementById("c_progression").value,l=document.getElementById("c_syllabus").value;if(""==e||null==e&&""==t||null==t&&""==n||null==n&&""==l||null==l)document.getElementById("msg").innerHTML="Fyll i alla fält!";else{let o=JSON.stringify({code:e,name:t,progression:n,syllabus:l});fetch(url,{method:"POST",headers:{"Content-Type":"application/json"},body:o}).then(e=>e.json()).then(e=>location.reload(!0)).catch(e=>console.log(e))}}window.onload=getCourses,document.getElementById("formBtn").addEventListener("click",addCourse);