/*function addNewPageForm()
{
    console.log('nic2');
}

function openAddPageForm() {
    document.getElementById("addPageForm").style.display = "block";
}

function closeAddPageForm() {
    document.getElementById("addPageForm").style.display = "none";
}*/

$("#form-popup-show").click(function() {
    $("#addPageForm").toggleClass("show");
    $("#blur").toggleClass("show");
});

$("#form-popup-hide").click(function() {
    $("#addPageForm").toggleClass("show");
    $("#blur").toggleClass("show");
});