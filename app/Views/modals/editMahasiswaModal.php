<!-- Modal -->
<div class="modal fade editMahasiswa" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= route_to('update.mahasiswa'); ?>" method="POST" id="update-mahasiswa-form" autocomplete="off">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="cid">
                    <div class="form-group mb-3">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="Nama" placeholder="Masukkan Nama">
                        <span class="text-danger error-text Nama_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Jenis Kelamin</label>
                        <select name="JenisKelamin" id="" class="form-select">
                            <option selected value="">-Pilih-</option>
                            <option value="Laki-laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <span class="text-danger error-text JenisKelamin_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Alamat</label>
                        <input type="text" name="Alamat" class="form-control" placeholder="Masukkan alamat">
                        <span class="text-danger error-text Alamat_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Agama</label>
                        <select name="Agama" class="form-select">
                            <option selected value="">-Pilih-</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katholik">Katholik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                        <span class="text-danger error-text Agama_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">No Telepon</label>
                        <input type="number" name="NoHp" class="form-control" placeholder="Masukkan Nomor Telepon">
                        <span class="text-danger error-text NoHp_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Email</label>
                        <input type="email" name="Email" class="form-control" placeholder="Masukkan Email">
                        <span class="text-danger error-text Email_error"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-success">Edit</button>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div> -->
        </div>
    </div>
</div>