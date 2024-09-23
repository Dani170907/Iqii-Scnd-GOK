<h2>Daftar Barang</h2>
<br>

<a class="btn btn-primary btn-md" href="?p=add_item"><span class="glyphicon glyphicon-plus"></span></a>
<br>

<div style="float: right">
    <form action="" class="form-inline" >
        <input placeholder="Cari disini" type="text" name="cari" class="form-control">
        <button type="submit" class="btn btn-sm btn-primary"> <span class="glyphicon glyphicon-search"></span> </button>
    </form>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Tanggal Ditambahkan</th>
            <th>Dirubah</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM products";
            $query = mysqli_query($connection, $sql);
            $check = mysqli_num_rows($query);

            $no = 1;
            if ( $check > 0 )  :
                while($data = mysqli_fetch_array($query)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $data['productName'] ?></td>
                        <td><?= $data['category'] ?></td>
                        <td><?= "Rp " . number_format($data['price'],2,',','.'); ?></td>
                        <td><?= $data['createdAt'] ?></td>
                        <td><?= $data['updatedAt'] ?></td>
                        <td>
                            <a onclick="return confirm('Beneran mau dihapus bang?')" class="btn btn-danger btn-sm" href="page/delete_item.php?productId=<?= $data['productId'] ?>"> <span class="glyphicon glyphicon-trash"></span> </a>
   |
                            <a class="btn btn-info btn-sm" href="?p=edit_item&productId=<?= $data['productId'] ?>"> <span class="glyphicon glyphicon-edit"></span> </a>
                        </td>
                    </tr>
            <?php endwhile; ?>
        <?php else : ?>
            <tr>
                <td colspan="7">
                    Tidak ada data!
                </td>
            </tr>    
        <?php endif; ?>
    </tbody>
</table>

<div class="float-left">
    Halaman 1 dari 5
</div>

<div style="float: right;">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li>
                <a href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li>
            <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
            </li>
        </ul>
    </nav>
</div>