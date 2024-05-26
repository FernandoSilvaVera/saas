<div class="pb_15">
	<h4 class="pb_5">Máximo de palabras</h4>
	<input id="maxCharts" type="number" class="input_field w-100" placeholder="" value="{{$plan->word_limit}}" required {{ $bloquearCampos ? 'disabled' : '' }}>
</div>

<div class="pb_15">
	<h4 class="Editors pb_5">Nº Editores</h4>
	<input id="editors" type="number" class="input_field w-100" placeholder="" required {{ $bloquearCampos ? 'disabled' : '' }} value="{{$plan->editors_count}}">
</div>

<div class="pb_15">
	<div class="form-check">
		<input id="wordNoLimit" type="checkbox" class="form-check-input" {{ $bloquearCampos ? 'disabled' : '' }} @checked($plan->unlimited_words)>
		<label class="form-check-label" for="wordNoLimit">Sin límite de palabras</label>
	</div>
</div>

<div class="pb_15">
	<div class="form-check">
		<input id="nTest" type="checkbox" class="form-check-input" {{ $bloquearCampos ? 'disabled' : '' }} @checked($plan->test_questions_count > 0)>
		<label class="form-check-label" for="nTest">Preguntas</label>
	</div>
</div>

<div class="pb_15">
	<div class="form-check">
		<input id="nSummary" type="checkbox" class="form-check-input" {{ $bloquearCampos ? 'disabled' : '' }} @checked($plan->summaries)>
		<label class="form-check-label" for="nSummary">Resumen</label>
	</div>
</div>

<div class="pb_15">
	<div class="form-check">
		<input id="conceptualMap" type="checkbox" class="form-check-input" {{ $bloquearCampos ? 'disabled' : '' }} @checked($plan->concept_map)>
		<label class="form-check-label" for="conceptualMap">Mapa Conceptual</label>
	</div>
</div>

<div class="pb_15">
	<div class="form-check">
		<input id="voiceover" type="checkbox" class="form-check-input" {{ $bloquearCampos ? 'disabled' : '' }} @checked($plan->voiceover)>
		<label class="form-check-label" for="voiceover">Locución en línea</label>
	</div>
</div>

<div class="pb_15">
	<div class="form-check">
		<input id="customPlan" type="checkbox" class="form-check-input" {{ $bloquearCampos ? 'disabled' : '' }} @checked($plan->custom_plan)>
		<label class="form-check-label" for="customPlan">Plan personalizado (si se marca no aparecerá para los clientes)</label>
	</div>
</div>

@if($plan->id)
	@if($plan->is_active)
		<div class="d-flex justify-content-center">
			<button onclick="desactivarConfirm({{ $plan->id }})" type="button" class="buttonRed">Desactivar</button>
		</div>
	@else
		<div class="d-flex justify-content-center">
			<button onclick="activarConfirm({{ $plan->id }})" type="button" class="buttonGreen">Activar</button>
		</div>
	@endif
@endif
