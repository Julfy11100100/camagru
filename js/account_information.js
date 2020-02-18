
var button_login;
var button_email;
var button_password;

window.onload = function() {
	button_email = document.getElementById("button_new_email");
	button_login = document.getElementById("button_new_login");
	button_password = document.getElementById("button_new_password");

	button_email.addEventListener("click", formEmail);
	button_login.addEventListener("click", formLogin);
	button_password.addEventListener("click", formPassword);
}

function formEmail() {
	button_email.style.display = "none";
	button_login.style.display = "none";
	button_password.style.display = "none";

	document.getElementById("submit").style.display = "block";
	document.getElementById("old_password").style.display = "block";
	document.getElementById("email").style.display = "block";
}

function formLogin() {
	button_email.style.display = "none";
	button_login.style.display = "none";
	button_password.style.display = "none";

	document.getElementById("submit").style.display = "block";
	document.getElementById("old_password").style.display = "block";
	document.getElementById("login").style.display = "block";
}

function formPassword() {
	button_email.style.display = "none";
	button_login.style.display = "none";
	button_password.style.display = "none";

	document.getElementById("submit").style.display = "block";
	document.getElementById("old_password").style.display = "block";
	document.getElementById("new_password").style.display = "block";
}
