<?php 

require '../inc/dbcon.php';

function error422($message){

    $data= [
        'status' => 422,
        'message' => $message,
    
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}


function storeCustomer($customerInput){

    global $conn;

    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $place = mysqli_real_escape_string($conn, $customerInput['place']);
    $image = mysqli_real_escape_string($conn, $customerInput['image']);

    if(empty(trim($name))){

        return error422('Enter Your name');
    }elseif(empty(trim($place))){

        return error422('Enter Your place');
    }elseif(empty(trim($image))){

        return error422('Enter Your image');
    }
    else
    {
        $query = "INSERT INTO customers (name,place,image) VALUES ('$name','$place','$image')";
        $result = mysqli_query($conn, $query);

        if($result){

            $data= [
                'status' => 201,
                'message' =>  'Customer Created Successfullly',
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);

        }else{
            $data= [
                'status' => 500,
                'message' =>  'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }

    }


}

function getCustomerList(){

    global $conn;

    $query = "SELECT * FROM customers";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data= [
                // 'status' => 200,
                // 'message' =>  'Customer List Fetched Successfully',
                'userdata' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);

        }else{
            $data= [
                'status' => 404,
                'message' =>  'No Customer Found',
            ];
            header("HTTP/1.0 404 No Customer Found");
            return json_encode($data);
        }

    }
    else
    {
        $data= [
            'status' => 500,
            'message' =>  'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);

    }

}

?>