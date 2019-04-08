<?php
require_once "SistemaFCE/dao/DaoBase.class.php";
class DaoInstitutions extends DaoBase{

    public function findNoPersonales($limit=null) {
        $c = $this->getCriterioBase();
        $c->add(Restricciones::ne('type_id',168));
        return $this->findBy($c,null,$limit);
    }

    public function findNoPersonalesByName($name) {
        $c = $this->getCriterioBase();
        $c->add(Restricciones::ne('type_id',168));
        $c->add(Restricciones::like('name',"%{$name}%"));
        return $this->findBy($c);
    }

    public function findPersonalesByUser(Users $user)
    {
        $c = $this->getCriterioBase();
        $c->add(Restricciones::eq('type_id', 168));
        $c->add(Restricciones::eq('director_user_id', $user->getId()));
        $c->add(Restricciones::eq('contact_user_id', $user->getId()));
        $c->add(Restricciones::eq('manager_user_id', $user->getId()));
        $c->add(Restricciones::eq('name', $user->getUsername()));

        return $this->findFirst($c);

    }
}