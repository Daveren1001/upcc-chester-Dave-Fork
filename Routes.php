<?php
namespace Main;

/**
 * Contains the routes to the controllers or wherever you point them to.
 */
class Routes {

    /**
     * @var array $List
     * Contains routes for the app.
     */
    private static array $List;

    public function __construct() {
        self::$List = [

            /**
             * URI => [Controller, function, HTTP request type],
             * GET requests can also be processed by adding a route.
             * e.g. "products/view?*" => ["ViewController", "viewProducts"]
             * 
             * To get rid of 'index' in URIs, simply remove it,
             * and still route it normally.
             * e.g. "products/index"
             * 
             * If URI length is more than one (1), do not leave a
             * trailing slash in the route as it will cause an error.
             */

            "error/403" => ["ViewsController", "error403"],
            "error/404" => ["ViewsController", "error404"],
            "api/error/403" => ["ApiController", "error403"],
            "api/error/404" => ["ApiController", "error404"],

            "api/assets/js?name=*" => ["AssetsController", "js", "GET"],
            "api/assets/css?name=*" => ["AssetsController", "css", "GET"],
            "api/assets/img?name=*&type=*" => ["AssetsController", "img", "GET"],

            "api/verifylogin" => ["AuthController", "login", "POST"],
            "api/users/count" => ["FetchController", "usersCount", "GET"],
            "api/products/count" => ["FetchController", "productsCount", "GET"],
            "api/orders/count" => ["FetchController", "ordersCount", "GET"],
            "api/users?filter=*&page=*&limit=*" => ["FetchController", "users", "GET"],
            "api/products?filter=*&page=*&limit=*" => ["FetchController", "products", "GET"],
            "api/orders?filter=*&page=*&limit=*" => ["FetchController", "allOrders", "GET"],
            "api/edituser" => ["UpdateController", "user", "POST"],
            "api/editproduct" => ["UpdateController", "product", "POST"],
            "api/remove-users" => ["DeleteController", "users", "POST"],
            "api/remove-products" => ["DeleteController", "products", "POST"],
            "api/approveorder" => ["UpdateController", "approveOrder", "POST"],
            "api/declineorder" => ["UpdateController", "declineOrder", "POST"],
            "api/createuser" => ["CreateController", "user", "POST"],
            "api/createproduct" => ["CreateController", "products", "POST"],
            "api/companynatures" => ["FetchController", "companyNatures", "GET"],
            "api/uploads/img?name=*&type=*" => ["AssetsController", "imgUploaded", "GET"],
            "api/product?id=*" => ["FetchController", "product", "GET"],
            "api/user?id=*" => ["FetchController", "user", "GET"],
            "api/checkauth" => ["AuthController", "checkAuth", "GET"],
            "api/addtocart?product_id=*&quantity=*" => ["CreateController", "cartItem", "GET"],
            "api/product-types" => ["FetchController", "productTypesAll", "GET"],
            "api/product-types?filter=*&page=*&limit=*" => ["FetchController", "productTypes", "GET"],
            "api/create-product" => ["CreateController", "product", "POST"],
            "api/create-product-type" => ["CreateController", "productType", "POST"],
            "api/client/cart?client_id=*" => ["FetchController", "clientCart", "GET"],
            "api/client/remove-from-cart?id=*" => ["DeleteController", "clientCartItem", "GET"],
            "api/client/orders" => ["FetchController", "clientOrders", "GET"],
            "api/client/save-info" => ["UpdateController", "clientInfo", "POST"],
            "api/order?id=*" => ["FetchController", "order", "GET"],
            "api/featured-products" => ["FetchController", "featuredProducts", "GET"],
            "api/remove-product-types" => ["DeleteController", "productTypes", "POST"],
            "api/admin/update-order-status" => ["UpdateController", "orderStatus", "POST"],
            "api/agent/products-for-select?filter=*" => ["FetchController", "productsFilterOnly", "GET"],

            
            "default" => "home/index",
            "home/index" => ["ViewsController", "home"],
            "store/index" => ["ViewsController", "store"],
            "store/viewproduct?id=*" => ["ViewsController", "viewProduct"],
            "login/index" => ["ViewsController", "login"],
            "signup/index" => ["ViewsController", "signup"],
            "signup/success" => ["ViewsController", "signupSuccess"],
            "auth/logout" => ["AuthController", "logout"],
            "auth/loginredirect" => ["AuthController", "loginRedirect"],
            "admin/dashboard" => ["ViewsController", "adminDashboard"],
            "admin/users" => ["ViewsController", "adminUsers"],
            "admin/products" => ["ViewsController", "adminProducts"],
            "admin/product-types" => ["ViewsController", "adminProductTypes"],
            "admin/orders" => ["ViewsController", "adminOrders"],
            "admin/edituser?id=*" => ["ViewsController", "adminEditUser"],
            "admin/editproduct?id=*" => ["ViewsController", "adminEditProduct"],
            "admin/removeusers" => ["ViewsController", "adminRemoveUsers"],
            "admin/removeproducts" => ["ViewsController", "adminRemoveProducts"],
            "admin/new-product" => ["ViewsController", "adminNewProduct"],
            "admin/new-product-type" => ["ViewsController", "adminNewProductType"],
            "admin/view-order?order_id=*" => ["ViewsController", "adminViewOrder"],
            "client/account-details" => ["ViewsController", "clientAccountDetails"],
            "client/order-history" => ["ViewsController", "clientOrderHistory"],
            "client/order?id*" => ["ViewsController", "clientOrder"],
            "client/cart" => ["ViewsController", "clientCart"],
            "client/edit-info?id=*" => ["ViewsController", "clientEditInfo"],
            "agent/dashboard" => ["ViewsController", "agentDashboard"],
            "agent/orders" => ["ViewsController", "agentOrders"],
            "agent/view-order?order_id=*" => ["ViewsController", "agentViewOrder"],
            "agent/new-order" => ["ViewsController", "agentNewOrder"],
            "cookies/index" => ["ViewsController", "cookies"],
            "relevance/index" => ["RecommendationController", "computeRelevance"],
        ];
    }

    /**
     * @method public getRoute()
     * Returns corresponding route in $List.
     * @param string $URI
     */
    public static function getRoute($URI) {
        $keys = array_keys(self::$List);
        foreach ($keys as $key) if (fnmatch($key, $URI)) return self::$List[$key];
        return null;
    }

}