<?php

class Transaction {

    private $user_id, $stock_id, $quantity, $price, $timestamp, $id;

    public function __construct($user_id, $stock_id, $quantity, $price, $timestamp, $id = 0) {
        $this->set_name($user_id);
        $this->set_email_address($stock_id);
        $this->set_cash_balance($quantity);
        $this->set_id($price);
        $this->set_id($timestamp);
        $this->set_id($id);
    }

    function get_user_id() {
        return $this->user_id;
    }

    function get_stock_id() {
        return $this->stock_id;
    }

    function get_quantity() {
        return $this->quantity;
    }

    function get_price() {
        return $this->price;
    }

    function get_timestamp() {
        return $this->timestamp;
    }

    function get_id() {
        return $this->id;
    }

    function set_user_id($user_id): void {
        $this->user_id = $user_id;
    }

    function set_stock_id($stock_id): void {
        $this->stock_id = $stock_id;
    }

    function set_quantity($quantity): void {
        $this->quantity = $quantity;
    }

    function set_price($price): void {
        $this->price = $price;
    }

    function set_timestamp($timestamp): void {
        $this->timestamp = $timestamp;
    }

    function set_id($id): void {
        $this->id = $id;
    }
}

function insert_transaction($transaction) {
    global $database;

    $query = "INSERT INTO transactions (user_id, stock_id, quantity, price, timestamp) "
            . "VALUES (:user_id, :stock_id, :quantity, :price, :timestamp)";

    // value binding in PDO protects against sql injection
    $statement = $database->prepare($query);
    $statement->bindValue(":user_id", $transaction->get_user_id());
    $statement->bindValue(":stock_id", $transaction->get_stock_id());
    $statement->bindValue(":quantity", $transaction->get_quantity());
    $statement->bindValue(":quantity", $transaction->get_price());
    $statement->bindValue(":quantity", $transaction->get_timestamp());

    $statement->execute();

    $statement->closeCursor();
}

function list_transaction() {
    global $database;

    $query = 'SELECT user_id, stock_id, quantity, price, timestamp, id FROM transactions';

    // prepare the query please
    $statement = $database->prepare($query);

    // run the query please
    $statement->execute();

    // this might be risky if you have HUGE amounts of data
    $transactions = $statement->fetchAll();

    $statement->closeCursor();

    $transactions_array = array();

    foreach ($transactions as $transaction) {
        $transactions_array[] = new Transaction($transaction['user_id'], $transaction['stock_id'],
                $transaction['quantity'], $transaction['price'], $transaction['timestamp'], $transaction['id']);
    }

    return $transactions_array;
}

function update_transaction($transaction) {
    global $database;

    $query = "update transactions set quantity = :quantity, price = :price "
            . " timestamp = :timestamp";

    // value binding in PDO protects against sql injection
    $statement = $database->prepare($query);
    $statement->bindValue(":quantity", $transaction->get_quantity());
    $statement->bindValue(":price", $transaction->get_price());
    $statement->bindValue(":timestamp", $transaction->get_timestamp());

    $statement->execute();

    $statement->closeCursor();
}

function delete_user($transaction) {
    global $database;

    $query = "delete from transactions "
            . " where id = :id";

    // value binding in PDO protects against sql injection
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $transaction->get_id());

    $statement->execute();

    $statement->closeCursor();
}

