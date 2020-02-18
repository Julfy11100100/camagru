//var
var user;
var prev;
var next;
var number_of_page;


window.onload = function () {
	document.body.addEventListener("click", mainFunctionForImageBlock)
	prev = document.getElementById("prev");
	next = document.getElementById("next");
	number_of_page = document.getElementById("number_of_page");
	number_of_page.value = 0;

	prev.addEventListener('click', prevPage);
	next.addEventListener('click', nextPage);

	user = "testUSER111";
}
/*********************************** */
function prevPage() {
	if (number_of_page.value > 0) {
		number_of_page.value--;
	}
}

function nextPage() {
	number_of_page.value++;
}

function changePage(){
	
}

/*********************************** */


function findChildrenByClassname(parent, className) {
	for (var i = 0; i < parent.children.length; i += 1){
		if (parent.children[i].className != undefined) {
			if (parent.children[i].className == className) {
				return (parent.children[i]);
			}
		}
	}
}

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
	text = prompt("Create your comment (max 100 characters)");
	if (text != null) {
		if (text.length > 100 || text.length < 1){
			alert ("Comment must contain more than 0 and less than 100 characters")
		}
		else {
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
		}
	}
}

function addLike(target) {
	let like = findChildrenByClassname(target.parentNode, "logo_like2");
	like.style.display = "inline-block";
	target.style.display = "none";
}

function removeLike(target){
	let unlike = findChildrenByClassname(target.parentNode, "logo_like1");
	unlike.style.display = "inline-block";
	target.style.display = "none";
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