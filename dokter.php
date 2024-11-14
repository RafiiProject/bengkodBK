<?php
include_once("koneksi.php");

if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    
    if ($id) {
        // Update existing data
        $query = "UPDATE dokter SET nama='$nama', alamat='$alamat', no_hp='$no_hp' WHERE id='$id'";
        mysqli_query($mysqli, $query);
        $_SESSION['message'] = "Data berhasil diperbarui!";
    } else {
        // Insert new data
        $query = "INSERT INTO dokter (nama, alamat, no_hp) VALUES ('$nama', '$alamat', '$no_hp')";
        mysqli_query($mysqli, $query);
        $_SESSION['message'] = "Data berhasil ditambahkan!";
    }
    header("Location: index.php?page=dokter");
    exit();
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($mysqli, "DELETE FROM dokter WHERE id='$id'");
    $_SESSION['message'] = "Data berhasil dihapus!";
    header("Location: index.php?page=dokter");
    exit();
}

$nama = '';
$alamat = '';
$no_hp = '';
$id = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $ambil = mysqli_query($mysqli, "SELECT * FROM dokter WHERE id='$id'");
    $row = mysqli_fetch_array($ambil);
    $nama = $row['nama'];
    $alamat = $row['alamat'];
    $no_hp = $row['no_hp'];
}
?>

<div class="container">
    <h3>Dokter</h3>
    <hr>

    <!-- Success Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']); // Clear message after displaying
            ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div class="mb-3">
            <label for="inputNama" class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="<?php echo $nama; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="inputAlamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat" value="<?php echo $alamat; ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="inputNoHP" class="form-label">No HP</label>
            <input type="text" class="form-control" name="no_hp" id="inputNoHP" placeholder="No HP" value="<?php echo $no_hp; ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary rounded-pill" name="simpan">Simpan</button>
    </form>
    
    <table class="table table-hover mt-4">
        <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $result = mysqli_query($mysqli, "SELECT * FROM dokter ORDER BY id ASC");
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <th><?php echo $no++; ?></th>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['alamat']; ?></td>
                <td><?php echo $data['no_hp']; ?></td>
                <td>
                    <a class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id']; ?>">Ubah</a>
                    <a class="btn btn-danger rounded-pill" href="index.php?page=dokter&id=<?php echo $data['id']; ?>&aksi=hapus" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
