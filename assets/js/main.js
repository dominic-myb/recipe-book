$(document).ready(function () {
    function updateAccountDropdown(isAuthenticated) {
        var myRecipe = $(".my-recipe");
        var accountDropdown = $(".account-drp");
        var loginLink = '<a href="login.php">Login</a>';
        var signupLink = '<a href="register.php">Sign Up</a>';
        var accountSettingsLink = '<a href="#">Account Settings</a>';
        var logoutLink = '<a href="app/includes/PHP/logout.php" style="color:red;">Logout</a>';

        if (!isAuthenticated) {
            myRecipe.find(".account-btn").hide();
            accountDropdown.find(".account-btn").text("Account");
            accountDropdown.find(".account-drp-content").html(loginLink + signupLink);
        } else {
            myRecipe.find(".account-btn").show();
            accountDropdown.find(".account-btn").text("Welcome, " + jsUsername);
            accountDropdown.find(".account-drp-content").html(accountSettingsLink + logoutLink);
        }
    }

    function checkUserSession() {
        $.ajax({
            url: "app/includes/PHP/session.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response);
                var isAuthenticated = response && response.isAuthenticated;
                updateAccountDropdown(isAuthenticated);
            },
            error: function () {
                console.error("Error checking user session");
            },
        });
    }
    checkUserSession();
    $("#login-btn").on("click", function (e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
    $("#register-btn").on("click", function (e) {
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
