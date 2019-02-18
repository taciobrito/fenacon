<?php

namespace System;

class Model {

    private $_sql;
    protected $db;
    public $_table;
    public $_class;

    public function __construct() {
        require (__DIR__ . '/../app/config/database.php');
        $this->db = new \PDO('mysql:host=' . $db['hostname'] . ';dbname=' . $db['database'] . ';charset=utf8', $db['username'], $db['password']);
    }

    public function create(Array $data) {
        $fields = implode(", ", array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        $this->db->query("INSERT INTO {$this->_table} ({$fields}) VALUES ({$values})");
        $_id = $this->db->lastInsertId();
        if ($_id > 0) return $this->select(['where' => 'id = ' . $_id])->get();
        else return 0;
    }

    public function select(Array $select = null) {
        $fields = (isset($select['fields']) ? "{$select['fields']}" : "*");
        $join = (isset($select['join']) ? "{$select['join']}" : "");
        $where = (isset($select['where']) ? "WHERE {$select['where']}" : "");
        $limit = (isset($select['limit']) ? "LIMIT {$select['limit']}" : "");
        $offset = (isset($select['offset']) ? "OFFSET {$select['offset']}" : "");
        $group_by = (isset($select['group_by']) ? "GROUP BY {$select['group_by']}" : "" );
        $order_by = (isset($select['order_by']) ? "ORDER BY {$select['order_by']}" : "");
        // Prepare the query
        $sql = $this->db->prepare("SELECT {$fields} FROM {$this->_table} {$join} {$where} {$group_by} {$order_by} {$limit} {$offset}");
        // adding query to $this->_sql
        $this->_sql = $sql;
        // return self
        return $this;
    }

    public function query($query) {
        // Prepare the query
        $sql = $this->db->prepare($query);
        // adding query to $this->_sql
        $this->_sql = $sql;
        // return self
        return $this;
    }

    public function getAll() {
        // execute query
        $this->_sql->execute();
        // return object or object of class
        if ($this->_class == '')
            $this->_sql->setFetchMode(\PDO::FETCH_OBJ);
        else
            $this->_sql->setFetchMode(\PDO::FETCH_CLASS, $this->_class);
        // return result
        return $this->_sql->fetchAll();
    }

    public function get() {
        // execute query
        $this->_sql->execute();
        // return object or object of class
        if ($this->_class == '')
            $this->_sql->setFetchMode(\PDO::FETCH_OBJ);
        else
            $this->_sql->setFetchMode(\PDO::FETCH_CLASS, $this->_class);
        // return result
        return $this->_sql->fetch();
    }

    public function showSql() {
        return $this->_sql->queryString;
    }

    public function update(Array $data, $where) {
        // echo "<pre>";
        foreach ($data as $key => $value) {
            $fields[] = (!empty($value)) ? "{$key} = '{$value}'" : "{$key} = null";
            // print_r($key . '=>' . $value);
            // echo "<br>";
        }
        // die;
        $fields = implode(", ", $fields);
        $this->db->query("UPDATE {$this->_table} SET {$fields} WHERE {$where}");
        return $this->select(array('where' => $where))->get();
    }

    public function delete($where) {
        return $this->db->query("DELETE FROM {$this->_table} WHERE {$where}");
    }

}
