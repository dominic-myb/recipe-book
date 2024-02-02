$(document).ready(function () {
    $("#login-btn").on("click", function (e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
    $("#register-btn").on("click", function (e){
        if (!validateForm()) {
            e.preventDefault();
        }
    });
    function validateForm() {
        var username = $("#username").val();
        var pass = $("#password").val();
        if (username.trim() === "" || pass.trim() === "") {
            alert("Please fill in all required fields.");
            return false;
        }
        username = DOMPurify.sanitize(username);
        pass = DOMPurify.sanitize(pass);

        return true;
    }
    $("#showPassword").change(function () {
        var pass = $("#password");

        if ($(this).prop("checked")) {
            pass.attr("type", "text");
        } else {
            pass.attr("type", "password");
        }
    });
});
