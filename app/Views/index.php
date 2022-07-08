<?= $this->extend('layouts/backend'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">List Data Mahasiswa</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="mahasiswa-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Agama</th>
                                <th>NoHp</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Tambah Mahasiswa</div>
            <div class="card-body">
                <form action="<?= route_to('add.mahasiswa'); ?>" method="POST" id="add-mahasiswa-form" autocomplete="off">
                    <?= csrf_field(); ?>
                    <div class="form-group mb-2">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="Nama" placeholder="Masukkan Nama">
                        <span class="text-danger error-text Nama_error"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Jenis Kelamin</label>
                        <select name="JenisKelamin" id="" class="form-select">
                            <option selected value="">-Pilih-</option>
                            <option value="Laki-laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <span class="text-danger error-text JenisKelamin_error"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Alamat</label>
                        <input type="text" name="Alamat" class="form-control" placeholder="Masukkan alamat">
                        <span class="text-danger error-text Alamat_error"></span>
                    </div>
                    <div class="form-group mb-2">
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
                    <div class="form-group mb-2">
                        <label for="">No Telepon</label>
                        <input type="number" name="NoHp" class="form-control" placeholder="Masukkan Nomor Telepon">
                        <span class="text-danger error-text NoHp_error"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Email</label>
                        <input type="email" name="Email" class="form-control" placeholder="Masukkan Email">
                        <span class="text-danger error-text Email_error"></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->include('modals/editMahasiswaModal'); ?>
<?= $this->endsection(); ?>
<?= $this->section('scripts'); ?>
<script>
    var csrfName = $('meta.csrf').attr('name'); //CSRF Token Name
    var csrfHash = $('meta.csrf').attr('content'); //CSRF HASH

    //ADD New Mahasiswa ^
    $('#add-mahasiswa-form').submit(function(e) {
        e.preventDefault();
        var form = this;
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: new FormData(form),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function() {
                $(form).find('span.error-text').text('');
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    if (data.code == 1) {
                        $(form)[0].reset();
                        $('#mahasiswa-table').DataTable().ajax.reload(null, false);
                        Swal.fire(
                            'Berhasil',
                            'Data anda berhasil disimpan',
                            'success'
                        );
                    } else {
                        alert(data.msg);
                    }
                } else {
                    $.each(data.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    })
                }
            }
        });
    });
    //Load Data ^
    $(document).ready(function() {
        var t = $('#mahasiswa-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "<?= route_to('get.all.mahasiswa'); ?>",
            //ascending / descending
            "columnDefs": [{
                "orderSequence": ["desc"],
                "targets": [0]
            }],
            "dom": "lBfrtip",
            stateSave: true,
            info: true,
            "iDisplayLength": 5,
            "pageLength": 5,
            "aLengthMenu": [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
            "fnCreateRow": function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            }
        });
    });

    //Update Data
    $(document).on('click', '#updateMahasiswaBtn', function() {
        var mahasiswa_id = $(this).data('id');

        $.post("<?= route_to('get.mahasiswa.info') ?>", {
            mahasiswa_id: mahasiswa_id,
            [csrfName]: csrfHash
        }, function(data) {

            $('.editMahasiswa').find('form').find('input[name="cid"]').val(data.results.id);
            $('.editMahasiswa').find('form').find('input[name="Nama"]').val(data.results.Nama);
            $('.editMahasiswa').find('form').find('select[name="JenisKelamin"]').val(data.results.JenisKelamin);
            $('.editMahasiswa').find('form').find('input[name="Alamat"]').val(data.results.Alamat);
            $('.editMahasiswa').find('form').find('select[name="Agama"]').val(data.results.Agama);
            $('.editMahasiswa').find('form').find('input[name="NoHp"]').val(data.results.NoHp);
            $('.editMahasiswa').find('form').find('input[name="Email"]').val(data.results.Email);
            $('.editMahasiswa').find('form').find('span.error-text').text('');
            $('.editMahasiswa').modal('show');
        }, 'json');
    });

    $('#update-mahasiswa-form').submit(function(e) {
        e.preventDefault();
        var form = this;

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: new FormData(form),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function() {
                $(form).find('span.error-text').text('');
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    if (data.code == 1) {
                        Swal.fire(
                            'Berhasil',
                            'Data anda berhasil diubah',
                            'success'
                        );
                        $('#mahasiswa-table').DataTable().ajax.reload(null, false);
                        $('.editMahasiswa').modal('hide');
                    } else {
                        alert(data.msg);
                    }
                } else {
                    $.each(data.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                }
            }
        });
    });

    $(document).on('click', '#deleteMahasiswaBtn', function() {
        var mahasiswa_id = $(this).data('id');
        var url = "<?= route_to('delete.mahasiswa'); ?>";

        swal.fire({
            title: 'Are you sure?',
            html: 'You want to delete this country',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: 'cancel',
            confirmButtonText: 'Yes, delete',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#556eeb',
            width: 300,
            allowOutsideClick: false
        }).then(function(result) {
            if (result.value) {
                $.post(url, {
                    [csrfName]: csrfHash,
                    mahasiswa_id: mahasiswa_id
                }, function(data) {
                    if (data.code == 1) {
                        $('#mahasiswa-table').DataTable().ajax.reload(null, false);
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        })
                        alert(data.msg);
                    }
                }, 'json');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                })
            }
        });

    });
</script>

<?= $this->endSection(); ?>