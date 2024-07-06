let registrationForm = document.querySelector("#registrationForm");

registrationForm.addEventListener("submit", function (event) {
    event.preventDefault();
    let formData = new FormData(registrationForm);

    fetch("app/handlers/registration_handler.php", {
        method: "POST",
        body: formData
    }).then(function (response) {
        return response.json();
    }).then(function (result) {
        let registrationResult = document.querySelector("#registrationResult");
        registrationResult.innerHTML = "";
        registrationForm.querySelectorAll(".is-invalid").forEach(function (element) {
            element.classList.remove("is-invalid");
        });

        if (result.status == "success") {
            window.location.href = "/";
        } else if (result.status == "error") {
            for (let key of result.data) {
                if (key["name"]) {
                    registrationForm.querySelector("[name='name']").classList.add("is-invalid");
                    registrationResult.innerHTML += key["name"] + "<br>";
                }
                if (key["password"] || key["repeat-password"]) {
                    registrationForm.querySelector("[name='password']").classList.add("is-invalid");
                    registrationForm.querySelector("[name='repeat-password']").classList.add("is-invalid");
                }
                if (key["password"]) {
                    registrationResult.innerHTML += key["password"] + "<br>";
                }
                if (key["repeat-password"]) {
                    registrationResult.innerHTML += key["repeat-password"] + "<br>";
                }
                if (key["form"]) {
                    registrationResult.innerHTML += key["form"] + "<br>";
                }
                if (key["message"]) {
                    registrationResult.innerHTML += key["message"] + "<br>";
                }
            }
        }
    });
});