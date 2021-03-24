<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  // Connect to database
	include("./connection.php");
	$db = new dbObj();
  $connection =  $db->getConnstring();
  
  function get_cities($city_id=0){
    global $connection;
    $query="SELECT * FROM city";
    if($city_id != 0){
      $query.=" WHERE city_id=".$city_id." LIMIT 1";
    }
    $response=array();
    $result=mysqli_query($connection, $query);
    while($row=mysqli_fetch_array($result)){
      $response[]=$row;
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }

  function insert_city($city_id=0, $country=null, $city_label=null, $temperature=null, $weather=null, $precipitation=null, $humidity=null, $wind=null){
    global $connection;
    
    if($city_id != 0){
      $query = "INSERT INTO weather (weather_city_id, city_id, temperature, weather, precipitation, humidity, wind, date) 
                VALUES (NULL, '$country', '$temperature', '$weather', '$precipitation', '$humidity', '$wind', CURRENT_TIMESTAMP)";
    } else {
      $query = "INSERT INTO city (city_id, country, city_label, CREATION_DATE) 
                VALUES (NULL, '$country', '$city_label', CURRENT_TIMESTAMP)";
    }
    
    if(mysqli_query($connection, $query)){
      $response=array('status' => 1,'status_message' =>'Ajout réussi.');
    } else {
      $response=array('status' => 0,'status_message' =>'Ajout impossible.');
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }

  function delete_city($city_id=0, $weather_id=null){
    global $connection;
    
    if($city_id != 0){
      $query = "DELETE FROM weather WHERE weather_id=$city_id";
    } else {
      $query = "DELETE FROM city WHERE city_id=$city_id";
    }
    
    if(mysqli_query($connection, $query)){
      $response=array('status' => 1,'status_message' =>'Suppression réussi.');
    } else {
      $response=array('status' => 0,'status_message' =>'Suppresion impossible.');
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }

  $request_method=$_SERVER["REQUEST_METHOD"];

  switch($request_method)
	{
		case 'GET':
			// Retrive Values
			if(!empty($_GET["city_id"])){
				$city_id = intval($_GET["city_id"]);
				get_cities($city_id);
			}
			else{
				get_cities();
			}
      break;
    case 'POST':
        // Retrive Values
        $country = strval($_POST["country"]);
        if(!empty($_POST["city_id"])){
          $city_id = intval($_POST["city_id"]);
          $city_label = strval($_POST["city_label"]);
          $temperature = strval($_POST["temperature"]);
          $weather = strval($_POST["weather"]);
          $precipitation = strval($_POST["precipitation"]);
          $humidity = strval($_POST["humidity"]);
          $wind = strval($_POST["wind"]);

          insert_cities($city_id, $country, $city_label, $temperature, $weather, $precipitation, $humidity, $wind);
        }
        else{
          insert_cities(0, $country);
        }
        break;
    case 'DELETE':
      // Retrive Values
      if(!empty($_DELETE["weather_id"])){
        $city_id = intval($_DELETE["city_id"]);
        delete_city($city_id, $weather_id);
      }
      else{
        delete_city($city_id);
      }
      break;
		default:
			// Invalcity_id Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
  }

  
?>