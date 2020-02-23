
//vars
var img_panel;
var block_shot;
var button_panel;
var add_file_button;
var div_camera;
var input_box;
var shot;
var save_button;
var video;
var shot_box;
var delete_area;
var take_button;
var start_button;
var shots_panel;

var navigatorCamera; //1 - Google Chrome; 0 - MF

var bool_webcam; //включена ли камера.
var bool_shots; //есть ли на блоке изображение.*/

var constraints = {
    video: {
        width: { ideal: 1280 },
        height: { ideal: 720}
    }
};
var ratio = 1280 / 720;
var width = 300;
var height = width / ratio;

/************************************/

window.onload = function () {
	block_shot = document.getElementById('block_shot');
	add_file_button = document.getElementById('add_file_button');
	input_box = document.getElementById('input_box');
	button_panel = document.getElementById('button_panel');
	div_camera = document.getElementById('div_camera');
	delete_area = document.getElementById('delete_area');
	img_panel = document.getElementById('img_panel');
	shot = document.getElementById("shot");
	shots_panel = document.getElementById('shots_panel');
	img_panel.addEventListener('click', addToCamera);
	add_file_button.addEventListener('click', addFile);
	save_button = document.getElementById('save_button');
	save_button.addEventListener("click", sendImageData);
    save_button.disabled = true;
    video = document.getElementById('video');
	shot_box = document.getElementById('shot_box');
    take_button = document.getElementById('take_button');
	start_button = document.getElementById('start_button');

	bool_webcam = false;
	bool_shots = false;
	bool_add_file = false;


    function hasGetUserMedia() {
        return !!(navigator.getUserMedia || navigator.mozGetUserMedia);
    }

    if (hasGetUserMedia()) {
		navigatorCamera = navigator.mozGetUserMedia==undefined?1:0;
		//console.log(navigatorCamera);
        //console.log('getUserMedia is supported in this browser');
        start_button.addEventListener("click", startStopStream);
        if (bool_webcam){
            take_button.disabled;
        }
        take_button.addEventListener('click', takeShot);
    }
    else {
        //console.log('getUserMedia is not supported in this browser');
        take_button.remove();
        video.remove();
    }
}
/************************************/
/* работа с изображениями поверх */
function addToCamera(event) {
	let target = event.target;

	if (target.tagName != 'IMG')
		return;
	var img = target.cloneNode(true);
	img.style.position = 'absolute';
	img.style.zIndex = 10; // над другими элементами
	div_camera.appendChild(img);
	img.onmousedown = function(e) {
		var coords = getCoords(img);
		var shiftX = e.pageX - coords.left;
		var shiftY = e.pageY - coords.top;
		img.style.border = "2px solid red";

		div_camera.appendChild(img);
		moveAt(e);

		delete_area.onclick = function() {
			if (confirm("Delete?")) {
				delete_area.onmouseover = null;
				img.remove();
			}
		}
		
		function moveAt(e) {
			var coords = getCoords(div_camera);
			var blockX = e.pageX - coords.left;
			var blockY = e.pageY - coords.top;
			img.style.left = blockX - shiftX + 'px';
			img.style.top = blockY - shiftY + 'px';
			img.onmouseup = function() {
				blockX = (blockX - shiftX)<0?shiftX:blockX;
				blockY = (blockY - shiftY)<0?shiftY:blockY;
				img.style.left = (blockX - shiftX)>(330 - img.width - 3)?(330 - img.width - 3 + "px"):(blockX - shiftX + 'px');
				img.style.top = (blockY - shiftY)>(402 - img.height - 3)?(402 - img.height - 3 + "px"):(blockY - shiftY + "px");
				div_camera.onmousemove = null;
				img.onmouseup = null;
				img.style.border = null;
			};
		}

		div_camera.onmousemove = function(e) {
			moveAt(e);
		};
	  }
	  
	img.ondragstart = function() {
		return false;
	};
	
	/*координаты относительно elem*/
	function getCoords(elem) {
		var box = elem.getBoundingClientRect();
		return {
	  		top: box.top + pageYOffset,
	  		left: box.left + pageXOffset
		};
	}
}


/*удалить все потомки IMG */

function childImgDel(elem) {
	var child;
	for (var i = elem.children.length - 1; i >= 0; i -= 1) {
		child = elem.children[i];
		if (child.tagName === 'IMG') {
			elem.removeChild(child);
		}
	}
}

/* копировать все IMG из place в dest */

function childImgCopy(place, dest) {
	var child;
	for (var i = 0; i < place.children.length; i += 1) {
		child = place.children[i].cloneNode(true);
		if (child.tagName === 'IMG') {
			child.onmousedown = null;
			dest.appendChild(child);
		}
	}
}

/* копировать слайд */

function copySlide(place, dest, bool)
{
	var clonediv = place.cloneNode(true);
	if (bool) { //добавить функцию кликанья, если это перенос в панель изображений
		clonediv.addEventListener('click', addToBlockShot)
	}

	dest.appendChild(clonediv);
}

/*добавить слайд из панели снимков в блок снимка*/
function addToBlockShot() {
	//копируем из блока в panel
	copySlide(shot, shots_panel, 1);
	//удаляем наложенные картинки
	childImgDel(shot);

	for (var i = 0; i < shot_box.children.length; i += 1) {
		if (shot_box.children[i].id === 'main_img') {
			shot_box.children[i].parentNode.removeChild(shot_box.children[i]);
			break;
		}
	}

	for (var i = 0; i < this.children.length; i += 1) {
		if (this.children[i].id === 'shot_box') {
			shot_box.appendChild(this.children[i].firstChild);
			break;
		}
	}
	//добавляем наложенные картинки
	childImgCopy(this, shot);
	//удаляем с панели
	this.remove();
}


