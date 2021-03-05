'use strict';
$(document).ready(function () {
    var token = "";
    var email, password;
    // login ajax call
    $("#loginCheck").click(function () {
        email = $('#email').val();
        password = $('#password').val();
        $("#logintatus").html("<b>Checking Credencial...</b>");

        // Call ajax to fetch all jobs
        $.ajax({
            type: "POST",
            url: "api/login.php",
            accepts: "application/json; charset=UTF-8",
            data: JSON.stringify ({
                "email": email,
                "password": password
              })
        })
            .done(function (data) {
                token = data;
                $("#logintatus").html(data.message);
                console.log(data.status);
                console.log(data.message.jwt);
                var url = "report.html?s="+encodeURIComponent(data.status)+"&t="+encodeURIComponent(data.message.jwt)+"&e="+encodeURIComponent(data.message.expireAt);
                window.location.href = url;
            })
            .fail(function (data) {
                console.log(data.message);
                // just in case posting your form failed
                $("#logintatus").html(data.message);
            }).always(function () {
                console.log("always");
            });
        // to prevent refreshing the whole page page
        return false;
    });
});
