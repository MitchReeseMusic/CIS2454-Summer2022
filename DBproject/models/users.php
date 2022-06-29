<?php

class Users {

    private $name, $email_address, $cash_balance, $id;

    public function __construct($name, $email_address, $cash_balance, $id = 0) {
        $this->set_name($name);
        $this->set_email_address($email_address);
        $this->set_cash_balance($cash_balance);
        $this->set_id($id);
    }

    function get_name() {
        return $this->name;
    }

    function get_email_address() {
        return $this->email_address;
    }

    function get_cash_balance() {
        return $this->cash_balance;
    }

    function get_id() {
        return $this->id;
    }

    function set_name($name): void {
        $this->name = $name;
    }

    function set_nmail_address($email_address): void {
        $this->email_address = $email_address;
    }

    function set_cash_balance($cash_balance): void {
        $this->cash_balance = $cash_balance;
    }

    function set_id($id): void {
        $this->id = $id;
    }



}

function insert_user($user) {
    global $database;

    $query = "INSERT INTO users (name, email_address, cash_balance) "
            . "VALUES (:name, :email_address, :cash_balance)";

    // value binding in PDO protects against sql injection
    $statement = $database->prepare($query);
    $statement->bindValue(":name", $user->get_name());
    $statement->bindValue(":email_address", $user->get_email_address());
    $statement->bindValue(":cash_balance", $user->get_cash_balance());

    $statement->execute();

    $statement->closeCursor();
}

function list_users() {
    global $database;

    $query = 'SELECT name, email_address, cash_balance, id FROM users';

    // prepare the query please
    $statement = $database->prepare($query);

    // run the query please
    $statement->execute();

    // this might be risky if you have HUGE amounts of data
    $users = $statement->fetchAll();

    $statement->closeCursor();

    $users_array = array();

    foreach ($users as $user) {
        $users_array[] = new User($user['name'], $user['email_address'],
                $user['cash_balance'], $user['id']);
    }

    return $users_array;
}

function update_user($user) {
    global $database;

    $query = "update users set name = :name, email_address = :email_address "
            . " where cash_balance = :cash_balance";

    // value binding in PDO protects against sql injection
    $statement = $database->prepare($query);
    $statement->bindValue(":name", $user->get_name());
    $statement->bindValue(":email_address", $user->get_email_address());
    $statement->bindValue(":cash_balance", $user->get_cash_balance());

    $statement->execute();

    $statement->closeCursor();
}

function delete_user($user) {
    global $database;

    $query = "delete from stocks "
            . " where id = :id";

    // value binding in PDO protects against sql injection
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $user->get_id());

    $statement->execute();

    $statement->closeCursor();
}
