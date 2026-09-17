<?php
	/*
	 *  <@)
	 *   KU//
	 *   " "
	 *   LUCAS FRIAS EECS 210
	 *   KUID: 3195413
	 *   LAB: WEDNESDAY 8:00 AM (MOHAMMAD)
	 *   LAB NO 3
	 *   DESCRIPTION: given a matrix that is
	 *   space seperated, returns the multi
	 *   -plication of two matrixes if 
	 *   possible. Written in PHP
	 *   Collaborators: Mrs. Mohammad for
	 *   discussing better algorithms with me
	 *   and Prof. Hodges (Linear Algebra)
	 *   for discussing boolean matrix mult-
	 *   iplication.
	 */

    //defines a new prompt function to work with
    //the less fancy php library that INSTALL.sh
    //uses, instead of readline
    function prompt(string $label): string {
        //echoes the prompt like readline
        echo $label;
        //returns the text from STDIN, trimmed at the end to remove\n
        $line = trim(fgets(STDIN));
        //this is a fancy little regex i'm adding last minute because
        //the python lab has it formatted so that you can put a whole lot
        //of whitespace between the values. this shouuuuld fix that
        return preg_replace('/ +/', ' ', $line);
    }

	$matrix1_height = 0;
	$matrix1_width = -1;
	$matrix2_height = 0;
	$matrix2_width = -1;
	
	$matrix1_arr = array();
	$matrix2_arr = array();
	
	while (true){
		$usr_input = prompt("MATRIX 1: Enter your matrix, with a blank line to end:\n>"); 
		if ($usr_input == ""){break;}
		$usr_input_split = explode(' ', $usr_input);
		$row_of_bools = array();
		$row_counter = 0;
		foreach ($usr_input_split as $row_el) {
			//returns null if not truthy
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
		$usr_input = prompt("MATRIX 2: Enter your matrix, with a blank line to end:\n>"); 
		if ($usr_input == ""){break;}
		$usr_input_split = explode(' ', $usr_input);
		$row_of_bools = array();
		$row_counter = 0;
		foreach ($usr_input_split as $row_el) {
			//returns null if not truthy
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


	//okay so apparently matrix multiplcation is almost always O(n^3)
	//i don't make a resulting matrix to display i just format and display the result
	//okay here's how this works. imagine we multiply
	// | 1  0 |      | 0 0 |
	// | 0  1 |   x  | 1 1 |
	//
	// first, we pick the ith row on the left matrix (start at i=0)
	//
	//this one here
	// --->| (1 0) |    | 0  0 |
	//     | 0   1 |    | 1  1 |
	// then we iterate through the jth column of the second matrix
	// so this one here 
	//		       |	
	//                     |
	// 	               v	
	//     | (1 0) |    | (0)  0 |
	//     | 0   1 |    | (1)  1 |
	//
	// and then we iterate through the range of values represented in the set of values whose column = j
	// (0, 1)
	// and apply them to the ith row
	// (0 * 1) + (1 * 0) = 0
	//
	// we can write this in php as
	// $sum += ( (int) $matrix1_arr[$i][$k] ) * ( (int) ($matrix2_arr[$k][$j]) );
	//
	// and then display our result with echo after the end of the third loop for each sum
	// 
	// lastly, at the end of every ith result we newline to demonstrate we're on a new column
	// badaboosh

	echo "ANSWER OF A*B:\n____________________________\n";

	for ($i = 0; $i < $result_height; $i++){
		//echo the beginning char to set the thing
		echo "| ";
		//do the second loop over columns
		for ($j = 0; $j < $result_width; $j++){
			$sum = 0;
			//so this is gonna be confusing.
			//for each x, we multiply the integer value
			//like $matrix1_arr[i][j] * $matrix2_arr[j][i]
			//and we have to cast it to int because they are strings at the moment
			for ($k = 0; $k < $matrix1_width; $k++){
				//then we add the sum to the value for each element from each area
				$sum += ((int) $matrix1_arr[$i][$k] ) * ( (int) ($matrix2_arr[$k][$j]) );

				//okay sneaky optimization here. if 1 of the elements is true, we
				//can just break and go to the next statement, this makes our algorithm O(n^2 * log_2(n) because of the probability distribution of having a true statement arise (for more inputs it will happen eventualy)
				if ($sum > 0){
					//echo the result, we don't need to keep searching
					echo '1 ';
					//break out of this loop, we're done
					break;
				}
			}
			if ($sum == 0){
				//now if the sum is zero, that means, well, the result is zero
				echo '0 ';
			}
		}
		//end of the statement so we newline and continue
		echo "|\n";
	}

	//bad code is below for prosperity. feel free to look, just trying to grapple with the algorithmic
	//tendencies of doing this. take a look if you're interested.

	//okay so the way i understand matrix multiplication is by rotating left
	//and then doing all values, which i will now recreate
	//we are gonna make a left array, with inversed width and height
	//from our matrix 2
	//$leftm_height = $matrix2_width;
	//$leftm_width = $matrix2_height;
	//$leftm_arr = array();

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

	/*for($x = $matrix2_width-1; $x >= 0; $x--){
	       $x_level_arr = array();
	       for ($y = 0; $y < $matrix2_height; $y++){
		    array_push($x_level_arr, $matrix2_arr[$y][$x]);
	       }
	       array_push($leftm_arr, $x_level_arr);
	}*/
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
	//echo "Left shifted matrix is\n";
	/*foreach ($leftm_arr as $py){
		foreach($py as $px){
			echo ' ' . $px . ' ';
		}
		echo "\n";
	}*/

	
	//this is O(n^3). gross!!! but it works
	/*echo "|";
	for ($matrix1_i = 0; $matrix1_i < $matrix1_height; $matrix1_i++){

		//this is our array for the current working row of x values
		$matrix1_slice_at_y = $matrix1_arr[$matrix1_i];

		//sum_slot, a slot to put sums into
		//we basically just gotta sum up the values
		//by converting them to chars and then multiplying and adding
		//to the sum_slot. if the sum slut is >= 1
		//then the value is set it true else false


		//these should be the same len so we need to check before
		//just to be paranoid
		if ($leftm_width != $matrix1_width){
			throw new Error("Impossible Error, the width and matrix1_width shouldn't happen");
		}

		for ($leftm_i = 0; $leftm_i < $leftm_height; $leftm_i++){
			
			
			$sum_slot = 0;
			//get our x array for this iteration

			$leftm_slice_at_y = $leftm_arr[$leftm_i];
			
			for ($i=0; $i<$leftm_width; $i++){
				$sum_slot += ( (int) ( ($leftm_arr[$leftm_i][$i]) * ($matrix1_arr[$matrix1_i][$i])) );

			}

			$sum_slot = $sum_slot >= 1 ? 1 : 0;	
			echo $sum_slot . " " ;
		}
	       echo "\n|";

	}
	
	 */	



?>
