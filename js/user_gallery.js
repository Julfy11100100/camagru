//var
var user;
var prev;
var next;
var number_of_page;
var main_gallery;
var authorization;
var max_page;


window.onload = function () {
	document.body.addEventListener("click", mainFunctionForImageBlock)
	main_gallery = document.getElementById("main_gallery");
	prev = document.getElementById("prev");
	next = document.getElementById("next");
	number_of_page = document.getElementById("number_of_page");
	number_of_page.value = 0;
	
	checkAuthorizationAndGetMaxPage();
	sendNumberOfPage();

	prev.addEventListener('click', prevPage);
	next.addEventListener('click', nextPage);
}

function checkAuthorizationAndGetMaxPage(){
	const request = new XMLHttpRequest();
	const url = "../controllers/controller_user_gallery.php";
	const params = "authorization=" + 1;

	request.onload = () => {
		let responseObject = null;

		try {
			responseObject = JSON.parse(request.responseText);
		} catch (e) {
			console.error("Could not parse JSON!");
		}
		if (responseObject) {
			if (responseObject["authorization"] == 1) {
				authorization = 1;
			}
			else {
				authorization = 0;
			}
			max_page = responseObject["max_page"];
		}
	}
	request.open("POST", url, true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(params);
}

/*********************************** */
function prevPage() {
	if (number_of_page.value === "") {
		number_of_page.value = 0;
	}
	else if (number_of_page.value > 0) {
		number_of_page.value--;
		sendNumberOfPage();
	}
}

function nextPage() {
	if (number_of_page.value < (max_page - 1)) {
		number_of_page.value++;
		sendNumberOfPage();
	}
}

function sendNumberOfPage(){
	const request = new XMLHttpRequest();
	const url = "../controllers/controller_user_gallery.php";
	const params = "number_of_page=" + number_of_page.value;

	request.onload = () => {
		let responseObject = null;

		try {
			responseObject = JSON.parse(request.responseText);
		} catch (e) {
			console.error("Could not parse JSON!");
		}

		if (responseObject) {
			clearMainGellery();
			showImages(responseObject);
		}
	}
	
	request.open("POST", url, true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(params);
}

function showImages(responseObject) {
	let image_block;
	let name_panel;
	let span_username;
	let span_date;
	let image_of_user;
	let img_src;
	let like_comment_panel;
	let comments_logo;
	let logo_comment;
	let span_count_comments;
	let logo_plus;
	let like_logo;
	let logo_like1;
	let logo_like2;
	let span_count_likes;
	let comments_block;
	let comment;
	let comment_name;
	let comment_text;

	for (var i = 0; i < responseObject.length;i++){

		/*Пустой карскас*/
		image_block = myCreateElement("div",1,"image_block");
		name_panel = myCreateElement("div", 1, "name_panel");
		span_username = myCreateElement("span", 1, "span_username");
		span_date = myCreateElement("span", 1, "span_date");
		logo_delete = myCreateElement("img", 1, "logo_delete");
		image_of_user = myCreateElement("div", 1, "image_of_user");
		img_src = myCreateElement("img", 1, "img_src");
		like_comment_panel = myCreateElement("div", 1, "like_comment_panel");
		comments_logo = myCreateElement("div", 1, "comments_logo");
		logo_comment = myCreateElement("img", 1, "logo_comment");
		span_count_comments = myCreateElement("span", 1, "span_count_comments");
		logo_plus = myCreateElement("img", 1, "logo_plus");
		like_logo = myCreateElement("div", 1, "like_logo");
		logo_like1 = myCreateElement("img", 1, "logo_like1");
		logo_like2 = myCreateElement("img", 1, "logo_like2");
		span_count_likes = myCreateElement("span", 1, "span_count_likes");
		comments_block = myCreateElement("div", 1, "comments_block");
		
		like_logo.appendChild(logo_like1);
		like_logo.appendChild(logo_like2);
		like_logo.appendChild(span_count_likes);
		comments_logo.appendChild(logo_comment);
		comments_logo.appendChild(span_count_comments);
		comments_logo.appendChild(logo_plus);
		like_comment_panel.appendChild(comments_logo);
		like_comment_panel.appendChild(like_logo);
		image_of_user.appendChild(img_src);
		name_panel.appendChild(span_username);
		name_panel.appendChild(span_date);
		name_panel.appendChild(logo_delete);
		image_block.appendChild(name_panel);
		image_block.appendChild(image_of_user);
		image_block.appendChild(like_comment_panel);
		image_block.appendChild(comments_block);
		main_gallery.appendChild(image_block);
		logo_delete.src = "/img/svg/close.svg";
		logo_comment.src = "/img/svg/comments.svg";
		logo_plus.src = "/img/svg/plus.svg";
		logo_like1.src = "/img/svg/like1.svg";
		logo_like2.src = "/img/svg/like2.svg";
		/****************************************/
		/* Заполняем данными */
		span_username.innerHTML = responseObject[i]["login"];
		span_date.innerHTML = responseObject[i]["date"];
		img_src.src = "/img/user_img/" + responseObject[i]["login"] + "/"
		+ responseObject[i]["title"];
		span_count_comments.innerHTML = responseObject[i]["count_of_comments"];
		span_count_likes.innerHTML = responseObject[i]["count_of_likes"];
		if (responseObject[i]["userlike"] == "0"){
			logo_like2.style.display = "none";
		}
		else {
			logo_like1.style.display = "none";
		}
		for (var j = 0; j < responseObject[i]["comments"].length; j++){
			comment = myCreateElement("div", 1, "comment");
			comment_name = myCreateElement("span", 0, "comment_name");
			comment_text = myCreateElement("span", 0, "comment_text");

			comment.appendChild(comment_name);
			comment.appendChild(comment_text);
			comments_block.appendChild(comment);

			comment_name.innerHTML = responseObject[i]["comments"][j]["login"];
			comment_text.innerHTML = responseObject[i]["comments"][j]["comment"];
		}


		/****************************************/
	}
}

//удаляем все изображения
function clearMainGellery(){
	while (main_gallery.firstChild) {
		main_gallery.firstChild.remove();
	}
}

// функция для быстрого createElement;
function myCreateElement(type, boolClass, name) {
	var buf = document.createElement(type);
	if (boolClass) {
		buf.className = name;
	}
	else {
		buf.id = name;
	}
	return (buf);
}

/*********************************** */

//найти потомка по классу
function findChildrenByClassname(parent, className) {
	for (var i = 0; i < parent.children.length; i += 1){
		if (parent.children[i].className != undefined) {
			if (parent.children[i].className == className) {
				return (parent.children[i]);
			}
		}
	}
}

// лайки, комменты все дела
function mainFunctionForImageBlock(elem) {
	let target = elem.target;

	if (target.className != undefined) {
		if (target.className == "logo_comment")
		{
			showComments(target);
		}
		else if (target.className == "logo_plus") {
			addComment(target);
		}
		else if (target.className == "logo_like1" || target.className == "logo_like2")
		{
			if (target.className == "logo_like1"){
				addLike(target);
			}
			else {
				removeLike(target);
			}
		}
		else if (target.className == "logo_delete") {
			deleteImage(target);
		}
	}
}

function showComments(target) {
	let image_block = target.parentNode.parentNode.parentNode;
	let comments_block = findChildrenByClassname(image_block, "comments_block");
	if (comments_block.style.display == "block") {
		comments_block.style.display = "none";
	}
	else {
		comments_block.style.display = "block";
	}
}

function addComment(target) {
	if (!authorization) {
		alert ("please log in");
	}
	else {
		text = prompt("Create your comment (max 140 characters)");
		if (text != null) {
			if (text.length > 140 || text.length < 1){
				alert ("Comment must contain more than 0 and less than 140 characters")
			}
			else {
				let image_block = target.parentNode.parentNode.parentNode;
				let image_of_user = findChildrenByClassname(image_block, "image_of_user");
				let img = findChildrenByClassname(image_of_user, "img_src");
				let src = img.src.split("").reverse().join("");
				src = src.substr(0, 20).split("").reverse().join("");

				const request = new XMLHttpRequest();
				const url = "../controllers/controller_user_gallery.php";
				const params = "comment_img=" + src + "&comment_text=" + text;
				request.responseType =	"json";
				request.onload = () => {
					let comment_name = document.createElement("span");
					let comment_text = document.createElement("span");
					let comment = document.createElement("div");
					let image_block = target.parentNode.parentNode.parentNode;
					let comments_block = findChildrenByClassname(image_block, "comments_block");

					comment_name.id = "comment_name";
					comment_text.id = "comment_text";
					comment.className = "comment";

					comment_name.textContent = user;
					comment_text.textContent = text;
					comment.appendChild(comment_name);
					comment.appendChild(comment_text);
					comments_block.appendChild(comment);
					sendNumberOfPage();
				}

				request.open("POST", url, true);
				request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				request.send(params);
			}
		}
	}
}

function addLike(target) {
	if (!authorization) {
		alert ("please log in");
	}
	else {
		//получаем src изображения
		let image_block = target.parentNode.parentNode.parentNode;
		let image_of_user = findChildrenByClassname(image_block, "image_of_user");
		let img = findChildrenByClassname(image_of_user, "img_src");
		let src = img.src.split("").reverse().join("");
		src = src.substr(0, 20).split("").reverse().join("");
		
		const request = new XMLHttpRequest();
		const url = "../controllers/controller_user_gallery.php";
		const params = "new_like=" + src;
		request.onload = () => {
			let like = findChildrenByClassname(target.parentNode, "logo_like2");
			like.style.display = "inline-block";
			target.style.display = "none";
			sendNumberOfPage();
		}
		
		request.open("POST", url, true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.send(params);
	}
}

function removeLike(target){
	//получаем src изображения
	let image_block = target.parentNode.parentNode.parentNode;
	let image_of_user = findChildrenByClassname(image_block, "image_of_user");
	let img = findChildrenByClassname(image_of_user, "img_src");
	let src = img.src.split("").reverse().join("");
	src = src.substr(0, 20).split("").reverse().join("");

	const request = new XMLHttpRequest();
	const url = "../controllers/controller_user_gallery.php";
	const params = "remove_like="+ src;
	request.onload = () => {0
		let unlike = findChildrenByClassname(target.parentNode, "logo_like1");
		unlike.style.display = "inline-block";
		target.style.display = "none";
		sendNumberOfPage();
	}
	
	request.open("POST", url, true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(params);
}

function deleteImage(target) {
	if (confirm("Delete this image?")){
		let image_block = target.parentNode.parentNode;
		let image_of_user = findChildrenByClassname(image_block, "image_of_user");
		let img = findChildrenByClassname(image_of_user, "img_src");
		let src = img.src.split("").reverse().join("");
		src = src.substr(0, 20).split("").reverse().join("");
		
		const request = new XMLHttpRequest();
		const url = "../controllers/controller_user_gallery.php";
		const params = "delete_img="+ src;
		request.onload = () => {
			sendNumberOfPage();
		}
		
		request.open("POST", url, true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.send(params);
	}
}

function showCommentConsole() {
	
	text = prompt("Create your comment (max 100 characters)");
	if (text != null) {
		if (text.length > 100 || text.length < 1){
			alert ("Comment must contain more than 0 and less than 100 characters")
		}
		else {
			let comment_name = document.createElement("span");
			let comment_text = document.createElement("span");
			let comment = document.createElement("div");

			comment_name.id = "comment_name";
			comment_text.id = "comment_text";
			comment.className = "comment";

			comment_name.textContent = user;
			comment_text.textContent = text;
			comment.appendChild(comment_name);
			comment.appendChild(comment_text);
			comments_block.appendChild(comment);
		}
	}
}
/*********************************************** */