<div class="mb-3">
    <label>Pilih Kategori</label>
    <select name="id_kategori" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>
        <?php
        $ambil_kategori = mysqli_query($conn, "SELECT * FROM kategori");
        while($k = mysqli_fetch_array($ambil_kategori)) {
            // value diisi ID, tapi yang tampil di layar adalah Nama Kategori
            echo "<option value='".$k['id']."'>".$k['nama_kategori']."</option>";
        }
        ?>
    </select>
</div>