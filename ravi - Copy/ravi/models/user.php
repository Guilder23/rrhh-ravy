<?php
class User {
    private $conn;
    private $table_name = "user";

    public $codeuser;
    public $username;
    public $userlastname;
    public $userci;
    public $userphone;
    public $useraddress;
    public $usertype;
    public $userlogin;
    public $userpassword;
    public $userstate;
    public $useraccess;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE userlogin = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();

        return $stmt;
    }
}


