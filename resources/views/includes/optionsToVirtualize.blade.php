<div class="container">

	@if(isset($messageWordsUsed))
		<div class="alert alert-success" role="alert">
			{!! $messageWordsUsed !!}
		</div>
	@endif


	<h2 class="mb-3">Personaliza Tu Virtualización</h2>


	<label class="mt-1">Plantilla</label>
	<div class="mb-3">
		<select class="form-select" id="template">
			<option value="-1">
				Selecciona una plantilla
			</option>
			@foreach($templates as $template)
			<option value="{{ $template->id }}" @if(isset($templateId) && $template->id == $templateId) selected @endif>
				{{ $template->template_name }}
			</option>
			@endforeach
		</select>
	</div>

	<label class="mt-1">Idioma</label>
	<div class="mb-3">
		<select class="form-select" id="language">
			@foreach($languages as $language)
				<option value="{{ $language }}" @if(isset($languageInput) && $language == $languageInput) selected @endif>
					{{ $language }}
				</option>
			@endforeach
		</select>
	</div>

	@if($isAdmin || ($currentSubscription && $currentSubscription->subscriptionPlan->summaries))
	<label class="mt-1">Resumen</label>
	<div class="form-group">
		<select class="form-select" id="summaryOptions">
			@php
				$summaryOptionPreview = $summaryOptionPreview ?? '0';
			@endphp
			<option value="0" @if($summaryOptionPreview == '0') selected @endif>Selecciona un tipo de resumen</option>
			<option value="1" @if($summaryOptionPreview == '1') selected @endif>Resumen Largo</option>
			<option value="2" @if($summaryOptionPreview == '2') selected @endif>Resumen Corto</option>
		</select>
	</div>
	@endif


	@if($isAdmin || ($currentSubscription && $currentSubscription->subscriptionPlan->test_questions_count))
	<div class="form-check mt-1">
		@php
			$generateQuestionsPreview = $generateQuestionsPreview ?? false;
		@endphp

		<input class="form-check-input" type="checkbox" id="generateQuestions" name="generateQuestions" @if($generateQuestionsPreview) checked @endif>
		<label class="form-check-label" for="generateQuestions">
			Preguntas
		</label>
	</div>
	@endif

	@if($isAdmin || ($currentSubscription && $currentSubscription->subscriptionPlan->concept_map))
	<div class="form-check mt-1">
		@php
			$generateConceptMapPreview = $generateConceptMapPreview ?? false;
		@endphp

		<input class="form-check-input" type="checkbox" id="generateConceptMap" name="generateConceptMap" @if($generateConceptMapPreview) checked @endif>
		<label class="form-check-label" for="generateConceptMap">
			Mapa Conceptual
		</label>
	</div>
	@endif

	@if($isAdmin || ($currentSubscription && $currentSubscription->subscriptionPlan->voiceover))
	<div class="form-check mt-1">
		@php
			$useNaturalVoicePreview = $useNaturalVoicePreview ?? false;
		@endphp

		<input class="form-check-input" type="checkbox" id="useNaturalVoice" name="useNaturalVoice" @if($useNaturalVoicePreview) checked @endif>
		<label class="form-check-label" for="useNaturalVoice">
			Voz natural
		</label>
	</div>
	@endif

</div>
