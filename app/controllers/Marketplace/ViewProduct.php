<?php
class ViewProduct extends Controller {
    private $marketplaceModel;

    public function __construct() {
        $this->marketplaceModel = $this->model('M_Marketplace/M_Marketplace', new Database());
    }

    public function index($categorySlug = null) {
        // Slug → DB category mapping
        $categoryMap = [
            'fertilizer' => 'Fertilizer',
            'paddy-seeds' => 'Seeds',
            'agrochemicals' => 'Agrochemicals',
            'equipments' => 'Equipments',
            'machinery' => 'Rent Machinery',
            'others' => 'Others'
        ];

        $categorySlug = strtolower($categorySlug ?? '');
        $category = $categoryMap[$categorySlug] ?? null;

        $products = $category ? $this->marketplaceModel->getProductsByCategory($category) : [];

        $data = [
            'category' => $category,
            'products' => $products
        ];

        $this->view('marketplace/V_viewproduct', $data);
    }
}
?>
