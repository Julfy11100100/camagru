
var button_login;
var button_email;
var button_password;
var button_change;
var status1;
var status2;

window.onload = function() {
	button_email = document.getElementById("button_new_email");
	button_login = document.getElementById("button_new_login");
	button_password = document.getElementById("button_new_password");
	button_change = document.getElementById("button_change");
	status1 = document.getElementById("comment_status1");
	status2 = document.getElementById("comment_status2");
	checkStatus();

	button_email.addEventListener("click", formEmail);
	button_login.addEventListener("click", formLogin);
	button_password.addEventListener("click", formPassword);
	button_change.addEventListener("click", changeStatus);
}

function formEmail() {
	button_email.style.display = "none";
	button_login.style.display = "none";
	button_password.style.display = "none";
	button_change.style.display = "none";
	status1.style.display = "none";
	status2.style.display = "none";

	document.getElementById("submit").style.display = "block";
	document.getElementById("old_password").style.display = "block";
	document.getElementById("email").style.display = "block";
}

function formLogin() {
	button_email.style.display = "none";
	button_login.style.display = "none";
	button_password.style.display = "none";
	button_change.style.display = "none";
	status1.style.display = "none";
	status2.style.display = "none";

	document.getElementById("submit").style.display = "block";
	document.getElementById("old_password").style.display = "block";
	document.getElementById("login").style.display = "block";
}

function formPassword() {
	button_email.style.display = "none";
	button_login.style.display = "none";
	button_password.style.display = "none";
	button_change.style.display = "none";
	status1.style.display = "none";
	status2.style.display = "none";

	document.getElementById("submit").style.display = "block";
	document.getElementById("old_password").style.display = "block";
	document.getElementById("new_password").style.display = "block";
}

function checkStatus() {
	const request = new XMLHttpRequest();
	const url = "../controllers/controller_account_information.php";
	const params = "check_status=" + 1;

	request.onload = () => {
		let responseObject = null;

		try {
			responseObject = JSON.parse(request.responseText);
		} catch (e) {
			console.error("Could not parse JSON!");
		}
		if (responseObject) {
			if (responseObject["status"] == 1) {
				status1.style.display = "block";
				status2.style.display = "none";
			}
			else {
				status1.style.display = "none";
				status2.style.display = "block";
			}
		}
	}
	request.open("POST", url, true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(params);
}

function changeStatus() {
	const request = new XMLHttpRequest();
	const url = "../controllers/controller_account_information.php";
	const params = "change_status=" + 1;

	request.onload = () => {
		checkStatus();
	}
	request.open("POST", url, true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(params);
}