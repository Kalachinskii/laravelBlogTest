document
    .querySelector(".content-container")
    .addEventListener("click", async (e) => {
        if (e.target.matches(".remove-favourites")) {
            e.preventDefault();
            const postId = e.target
                .closest("form")
                .querySelector('[name="postId"]').value;
            const token = document.querySelector('[name="_token"]').value;

            const resp = await fetch("/", {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": token,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ id: postId }),
            });
            const res = await resp.json();
            if (res === "0") {
                const alert = `<div class="alert alert-danger">
                    Ошибка! Не удалось удалить пост
                </div>`;
                document.querySelector(".alert")?.remove();

                document
                    .querySelector(".container")
                    .insertAdjacentHTML("afterbegin", alert);
            } else {
                const removeBtn = e.target
                    .closest("form")
                    .querySelector(".remove-favourites");
                const sibling = removeBtn.previousElementSibling;
                removeBtn.remove();
                sibling.insertAdjacentHTML(
                    "afterend",
                    '<button class="d-inline-block btn btn-warning add-favourites" type="submit">В избранное</button>'
                );
                const alert = `<div class="alert alert-success">
                Пост удален из избранного
            </div>`;
                document.querySelector(".alert")?.remove();
                document
                    .querySelector(".container")
                    .insertAdjacentHTML("afterbegin", alert);
            }
        }
    });
