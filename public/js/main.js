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
        } else if (e.target.matches(".btn-edit")) {
            const postId = e.target.dataset.id;

            const resp = await fetch(`admin/${postId}/edit`);
            const res = await resp.json();

            if (res !== `false`) {
                const { post, categories } = res;
                console.log(categories);
                console.log(post);

                document.querySelector(".form-edit #title").value = post.title;
                document.querySelector(".form-edit #description").value =
                    post.description;
                document
                    .querySelector(".form-edit #image")
                    .parentElement.querySelector(".post-image")
                    ?.remove();
                document.querySelector(".form-edit #image").insertAdjacentHTML(
                    "beforebegin",
                    `
                    <img src=${
                        post.image
                            ? `../img/${post.image}`
                            : `../img/no-photo.jpg`
                    } class="card-img-top post-image w-25 d-inline-block col-1" alt="...">
                    `
                );

                document.querySelector("#category").innerHTML = "";

                const out = categories.map(
                    (cat) =>
                        `<option data-id="${cat.id}" ${
                            post.category_id === cat.id ? "selected" : ""
                        } value="${cat.name}">${cat.name}</option> `
                );

                document
                    .querySelector(".form-edit select")
                    .insertAdjacentHTML("beforeend", out.join(""));
            } else {
                const alert = `<div class="alert alert-danger">
                    Ошибка! Не удалось получить данные поста
                </div>`;
                document.querySelector(".alert")?.remove();

                document
                    .querySelector(".container")
                    .insertAdjacentHTML("afterbegin", alert);
            }
        }
    });
