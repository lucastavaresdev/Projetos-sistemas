//=========================================================================================
// Uploads
//=========================================================================================
function windowUpload(tabid, idx) {

	totalSlots = 3;

	for (var i=1; i <= totalSlots; i++) {

		var anexo 		= _data[idx]['anexo' + i],
			filename 	= byid('filename' + i),
			label 		= byid('label' + i),
			button 		= byid('button' + i);

		if (anexo) {

			if (filename) {
				filename.value = anexo;
				filename.setAttribute('onclick','openLink(this)');
				filename.addClass('filelink');
			}

			if (label)
				label.innerText = 'Remover';

			if (button)
				button.setAttribute('onclick', "deleteFile('" + i + "')");

		} else {
			
			if (filename) {
				filename.value = '';
				filename.removeAttribute('onclick');
				filename.removeClass('filelink');
			}

			if (label)
				label.innerText = 'Selecionar Arquivo';

			if (button)
				button.setAttribute('onclick', "fileBrowser('" + i + "')");
			
		}
		
		if (button)
			button.disabled = false;

	}

	if (tabid && idx) {

		_data.index = idx;
		pageTab(tabid);

	}

}

//=========================================================================================
// File Browser
//=========================================================================================
function fileBrowser(slot) {

	if (slot) {

		var input = byid('file' + slot);

		if (input)
			input.click();

	}

}

// =====================================================================================
// FileType Validation
// =====================================================================================
function fileValidation(_this, slot) {

	if (typeof _this == 'object') {

		var file = _this.files[0];

		if (file) {

			var filename = file.name;
			var filesize = file.size.kb();
			

			if ((file.size / 1000) > 5000) {
				ajaxStatus('5', 2, 'Arquivo maior que 5MB');
				return;
			}

			if (filename && filesize) {

				var filename_input = byid('filename' + slot);

				if (filename_input) {

					filename_input.value = s("$0 [$1]", filename, filesize);

					var button = byid('button' + slot);
					var label = byid('label' + slot);

					if (label && button) {

						label.innerHTML = "<i class='fa fa-spinner fa-spin'></i><label>Aguarde</label>";
						button.disabled = true;

					}

				}

			}

			if (file.type == 'image/jpeg' || file.type == 'image/png') {

				preloadImage(file, slot);

			} else {

				preloadFile(file, slot);

			}

		}

	}

}

// =====================================================================================
// Preload Image
// =====================================================================================
function preloadImage(file, slot) {

	if (typeof file == 'object') {

		var url = URL.createObjectURL(file);
		var filename = file.name;

		var canvas =  document.createElement('CANVAS');

		var ctx = canvas.getContext('2d');
			ctx.mozImageSmoothingEnabled = false;
			ctx.webkitImageSmoothingEnabled = false;
			ctx.msImageSmoothingEnabled = false;
			ctx.imageSmoothingEnabled = false;

		var img = new Image();

			img.onload = function() {

				var r = resizeImage(this.width, this.height);

				canvas.width = r.width;
				canvas.height = r.height;

				ctx.drawImage(this, 0, 0, r.width, r.height);

				var dataURL = canvas.toDataURL();

				uploadImage(dataURL, filename, slot);

			}

			img.src = url;

	}

}

// =====================================================================================
// Resize Image
// =====================================================================================
function resizeImage(width, height) {

	var MAX_WIDTH = 2000;
	var MAX_HEIGHT = 2000;

	if (width > height) {

		if (width > MAX_WIDTH) {

			height *= MAX_WIDTH / width;
			width = MAX_WIDTH;

		}

	} else {

		if (height > MAX_HEIGHT) {

			width *= MAX_HEIGHT / height;
			height = MAX_HEIGHT;

		}

	}

	var size = {
		width: Math.floor(width),
		height: Math.floor(height)
	}

	return size;

}

