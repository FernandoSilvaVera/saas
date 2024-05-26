function desactivar(id){
	var plan = {};
	plan.id = id
	var apiUrl = '/api/plan/desactive';
	$.ajax({
		url: apiUrl,
		type: 'POST',
		contentType: 'application/json',
		data: JSON.stringify(plan),
		success: function(data) {
			location.reload();
		},
		error: function(xhr, status, error) {

		}
	});
}

function activar(id)
{
	var plan = {};
	plan.id = id
	var apiUrl = '/api/plan/active';
	$.ajax({
		url: apiUrl,
		type: 'POST',
		contentType: 'application/json',
		data: JSON.stringify(plan),
		success: function(data) {
			location.reload();
		},
		error: function(xhr, status, error) {

		}
	});
}

function desactivarConfirm(id)
{
	desactivar(id)
}

function activarConfirm(id)
{
	activar(id)
}
