<?php



class UserRepo
{

    public DatabaseConnection $connectiondb;

    public function addUser(array $input)
    {

        $firstname = $input['firstname'];
        $lastname = $input['lastname'];
        $email = $input['email'];
        $password = $input['password'];
        

        $statement = $this->connectiondb->getConnection()->prepare(
            "INSERT INTO `user` (`firstname`, `lastname`, `email`, `password`) VALUES (?,?,?,?)"
        );

        $affectedLines = $statement->execute([$firstname, $lastname, $email, $password]);
        
        if($affectedLines > 0){

            $_SESSION['email'] = $email;
        }

        return ($affectedLines > 0);
    }



public function checkUser(array $input)
{
    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id`,`role`,`password` FROM `user` WHERE `email` = ?"
    );
    $statement->execute([$input['email']]);

    $row = $statement->fetch();

    $auth = ($row && password_verify($input['password'],$row['password']));


    if($auth){

        $_SESSION['email'] = $input['email'];

    }

    return $row;

   }


   public function getClientId(string $email):string
   {

    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id` FROM `user` WHERE `email` = ?"
    );

    $statement->execute([$email]);

    $row = $statement->fetch();

    return $row['id'];
    
   }


}