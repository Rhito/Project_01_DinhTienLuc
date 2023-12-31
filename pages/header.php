<?php
session_start();

$cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];
$quantity = 1;

if (isset($_POST['add-to-cardBtn'])) {
    $id = $_POST['add-to-cardBtn'];
    // Thực hiện logic cập nhật giỏ hàng tại đây
    $id = $_POST['add-to-cardBtn'];
    $sql = "SELECT * FROM sanpham WHERE id_sanpham = '$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_array();

    $items = [
        'id_sanpham' => $row['id_sanpham'],
        'ten_sanpham' => $row['ten_sanpham'],
        'mau_sanpham' => $row['mau_sanpham'],
        'anh_sanpham' => $row['anh_sanpham'],
        'gia_sanpham' => $row['gia_sanpham'],
        'quantity' => $quantity,
    ];


    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$id] = $items;
    }
    header("Location: index.php");
}

if (isset($_POST['cartQtyBtn']) && $_SESSION['cart'] != "") {
    $id = $_POST['cartQtyBtn'];
    $_SESSION['cart'][$id]['quantity'] = $_POST['cart-qty'];
    header("Location: index.php");
}

if (isset($_POST["remove-cart-item"])){
    $id = $_POST["remove-cart-item"];
    if($id){
        unset($_SESSION['cart'][$id]);
        header("Location: index.php");
    }
}
?>



