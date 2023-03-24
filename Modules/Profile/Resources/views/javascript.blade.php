<script>
    var form = 'form_user';

    var fields = [
        'user_id',
        'user_nama',
        'user_username',
        'user_email',
        'user_password',
    ];

    var image_pp = "<?= Session::get('userdata.user_photo')?>";
    $(()=> {

        $("#user_photo").change(function() {
            readURL(this);
        });

        $('.show-user_nama').html("<?= Session::get('userdata.user_nama')?>");
        $('.show-user_email').html("<?= Session::get('userdata.user_email')?>");
        $('.show-user_username').html("<?= Session::get('userdata.user_username')?>");

        if(image_pp != ''){
            $('#photoUser').attr('src', `<?php echo (Storage::disk('local')->url('public/uploads/user/${image_pp}')); ?>`);
        }else{
            $('#photoUser').attr('src', 'assets/user.png');
        }

        onEdit()
    })

    readURL = (input) => {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#user_photoPreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    removePP = () => {
        $('#user_photoPreview').attr('src', '').fadeIn('slow');
        $('#user_photo').val('');
    }

    onSave = () => {
        var formData = new FormData($(`[name="${form}"]`)[0]);

        var id_user = $('#user_id').val();
        formData.append('user_id', id_user);
        var urlSave = "{{ route('user/update') }}";

        saConfirm({
            message: 'Apakah anda yakin untuk mengubah data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: urlSave,
                        method: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            // JSON.parse(res);
                            location.reload()

                            saMessage({
                                success: res['success'],
                                title: res['title'],
                                message: res['message']
                            })
                        }
                    })
                }

            }
        })
    }

    onEdit = () => {
        // var id = $(el).data('id');
        var id = "<?= Session::get('userdata.user_id')?>";

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "{{ route('user/edit') }}",
            data:{
                user_id : id
            },
            method: 'post',
            success: function(data){
                var img = data[0]['user_photo'];

                if(img){
                    $('#user_photoPreview').attr('src', `{{ Storage::disk('local')->url('public/uploads/user/${img}') }}`);
                }

                $.each(fields, function(i,v){
                    $('#'+v).val(data[0][v]).change()
                })

                $('#user_password').val('').attr('placeholder', 'Kosongkan jika tidak ingin mengubah password');

                if(data[0]['user_active'] == 1){
                    $('#user_active').prop('checked', true)
                }else{
                    $('#user_active').prop('checked', false)
                }
            }
        })
    }

</script>