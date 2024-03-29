var selectDate = document.getElementById("date");
var displayDate = document.getElementById("result__date");
displayDate.textContent = selectDate.value;

selectDate.addEventListener("change", function () {
    var value = selectDate.value;
    displayDate.textContent = value;
});

var selectTime = document.getElementById("time");
var displayTime = document.getElementById("result__time");
displayTime.textContent = selectTime.value;

selectTime.addEventListener("change", function () {
    var value = selectTime.value;
    displayTime.textContent = value;
});

var selectNumber = document.getElementById("number");
var displayNumber = document.getElementById("result__number");
if (selectNumber.value == "over_10") {
    displayNumber.textContent = "10人以上";
} else {
    displayNumber.textContent = selectNumber.value + "人";
}
selectNumber.addEventListener("change", function () {
    var value = selectNumber.value;
    if (value == "over_10") {
        displayNumber.textContent = "10人以上";
    } else {
        displayNumber.textContent = value + "人";
    }
});

var stars = document.querySelectorAll(".evaluation__star");
stars.forEach(function (star) {
    star.addEventListener("click", function () {
        var clickedStar = parseInt(this.id.replace("star", ""));
        stars.forEach(function (s) {
            s.classList.remove("evaluation__star--check");
        });

        for (var i = 1; i <= clickedStar; i++) {
            document
                .getElementById("star" + i)
                .classList.add("evaluation__star--check");
            document.getElementById("evaluation").setAttribute("value", i);
        }
    });
});
