const buttonSearch = document.querySelector("#abrir")
const modal = document.querySelector("#modal")
const close = document.querySelector("#fechar")

buttonSearch.addEventListener("click", () => {
    modal.classList.remove("hide")
})

close.addEventListener("click", () => {
    modal.classList.add("hide")
})

   