<!-- header -->
<div class="header">
    <!-- logo home -->
    <img onclick="document.location.href='index.php'" src="./fontend/images/logo.svg" alt="" width="7%">

    <?php
    if (isset($_GET['quanly'])) {
        $temp = $_GET['quanly'];
    } else {
        $temp = '';
    }
    ?>
    <!-- list menu -->
    <ul class="list-menu">
        <li>
            <a href="index.php" class="<?php if ($temp == '') echo 'site-active'; ?>">Trang Chủ</a>
        </li>
        <li>
            <a href="index.php?quanly=gioithieu" class="<?php if ($temp == 'gioithieu') echo 'site-active'; ?>">Giới Thiệu</a>
        </li>
        <li>
            <a href="index.php?quanly=tintuc" class="<?php if ($temp == 'tintuc') echo 'site-active'; ?>">Tin Tức</a>
        </li>
        <li>
            <a href="index.php?quanly=lienhe" class="<?php if ($temp == 'lienhe') echo 'site-active'; ?>">Liên Hệ</a>
        </li>
        <li>
            <a href="index.php?quanly=danhmucsanpham" class="<?php if ($temp == 'danhmucsanpham') echo 'site-active'; ?>">Sản Phẩm</a>
            <ul class="submenu">
                <?php
                include('admin/config/connect.php');
                $sql = "SELECT * FROM danhmuc WHERE 1 = 1";
                $result = $conn->query($sql);
                while ($row = $result->fetch_array()) {
                    if ($row['trangthai'] == 1) {
                        echo "<li><a href='index.php?quanly=danhmucsanpham&id={$row['id_danhmuc']}'>{$row['ten_danhmuc']}</a></li>";
                    }
                }
                ?>
            </ul>
        </li>
    </ul>

    <!-- menu icons -->
    <div class="menu-icon">
        <?php if(isset($_SESSION['dangnhap']['admin'])){ ?>
            
            <div class="move-to-admin">
                <a href="admin/index.php">
                    <i class="fa-solid fa-key"></i>
                    <span class="user-title">
                        Admin page
                    </span>
                </a>
            </div>
        <?php
        }
        ?>
        <div class="user-login">
            <a <?php if(isset($_SESSION['dangnhap'])) echo 'href="index.php?quanly=thongtinkhachhang"';?> class="login-select">
                <i class="fa-solid fa-user"></i>
                <span class="user-title"> <?php 
                    if (isset($_SESSION['dangnhap']['admin'])) {
                        echo $_SESSION['dangnhap']['admin'];
                    }elseif(isset($_SESSION['dangnhap'])){
                        echo $_SESSION['dangnhap'];
                    }else {
                        echo 'Tài khoản';
                    }
                ?></span>
            </a>
        </div>
        <!-- modal login -->
        <div class="login-modal">
            <div class="modal-content">
                <div class="modal-close">
                    <i class="fa-solid fa-x"></i>
                </div>

                <div class="block-login">
                    <div class="login-img">
                        <img src="./fontend/images/account-login.png" alt="">
                    </div>
                    <!-- login backend -->
                    <?php
                        if(isset($_POST['submit-login-btn'])){
                            $userName = filter_input(INPUT_POST, "login_username", FILTER_SANITIZE_SPECIAL_CHARS);
                            $password = filter_input(INPUT_POST, "login_password", FILTER_SANITIZE_SPECIAL_CHARS);
                            
                            $sqlLogin = "SELECT * FROM admin WHERE username_admin = '$userName' AND password = '$password'";
                            $resultLogin = $conn->query($sqlLogin);
                            $countAdmin = $resultLogin->num_rows;
                            if (!empty($userName) && !empty($password)){
                                if ($countAdmin > 0){
                                    $rowLogin = $resultLogin->fetch_array();
                                    if ($rowLogin['status'] == 0){
                                        echo "<script>alert('Tài khoản bị đã bị khóa!')</script>";
                                    }else {
                                        $_SESSION['dangnhap']['admin'] = $userName;
                                        header('Location: admin/index.php');
                                    }
                                }else {
                                    $sqlLogin = "SELECT * FROM khachhang WHERE tendangnhap = '$userName' AND matkhau = '$password'";
                                    $resultLogin = $conn->query($sqlLogin);
                                    $count = $resultLogin->num_rows;

                                    if ($count > 0){
                                        $rowLogin = $resultLogin->fetch_array();
                                        if ($rowLogin['trangthai'] == 0){
                                            echo "<script>alert('Tài khoản bị đã bị khóa!')</script>";
                                        }else {
                                            $_SESSION['dangnhap'] = $userName;
                                            header('Location: index.php');
                                        }
                                    }else {
                                        echo "<script>alert('Sai tài khoản hoặc mật khẩu vui lòng nhập lại!')</script>";
                                    }
                                }
                            }else {
                                echo "<script>alert('Sai hoặc thiếu thông tin vui lòng nhập lại!')</script>";
                           
                            }
                        }
  
                    ?>
                    
                    <form method="post" <?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?> class="signin-frm">
                        <h1>Xin chào,</h1>
                        <label for="login_username">Tên đăng nhập:</label>
                        <input autocomplete="off" class="form-control" type="text" name="login_username" id="login_username" placeholder="Tên đăng nhập">
                        <label for="login_password">Mật khẩu:</label>
                        <input autocomplete="off" class="form-control" type="password" name="login_password" id="login_password" placeholder="Mật khẩu">
                        <button class="form-control submit-btn" type="submit" name="submit-login-btn">
                            Tiếp tục
                        </button>
                    </form>
                    
                    <div class="note-term">
                        <p>* nếu bạn chưa có tài khoản hãy đăng ký <a class="sign-in">* tại đây</a></p>
                    </div>
                </div>

            </div>

        </div>
        <!-- model sign-in -->
        <div class="signin-modal">
            <div class="block-signin">
                <div class="modal-content ">
                    <div class="modal-signin-close">
                        <i class="fa-solid fa-x"></i>
                    </div>
                    <?php
                    if (isset($_POST['submit-signin-btn'])){
                        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
                        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
                        $full_name = filter_input(INPUT_POST, "full_name", FILTER_SANITIZE_SPECIAL_CHARS);
                        $age = $_POST['age']; if($age <= 6 || $age >= 150 ) $age = '';
                        $gender = $_POST['gender'];
                        $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
                        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
                        $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_NUMBER_INT);
                        if($phone < 1) $phone = '';

                        if(empty($username) || empty($password) || empty($full_name) || empty($age) || 
                           empty($gender) || empty($address) || empty($email) || empty($phone)) {
                                echo "<script>alert('Sai hoặc thiếu thông tin vui lòng nhập lại!')</script>";
                        }else {
                            $sqlSignIn = "INSERT INTO khachhang(ten_khachhang, tuoi_khachhang, gioitinh, diachi,sodienthoai,
                                                                email, tendangnhap, matkhau) 
                                                VALUES ('$full_name','$age', '$gender', '$address',
                                                        '$phone', '$email','$username','$password')";
                            $resultSignIn = $conn->query($sqlSignIn);
                            if ($resultSignIn){
                                echo "<script>alert('Chúc mừng bạn đăng ký thành công')</script>";
                                header('Location: index.php');
                            }
                        }

                    }
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="post" class="signin-frm">
                        <h1>Vui lòng nhập đầy đủ thông tin,</h1>
                        <label for="username">Tên đăng nhập:</label>
                        <input  autocomplete="off" class="form-control" type="text" name="username" id="username" placeholder="Tên đăng nhập">

                        <label for="password">Mật khẩu:</label>
                        <input autocomplete="off" class="form-control" type="password" name="password" id="password" placeholder="Mật khẩu">

                        <label for="full_name">Họ và tên</label>
                        <input autocomplete="off" class="form-control" type="text" name="full_name" id="full_name">

                        <label for="age">Tuổi</label>
                        <input autocomplete="off" class="form-control" type="number" name="age" id="age">

                        <label for="gender">Giới tính</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value=""></option>
                            <option value="1">Nam</option>
                            <option value="0">Nữ</option>
                        </select>

                        <label for="address">Địa chỉ</label>
                        <input autocomplete="off" class="form-control" type="text" name="address" id="address">

                        <label for="email">Email</label>
                        <input autocomplete="off" class="form-control" type="email" name="email" id="email">

                        <label for="phone">Số điện thoại</label>
                        <input autocomplete="off" placeholder="SĐT phải là định dang 10 chữ số" class="form-control" type="number" name="phone" id="phone">

                        <button class="form-control submit-btn" type="submit" name="submit-signin-btn">
                            Tiếp tục
                        </button>
                    </form>

                </div>

            </div>
        </div>

        <!-- modal cart-shopping  -->
        <div class="cart-shopping">
            <a class="cart-icon">
                <span class="in-cart"><?php
                                        $numOfProduct = 0;
                                        foreach ($cart as $key => $values) {
                                            $numOfProduct++;
                                        }
                                        if ($numOfProduct != 0) {
                                            echo $numOfProduct;
                                        }
                                        ?></span>
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-shopping-title">Giỏ hàng</span>
            </a>

            <div class="cart-wrapper">
                <div class="exit-cart"></div>

                <div class="block-cart">
                    <div class="block-cart-heading">
                        <h3 class="cart-title">Giỏ hàng</h3>
                        <button class="cart-close"><i class="fa-solid fa-angles-right"></i></button>
                    </div>

                    <div class="block-cart-content">
                        <?php
                        if ($cart != []) {

                            foreach ($cart as $key => $values) : ?>
                                <div class="cart-item">
                                    <div class="cart-item-photo">
                                        <img src="admin/uploads/<?php echo $values['anh_sanpham']; ?>" alt="" class="cart-img">
                                    </div>
                                    <div class="cart-item-details">
                                        <a href="?idsanpham=<?php echo $values['id_sanpham']; ?>" class="cart-item-name"><?php echo $values['ten_sanpham'] ?></a>

                                        <div class="cart-show">
                                            <div class="cart-infor">
                                                <div class="cloth-color color-selected">
                                                    <img src="admin/uploads/<?php echo $values['mau_sanpham']; ?>" alt="">
                                                </div>
                                                <span class="id-product">Mã SP: <?php echo $values['id_sanpham']; ?></span>
                                                <span class="normal-price"><?php echo $values['gia_sanpham']; ?> ₫</span>
                                            </div>

                                            <div class="cart-quantity">
                                                <form method="post">
                                                    <div class="cart-item-qty">
                                                        <a class="minus-qty"><i class="fa-solid fa-minus"></i></a>
                                                        <input type="text" value="<?php echo $values['quantity']; ?>" class="input-qty" name="cart-qty">
                                                        <a class="plus-qty"><i class="fa-solid fa-plus"></i></a>
                                                    </div>
                                                    <button type="submit" class="cartQtyBtn" name="cartQtyBtn" style="cursor: pointer;" value="<?php echo $values['id_sanpham']; ?>">Cập nhật số lượng</button>

                                                
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="remove-cart-item" value="<?php echo $values['id_sanpham']; ?>" onclick="if(confirm('Bạn có muốn xóa không?')){return true;}else{return false;}" class="remove-cart-item">
                                        <i class="fa-solid fa-x"></i>
                                    </button>
                                                </form>
                                </div>
                        <?php endforeach;
                        }
                        ?>
                    </div>
                    <div class="block-cart-footer">
                        <?php 
                            // $numOfProduct = 0;
                            $totalPay = 0;
                            foreach ($cart as $key => $values) {
                                $numOfProduct++;
                                $totalPay += $values['gia_sanpham'] * $values['quantity'];
                            }
                            // if ($numOfProduct != 0) {
                        ?>
                        <div class="price-pay">
                            <h4>Tạm tính: </h4>
                            <p class="normal-price"><?php echo $totalPay; ?>₫</p>
                        </div>
                        <?php
                            // }
                        ?>
                        
                        <button type="submit" class="payBtn" name="payBtn">Thanh toán</button>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>