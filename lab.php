<?php
	$matrix1_height = 0;
	$matrix1_width = -1;
	$matrix2_height = 0;
	$matrix2_width = -1;
	
	$matrix1_arr = array();
	$matrix2_arr = array();
	
	while (true){
		$usr_input = readline("MATRIX 1: Put in the matrix by inputting values serpated by one space. Type q and enter to finish\n");
		if ($usr_input == "q"){break;}
		$usr_input_split = explode(' ', $usr_input);
		$row_of_bools = array();
		$row_counter = 0;
		foreach ($usr_input_split as $row_el) {
			//returns null if not truthy
			echo "ROW EL IS (". $row_el .")\n";
			if ($row_el != "0" && $row_el != "1"){throw new Exception("Values are not truthy enough to be in a Boolean Matrix");}
			//now we just push the value because it's either true or false
			array_push($row_of_bools, $row_el);
			$row_counter++;
		}

		if ($row_counter != $matrix1_width){
			if ($matrix1_width == -1){
				$matrix1_width = $row_counter;
			}
			else {
				throw new Exception("Error Rows have incompatible sizing");
			}
		}

		array_push($matrix1_arr, $usr_input_split);

		$matrix1_height++;
	}
	if ($matrix1_height == 0){
		throw new Exception("Error, matrix height is zero, has no values");	
	}
	echo "Resulting Matrix 1\n";
	foreach ($matrix1_arr as $row){
		echo '|';
		foreach ($row as $x){
			echo ' ' . $x . ' ';
		}
		echo "|\n";
	}


	while (true){
		$usr_input = readline("MATRIX 2: Put in the matrix by inputting values serpated by one space. Type q and enter to finish\n");
		if ($usr_input == "q"){break;}
		$usr_input_split = explode(' ', $usr_input);
		$row_of_bools = array();
		$row_counter = 0;
		foreach ($usr_input_split as $row_el) {
			//returns null if not truthy
			echo "ROW EL IS (". $row_el .")\n";
			if ($row_el != "0" && $row_el != "1"){throw new Exception("Values are not truthy enough to be in a Boolean Matrix");}
			//now we just push the value because it's either true or false
			array_push($row_of_bools, $row_el);
			$row_counter++;
		}

		if ($row_counter != $matrix2_width){
			if ($matrix2_width == -1){
				$matrix2_width = $row_counter;
			}
			else {
				throw new Exception("Error Rows have incompatible sizing");
			}
		}

		array_push($matrix2_arr, $usr_input_split);

		$matrix2_height++;
	}

	if ($matrix2_height == 0){
		throw new Exception("Error, matrix height is zero, has no values");	
	}

	echo "Resulting Matrix 1\n";
	foreach ($matrix2_arr as $row){
		echo '|';
		foreach ($row as $x){
			echo ' ' . $x . ' ';
		}
		echo "|\n";
	}

	//now we gotta check if we can actually do this arr
	//based on the rules of matrix multiplication
	if ($matrix1_width != $matrix2_height){
		throw new Exception("The laws of linear algebra do not allow this multiplcation to occur\n");
	}

	//our resulting matrix will come from the matrix1_height x matrix2_width

	$result_height = $matrix1_height;
	$result_width = $matrix2_width;

	//okay so the way i understand matrix multiplication is by rotating left
	//and then doing all values, which i will now recreate
	//we are gonna make a left array, with inversed width and height
	//from our matrix 2
	$leftm_height = $matrix2_width;
	$leftm_width = $matrix2_height;

	//these variables are to access the values in the matrix2 rows
	$mut_row = $leftm_width-1; //start it at left-m the fartherst row we can
	for($i = 0; i < $leftm_width; i++){
		
	}
	




?>
