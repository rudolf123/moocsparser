<?php

class WebUser extends CWebUser {

    private $_model = null;

    function getRole() {
        if ($user = $this->getModel()) {
            // в таблице User есть поле role
            return $user->role;
        }
    }

    public function getisAdmin() {
        return ( $this->getRole() == 'administrator' );
    }

    public function getisModer() {
        return ( $this->getRole() == 'moderator' );
    }

    private function getModel() {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = User::model()->findByPk($this->id, array('select' => 'role'));
        }
        return $this->_model;
    }

}

?>
