function activateBadCredentialsLabel() {
    document.getElementById("bad-credentials").innerHTML = "Bad credentials";
}

function deactivateBadCredentialsLabel() {
    document.getElementById("bad-credentials").innerHTML = "";
}

function addConfirmationPopup(studId) {
    var confirmResult = confirm("Are you sure?");
    if (confirmResult == true) {
        document.getElementById("dismissStudentForm"+studId).submit();
    } else {
    }
}