// =====================================================================================
// Upload Image
// =====================================================================================
function uploadImage(file, filename, slot) {

	if (file && slot && filename) {

		var control = byid('control' + slot);
			control.removeClass('upload-close');
			control.addClass('upload-open');

		var ajaxData = {
			file: file,
			filename: filename,
			command: 'uploadImage',
			id: _data[_data.index].id,
			slot: slot,
			upload: true,
			tabid: '3',
			success: uploadSuccess,
			warning: uploadError,
			error: uploadError
		}

		ajaxQuery(ajaxData);
		
	}

}

// =====================================================================================
// Upload File
// =====================================================================================
function preloadFile(file, slot) {

	if (file && slot) {

		var ajaxData = {
			file: file,
			command: 'upload',
			id: _data[_data.index].id,
			slot: slot,
			upload: true,
			tabid: '3',
			success: uploadSuccess,
			warning: uploadError,
			error: uploadError
		}

		ajaxQuery(ajaxData);

	}

}

// =====================================================================================
// Upload Success
// =====================================================================================
function uploadSuccess(data, ajaxData) {

	if (data && ajaxData) {

		var slot 		= ajaxData.slot;
		var button		= byid('button' + slot);
		var label		= byid('label' + slot);
		var filename	= byid('filename' + slot);
		var control		= byid('control' + slot);
		var bar			= byid('uploadbar' + slot);

		if (button && label && filename && control && bar) {

			label.innerText = 'Remover';
			button.setAttribute('onclick', 'deleteFile(' + slot + ')');
			button.disabled = false;
			filename.value = data;
			filename.setAttribute('onclick','openLink(this)');
			filename.addClass('filelink');

			control.removeClass('upload-open');
			control.addClass('upload-close');
			bar.style.width = '0px';

			_data[_data.index]['anexo' + slot] = data;

		} else {

			console.log('Um ou mais elementos necessários não foram encontrados');

		}

	}

}

// =====================================================================================
// Upload Error
// =====================================================================================
function uploadError(data, ajaxData) {
	
	console.log(data);
	console.log(ajaxData);
	if (data && ajaxData) {

		var slot = ajaxData.slot;
		var button		= byid('button' + slot);
		var label		= byid('label' + slot);

		if (slot && label && button) {

			label.innerText = 'Selecionar Arquivo';
			button.setAttribute('onclick', 'fileBrowser(' + slot + ')');
			button.disabled = false;

		}

	}

}

//=========================================================================================
// Upload Progress
//=========================================================================================
function uploadProgress(e, slot){
	
	if (e.lengthComputable) {

        var max 		= e.total,
			current 	= e.loaded,
			percentage 	= parseInt((current * 100) / max),
			bar			= byid('uploadbar' + slot);

		if (bar)
			bar.style.width = percentage + '%';
		
	}

}

//=========================================================================================
// Delete File
//=========================================================================================
function deleteFile(slot) {

	var ajaxData = {
		command: 'deletarUpload',
		id: _data[_data.index].id,
		filename: _data[_data.index]['anexo' + slot],
		remove: slot,
	}

	ajaxQuery(ajaxData);

}

//=========================================================================================
// Data Remove
//=========================================================================================
function dataRemove(slot) {

	if (slot) {

		var file		= byid('file' + slot);
		var filename	= byid('filename' + slot);
		var button 		= byid('button' + slot);
		var label 		= byid('label' + slot);

		if (file && filename && button && label) {

			file.value = '';
			filename.value = '';
			filename.removeAttribute('onclick');
			filename.removeClass('filelink');
			label.innerText = 'Selecionar Arquivo';
			button.setAttribute('onclick', 'fileBrowser(' + slot + ')');
			_data[_data.index]['anexo' + slot] = '';

		}

	}

}

//=========================================================================================
// Open Link
//=========================================================================================
function openLink(_this) {

	if (_this) {

		var filename = _this.value;

		if (filename)
			window.open(_upload + filename, '_blank');

	}

}