/************************************/
/* включить/выключить камеру*/
function startStopStream() {
    if (bool_webcam == false && video.srcObject == null) //если камера выключена - пытаемся включить
    {
		for (var i = 0; i < input_box.children.length; i += 1) {
			if (input_box.children[i].id === 'main_img') {
				input_box.children[i].parentNode.removeChild(input_box.children[i]);
				break;
			}
		}

		input_box.style.visibility = "hidden";

		if (navigatorCamera) {
			navigator.getUserMedia(constraints, function (stream) {
				video.srcObject = stream;
				bool_webcam = true;
				bool_add_file = false;
			}, function (err) {
				console.log("Error: " + err);
				alert('Something wrong with your webcam. You can use "add file".')
			});
		}
		else {
			navigator.mozGetUserMedia(constraints, function (stream) {
				video.srcObject = stream;
				bool_webcam = true;
				bool_add_file = false;
			}, function (err) {
				console.log("Error: " + err);
				alert('Something wrong with your webcam. You can use "add file".')
			});
		}
    }
    else if (bool_webcam == true){ //если камера включена - выключаем
		let stream = video.srcObject;
		let tracks = stream.getTracks();
    	tracks.forEach(function (track) {
    		track.stop();
		});
		video.srcObject = null;
		bool_webcam = false;
	}
}

/************************************/
/*сделать снимок*/

function takeShot() {

	//если на блоке снимка уже сть снимок - сначала копировать его на панель.
	if (bool_webcam || bool_add_file)
	{
		if (bool_shots) {
			copySlide(shot, shots_panel, 1);
		}
		childImgDel(shot);
		childImgCopy(div_camera, shot);
	}
    if (bool_webcam)
    {	
		for (var i = 0; i < shot_box.children.length; i += 1) {
			if (shot_box.children[i].id === 'main_img') {
				shot_box.children[i].parentNode.removeChild(shot_box.children[i]);
				break;
			}
		}

        var canv = document.createElement('canvas');
        var ctx = canv.getContext('2d');
        var img = new Image();
        
		ctx.translate(video.videoWidth, 0);
		ctx.scale(-1, 1);
        canv.width = video.videoWidth;
        canv.height = video.videoHeight;
		
		ctx.fillRect(0, 0, video.videoWidth, video.videoHeight);
		ctx.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
		img.src = canv.toDataURL();
		img.width = width;
		img.height = height;
        img.id = "main_img";
		shot_box.appendChild(img);
		ctx.fillRect(0, 0, width, height);
		save_button.disabled = false;
		bool_shots = true;
	}
	else if (bool_add_file) {

		for (var i = 0; i < shot_box.children.length; i += 1) {
			if (shot_box.children[i].id === 'main_img') {
				shot_box.children[i].parentNode.removeChild(shot_box.children[i]);
				break;
			}
		}

		for (var i = 0; i < input_box.children.length; i += 1) {
			if (input_box.children[i].id === 'main_img') {
				shot_box.appendChild(input_box.children[i].cloneNode(true));
				break;
			}
		}
		save_button.disabled = false;
		bool_shots = true;
	}
}
/************************************/
/* отправляем данные на сервер */

function sendImageData() {
	var forma = document.createElement('form');
	var formData = new FormData(forma);
	var overlay = new Array();
	var elem;
	var over_img;

	if (bool_shots) {
		var url = shot_box.firstChild.src;
		if (url.indexOf('blob') == 0)
		{
			img = shot_box.firstChild;
			var save_canvas = document.createElement('canvas');
			var save_ctx = save_canvas.getContext('2d');

			//console.log("imgwidth: " +img.naturalWidth);
			//console.log("imgheight: " +img.naturalHeight);
			save_canvas.width = img.naturalWidth;
			save_canvas.height = img.naturalHeight;
			save_ctx.drawImage(img, 0, 0);

			url = save_canvas.toDataURL('image/png');
		}
		formData.append('main_img', url);
	}

	for (var i = 0; i < shot.children.length; i += 1) {
		elem = shot.children[i];
		if (elem.tagName == 'IMG') {
			over_img = elem.id + "/";
			over_img += elem.style.left==""?"0":elem.style.left;
			over_img += "/";
			over_img += elem.style.top==""?"0":elem.style.top;
			overlay.push(over_img);
		}
	}

	formData.append('overlay', overlay);

	var request = new XMLHttpRequest();

	request.onload = () => {
		if (request.responseText == "true"){
			alert("Your image has been successfully uploaded!");
		}
	}

	request.open("POST", "../controllers/controller_new_photo.php", true);
	request.send(formData);
}

/************************************/
/* Добавить файл вместо видео*/

function addFile() {
	if (!document.getElementById('input_file')) {
		var elem_input = document.createElement('input');
		elem_input.type = 'file';
		elem_input.accept = ".jpg, .jpeg, .png";
		elem_input.id = "input_file";
		button_panel.appendChild(elem_input);
		var input = document.getElementById('input_file');

		input.addEventListener('change', function(e) {

			bool_add_file = true;
			if (bool_webcam) {
				startStopStream();	
			}

			for (var i = 0; i < input_box.children.length; i += 1) {
				if (input_box.children[i].id === 'main_img') {
					input_box.children[i].parentNode.removeChild(input_box.children[i]);
					break;
				}
			}

			input_box.style.visibility = 'visible';
			var url = URL.createObjectURL(e.target.files[0]);
			var img = new Image();
			img.id = "main_img";

			img.onload = function() {
				img.width = width;
				img.height = height;
			}
			img.src = url;
			this.parentElement.removeChild(this);
			input_box.append(img);
		});
	}
}


/************************************/