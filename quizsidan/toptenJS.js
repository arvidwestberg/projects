var arr = [document.getElementById('totalScore'), document.getElementById('avrageScore'), document.getElementById('fastestTime')];
var scroller = 0;

function minus() {
    scroller--;
    updateTable();
}

function plus() {
    scroller++;
    updateTable();
}

function updateTable() {
    value = Math.abs(scroller);
    arr.forEach(element => {
        element.style.display = "none";
    }
    );
    arr[value % (arr.length)].style.display = "block";
}