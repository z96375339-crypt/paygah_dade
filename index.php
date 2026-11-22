<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'shop_test';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("خطا در اتصال: " . $conn->connect_error);
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فروشگاه من</title>
    <style>
        body {
            font-family: Tahoma, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }
        .card {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-top: 4px solid #2980b9;
            text-decoration: none;
            color: inherit;
            display: block;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        .price {
            color: #27ae60;
            font-weight: bold;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

    <h2>لیست محصولات فروشگاه</h2>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            // فرض می‌کنیم ستون شناسه (ایدی) در جدول شما id نام دارد
            while($row = $result->fetch_assoc()) {
                $values = array_values($row);
                $product_id = isset($row['id']) ? $row['id'] : $values[0];
                $product_name = isset($row['name']) ? $row['name'] : (isset($values[1]) ? $values[1] : 'نامشخص');
                $product_price = isset($row['price']) ? $row['price'] : (isset($values[2]) ? $values[2] : '0');
                
                // هر کارت را تبدیل به یک لینک می‌کنیم که به صفحه product.php با ایدی محصول می‌رود
                echo '<a href="product.php?id=' . $product_id . '" class="card">';
                echo '<h3>' . $product_name . '</h3>';
                echo '<p class="price">قیمت: ' . number_format($product_price) . ' تومان</p>';
                echo '</a>';
            }
        } else {
            echo "<p style='text-align:center;'>محصولی یافت نشد.</p>";
        }
        $conn->close();
        ?>
    </div>

</body>
</html>