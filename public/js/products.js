
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

$(document).ready(function() {

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
                        ' class="btn btn-outline-info delete-product" ' +
                        ' data-product-id="' + v.productID + '">Delete' +
                        '</button> ';
                    productsHtml +=
                        '<button ' +
                        ' class="btn btn-outline-info copy-btn" ' +
                        ' data-clipboard-text="' + v.product_name + '">Copy' +
                        '</button> ';
                    productsHtml +=
                        '<button ' +
                        ' class="btn btn-outline-info edit-product" ' +
                        ' data-product-id="' + v.productID + '">Edit' +
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

    $('#searchForm').submit(function(e) {
        e.preventDefault();
        let search = $('#searchInput').val();
        loadProducts(1, search);
    });

    $(document).on('click', '#pagination a', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        let search = $('#searchInput').val();
        loadProducts(page, search);
    });

    $(document).on('click', '.addProduct', function(e) {
        e.preventDefault();
        $('.error').text('');
        $('#product_name').removeClass('is-invalid');
        $('#product_category').removeClass('is-invalid');
        $('#product_image').removeClass('is-invalid');
        $('#add-product-form')[0].reset();
    });

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

    // Clear form validation errors when input is changed
    $('#add-product-form input,  #add-product-form select').on('input change', function() {
        $(this).removeClass('is-invalid');
        $('#' + $(this).attr('id') + '-error').text('');
    });

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

    // Edit and update product in modal
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

    // Submit updated product form
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
