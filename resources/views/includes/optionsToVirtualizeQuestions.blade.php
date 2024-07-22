<div class="container">

	@if(isset($messageWordsUsed))
		<div class="alert alert-success" role="alert">
			{!! $messageWordsUsed !!}
		</div>
	@endif


	<h2 class="mb-3">Preguntas a generar</h2>

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

	@if($isAdmin || ($currentSubscription && $currentSubscription->numero_preguntas))
		@php
			$generateQuestionsPreview = $generateQuestionsPreview ?? false;
		@endphp

		<div id="numberInputContainer" class="form-group mt-2">
			<label for="numberOfQuestions">Cantidad de preguntas:</label>
			<input type="number" class="form-control" id="generateQuestions" name="generateQuestions" min="1" step="1" value="{{$generateQuestionsPreview}}">
		</div>
	@endif

</div>
