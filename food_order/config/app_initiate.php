<?php
require "../util/dbconfig.php";

$sql = "DROP TABLE IF EXISTS food_customer";
if($conn->query($sql) == TRUE){
  if(DBG) echo outmsg(DROPTBL_SUCCESS);
}

$sql = "DROP TABLE IF EXISTS food_items";
if($conn->query($sql) == TRUE){
  if(DBG) echo outmsg(DROPTBL_SUCCESS);
}

$sql = "DROP TABLE IF EXISTS food_orders";
if($conn->query($sql) == TRUE){
  if(DBG) echo outmsg(DROPTBL_SUCCESS);
}

$sql ="CREATE TABLE `food_customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if($conn->query($sql) == TRUE){
    if(DBG) echo outmsg(CREATETBL_SUCCESS);
 }else{
    echo outmsg(CREATETBL_FAIL);
 }

$sql = "ALTER TABLE `food_customer`  ADD PRIMARY KEY (`id`);";

if($conn->query($sql) == TRUE){
    if(DBG) echo outmsg(CREATETBL_SUCCESS);
 }else{
    echo outmsg(CREATETBL_FAIL);
 }

 $sql = "ALTER TABLE `food_customer` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;";

if($conn->query($sql) == TRUE){
    if(DBG) echo outmsg(CREATETBL_SUCCESS);
 }else{
    echo outmsg(CREATETBL_FAIL);
 }

 $sql = "INSERT INTO `food_customer` (`id`, `name`, `email`, `password`, `phone`, `address`) VALUES
(1, 'Chris Morris', 'chris@phpzag.com', '202cb962ac59075b964b07152d234b70', '1234567890', 'A - 1111 Street road, Newyork USA.');";

if($conn->query($sql) == TRUE){
    if(DBG) echo outmsg(CREATETBL_SUCCESS);
 }else{
    echo outmsg(CREATETBL_FAIL);
 }

$sql = "CREATE TABLE `food_items` (
    `id` int(30) NOT NULL,
    `name` varchar(30) NOT NULL,
    `price` int(30) NOT NULL,
    `description` varchar(200) NOT NULL,
    `images` varchar(200) NOT NULL,
    `status` varchar(10) NOT NULL DEFAULT 'ENABLE'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
  
if($conn->query($sql) == TRUE){
    if(DBG) echo outmsg(CREATETBL_SUCCESS);
 }else{
    echo outmsg(CREATETBL_FAIL);
 }

 $sql = "ALTER TABLE `food_items` ADD PRIMARY KEY (`id`);";

if($conn->query($sql) == TRUE){
    if(DBG) echo outmsg(CREATETBL_SUCCESS);
 }else{
    echo outmsg(CREATETBL_FAIL);
 }

$sql = "ALTER TABLE `food_items`
    MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;";
if($conn->query($sql) == TRUE){
    if(DBG) echo outmsg(CREATETBL_SUCCESS);
 }else{
    echo outmsg(CREATETBL_FAIL);
 }

