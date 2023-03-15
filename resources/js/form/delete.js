// get element from dom
const deleteForms = document.querySelectorAll(".delete-form");

deleteForms.forEach((form) => {
    // event listener on submit
    form.addEventListener("submit", (e) => {
        //stop event submit
        e.preventDefault();

        // get title from custom attribute
        const title = form.getAttribute("data-form");

        // ask delete confirmation
        const confirm = window.confirm(`Vuoi davvero cancellare "${title}"?`);

        // if yes, submit
        if (confirm) form.submit();
    });
});
