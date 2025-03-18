<?php
function backend($method, $path, $body = [])
{
    $curl = curl_init();

    $url = "http://localhost:8080/$path";

    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => strtoupper($method),
    ]);

    // Menangani request body untuk metode POST, PUT, PATCH
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

// echo 1;
function getProducts()
{
    $response = backend("GET", "product.php");
    return $response;
}
function getProduct($id)
{
    $response = backend("GET", "product.php?id=" . $id);
    return $response;
}
function updateProduct($id, $data)
{
    $response = backend("POST", "product.php?id=$id", $data);
    return $response;
}
function deleteProduct($id)
{
    $response = backend("DELETE", "product.php?id=$id");
    return $response;
}
function insertProduct($data)
{
    $response = backend("POST", "product.php", $data);
    return $response;
}
function getCategories()
{
    $response = backend("GET", "category.php");
    return $response;
}
function getCategory($id)
{
    $response = backend("GET", "category.php?id=$id");
    return $response;
}
function updateCategory($id, $data)
{
    $response = backend("POST", "category.php?id=$id", $data);
    return $response;
}
function deleteCategory($id)
{
    $response = backend("DELETE", "category.php?id=$id");
    return $response;
}
function insertCategory($data)
{
    $response = backend("POST", "category.php", $data);
    return $response;
}
