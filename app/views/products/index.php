<?php require APPROOT . '/views/inc/header.php';?>
<?php flash('post_message');?>
<div class="row">
    <div class="col-md-12">
        <form id="searchForm">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Search for products...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="searchButton">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <p>Total: <b class='count-product'> </b> results</p>
    </div>
    <div class="col-md-4">
        <a class="btn btn-primary pull-right btn-sm mb-2 addProduct" href="#addProductModal" data-toggle="modal"><i
                class="fa fa-pencil"></i>
            Add
            Product</a>
    </div>
</div>
<div id="alert-div">

</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="productsTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-center">
            <nav>
                <ul class="pagination" id="pagination">
                </ul>
            </nav>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mt-5">
        <p>
            Copyright@2023. All right center
        </p>
    </div>
</div>

<!-- A. Add Product Modal -->
<div id="addProductModal" class="modal fade">
    <div class="modal-dialog">
        <form id="add-product-form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add new product ( Use Validation )</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body add_product">
                    <div class="form-group">
                        <label for="product_name" class="form-label">Product name:</label>
                        <input type="text" class="form-control" id="product_name" name="product_name">
                        <div class="error invalid-feedback" id="product_name-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="product_category" class="form-label">Category:</label>
                        <select class="custom-select" id="product_category" name='product_category'>
                            <option value="">Chọn danh mục</option>
                            <?php
                                foreach ($data['categories'] as $category) {
                            ?>
                            <option value="<?php echo $category->id ?>"><?php echo $category->category_name ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <div class="error invalid-feedback" id="product_category-error"></div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="product_image" class="form-label">Product Image</label>
                            <input class="form-control" type="file" id="product_image" name='product_image'>
                            <div class="error invalid-feedback" id="product_image-error"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-success" value="Submit">
                </div>
            </div>
        </form>

    </div>
</div>

<!-- B. View Product modal -->
<div class="modal" tabindex="-1" id="view-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <b>ID :</b>
                <p id="product-id-info"></p>
                <b>Tên sản phẩm:</b>
                <p id="product-name-info"></p>
                <b>Danh mục sản phẩm:</b>
                <p id="product-category-info"></p>
            </div>
        </div>
    </div>
</div>

<!-- C. Edit Product Modal -->
<!-- Modal for editing product -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product ( No use Validation Form )</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editProductForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="productId" name="productId">
                    <div class="form-group">
                        <label for="productName">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName">
                    </div>
                    <div class="form-group">
                        <label for="productCategory">Product Category</label>
                        <select class="custom-select" id="productCategory" name="productCategory">
                            <option value="">Chọn danh mục</option>
                            <?php
                                foreach ($data['categories'] as $category) {
                            ?>
                            <option value="<?php echo $category->id ?>"><?php echo $category->category_name ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="productImage">Product Image</label>
                        <input type="file" class="form-control-file" id="productImage" name="productImage">
                        <img id="previewImage" src="" alt="" style="max-width: 100%;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveProductBtn">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>

<script>
// 1. Hiển thị sản phẩm chi tiết
function showProduct(id) {
    $("#product-name-info").html("");
    $("#product-category-info").html("");
    let url = 'products/show/' + id;
    $.ajax({
        url: url,
        type: "GET",
        dataType: 'json',
        success: function(response) {
            let data = response.data;
            $("#product-id-info").html(data.productID);
            $("#product-name-info").html(data.product_name);
            $("#product-category-info").html(data.categoryName);
            $("#view-modal").modal('show');
        }
    });
}
</script>

<script>
$(document).ready(function() {

    // 2. Hiển thị danh sách nhiều sản phẩm ( combo: search + pagination )
    function loadProducts(page, search = '') {
        $.ajax({
            url: 'products/getAllProducts?page=' + page + '&search=' + search,
            dataType: 'json',
            success: function(response) {
                let products = response.products;
                let totalProducts = response.totalProducts;
                let totalPages = response.totalPages;

                $('.count-product').html(totalProducts);
                let productsHtml = '';
                $.each(products, function(i, v) {
                    productsHtml += '<tr>';
                    productsHtml += '<td>' + i + '</td>';
                    productsHtml += '<td>' + v.product_name + '</td>';
                    productsHtml += '<td>' + v.categoryName + '</td>';
                    productsHtml += '<td> <img src="uploads/' + v.product_image +
                        '" alt="Image display error"> </td>';
                    productsHtml += '<td>';
                    productsHtml +=
                        '<button ' +
                        ' class="btn btn-outline-info" ' +
                        ' onclick="showProduct(' + v.productID + ')">Show' +
                        '</button> ';
                    productsHtml +=
                        '<button ' +
                        ' class="btn btn-outline-info edit-product" ' +
                        ' data-product-id="' + v.productID + '">Edit' +
                        '</button> ';
                    productsHtml +=
                        '<button ' +
                        ' class="btn btn-outline-info delete-product" ' +
                        ' data-product-id="' + v.productID + '">Delete' +
                        '</button> ';
                    productsHtml +=
                        '<button ' +
                        ' class="btn btn-outline-info copy-btn" ' +
                        ' data-clipboard-text="' + v.product_name + '">Copy' +
                        '</button> ';

                    productsHtml += '</td>';
                    productsHtml += '</tr>';
                });
                $('#productsTable tbody').html(productsHtml);

                let paginationHtml = '';
                let visiblePages = 3;

                let startPage = Math.max(1, page - Math.floor(visiblePages / 2));
                let endPage = Math.min(totalPages, startPage + visiblePages - 1);

                if (page > 1) {
                    paginationHtml +=
                        '<li class="page-item"><a class="page-link" href="#" data-page="' + (page -
                            1) + '">Previous</a></li>';
                }

                if (startPage > 1) {
                    paginationHtml +=
                        '<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>';
                    if (startPage > 2) {
                        paginationHtml +=
                            '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                    }
                }
                for (let i = startPage; i <= endPage; i++) {
                    let activeClass = '';
                    if (i == page) {
                        activeClass = 'active';
                    }
                    paginationHtml += '<li class="page-item ' + activeClass +
                        '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                }
                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        paginationHtml +=
                            '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                    }
                    paginationHtml +=
                        '<li class="page-item"><a class="page-link" href="#" data-page="' +
                        totalPages + '">' + totalPages + '</a></li>';
                }

                if (page < totalPages) {
                    paginationHtml +=
                        '<li class="page-item"><a class="page-link" href="#" data-page="' + (page +
                            1) + '">Next</a></li>';
                }

                $('#pagination').html(paginationHtml);

            }
        });
    }

    loadProducts(1);

    // 3. Tìm kiếm tên sản phẩm và tên danh mục sản phẩm
    $('#searchForm').submit(function(e) {
        e.preventDefault();
        let search = $('#searchInput').val();
        loadProducts(1, search);
    });

    // 4. Phân trang
    $(document).on('click', '#pagination a', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        let search = $('#searchInput').val();
        loadProducts(page, search);
    });

    // 5.  Used to reset a form for adding a new product
    $(document).on('click', '.addProduct', function(e) {
        e.preventDefault();
        $('.error').text('');
        $('#product_name').removeClass('is-invalid');
        $('#product_category').removeClass('is-invalid');
        $('#product_image').removeClass('is-invalid');
        $('#add-product-form')[0].reset();
    });

    // 6. Thêm mới sản phẩm
    $('#add-product-form').submit(function(event) {
        event.preventDefault();

        // Get form data
        let product_name = $("#product_name").val();
        let product_category = $("#product_category").val();
        let product_image = $("#product_image").val();

        // Send AJAX request
        $.ajax({
            url: 'products/store',
            type: 'POST',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                // If product was added successfully, refresh the product list
                // response = JSON.parse(response);
                if (response.success) {
                    loadProducts(1);
                    $('#addProductModal').hide();
                    $('#addProductModal').modal('hide');
                    $("#alert-div").html(
                        "<div class='alert alert-primary'>Thêm sản phẩm thành công</div>"
                    );
                    setTimeout(function() {
                        $("#alert-div").html("");
                    }, 2000);
                } else {
                    let errors = response.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key + '-error').text(value);
                        $('#' + key).addClass('is-invalid');
                    });
                }
            }
        });
    });

    // 7. Clear form validation errors when input is changed
    $('#add-product-form input,  #add-product-form select').on('input change', function() {
        $(this).removeClass('is-invalid');
        $('#' + $(this).attr('id') + '-error').text('');
    });

    // 8. Xóa sản phẩm
    $(document).on('click', '.delete-product', function() {
        let productId = $(this).data('product-id');
        if (confirm('Are you sure you want to delete product ' + productId + '?')) {
            $.ajax({
                url: 'products/delete/' + productId,
                method: 'DELETE',
                data: {
                    productId: productId
                },
                success: function(response) {
                    loadProducts(1);
                    $("#alert-div").html(
                        "<div class='alert alert-primary'>Xóa sản phẩm thành công</div>"
                    );
                    setTimeout(function() {
                        $("#alert-div").html("");
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }
    });

    // 9. Copy tên sản phẩm
    $(document).on('click', '.copy-btn', function() {
        result = new ClipboardJS('.copy-btn');
        result.on('success', function(event) {
            $("#alert-div").html(
                "<div class='alert alert-primary'>Đoạn text bạn vừa copy là <b>" +
                event.text + "</b>  </div>"
            );
            setTimeout(function() {
                $("#alert-div").html("");
            }, 3500);
        });
    });

    // 10. Edit and update product in modal
    $(document).on('click', '.edit-product', function() {
        let productId = $(this).data('product-id');
        $.ajax({
            url: 'products/show/' + productId,
            type: 'GET',
            data: {
                productId: productId
            },
            dataType: 'JSON',
            success: function(response) {
                let data = response.data;
                $('#productId').val(data.productID);
                $('#productName').val(data.product_name);
                $('#productCategory').val(data.category_id);
                $('#productImage').attr('src', 'images/' + data.image);
                $('#editProductModal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    // 11. Submit updated product form
    $('#editProductForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData($(this)[0]);
        $.ajax({
            url: 'products/update',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                loadProducts(1);
                $('#editProductModal').modal('hide');
                $('#editProductModal').hide();
                $("#alert-div").html(
                    "<div class='alert alert-primary'>Sửa sản phẩm thành công</div>"
                );
                setTimeout(function() {
                    $("#alert-div").html("");
                }, 2000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                loadProducts(1);
                $('#editProductModal').modal('hide');
                $('#editProductModal').hide();
                $("#alert-div").html(
                    "<div class='alert alert-warning'>Sửa sản phẩm không thành công</div>"
                );
                setTimeout(function() {
                    $("#alert-div").html("");
                }, 2000);
            }
        });
    });

});
</script>