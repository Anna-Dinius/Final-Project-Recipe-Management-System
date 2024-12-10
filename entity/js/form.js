
/*------- CREATE/EDIT PAGE LOGIC -------------------------------------------------------------------------- */
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

var prepHrs;
var prepMins;
var cookHrs;
var cookMins;

function getTimeValues() {
    prepHrs = parseInt(document.getElementById('prep_time_hrs')?.value || 0);
    prepMins = parseInt(document.getElementById('prep_time_mins')?.value || 0);
    cookHrs = parseInt(document.getElementById('cook_time_hrs')?.value || 0);
    cookMins = parseInt(document.getElementById('cook_time_mins')?.value || 0);
}

$(document).on('change', '.time', function() {
    getTimeValues();
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
    console.log('Total Time:', totalTimeString);
}
