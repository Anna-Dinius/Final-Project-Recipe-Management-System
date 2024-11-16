/*------- FORM LOGIC -------------------------------------------------------------------------- */
$(document).on("click", ".del-input", function() {
    $(this).closest("div").remove();
});

$(document).on("click", "#add-ingredient", function() {
    $("#m-ingredients").append(
        `<div class="d-flex">
			<input class="form-control mb-3 ingredient-input" name="ingredients[]"/>
			<button type="button" class="btn btn-danger del-input">X</button>
		</div>`,
    );
});

$(document).on("click", "#add-step", function() {
    $("#m-steps").append(
        `<div class="d-flex">
			<textarea class="form-control textarea mb-3 step-input" name="steps[]"></textarea>
			<button type="button" class="btn btn-danger del-input">X</button>
		</div>`,
    );
});

export function clearForm() {
    $("#change-form").trigger("reset");
    $("#m-ingredients").empty();
    $("#m-steps").empty();
    $("#ingredients").empty();
    $("#steps").empty();
}

var prepHrs = 0;
var prepMins = 0;
var cookHrs = 0;
var cookMins = 0;

$(document).on('change', '.prep_time.time_hrs', function() {
    prepHrs = parseInt($(this).val());
    updateTotalTime();
});

$(document).on('change', '.prep_time.time_mins', function() {
    prepMins = parseInt($(this).val());
    updateTotalTime();
});

$(document).on('change', '.cook_time.time_hrs', function() {
    cookHrs = parseInt($(this).val());
    updateTotalTime();
});

$(document).on('change', '.cook_time.time_mins', function() {
    cookMins = parseInt($(this).val());
    updateTotalTime();
});

export function updateTotalTime() {
    var totalHrs = prepHrs + cookHrs;
    var totalMins = prepMins + cookMins;

    if (totalMins >= 60) {
        totalMins -= 60;
        totalHrs++;
    }

    var hours = "hours";
    var minutes = "minutes";

    if (totalHrs == 1) {
        hours = "hour";
    }

    var totalTimeString = totalHrs + " " + hours + ", " + totalMins + " " + minutes;

    document.getElementById('m-total-time').value = totalTimeString;
}
