//星をチェックするための処理
var stars = document.querySelectorAll(".evaluation__star");
var evaluation = document.getElementById("evaluation");
if (evaluation.value !== null) {
        for (let i = 1; i <= evaluation.value; i++) {
            document
                .getElementById("star" + i)
                .classList.add("evaluation__star--check");
        }
    }
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


//画像ドラッグ＆ドロップ処理
var imgArea = document.getElementById("drop__area");
var imgInput = document.getElementById("img");
imgArea.addEventListener("dragover", function (e) {
    e.preventDefault();
    imgArea.classList.add("dragover");
});
imgArea.addEventListener("dragleave", function (e) {
    e.preventDefault();
    imgArea.classList.remove("dragover");
});
imgArea.addEventListener("drop", function (e) {
    e.preventDefault();
    imgArea.classList.remove("dragover");

    var file = e.dataTransfer.files;
    imgInput.files = file;
});

//フォーム送信処理
var btn = document.getElementById("btn");
btn.addEventListener("click", function () {
    document.form.submit();
});

//コメント数カウンター
var comment = document.getElementById("comment");
var counter = document.getElementById("counter");
comment.addEventListener("input", function () {
    counter.textContent = comment.value.length;
});
