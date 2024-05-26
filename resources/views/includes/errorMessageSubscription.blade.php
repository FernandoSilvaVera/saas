@if(isset($errorMessageSubscription))
	<div id="success-errorMessageSubscription" class="alert alert-danger alert-dismissible fade show" role="alert">
		Es necesario tener una suscripción activa para virtualizar
	</div>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var successMessage = document.getElementById('success-errorMessageSubscription');
		});
	</script>

	@php exit; @endphp <!-- Detener la ejecución del programa aquí -->

@endif
