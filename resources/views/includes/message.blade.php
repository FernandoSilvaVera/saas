@if(isset($message))
	<div id="success-message" class="alert alert-success alert-dismissible fade show" role="alert">
		{{$message}}
	</div>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var successMessage = document.getElementById('success-message');
			if (successMessage) {
				setTimeout(function() {
					successMessage.remove();
				}, 6000); // 5000 milisegundos = 5 segundos
			}
		});
	</script>
@endif
