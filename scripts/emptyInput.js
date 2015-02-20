$(document).ready(function () {
    var intputElements = document.getElementsByTagName("INPUT");
    for (var i = 0; i < intputElements.length; i++) {
        intputElements[i].oninvalid = function (e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                if (e.target.name == "startpage") {
                    e.target.setCustomValidity("We need a page to start at!");
                }
                else if(e.target.name == "endpage")
                {
                    e.target.setCustomValidity("We need a destination page!");
                }
            }
        };
    }
})