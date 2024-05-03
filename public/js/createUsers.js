function setPlan(plans) {
	var planId = $('#selectPlan').val();
	var plansObj = JSON.parse(plans);
	var selectedPlan = null;
	for (var i = 0; i < plansObj.length; i++) {
		if (plansObj[i].id == planId) {
			selectedPlan = plansObj[i];
			break;
		}
	}

	$('#maxCharts').val(selectedPlan.word_limit);
	$('#editors').val(selectedPlan.editors_count);
	$('#nTest').val(selectedPlan.test_questions_count);
	$('#nSummary').val(selectedPlan.summaries);


	$('#payment').html('<option value="1">mensual: ' + selectedPlan.monthly_price + ' €</option><option value="2">anual: ' + selectedPlan.annual_price + ' €</option>');
}

function createUser(){

	var firstName = $('#name').val();

	var email = $('#email').val();
	var password = $('#password').val();
	var repeatPass = $('#repeatPass').val();
	var paymentOptionId = $('#payment').val();
	var planId = $('#selectPlan').val();

	var user = {
		"payment": paymentOptionId,
		"plan": planId,
		"name": firstName,
		"email": email,
		"password": password,
		"password_confirmation": repeatPass
	};

    $.ajax({
            url: '/saas/public/api/users',
	    type: 'POST',
	    contentType: 'application/json',
	    data: JSON.stringify(user),
	    success: function(response) {

	    },
	    error: function(xhr, status, error) {

	    }
    });

}
