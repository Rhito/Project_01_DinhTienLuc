<?php

    $sql = "SELECT * FROM sanpham WHERE id_danhmuc = 1";
    $result = $conn->query($sql);

?>

<div class=" block-product">
    <div class="block-title">
        <h2>Nam</h2>
        <div class="nav-items-blocktitle">
            <a href="index.php?quanly=danhmucsanpham&id=1" class="view-more">
                Xem thêm
                <i class="fa-solid fa-angles-right view-more-angle"></i>
            </a>
        </div>
    </div>
    <div class="image-slider-wrapper">
        <div class="image-slider">
            <?php
            while ($row = $result->fetch_array()) {
                if ($row['tinhtrang_sanpham'] == 1) {
            ?>
            <div class="image-item">
                <div class="image">
                    <img src="admin/uploads/<?php echo $row['anh_sanpham'] ?>" alt="">
                    <form action="<?php //echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="post">
                        <button name="add-to-cardBtn" type="submit" value="<?php echo $row['id_sanpham'] ?>" class="add-to-card">
                            <p>Thêm nhanh vào giỏ</p>
                        </button>
                    </form>
                </div>
                <div class="cloth-color color-selected">
                    <img src="admin/uploads/<?php echo $row['mau_sanpham']; ?>" alt="">
                </div>
                <div class="inf-product">
                    <a href="?idsanpham=<?php echo $row['id_sanpham']?>" class="product-name"><?php echo $row['ten_sanpham']; ?></a>
                    <div class="price-box">
                        <span class="normal-price"><?php echo $row['gia_sanpham']; ?> ₫</span>
                        <div class="product-item-label-text">Độc quyền online</div>
                    </div>
                </div>
            </div>
            <?php
                } else {
                }
            }
            ?>
        </div>
    </div>
</div>