function checkuser() {
    if (document.getElementById("designer").checked==true) {
        document.getElementById("logIn").action="designerHomePage.html"    }

    if (document.getElementById("client").checked==true) {
        document.getElementById("logIn").action="clientHomepage.html"
    }
    return true;
}