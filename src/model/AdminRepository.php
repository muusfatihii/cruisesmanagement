<?php



spl_autoload_register(function($class){

    require_once('src/lib/'.$class.'.php');

});





class AdminRepository
{

    public DatabaseConnection $connectiondb;




   public function checkAdmin(array $input)
   {
    $statement = $this->connectiondb->getConnection()->prepare(
        "SELECT `id` FROM `user` WHERE `email` = ? AND `password` = ? WHERE `role`=?"
    );
    $statement->execute([$input['email'],$input['password'],'admin']);

    $auth = $statement->fetch();



    return $auth;

   }


}
