<?php

class Category
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getCategories()
    {
        $this->db->query("SELECT * from categories");
        $result = $this->db->resultSet();
        return $result;
    }

}
