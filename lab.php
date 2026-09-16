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

	echo "Resulting Matrix 2\n";
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
	$result_arr = array();

	//okay so the way i understand matrix multiplication is by rotating left
	//and then doing all values, which i will now recreate
	//we are gonna make a left array, with inversed width and height
	//from our matrix 2
	$leftm_height = $matrix2_width;
	$leftm_width = $matrix2_height;
	$leftm_arr = array();

	//these variables are to access the values in the matrix2 rows
	  
	//so when we "rotate" a matrix we basically just shift it up where the farthest x elements become the smallest y elements
	//like so
	//
	//|  1  2 |  rotate left    |  2  4  6 |
	//|  3  4 |  90* degrees    |  1  3  5 |
	//|  5  6 |  ----------->
	//
	//so here's what we do:
	//for every i in the width range (in this case, 0 to 1
	//	get every x-ith element in any y column
	//		(example): 2, 4, 6 have x=1, y=*wildcard
	//	make them into an array
	//		(2,4,6)
	//	push that value to the main array
	//		array_push($result_arr, (2,4,6))
	//	proceed.
	//
	//this will be a bit tough, but hopefully this makes sense

	for($x = $matrix2_width-1; $x >= 0; $x--){
	       $x_level_arr = array();
	       for ($y = 0; $y < $matrix2_height; $y++){
		    array_push($x_level_arr, $matrix2_arr[$y][$x]);
	       }
	       array_push($leftm_arr, $x_level_arr);
	}
	//boom badabooey we have our left shifted matrix.
	//now we have to iteravely define the matrix thing
	//for every value in the matrix and correspond it correctly
	//so fun!!

	//basically, here's the psuedogist
	//
	//for every row in matrix_1:
	//	for every row on matrix_2:
	//		calculate their combined coefficients
	//		(example, matrix_1 is 1 1 and the other is 0 1 
	//		(1 * 0 ) + ( 1 * 1)
	//		calcualte the response, i think it's just or??
	//
	echo "Left shifted matrix is\n";
	foreach ($leftm_arr as $py){
		foreach($py as $px){
			echo ' ' . $px . ' ';
		}
		echo "\n";
	}


	//this is O(n^3). gross!!! but it works

	for ($matrix1_i = 0; $matrix1_i < $matrix1_height; $matrix1_i++){

		//this is our array for the current working row of x values
		$matrix1_slice_at_y = $matrix1_arr[$matrix1_i];

		//sum_slot, a slot to put sums into
		//we basically just gotta sum up the values
		//by converting them to chars and then multiplying and adding
		//to the sum_slot. if the sum slut is >= 1
		//then the value is set it true else false
		$sum_slot = 0;


		//these should be the same len so we need to check before
		//just to be paranoid
		if ($leftm_width != $matrix1_width){
			throw new Error("Impossible Error, the width and matrix1_width shouldn't happen");
		}

		for ($leftm_i = 0; $leftm_i < $leftm_height; $leftm_i++){
			
			
			//get our x array for this iteration

			$leftm_slice_at_y = $leftm_arr[$leftm_i];
			
			for ($i=0; $i<$leftm_width; $i++){
				$sum_slot += ( (int) ( ($leftm_arr[$leftm_i][$i]) * ($matrix1_arr[$matrix1_i][$i])) );

			}

			$sum_slot = $sum_slot >= 1 ? 1 : 0;	
			echo $sum_slot . " " ;
		}
	       echo "\n";

	}
	
	



?>
