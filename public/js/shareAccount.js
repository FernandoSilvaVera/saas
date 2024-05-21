function update() {
	var inputs = document.getElementsByName('editores[]');
	var values = [];

	for (var i = 0; i < inputs.length; i++) {
		values.push(inputs[i].value);
	}

	document.getElementById('editoresArray').value = JSON.stringify(values);
	document.getElementById('updateForm').submit();
}
