<?php 

//data_populate.php

if(isset($_POST["Brand"]))
{
	sleep(5);
	$connect = new PDO("mysql:host=localhost; dbname=wordpress", "root", "root");

	$success = '';

	$brand = $_POST["brand"];
	$model = $_POST["model"];
	$body = $_POST["body"];
	$trim = $_POST["trim"];
	$level = $_POST["level"];
	$engine = $_POST["engine"];
	$fuel = $_POST["fuel"];
	$transmission = $_POST["transmission"];
	$power = $_POST["power"];
	$efficiency = $_POST["efficiency"];
	$emission = $_POST["emission"];
	$price = $_POST["price"];

	$brand_error = '';
	$model_error = '';
	$body_error = '';
	$trim_error = '';
	$level_error = '';
	$engine_error = '';
	$fuel_error = '';
	$transmission_error = '';
	$power_error = '';
	$efficiency_error = '';
	$emission_error = '';
	$price_error = '';

	// if(empty($Brand))
	// {
	// 	$brand_error = 'Brand is Required';
	// }
	// else
	// {
	// 	if(!preg_match("/^[a-zA-Z-' ]*$/", $Brand))
	// 	{
	// 		$brand_error = 'Only Letters and White Space Allowed';
	// 	}
	// }

	// if(empty($model))
	// {
	// 	$model_error = 'model is Required';
	// }
	// else
	// {
	// 	if(!filter_var($model, VALIDATE_ALPHA))
	// 	{
	// 		$model_error = 'model is invalid';
	// 	}
	// }

	// if(empty($website))
	// {
	// 	$website_error = 'Website is Required';
	// }
	// else
	// {
	// 	if(!filter_var($website, FILTER_VALIDATE_URL))
	// 	{
	// 		$website_error = 'Invalid Website Url';
	// 	}
	// }

	// if(empty($comment))
	// {
	// 	$comment_error = 'Comment is Required Field';
	// }

	// if(empty($gender))
	// {
	// 	$gender_error = 'Please Select your gender';
	// }

	if($brand_error == '' && $model_error == '' && $website_error == '' && $comment_error == '' && $gender_error == '')
	{
		//put insert data code here 

		$data = array(
			':brand'			=>	$Brand,
			':model'		=>	$model,
			':body'		=>	$body,
			':trim'		=>	$trim,
			':level'		=>	$level,
			':engine'		=>	$engine,
			':fuel'		=>	$fuel,
			':transmission'		=>	$transmission,
			':power'		=>	$power,
			':efficiency'		=>	$efficiency,
			':emission'		=>	$emission,
			':price'		=>	$price
		);

		$query = "
		INSERT INTO data_sample 
		(brand, model, body, trim, level, engine, fuel, transmission, power, efficiency, emission, price	
        ) 
		VALUES (:brand, :model, :body, :trim, :level, :engine, :fuel, :transmission, :power, :efficiency, :emission, :price)
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		$success = '<div class="alert alert-success">Data Saved</div>';
	}

	$output = array(
		'success'		=>	$success,
		'Brand_error'	=>	$brand_error,
		'model_error'	=>	$model_error,
		'website_error'	=>	$website_error,
		'comment_error'	=>	$comment_error,
		'gender_error'	=>	$gender_error
	);

	echo json_encode($output);
	
}
