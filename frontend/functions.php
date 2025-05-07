<?php
require_once "config.php";

function backend($method, $path, $body = [])
{
    $curl = curl_init();

    $url = "http://10.33.102.102/$path";

    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => strtoupper($method),
    ]);

    if (in_array(strtoupper($method), ["GET", "POST", "DELETE"])) {
        $jsonBody = json_encode($body);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonBody);
        $headers[] = "Content-Type: application/json";
        $headers[] = "Content-Length: " . strlen($jsonBody);
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
}

function getProducts()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM products");
    $local = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response = backend("GET", "product.php");
    return [$response,$local];
}
function getProduct($id)
{
    $response = backend("GET", "product.php?id=" . $id);
    return $response;
}
function updateProduct($id, $data)
{
    global $conn;
    $query = "UPDATE products SET name = '{$data['name']}', category_id = {$data['category_id']}, description = '{$data['description']}', price = {$data['price']} WHERE id = $id";
    mysqli_query($conn, $query);
    $response = backend("POST", "product.php?id=$id", $data);
    return $response;
}
function deleteProduct($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    $response = backend("DELETE", "product.php?id=$id");
    return $response;
}
function insertProduct($data)
{
    global $conn;
    $query = "INSERT INTO products (name, category_id, description, price) VALUES ('{$data['name']}', {$data['category_id']}, '{$data['description']}', {$data['price']})";
    mysqli_query($conn, $query);
    $response = backend("POST", "product.php", $data);
    return $response;
}
function getCategories()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM categories");
    $local = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response = backend("GET", "category.php");
    return [$response,$local];
}
function getCategory($id)
{
    $response = backend("GET", "category.php?id=$id");
    return $response;
}
function updateCategory($id, $data)
{
    global $conn;
    $name = $data["name"];
    mysqli_query($conn, "UPDATE categories SET name='$name'  WHERE id = $id");
    $response = backend("POST", "category.php?id=$id", $data);
    return $response;
}
function deleteCategory($id)
{
    global $conn;
    $check = mysqli_query($conn, "SELECT * FROM products WHERE category_id = $id");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(["error" => "Category cannot be deleted because it has associated products"]);
        return;
    }
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
    $response = backend("DELETE", "category.php?id=$id");
    return $response;
}
function insertCategory($data)
{
    global $conn;
    $query = "INSERT INTO categories (name) VALUES ('{$data['name']}')";
    mysqli_query($conn, $query);
    $response = backend("POST", "category.php", $data);
    return $response;
}
