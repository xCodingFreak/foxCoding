<?php
include "../Configs/config.php";
include "../Models/loginModel.php";

//Function to validate the data entry at the login
function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
 }

 /* Function to authenticate wich role each user has,
 so it will redirect to the right view*/
 function roleAuth($email, $password){
    global $conn;
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['email'] == $email && $row['password'] == $password) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['descriptionAuth'] = userIdAuth($row['id_authorization']);
            if ($row['id_authorization'] == 1){					
                header("Location: ../Views/adminView.php");
                exit();
            } else if ($row['id_authorization'] == 2){					
                header("Location: ../Views/accountingView.php");
                exit();
            }
            
        }else{
            header("Location: ../Views/loginView.html?error=Incorect User name or password");
            exit();
        }
    }else{
        header("Location: ../Views/loginView.html?error=Incorect User name or password");
        exit();
    }
 }
?>