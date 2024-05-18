<div class="pb_15">
	<h4 class="pb_5">Plan Contratado</h4>
	<p>{{$plan->name}}</p>
</div>
<div class="pb_15">
	<h4 class="pb_5">Palabras restantes</h4>
	<p>{{$currentSubscription->palabras_maximas}}/{{$plan->word_limit}}</p>
</div>
<div class="pb_15">
	<h4 class="Editors pb_5">Editores</h4>
	<p>{{$currentSubscription->numero_editores}}/{{$plan->editors_count}}</p>
</div>
<div class="pb_15">
	<h4 class="pb_5">Nº Preguntas Tipo Test</h4>
	<p>{{$currentSubscription->numero_preguntas}}/{{$plan->test_questions_count}}</p>
</div>
<div class="pb_15">
	<h4 class="pb_5">Nº de resumenes</h4>
	<p>{{$currentSubscription->numero_resumenes}}/{{$plan->summaries}}</p>
</div>
