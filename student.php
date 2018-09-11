<?php
	if (isset($_POST['key'])) {
	

		$conn = new mysqli('localhost', 'root', '', 'student');

		

		if ($_POST['key'] == 'getExistingData') {
			$start = $conn->real_escape_string($_POST['start']);
			$limit = $conn->real_escape_string($_POST['limit']);

			$sql = $conn->query("SELECT id, s_name , year FROM students LIMIT $start, $limit");
			if ($sql->num_rows > 0) {
				$response = "";
				while($data = $sql->fetch_array()) {
					$response .= '
						<tr>
							<td> <a href="page2.html?id='.$data["id"].'" id= '.$data["id"].' >'.$data["id"].' </a></td> 
							<td id="student_'.$data["id"].'"> <a href="page2.html?id='.$data["id"].'" id= '.$data["id"].'>'.$data["s_name"].'</a></td>
							<td id="student_'.$data["id"].'"><a href="page2.html?id='.$data["id"].'" id= '.$data["id"].'>'.$data["year"].'</a></td>
							
						</tr> 
					';
				}
				exit($response);
			} else
				exit('reachedMax');
		}

		$rowID = $conn->real_escape_string($_POST['rowID']);

		

		$s_name = $conn->real_escape_string($_POST['s_name']);
		$year = $conn->real_escape_string($_POST['year']);
		

	

		if ($_POST['key'] == 'addNew') {
			
			$sql = $conn->query("SELECT id FROM students WHERE s_name = '$s_name'");
			if ($sql->num_rows > 0)
				exit("Student with this name already exists!");
			else {
				$conn->query("INSERT INTO students (s_name, year) 
							VALUES ('$s_name', '$year')");
				exit('Student Has Been added');
			}
		}
	}
?>

