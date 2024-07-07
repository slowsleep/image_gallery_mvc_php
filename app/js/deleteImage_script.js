let deleteImageButton = document.querySelectorAll("#deleteImageButton");

deleteImageButton.forEach(element => {
    element.addEventListener("click", function (event) {
        event.preventDefault();
        let confirm = window.confirm("Вы уверены, что хотите удалить изображение?");

        if (!confirm) {
            return;
        }

        let image = {
            id: this.dataset.id
        }

        fetch("app/handlers/deleteImage_handler.php", {
            method: "POST",
            body: JSON.stringify(image),
        }).then(function (response) {
            return response.json();
        }).then(function (result) {
            if (result.status == "success") {
                window.location.href = "/";
            } else if (result.status == "error") {
                alert(result.message);
            }
        });
    });
});
