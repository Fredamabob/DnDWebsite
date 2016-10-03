function autocompleter() {
	var min_length = 1;
	var search = $('#name_id').val();
	var key = $('#key').val();
	var type = $('input[name=type]:checked').val();
	if (search.length >= min_length) {
		$.ajax({
			url: 'js/refresh.php',
			type: 'POST',
			data: {search: search, type: type, key: key},
			success:function(data){
				$('#name_list_id').show();
				$('#name_list_id').html(data);
			}
		});
	} else {
		$('#name_list_id').hide();
	}
}

function set_item(item) {
	$('#name_id').val(item);
	$('#name_list_id').hide();
}