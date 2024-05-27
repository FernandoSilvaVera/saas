@if($plan->id)

	<div class="pb_15">
		<h4 class="pb_5">Palabras restantes</h4>
		@if($currentSubscription->subscriptionPlan->unlimited_words)
			<p>Plan Sin límites</p>
		@else
			<p>{{$currentSubscription->palabras_maximas}}/{{$plan->word_limit}}</p>
		@endif
	</div>

	<div class="pb_15">
		<h4 class="pb_5">Suscripción de</h4>
		<p>{{$currentSubscription->email}}</p>
	</div>

	<div class="pb_15">
		<h4 class="pb_5">Plan Contratado</h4>
		<p>{{$plan->name}}</p>
	</div>

	@if(isset($nextDate))
		<div class="pb_15">
			<h4 class="pb_5">Próxima renovación</h4>
			<p>{{$nextDate}}</p>
		</div>
	@endif
@else

	<div class="alert alert-success text-center" role="alert">
		Los administradores no necesitan una suscripción para virtualizar.
	</div>

@endif
