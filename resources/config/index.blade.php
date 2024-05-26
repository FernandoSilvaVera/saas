<!DOCTYPE html>
<html>
<head>
<title>Config</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
<h1>Configuration</h1>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<form action="{{ route('config.update') }}" method="POST">
@csrf

<div class="form-group">
<label for="concept_map_percentage">% of Concept Map Words</label>
<input type="number" name="concept_map_percentage" class="form-control" value="{{ $configs['concept_map_percentage']->value ?? '' }}" required>
</div>

<div class="form-group">
<label for="long_summary_percentage">% of Long Summary Words</label>
<input type="number" name="long_summary_percentage" class="form-control" value="{{ $configs['long_summary_percentage']->value ?? '' }}" required>
</div>

<div class="form-group">
<label for="short_summary_percentage">% of Short Summary Words</label>
<input type="number" name="short_summary_percentage" class="form-control" value="{{ $configs['short_summary_percentage']->value ?? '' }}" required>
</div>

<div class="form-group">
<label for="questions_percentage">% of Questions Words</label>
<input type="number" name="questions_percentage" class="form-control" value="{{ $configs['questions_percentage']->value ?? '' }}" required>
</div>

<div class="form-group">
<label for="online_narration_percentage">% of Online Narration Words</label>
<input type="number" name="online_narration_percentage" class="form-control" value="{{ $configs['online_narration_percentage']->value ?? '' }}" required>
</div>

<button type="submit" class="btn btn-primary">Update Configurations</button>
</form>
</div>
</body>
</html>

