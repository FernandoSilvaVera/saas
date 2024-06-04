<div class="pb_15">
	<h4 class="pb_5">Máximo de palabras</h4>
	<input id="maxCharts" type="number" class="input_field w-100" placeholder="" value="{{$plan->word_limit}}" required {{ $bloquearCampos ? 'disabled' : '' }}>
</div>

<div class="pb_15">
	<h4 class="Editors pb_5">Nº Editores</h4>
	<input id="editors" type="number" class="input_field w-100" placeholder="" required {{ $bloquearCampos ? 'disabled' : '' }} value="{{$plan->editors_count}}">
</div>

<div class="pb_15">
	<h4 class="Editors pb_5">Nº Preguntas</h4>
	<input id="nTest" type="number" class="input_field w-100" placeholder="" required {{ $bloquearCampos ? 'disabled' : '' }} value="{{$plan->test_questions_count}}">
</div>

<div class="pb_15">
	<h4 class="Editors pb_5">Nº Resumenes</h4>
	<input id="nSummary" type="number" class="input_field w-100" placeholder="" required {{ $bloquearCampos ? 'disabled' : '' }} value="{{$plan->summaries}}">
</div>

<div class="pb_15">
	<h4 class="Editors pb_5">Nº Mapa Conceptual</h4>
	<input id="conceptualMap" type="number" class="input_field w-100" placeholder="" required {{ $bloquearCampos ? 'disabled' : '' }} value="{{$plan->concept_map}}">
</div>

<div class="pb_15">
	<div class="form-check">
		<input id="wordNoLimit" type="checkbox" class="form-check-input" {{ $bloquearCampos ? 'disabled' : '' }} @checked($plan->unlimited_words)>
		<label class="form-check-label" for="wordNoLimit">Sin límite de palabras</label>
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
