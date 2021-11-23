$(document).ready(function(){
    $("#box-gambar").click(function(){
        $("#foto-kategori").click();
    });

    $("#foto-kategori").change(function(){
      
        $("#form-upload-foto").submit();
    });

    $('#form-upload-foto').submit(function() {
   
        
        e.preventDefault();
        // var d = new FormData(this);
      
        $.ajax({
            url: url+"kategori/upload",
            method: "POST",
            data: new FormData("#form-upload-foto"),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {

                console.log(data);
            }
        });

        // return false;
       

    });
});
