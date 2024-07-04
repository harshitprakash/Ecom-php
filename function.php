<?php


function get_product($con, $type = '', $limit = '', $cat_id='', $product_id='') {
    $sql = "SELECT product.*, categories.categories 
            FROM product
            JOIN categories ON product.categories_id = categories.id 
            WHERE product.status = 1"; // Start of SQL query with status condition

    // Add condition for cat_id if provided
    if (!empty($cat_id)) {
        $sql .= " AND product.categories_id = $cat_id";
    }
    // Apply type condition (e.g., latest)
    if ($type == 'latest') {
        $sql .= " ORDER BY product.id DESC";
    }

    // Apply limit condition
    if (!empty($limit)) {
        $sql .= " LIMIT $limit";
    }

    // Execute the SQL query
    $res = mysqli_query($con, $sql);

    // Fetch the results into an array
    $data = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }

    // Free result set
    mysqli_free_result($res);

    // Return the data array
    return $data;
}





?>