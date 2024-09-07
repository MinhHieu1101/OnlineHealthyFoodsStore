const sign_up_btn = document.getElementById("sign-up");
const sign_in_btn = document.getElementById("sign-in");
const account = document.getElementById("account-container");

//transition of account page
sign_up_btn.addEventListener("click", () => {
	account.classList.add("panel-active");
});

sign_in_btn.addEventListener("click", () => {
	account.classList.remove("panel-active");
});