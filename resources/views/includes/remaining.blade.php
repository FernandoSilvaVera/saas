<div class="pb_15">
	<h4 class="pb_5">Suscripción de</h4>
	<p>{{$currentSubscription->email}}</p>
</div>

<div class="pb_15">
	<h4 class="pb_5">Plan Contratado</h4>
	<p>{{$plan->name}}</p>
</div>

<div class="pb_15">
	<h4 class="pb_5">Palabras restantes</h4>
	<p>{{$currentSubscription->palabras_maximas}}/{{$plan->word_limit}}</p>
</div>

<div class="pb_15">
	<h4 class="pb_5">Nº Preguntas Tipo Test</h4>
	<p>{{$currentSubscription->numero_preguntas}}/{{$plan->test_questions_count}}</p>
</div>
<div class="pb_15">
	<h4 class="pb_5">Nº de resumenes</h4>
	<p>{{$currentSubscription->numero_resumenes}}/{{$plan->summaries}}</p>
</div>

<div class="pb_15">
	<h4 class="Editors pb_5">Editores Máximos: {{$plan->editors_count}}</h4>

	@foreach(json_decode($currentSubscription->otros_usuarios) as $email)
	    <p>{{$email}}</p>
	@endforeach
</div>

@if(isset($nextDate))
	<div class="pb_15">
		<h4 class="pb_5">Próxima renovación</h4>
		<p>{{$nextDate}}</p>
	</div>
@endif
