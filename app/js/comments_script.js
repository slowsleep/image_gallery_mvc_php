let commentsButton = document.querySelectorAll("#commentsButton");

commentsButton.forEach(element => {
    element.addEventListener("click", function (event) {
        event.preventDefault();

        fetch("app/handlers/getComments_handler.php", {
            method: "POST",
            body: JSON.stringify({
                id: this.dataset.id
            })
        }).then(function (response) {
            return response.json();
        }).then(function (result) {
            let comments = document.querySelector("#comments");
            comments.innerHTML = "";

            if (result.status == "success") {
                let curUserId = result.currentUserId;

                for (let comment of result.comments) {
                    let newComment = createCommentDiv(comment, curUserId);
                    comments.appendChild(newComment);
                }
                
            } else if (result.status == "error") {
                comments.innerHTML = result.message;
            }
        });

        let commentsForm = document.querySelector("#commentsForm");

        if (commentsForm) {
            commentsForm.querySelector("[name='image_id']").value = this.dataset.id;
            commentsForm.addEventListener("submit", sendComment);
            let modal = document.querySelector("#modalComments");
            modal.addEventListener("hidden.bs.modal", function () {
                commentsForm.removeEventListener("submit", sendComment);
            });
        }
    });
});



function createCommentDiv(comment, currentUserId = null) {
    let newComment = document.createElement("div");
    newComment.classList.add("mb-3", "shadow", "rounded", "p-2", "m-1");
    let editCommentDiv = null;

    let newCommentHeader = document.createElement("div");
    newCommentHeader.classList.add("d-flex", "justify-content-between");

    let newCommentUsername = document.createElement("p");
    newCommentUsername.classList.add("small");
    newCommentUsername.textContent = comment["username"];

    let newCommentTime = document.createElement("p");
    newCommentTime.classList.add("small");
    newCommentTime.textContent = comment["updated_at"] ? comment["updated_at"] : comment["created_at"];

    newCommentHeader.appendChild(newCommentUsername);
    newCommentHeader.appendChild(newCommentTime);
    newComment.appendChild(newCommentHeader);

    let newCommentComment = document.createElement("p");
    newCommentComment.classList.add("m-0");
    newCommentComment.textContent = comment["content"];

    newComment.appendChild(newCommentComment);

    if (currentUserId == comment["user_id"]) {
        editCommentDiv = document.createElement("div");
        editCommentDiv.classList.add("d-flex", "justify-content-end");

        let newCommentDeleteButton = document.createElement("button");
        newCommentDeleteButton.innerHTML = '<i class="bi bi-trash"></i>';
        newCommentDeleteButton.id = "deleteCommentButton";
        newCommentDeleteButton.title = "Удалить";
        newCommentDeleteButton.classList.add("btn", "btn-danger", "p-0" , "h-100");
        newCommentDeleteButton.addEventListener("click", function (event) {
            event.preventDefault();
            console.log("delete", comment["id"]);
            fetch("app/handlers/deleteComment_handler.php", {
                method: "POST",
                body: JSON.stringify({
                    id: comment["id"]
                })
            }).then(function (response) {
                return response.json();
            }).then(function (result) {
                if (result.status == "success") {
                    newComment.remove();
                } else if (result.status == "error") {
                    alert(result.message);
                }
            });
        });

        editCommentDiv.appendChild(newCommentDeleteButton);
        newComment.appendChild(editCommentDiv);
    }

    return newComment;
}

function sendComment(event) {
    event.preventDefault();
    let formData = new FormData(commentsForm);

    fetch("app/handlers/sendComment_handler.php", {
        method: "POST",
        body: formData
    }).then(function (response) {
        return response.json();
    }).then(function (result) {

        if (result.status == "success") {
            let comments = document.querySelector("#comments");

            if (comments.children.length == 0) {
                comments.innerHTML = "";
            }

            let newComment = createCommentDiv(result.comment, result.currentUserId);
            comments.appendChild(newComment);
        } else if (result.status == "error") {
            comments.innerHTML = result.message;
        }
    });
}
