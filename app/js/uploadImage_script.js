let uploadImageForm = document.querySelector("#uploadImageForm");
let uploadResult = document.querySelector("#uploadResult");
const UPLOAD_MAX_SIZE = 1000000;

uploadImageForm.addEventListener("submit", function (event) {
    event.preventDefault();
    let formData = new FormData(uploadImageForm);

    if (formData.get("image[]").size > UPLOAD_MAX_SIZE) {
        uploadImageForm.querySelector("[name='image[]']").classList.add("is-invalid");
        uploadResult.innerHTML = "Максимальный размер файла: " + UPLOAD_MAX_SIZE / 1000000 + "Мб.";
        return;
    }

    fetch("app/handlers/uploadImage_handler.php", {
        method: "POST",
        body: formData
    }).then(function (response) {
        return response.json();
    }).then(function (result) {
        uploadImageForm.querySelectorAll(".is-invalid").forEach(function (element) {
            element.classList.remove("is-invalid");
        });
        uploadResult.innerHTML = "";

        if (result.status == "success") {
            window.location.href = "/";
            uploadResult.innerHTML = "Изображение успешно загружено";
        } else if (result.status == "error") {
            for (let key of result.data) {
                if (key["image"]) {
                    uploadImageForm.querySelector("[name='image[]']").classList.add("is-invalid");
                    uploadResult.innerHTML += key["image"] + "<br>";
                }
                if (key["message"]) {
                    uploadResult.innerHTML += key["message"] + "<br>";
                }
            }
        }
    });
});
