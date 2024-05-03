function createPlan() {
	var plan = {};

	var maxChartsInput = document.getElementById("maxCharts");
	plan.word_limit = maxChartsInput.value;

	var editorsInput = document.getElementById("editors");
	plan.editors_count = editorsInput.value;

	var voiceOnlineCheckbox = document.getElementById("voiceOnline");
	plan.voiceover = voiceOnlineCheckbox.classList.contains("active");

	var testQuestionsInput = document.getElementById("nTest");
	plan.test_questions_count = testQuestionsInput.value;

	var customPlanCheckbox = document.getElementById("customPlan");
	plan.customPlan = customPlanCheckbox.classList.contains("active");

	var annualPriceInput = document.getElementById("priceYear");
	plan.annual_price = annualPriceInput.value;

	var monthlyPriceInput = document.getElementById("priceMontly");
	plan.monthly_price = monthlyPriceInput.value;

	var summariesInput = document.getElementById("nSummary");
	plan.summaries = summariesInput.value;

	var nameInput = document.getElementById("planName");
	plan.name = nameInput.value;

	plan.description = "TODO";

	var apiUrl = '/saas/public/api/subscription/plans';

	$.ajax({
		url: apiUrl,
		type: 'POST',
		contentType: 'application/json',
		data: JSON.stringify(plan),
		success: function(data) {

		},
		error: function(xhr, status, error) {

		}
	});

	return plan;
}
	
