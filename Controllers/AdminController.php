<?php
require_once "../config/autoload.php";
class AdminController extends Admin {

    public function getAdminController($email, $password) {
            return $this->getAdmin($email, $password);
    }
}

?>