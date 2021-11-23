$(document).ready(function () {
    /* validasi form register */
    $("#btn-register").prop('disabled', true);

    var username = $("#username-register").val();
    var nama = $("#nama-register").val();
    var email = $("#email-register").val();
    var pass1 = $("#password-register").val();
    var pass2 = $("#password-register2").val();

    /* cek inputan form */
    if (username.length < 3 || nama.length < 3 || email.length < 6) {
        $("#btn-register").prop('disabled', true);
    } else {
        if (pass1.length < 6 || pass2.length < 6) {
            $("#btn-register").prop('disabled', true);
        } else {
            if (pass1 == '' || pass2 == '') {
                $("#btn-register").prop('disabled', true);
            } else {
                if (pass1 == pass2) {
                    $("#btn-register").prop('disabled', false);
                } else {
                    $("#btn-register").prop('disabled', true);
                }
            }
        }
    }

    /* cek inputan form ketika tombol keyboard dilepas */
    $("#username-register, #nama-register, #email-register, #password-register, #password-register2").keyup(function () {
        var username = $("#username-register").val();
        var nama = $("#nama-register").val();
        var email = $("#email-register").val();
        var pass1 = $("#password-register").val();
        var pass2 = $("#password-register2").val();

        /* cek inputan form */
        if (username.length < 3 || nama.length < 3 || email.length < 6) {
            $("#btn-register").prop('disabled', true);
        } else {
            if (pass1.length < 6 || pass2.length < 6) {
                $("#btn-register").prop('disabled', true);
            } else {
                if (pass1 == '' || pass2 == '') {
                    $("#btn-register").prop('disabled', true);
                } else {
                    if (pass1 == pass2) {
                        $("#btn-register").prop('disabled', false);
                    } else {
                        $("#btn-register").prop('disabled', true);
                    }
                }
            }
        }


    });

    /* Akhir validasi form register */
});