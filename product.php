<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'shop_test';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("خطا در اتصال: " . $conn->connect_error);
}

// گرفتن ایدی محصول از لینک بالا
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $values = array_values($row);
    $product_name = isset($row['name']) ? $row['name'] : (isset($values[1]) ? $values[1] : 'نامشخص');
    $product_price = isset($row['price']) ? $row['price'] : (isset($values[2]) ? $values[2] : '0');
} else {
    die("محصول مورد نظر یافت نشد.");
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?php echo $product_name; ?></title>
    <style>
        body {
            font-family: Tahoma, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 40px;
        }
        .product-box {
            background: #fff;
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #2c3e50; font-size: 1.5rem; }
        .price { color: #27ae60; font-size: 1.2rem; font-weight: bold; }
        .counter {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 25px 0;
        }
        .counter button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 1.2rem;
            border-radius: 5px;
            cursor: pointer;
        }
        .counter button:hover { background-color: #2980b9; }
        .counter span { font-size: 1.2rem; font-weight: bold; min-width: 30px; text-align: center; }
        .total-price {
            font-size: 1.3rem;
            color: #e74c3c;
            font-weight: bold;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
        }
    </style>
</head>
<body>

    <div class="product-box">
        <h1><?php echo $product_name; ?></h1>
        <p class="price">قیمت واحد: <span id="unit-price"><?php echo $product_price; ?></span> تومان</p>
        
        <div class="counter">
            <span>تعداد:</span>
            <button onclick="changeCount(-1)">-</button>
            <span id="count">1</span>
            <button onclick="changeCount(1)">+</button>
        </div>

        <div class="total-price">
            مبلغ قابل پرداخت: <span id="total"> <?php echo number_format($product_price); ?> </span> تومان
        </div>

        <a href="index.php" class="back-btn">← بازگشت به لیست محصولات</a>
    </div>

    <script>
        let unitPrice = <?php echo $product_price; ?>;
        let countElem = document.getElementById('count');
        let totalElem = document.getElementById('total');
        let currentCount = 1;

        function changeCount(val) {
            currentCount += val;
            if (currentCount < 1) {
                currentCount = 1; // تعداد نباید کمتر از 1 شود
            }
            countElem.innerText = currentCount;
            
            let totalPrice = currentCount * unitPrice;
            totalElem.innerText = totalPrice.toLocaleString(); // جداکننده هزارگان
        }
    </script>

</body>
</html>