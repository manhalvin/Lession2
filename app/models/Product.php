<?php

class Product
{
    private $db;
    private $id;
    private $name;
    private $category;
    private $image;

    public function __construct($id = null, $name = null, $category = null, $image = null)
    {
        $this->db = new Database;
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->image = $image;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getProducts($search = '', $start = 0, $limit = 10)
    {
        $searchQuery = '';
        if (!empty($search)) {
            $searchQuery = " AND (products.product_name	 LIKE '%$search%' OR categories.category_name LIKE '%$search%')";
        }

        $this->db->query("SELECT *,
                            products.id as productID,
                            categories.category_name as categoryName
                            FROM products
                            INNER JOIN categories ON products.category_id  = categories.id
                            WHERE 1 $searchQuery
                            ORDER BY products.created_at DESC
                            LIMIT $start, $limit");

        $result = $this->db->resultSet();
        return $result;
    }

    public function countProducts($search = '')
    {
        $searchQuery = '';
        if (!empty($search)) {
            $searchQuery = " AND (products.product_name LIKE '%$search%' OR categories.category_name LIKE '%$search%')";
        }

        $sql = "SELECT COUNT(*) as total FROM products
                INNER JOIN categories ON products.category_id = categories.id
                WHERE 1 $searchQuery";
        $result = $this->db->query($sql);
        $result = $this->db->resultSet();
        return $result;
    }

    public function addProduct($data, $imagePath)
    {
        $this->db->query('INSERT INTO products(product_name, product_image, category_id, created_at) VALUES (:product_name, :product_image, :category_id , :created_at)');
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':product_image', $imagePath);
        $this->db->bind(':category_id', $data['product_category']);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));

        //execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductById($id)
    {
        $this->db->query('SELECT *,
        products.id as productID,
        categories.id as CategoryId,
        categories.category_name as categoryName FROM products INNER JOIN categories ON products.category_id = categories.id WHERE products.id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function updateProduct($data)
    {
        $this->db->query('UPDATE products SET product_name = :product_name, product_image = :product_image, category_id = :category_id, created_at = :created_at WHERE id = :id');
        $this->db->bind(':id', $data['productID']);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':product_image', $data['product_image'] ?  $data['product_image'] : null);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));

        //execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //delete a post
    public function deleteProduct($id)
    {
        $this->db->query('DELETE FROM products WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