$sql = "INSERT INTO `food_items` (`id`, `name`, `price`, `description`, `images`, `status`) VALUES
    (58, 'Masala Paneer Kathi Roll', 100, 'Yammi Masala Paneer Kathi Roll loaded with Masala Paneer chunks, onion & Mayo.', 'Masala_Paneer_Kathi_Roll.jpg', 'ENABLE'),
    (59, 'Grilled Fish', 90, 'A whole Pomfret fish grilled with tangy marination & served with grilled onions and tomatoes.', 'Meurig.jpg', 'ENABLE'),
    (60, 'Chocolate Hazelnut Truffle', 199, 'This very delicious chocolate hazelnut truffle.', 'Chocolate_Hazelnut_Truffle.jpg', 'ENABLE'),
    (61, 'Choco Chip Shake', 97, 'Choco Chip Shake - a perfect party sweet treat.', 'Happy_Happy_Choco_Chip_Shake.jpg', 'ENABLE'),
    (62, 'Spring Rolls', 55, 'Delicious Spring Rolls', 'Spring_Rolls.jpg', 'ENABLE'),
    (63, 'Deluxe Thali', 77, 'Deluxe Thali is accompanied by Kattapa Biriyani, Devasena Paratha, Bhalladeva Patiala Lassi', 'Baahubali_Thali.jpg', 'ENABLE'),
    (65, 'Coffee', 35, 'concentrated coffee made by forcing pressurized water through finely ground coffee beans.', 'coffee.jpg', 'DISABLE'),
    (66, 'Tea', 66, 'The simple elixir of tea is of our natural world.', 'tea.jpg', 'DISABLE'),
    (68, 'Paneer', 33, 'it\'s masal paneer for you.', 'paneer pakora.jpg', 'DISABLE'),
    (69, 'Coffee', 88, 'concentrated coffee made by forcing pressurized water through finely ground coffee beans.', 'coffee.jpg', 'ENABLE'),
    (70, 'Tea', 33, 'The simple elixir of tea is of our natural world.', 'tea.jpg', 'ENABLE'),
    (71, 'Samosa', 55, 'Masala Samosa..', 'samosa.jpg', 'ENABLE'),
    (72, 'Paneer Pakora', 44, 'Tasty paneer pakora', 'paneer pakora.jpg', 'ENABLE'),
    (73, 'Puff', 33, 'Vegetable Puff, a snack with crisp-n-flaky outer layer and mixed vegetables stuffing', 'puff.jpg', 'ENABLE'),
    (74, 'Pizza', 123, 'Good and Tasty Pizza', 'Pizza.jpg', 'DISABLE'),
    (75, 'French Fries', 220, 'Pure Veg and Tasty.', 'frenchfries.jpg', 'DISABLE'),
    (76, 'Pakora', 213, 'Pure Vegetable and Tasty.', 'Pakora.jpg', 'DISABLE'),
    (77, 'Pizza', 450, 'Pure Vegetable and Tasty.', 'Pizza.jpg', 'ENABLE'),
    (78, 'French Fries', 150, 'Pure Veg and Tasty.', 'frenchfries.jpg', 'ENABLE'),
    (79, 'Pakora', 350, 'TASTY', 'Pakora.jpg', 'ENABLE');";

if($conn->query($sql) == TRUE){
    if(DBG) echo outmsg(CREATETBL_SUCCESS);
 }else{
    echo outmsg(CREATETBL_FAIL);
}

$sql = "CREATE TABLE `food_orders` (
        `id` int(30) NOT NULL,
        `item_id` int(30) NOT NULL,
        `name` varchar(30) NOT NULL,
        `price` int(30) NOT NULL,
        `quantity` int(30) NOT NULL,
        `order_date` date NOT NULL,
        `order_id` varchar(50) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

      if($conn->query($sql) == TRUE){
        echo outmsg(CREATETBL_SUCCESS);
     }else{
        echo outmsg(CREATETBL_FAIL);
     }

     $sql = "ALTER TABLE `food_orders` ADD PRIMARY KEY (`id`);";

        if($conn->query($sql) == TRUE){
            if(DBG) echo outmsg(CREATETBL_SUCCESS);
         }else{
            echo outmsg(CREATETBL_FAIL);
         }

$sql = "ALTER TABLE `food_orders` MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;";
        if($conn->query($sql) == TRUE){
            if(DBG) echo outmsg(CREATETBL_SUCCESS);
         }else{
            echo outmsg(CREATETBL_FAIL);
         }
$sql = "INSERT INTO `food_orders` (`id`, `item_id`, `name`, `price`, `quantity`, `order_date`, `order_id`) VALUES
(5, 60, 'Chocolate Hazelnut Truffle', 99, 1, '2021-03-19', '605008512657435925'),
(6, 61, 'Choco Chip Shake', 80, 1, '2021-03-19', '605008512657435925'),
(7, 63, 'Deluxe Thali', 75, 1, '2021-03-19', '605008512657435925'),
(8, 59, 'Grilled Fish', 90, 1, '2021-03-19', '102263523585917743');";

if($conn->query($sql) == TRUE){
    if(DBG) echo outmsg(CREATETBL_SUCCESS);
 }else{
    echo outmsg(CREATETBL_FAIL);
 }
?>