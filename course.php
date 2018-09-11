<?php
	if (isset($_POST['key'])) {
	

        $conn = new mysqli('localhost', 'root', '', 'student');

        if ($_POST['key'] == 'getName') { 
        $id = $_POST['s_id'];    
        $sql = $conn->query("SELECT s_name  FROM students WHERE id = '$id'  ");
        $data = $sql->fetch_array();
        $response= $data["s_name"];
        exit($response);

        }


        if ($_POST['key'] == 'getExistingData') {

    
            $id = $conn->real_escape_string($_POST['s_id']);
			$start = $conn->real_escape_string($_POST['start']);
            $limit = $conn->real_escape_string($_POST['limit']);
            

			$sql = $conn->query("SELECT course_id, course_name , year FROM courses WHERE course_name IN
            (SELECT course_name FROM student_courses WHERE student_id = '$id') LIMIT $start, $limit ");
			if ($sql->num_rows > 0) {
				$response = "";
				while($data = $sql->fetch_array()) {
					$response .= '
						<tr>
							<td> '.$data["course_id"].'</td> 
							<td id="student_'.$data["course_id"].'">'.$data["course_name"].'</td>
                            <td id="student_'.$data["course_id"].'">'.$data["year"].'</td>
                            <td><input id="'.$data["course_name"].'" type="button" onclick="deleteCourse(get_id, \''.$data["course_name"].'\')" value="Delete" class="btn btn-danger"> </td>
							
						</tr> 
					';
				}
				exit($response);
            }
           
             else
				exit('reachedMax');
        }
        
        if ($_POST['key'] == 'getCourse') {
              $id = $conn->real_escape_string($_POST['s_id']);
              $sql_year = $conn->query("SELECT  year FROM students WHERE id ='$id' ");
              $data = $sql_year->fetch_array();
              $year= $data["year"];


            $sql = $conn->query("SELECT  course_name FROM courses WHERE year ='$year' ");
			if ($sql->num_rows > 0) {
				$response = "";
				while($data = $sql->fetch_array()) {
					$response .= '
						
							<option> '.$data["course_name"].'</option> 
							
							
						
					';
				}
				exit($response);
            }
           
        }
        

        if ($_POST['key'] == 'addCourse') {
            $id = $conn->real_escape_string($_POST['s_id']);
            $course = $conn->real_escape_string($_POST['course']);
			$sql = $conn->query("SELECT course_name FROM student_courses WHERE student_id = '$id'");
            if ($sql->num_rows > 0) {
				while($data = $sql->fetch_array()) {
                    if($data['course_name']==$course){
                        exit("Course already registered");
                    }

                }  
            }
            $conn->query("INSERT INTO student_courses(student_id, course_name) 
							VALUES ('$id', '$course')");
				exit('course Has Been added');
     

        
    }

    if ($_POST['key'] == 'deleteCourse') {

        
        $id = $conn->real_escape_string($_POST['s_id']);
        $course_name = $conn->real_escape_string($_POST['course']);
        //exit($id);
        $conn->query("DELETE FROM student_courses WHERE student_id='$id' AND course_name='$course_name'");
        exit('The Course Has Been Deleted!');
    }


}
?>