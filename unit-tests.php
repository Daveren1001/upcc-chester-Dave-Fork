<?php

use Main\Controllers\RecommendationController;
use Main\Models\FetchModel;

include_once "controllers/RecommendationController.php";
include_once "models/FetchModel.php";
include_once "Config.php";

function printSuccess($task) { echo "$task: \e[1;37;42mSUCCESS\e[1;37;0m"; }
function printFailed($task) { echo "$task: \e[1;37;41mFAILED\e[1;37;0m"; }

/**
 * Fetch model
 */

 // New fetch instance
$task = "\nNew fetch instance";
try {
    $FetchModel = new FetchModel();
    if (get_class($FetchModel) === "Main\Models\FetchModel") printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "\n\n$e\n";
}

// Fetch all users
$task = "\nFetch all users";
try {
    if($FetchModel->getResult("SELECT * FROM users")["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "\n\n$e\n";
} catch(Error $e) {
    printFailed($task);
    echo "\n\n$e\n";
}

// Fetch all users count
$task = "\nFetch all users count";
try {
    if($FetchModel->usersCount()["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "\n\n$e\n";
} catch(Error $e) {
    printFailed($task);
    echo "\n\n$e\n";
}

// Fetch all products count
$task = "\nFetch all products count";
try {
    if($FetchModel->usersCount()["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "\n\n$e\n";
} catch(Error $e) {
    printFailed($task);
    echo "\n\n$e\n";
}

// Fetch all orders count
$task = "\nFetch all orders count";
try {
    if($FetchModel->ordersCount()["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "\n\n$e\n";
} catch(Error $e) {
    printFailed($task);
    echo "\n\n$e\n";
}

// Fetch all cart items count
$task = "\nFetch all cart items count";
try {
    if($FetchModel->cartItemsCount()["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "\n\n$e\n";
} catch(Error $e) {
    printFailed($task);
    echo "\n\n$e\n";
}

// Fetch all users without filter
$task = "\nFetch all users without filter";
try {
    if($FetchModel->users([
        "filter" => "",
        "page" => "0",
        "limit" => "20",
    ])["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "\n\n$e\n";
} catch(Error $e) {
    printFailed($task);
    echo "\n\n$e\n";
}

// Fetch all users with existing 'User' filter
$task = "\nFetch all users with existing 'User' filter";
try {
    $filter = "User";
    $response = $FetchModel->users([
        "filter" => $filter,
        "page" => "0",
        "limit" => "20",
    ]);
    if($response["status"] === 200 && count($response["rows"]) > 0) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "\n\n$e\n";
} catch(Error $e) {
    printFailed($task);
    echo "\n\n$e\n";
}

// Fetch all users with non-existent 'banana' filter
$task = "\nFetch all users with non-existent 'banana' filter";
try {
    $filter = "banana";
    $response = $FetchModel->users([
        "filter" => $filter,
        "page" => "0",
        "limit" => "20",
    ]);
    if($response["status"] === 200 && count($response["rows"]) < 1) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "\n\n$e\n";
} catch(Error $e) {
    printFailed($task);
    echo "\n\n$e\n";
}


/**
 * Recommendation Engine
 */

// New rec controller instance
$task = "\nNew rec controller instance";
try {
    $RecController = new RecommendationController();
    if (get_class($RecController) === "Main\Controllers\RecommendationController") printSuccess($task);
} catch (Error $e) {
    printFailed($task);
    echo "\n\n$e\n";
}


/**
 * Fetch model (continuation)
 */

// Fetch all products without filter
$task = "\nFetch all products without filter";
try {
    $filter = "";
    $brand = "";
    $typeId = "";
    $response = $FetchModel->products([
        "filter" => $filter,
        "brand" => $brand,
        "typeid" => $typeId,
        "page" => "0",
        "limit" => "20",
    ]);
    if($response["status"] === 200) printSuccess($task);
} catch(mysqli_sql_exception $e) {
    printFailed($task);
    echo "\n\n$e\n";
} catch(Error $e) {
    printFailed($task);
    echo "\n\n$e\n";
}
