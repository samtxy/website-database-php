<html>
<body>
<b><font color=red>Results from available input:</font></b>
<p></p>
<?php
$link = mysql_connect('mariadb','cs332g17','ePae7ugh'); 
if(!$link) {
    die('Could not connect to mySQL database. ' .mysqli_error());
}
echo("Connected successfully to mySQL database.");
mysql_select_db("cs332g17",$link);

echo nl2br ("\nLast update: 12/18/2020 (Patched Bugs & Several Issues)\n\n");

$query = "SELECT ProfSSN FROM Professors WHERE ProfSSN=".$_POST["ssn"];
$result = mysql_query($query,$link);

if ($_POST["ssn"] && mysql_num_rows($result) != 0){
    echo nl2br ("===========================================================\n");
    echo ("Results for the Professor w/SSN ").$_POST["ssn"];
    echo nl2br ("\n===========================================================\n");
    $query = "SELECT * FROM Professors WHERE ProfSSN=".$_POST["ssn"];
    $result = mysql_query($query,$link);

    echo nl2br ("Name: ".mysql_result($result,0,"ProfName")."\n");
    echo nl2br("Title: ".mysql_result($result,0,"Title")."\n\n");

    $query = "SELECT * FROM Sections WHERE PSSN=".$_POST["ssn"];
    $result = mysql_query($query,$link);
    
    for($i=1; $i<=mysql_numrows($result); $i++) {
        echo "Class #$i <br>";
        echo "Classroom: ".mysql_result($result,$i - 1,"Classroom"), "<br>";
        echo "Meeting Days: ".mysql_result($result,$i - 1,"MeetingDays"), "<br>";
        echo "Time: ".mysql_result($result,$i - 1,"BegTime");
        echo " - ".mysql_result($result,$i - 1,"EndTime"), "<br> <br>";
    }

    echo nl2br ("\n");
}

$query = "SELECT CourseNo FROM Courses WHERE CourseNo=".$_POST["cno"];
$result = mysql_query($query,$link);
$query = "SELECT SectionNo FROM Sections WHERE SectionNo=".$_POST["sno"];
$result2 = mysql_query($query,$link);
if ($_POST["cno"] && $_POST["sno"] && mysql_num_rows($result) != 0 && mysql_num_rows($result2) != 0){
    echo nl2br ("===========================================================\n");
    echo ("Results for the course number ").$_POST["cno"].(" and the section number ").$_POST["sno"];
    echo nl2br ("\n===========================================================\n");
    
    // Display course name and section
    $query = "SELECT * FROM Courses WHERE CourseNo=".$_POST["cno"];
    $result = mysql_query($query,$link);
    echo nl2br("Name: ".mysql_result($result,0,"Title"));
    echo nl2br ("\n\n");

    // Display all other information
    $getCourseNo = $_POST["cno"];
    $query = "SELECT Grade, COUNT(*) AS Total FROM Enrollments WHERE C_Num = $getCourseNo GROUP BY Grade";
    $result = mysql_query($query,$link);

     for($i=1; $i<=mysql_numrows($result); $i++) {
         echo "Students w/Grade ".mysql_result($result,$i - 1,"Grade").": ".mysql_result($result,$i - 1,"Total"), "<br>";
     }

    echo nl2br ("\n");
}

$query = "SELECT CourseNo FROM Courses WHERE CourseNo=".$_POST["cno"];
$result = mysql_query($query,$link);
if ($_POST["cno"] && mysql_num_rows($result) != 0){
    echo nl2br ("===========================================================\n");
    echo ("Results for JUST the course number ").$_POST["cno"];
    echo nl2br ("\n===========================================================\n");
    
     // Display course name
     $query = "SELECT * FROM Courses WHERE CourseNo=".$_POST["cno"];
     $result = mysql_query($query,$link);
     echo nl2br("Name: ".mysql_result($result,0,"Title"));
     echo nl2br ("\n");
             
     // Display all other information
     $query = "SELECT * FROM Sections WHERE CNum=".$_POST["cno"];
     $result = mysql_query($query,$link);
     $query2 = "SELECT * FROM Enrollments WHERE C_Num=".$_POST["cno"];
     $result2 = mysql_query($query2,$link);
             
     for($i=1; $i<=mysql_numrows($result); $i++) {
         echo "Section: ".mysql_result($result,$i - 1,"SectionNo"), "<br>";
         echo "Classroom: ".mysql_result($result,$i - 1,"Classroom"), "<br>";
         echo "Meeting Days: ".mysql_result($result,$i - 1,"MeetingDays"), "<br>";
         echo "Time: ".mysql_result($result,$i - 1,"BegTime");
         echo " - ".mysql_result($result,$i - 1,"EndTime"), "<br> <br>";
     }
 
     $rows = mysql_num_rows($result2);
     echo "Enrolled Students: ".$rows;

    echo nl2br ("\n");
}

$query = "SELECT CWID FROM Students WHERE CWID=".$_POST["cwid"];
$result = mysql_query($query,$link);
if ($_POST["cwid"] && mysql_num_rows($result) != 0){
    echo nl2br ("===========================================================\n");
    echo ("Results for the specified CWID ").$_POST["cwid"];
    echo nl2br ("\n===========================================================\n");
    
    // Display student name
    $query = "SELECT * FROM Students WHERE CWID=".$_POST["cwid"];
    $result = mysql_query($query,$link);
    echo nl2br("Name: ".mysql_result($result,0,"FirstName"));
    echo nl2br ("\n");
            
    // Display all other information
    $query = "SELECT * FROM Enrollments WHERE SCWID=".$_POST["cwid"];
    $result = mysql_query($query,$link);
            
    for($i=1; $i<=mysql_numrows($result); $i++) {
        echo "Class #$i <br>";
        echo "Course: ".mysql_result($result,$i - 1,"C_Num"), "<br>";
        echo "Grade: ".mysql_result($result,$i - 1,"Grade"), "<br> <br>";
    }

    echo nl2br ("\n");
}

mysql_close($link);
?>
</body>
</html> 
