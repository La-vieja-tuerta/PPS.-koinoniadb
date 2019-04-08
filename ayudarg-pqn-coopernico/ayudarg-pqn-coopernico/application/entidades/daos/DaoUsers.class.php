<?php
require_once "SistemaFCE/dao/DaoBase.class.php";
class DaoUsers extends DaoBase{

    function findByNameOrEmail($name,$email) {
        $c = $this->getCriterioBase();
        if(!empty($email))
            $c->add(Restricciones::eq('email',"$email"));
        if(!empty($name))
            $c->add(Restricciones::like('name',"%$name%"));

        return $this->findBy($c);

    }

    /**
     * @param $username
     * @param $pass
     * @return Users
     */
    function findByUsernamePassword($username,$pass) {

        $c = $this->getCriterioBase();

        $c->add(Restricciones::eq('username',$username));

        $posibleUsers = $this->findBy($c);
        foreach($posibleUsers as $user) {

            if(function_exists('password_verify')) {
                if(password_verify($pass,$user->getPassword()))
                    return $user;
            }else {
                if(crypt($pass,$user->getPassword()) == $user->getPassword()  )
                    return $user;

            }

        }

        return null;
    }

    public function findUsersNotId($id) {
        $c = $this->getCriterioBase();
        $c->add(Restricciones::ne('id',$id));

        return $this->findBy($c);
    }
}