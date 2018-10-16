$(function() {
	var $uploadCrop;

	function readFile(input) {
		
		$('.progress').empty();
		
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			
			reader.onload = function (e) {
				$('.cropper').show();
				$('.loader').hide();
				$('.image').addClass('ready');
				$uploadCrop.croppie('bind', {
					url: e.target.result
				}).then(function(){
					console.log('Upload ready');
				});
				$('.progress').empty();
			}
			
			reader.readAsDataURL(input.files[0]);
			
			reader.onprogress = function (data) {                                          
				$('.progress').html('Warten auf Vorschau...');
			}
		}
		else {
			swal("Ihr Browser unterstützt die FileReader API nicht :(");
		}
	}

	$uploadCrop = $('.image').croppie({
		viewport: {
			width: 200,
			height: 200,
			type: 'circle'
		},
		boundary: {
			width:250,
			height:250
		},
		enableExif: true
	});

	$('#upload').on('change', function () { readFile(this); });

	$('.show-preview').click(function() {
		$uploadCrop.croppie('result', {
			type: 'base64',
			size: {width: 300, height: 300}
		}).then(function(res) {
				$('.preview').show();
				$('.preview').html('<img src="'+res+'">');
				$('#base64').attr('value',res);
				$('.save-button').show();
				$('.go-back').show();
				$('.show-preview').hide();
			});
		});
	
	$('.go-back').click(function() {
		$('.show-preview').show();
		$('.preview').hide();
		$(this).hide();
		$('.save-button').hide();
	});
	
	$('.abort').click(function() {
		$('.cropper').hide();
		$('.loader').show();
		$('.preview').hide();
		$('.save-button').hide();
		$('.show-preview').show();
		$('.go-back').hide();
		$('#upload-form')[0].reset();
	});
});