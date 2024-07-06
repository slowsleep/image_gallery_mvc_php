let loginrForm = document.querySelector("#loginForm");

loginrForm.addEventListener("submit", function (event) {
    event.preventDefault();
    let formData = new FormData(loginrForm);

    fetch("app/handlers/login_handler.php", {
        method: "POST",
        body: formData
    }).then(function (response) {
        return response.json();
    }).then(function (result) {
        let loginResult = document.querySelector("#loginResult");
        loginResult.innerHTML = "";
        loginrForm.querySelectorAll(".is-invalid").forEach(function (element) {
            element.classList.remove("is-invalid");
        });

        if (result.status == "success") {
            window.location.href = "/";
        } else if (result.status == "error") {
            for (let key of result.data) {
                if (key["password"]) {
                    loginrForm.querySelector("[name='password']").classList.add("is-invalid");
                    loginResult.innerHTML += key["password"] + "<br>";
                }
                if (key["form"]) {
                    loginrForm.querySelector("[name='name']").classList.add("is-invalid");
                    loginrForm.querySelector("[name='password']").classList.add("is-invalid");
                    loginResult.innerHTML += key["form"] + "<br>";
                }
                if (key["message"]) {
                    loginResult.innerHTML += key["message"] + "<br>";
                }
            }
        }
    });
})
