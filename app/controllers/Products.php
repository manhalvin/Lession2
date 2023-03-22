<?php
class Products extends Controller
{
    private $productModel, $categoryModel;

    public function __construct()
    {
        $this->productModel = $this->model('Product');
        $this->categoryModel = $this->model('Category');
    }

    public function index()
    {
        $data['categories'] = $this->categoryModel->getCategories();
        $this->view('products/index', $data);
    }

    public function getAllProducts()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 2;
        $start = ($page - 1) * $limit;

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $products = $this->productModel->getProducts($search, $start, $limit);
        $totalProducts = $this->productModel->countProducts($search);
        $totalProducts = $totalProducts[0]->total;

        $totalPages = ceil($totalProducts / $limit);

        $data = array(
            'products' => $products,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts,
        );
        echo json_encode($data);
    }

    public function store()
    {
        $errors = $this->validateProduct($_POST);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($errors)) {
                $this->productModel->setName($_POST['product_name']);
                $this->productModel->setCategory($_POST['product_category']);

                // Save uploaded image
                if (!empty($_FILES['product_image']['name'])) {
                    $upload_dir = "../uploads/";
                    $upload_file = $upload_dir . $_FILES['product_image']['name'];

                    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_file)) {
                        $imagePath = URLROOT . "/uploads/" . $_FILES['product_image']['name'];
                    }
                }

                $this->productModel->addProduct($_POST, $imagePath);

                $response = array('success' => true);
                echo json_encode($response);

            } else {
                $response = array('success' => false, 'errors' => $errors);
                echo json_encode($response);
            }
        }
    }

    public function validateProduct($productData)
    {
        $upload_dir = "../uploads/";
        $upload_file = $upload_dir . $_FILES['product_image']['name'];
        $errors = array();

        // Validate product name
        if (empty($productData['product_name'])) {
            $errors['product_name'] = 'Tên sản phẩm không được để trống';
        }

        // Validate product category
        if (empty($productData['product_category'])) {
            $errors['product_category'] = 'Danh mục bắt buộc phải chọn';
        }

        // Validate uploaded image
        if (!empty($_FILES['product_image']['name'])) {
            $allowedExtensions = array('jpg', 'jpeg', 'png');
            $uploadedExtension = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
            if (!in_array($uploadedExtension, $allowedExtensions)) {
                $errors['product_image'] = 'Chỉ cho phép hình ảnh JPG, JPEG và PNG.';
            }

            $file_size = $_FILES['product_image']['size'];
            if ($file_size > 29000000) {
                $errors['product_image'] = 'Chỉ được upload file ảnh bé hơn 20MB !';
            }

            // if (file_exists($upload_file)) {
            //     $errors['product_image'] = 'File ảnh đã tồn tại trên hệ thống';
            // }
        } else {
            $errors['product_image'] = 'Hình ảnh không được để trống';
        }

        return $errors;
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);

        $response = array('success' => true, 'data' => $product);
        echo json_encode($response);
    }

    //edit post
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['productId'];
            $name = $_POST['productName'];
            $categoryId = $_POST['productCategory'];
            $image = $_FILES['productImage']['name'];
            $tmpImage = $_FILES['productImage']['tmp_name'];
            $product = $this->productModel->getProductById($id);
            if ($product) {
                $product['product_name'] = $name;
                $product['category_id'] = $categoryId;

                if (!empty($image)) {
                    $product['product_image'] = $image;
                    move_uploaded_file($tmpImage, '../uploads/' . $image);
                }
                $result = $this->productModel->updateProduct($product);
                echo json_encode(['success' => $result]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
            $product = $this->productModel->getProductById($id);

            if (!$product) {
                $response = array('success' => true, 'message' => 'No find product');
                echo json_encode($response);
            }

            if ($this->productModel->deleteProduct($id)) {
                $response = array('success' => true, 'message' => 'Product removed success');
                echo json_encode($response);
            } else {
                $response = array('success' => false, 'message' => 'Product removed fail');
                echo json_encode($response);
            }
        }
    }
}