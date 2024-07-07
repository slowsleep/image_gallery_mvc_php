let uploadImageForm = document.querySelector("#uploadImageForm");

uploadImageForm.addEventListener("submit", function (event) {
    event.preventDefault();
    let formData = new FormData(uploadImageForm);

    fetch("app/handlers/uploadImage_handler.php", {
        method: "POST",
        body: formData
    }).then(function (response) {
        return response.json();
    }).then(function (result) {
        let gallery = document.querySelector("#gallery");
        let uploadResult = document.querySelector("#uploadResult");
        uploadImageForm.querySelectorAll(".is-invalid").forEach(function (element) {
            element.classList.remove("is-invalid");
        });
        uploadResult.innerHTML = "";

        if (result.status == "success") {
            let filename = result.data;
            const myImage = new Image(200, 200);
            myImage.src = "/app/uploads/" + filename;
            myImage.classList.add("img-thumbnail", "rounded");
            gallery.appendChild(myImage);
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
