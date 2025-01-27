<?php

namespace Main\Models;

date_default_timezone_set("Asia/Manila");

use Main\Config;

class UpdateModel {

    private function getResult($sql, $params = null) {
        $conn = (new Config())->openDbConnection();

        try {
            $query = $conn->prepare($sql);
        } catch (\Exception $e) {
            return ["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString()];
        }

        if ($params !== NULL) {
            $literals = "";
            foreach ($params as $param) {
                $literals .= "s";
            }
            $query->bind_param($literals, ...$params);
        }

        try {
            $query->execute();
        } catch (\Exception $e) {
            return ["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString()];
        }

        return ["status" => 200];
    }


    private function flattenAssocArray($array) {
        $flatArray = [];

        foreach ($array as $value) {
            $flatArray[] = $value;
        }

        return $flatArray;
    }



    function clientInfo($data) {
        $data = json_decode($data, true);

        $sql = "UPDATE users SET `first_name`=?, `last_name`=?, `company_name`=?, `company_address`=?, `phone_number`=?, `company_nature`=? WHERE `id`=?";

        return self::getResult($sql, $data);
    }


    function orderStatus($data) {
        if (gettype($data) == "string") $data = json_decode($data, true);
        if ($data["status"] == null) return;

        $redirectFlag = $data["redirect_flag"];

        unset($data["redirect_flag"]);

        $params = [$data["status"], $data["order_id"]];
        $sql = "UPDATE orders SET `status`=? WHERE `id`=?";

        $response = self::getResult($sql, $params);

        if ($redirectFlag != true || $redirectFlag == null) return $response;
        
        header("Location: ../../admin/view-order?order_id=".$data["order_id"]);
    }

    
    function updateImageData($fileDestination, $fileName, $imageType, $id) {
        if ($imageType === NULL) return;
        if ($imageType === "PRODUCT") {
            $sql = "UPDATE products SET `image_path`=?, `image_name`=? WHERE `id`=?";
            $data = [$fileDestination, $fileName, $id];
        }
        if ($imageType === "USER") {
            $sql = "UPDATE users SET `dp_path`=? WHERE `id`=?";
            $data = [$fileDestination, $id];
        }

        return self::getResult($sql, $data);
    }


    function product($data) {
        $data = json_decode($data, true);

        unset($data["image-input"], $data["image-type"], $data["old-image-path"]);

        $productPricesArr = [$data["unit-price"], $data["product-id"]];

        unset($data["product-id"], $data["unit-price"]);

        $data = self::flattenAssocArray($data);
        $data[] = $productPricesArr[1];

        $sql = "UPDATE products
                SET `name`=?, `material`=?, `brand`=?, `connection_type`=?, `length`=?, `width`=?, `thickness`=?, `type_id`=?
                WHERE `id`=?";

        self::getResult($sql, $data);

        $sql = "UPDATE products_prices
                SET `unit_price`=?
                WHERE `product_id`=?";

        return self::getResult($sql, $productPricesArr);
    }


    function password($newPassword) {
        $sql = "UPDATE users
                SET `password`=?
                WHERE `email`=?";

        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $response = self::getResult($sql, [$newPassword, $_SESSION["email-for-password-reset"]]);

        unset($_SESSION["email-for-password-reset"]);
        session_destroy();

        return $response;
    }


    function productClicks($id) {
        $sql = "UPDATE products
                SET `clicks`=`clicks`+1
                WHERE `id`=?";

        return self::getResult($sql, [$id]);
    }


    function adminInfo($data) {
        $data = json_decode($data, true);

        $sql = "UPDATE users SET `first_name`=?, `last_name`=?, `company_name`=?, `company_address`=?, `phone_number`=?, `company_nature`=? WHERE `id`=?";

        return self::getResult($sql, $data);
    }

}