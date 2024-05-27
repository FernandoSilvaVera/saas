var planId = null

function createPlan() {
	var plan = {};
	plan.id = planId

	var maxChartsInput = document.getElementById("maxCharts");
	plan.word_limit = maxChartsInput.value;

	var editorsInput = document.getElementById("editors");
	plan.editors_count = editorsInput.value;

/*
	var voiceOnlineCheckbox = document.getElementById("voiceOnline");
*/

	var nTestChecked = $('#nTest').prop('checked');
	var nSummaryChecked = $('#nSummary').prop('checked');
	var voiceoverChecked = $('#voiceover').prop('checked');
	var customPlanChecked = $('#customPlan').prop('checked');
	var conceptualMap = $('#conceptualMap').prop('checked');
	var wordNoLimit = $('#wordNoLimit').prop('checked');

	plan.test_questions_count = nTestChecked
	plan.customPlan = customPlanChecked
	plan.voiceover = voiceoverChecked
	plan.summaries = nSummaryChecked
	plan.conceptualMap = conceptualMap
	plan.wordNoLimit = wordNoLimit

	var annualPriceInput = document.getElementById("priceYear");
	plan.annual_price = annualPriceInput.value;

	var monthlyPriceInput = document.getElementById("priceMontly");
	plan.monthly_price = monthlyPriceInput.value;


	var nameInput = document.getElementById("planName");
	plan.name = nameInput.value;

	plan.description = "Suscripción a contenidos virtuales";

	var apiUrl = '/api/subscription/plans';

	$.ajax({
		url: apiUrl,
		type: 'POST',
		contentType: 'application/json',
		data: JSON.stringify(plan),
		success: function(data) {
			window.location.href = "/listPlans";
		},
		error: function(xhr, status, error) {

		}
	});

	return plan;
}
