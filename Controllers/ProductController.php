<?php
require_once "../config/autoload.php";
class ProductController extends Product {

    public function getProductsController() {
        return $this->getProducts();
    }

    public function deleteProductsController($productIds) {
        return $this->deleteProducts($productIds);
    }

    public function editProductController($productId, $name, $category, $sellingPrice, $balance, $productPhoto) {
        return $this->editProduct($productId, $name, $category, $sellingPrice, $balance, $productPhoto);
    }

    public function addProductController($productData)
    {
        return $this->addProduct($productData);
    }
}




?>