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
                for (let comment of result.comments) {
                    let newComment = createCommentDiv(comment["username"], comment["created_at"], comment["content"]);
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



function createCommentDiv(username, time, comment) {
    let newComment = document.createElement("div");
    newComment.classList.add("mb-3", "shadow", "rounded", "p-2", "m-1");

    let newCommentHeader = document.createElement("div");
    newCommentHeader.classList.add("d-flex", "justify-content-between");

    let newCommentUsername = document.createElement("p");
    newCommentUsername.classList.add("small");
    newCommentUsername.textContent = username;

    let newCommentTime = document.createElement("p");
    newCommentTime.classList.add("small");
    newCommentTime.textContent = time;

    newCommentHeader.appendChild(newCommentUsername);
    newCommentHeader.appendChild(newCommentTime);
    newComment.appendChild(newCommentHeader);

    let newCommentComment = document.createElement("p");
    newCommentComment.classList.add("m-0");
    newCommentComment.textContent = comment;

    newComment.appendChild(newCommentComment);

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

            let newComment = createCommentDiv(result.comment["username"], result.comment["created_at"], result.comment["content"]);
            comments.appendChild(newComment);
        } else if (result.status == "error") {
            comments.innerHTML = result.message;
        }
    });
}