@if($plan->id)

	<div class="pb_15">
		<h4 class="pb_5">Palabras</h4>
		@if($currentSubscription->subscriptionPlan->unlimited_words)
			<p>Plan Sin límites</p>
		@else
			<p>{{$currentSubscription->palabras_maximas}}/{{$plan->word_limit}}</p>
		@endif
	</div>

	<div class="pb_15">
		<h4 class="pb_5">Preguntas</h4>
		<p>{{$currentSubscription->numero_preguntas}}/{{$plan->test_questions_count}}</p>
	</div>

	<div class="pb_15">
		<h4 class="pb_5">Resumenes</h4>
		<p>{{$currentSubscription->numero_resumenes}}/{{$plan->summaries}}</p>
	</div>

	<div class="pb_15">
		<h4 class="pb_5">Mapa Conceptual</h4>
		<p>{{$currentSubscription->numero_mapa_conceptual}}/{{$plan->concept_map}}</p>
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
