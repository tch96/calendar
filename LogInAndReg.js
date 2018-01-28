//change
document.addEventListener("DOMContentLoaded", logout(), false);
$(function() { //shorthand document.ready function
    $('#login_form').on('submit', function(e) { //use on if jQuery 1.7+
        e.preventDefault(); //prevent form from submitting
        var data = $("#login_form :input").serializeArray();

        var username = data[0].value; // Get the username from the form
        var password = data[1].value; // Get the password from the form
        // Make a URL-encoded string for passing POST data:
        var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
        var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
        xmlHttp.open("POST", "passcheck.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
        xmlHttp.addEventListener("load", function(event) {
            var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
            if (jsonData.success) { // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
                alert("You've been Logged In!");
                var loginmsg = username + " logged in.";
                document.getElementById("token").value = jsonData.token;
                $("#loggedin").html(loginmsg);
                $("#loggedin").append("<br><button class='logout' onclick='logout()'> Log Out </button>");
                $("#loginandreg").hide();
                document.getElementById("login_form").reset();
            } else {
                alert("You were not logged in.  " + jsonData.message);
            }
        }, false); // Bind the callback to the load event
        xmlHttp.send(dataString); // Send the data
    });
});
$(function() { //shorthand document.ready function
    $('#register_form').on('submit', function(e) { //use on if jQuery 1.7+
        e.preventDefault(); //prevent form from submitting
        var data = $("#register_form :input").serializeArray();
        var newUser = data[0].value; // Get the username from the form
        var newpsw = data[1].value; // Get the password from the form
        // Make a URL-encoded string for passing POST data:
        var dataString = "newUser=" + encodeURIComponent(newUser) + "&newpsw=" + encodeURIComponent(newpsw);
        var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
        xmlHttp.open("POST", "createUser.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
        xmlHttp.addEventListener("load", function(event) {
            var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
            if (jsonData.success) { // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
                alert(jsonData.message);
            } else {
                alert("Registration failed.  " + jsonData.message);
            }
        }, false); // Bind the callback to the load event
        xmlHttp.send(dataString); // Send the data
    });
});

function logout() {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("POST", "logout.php", true);
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlHttp.addEventListener("load", function(event) {
        $("#loggedin").html("Hello, Guest.");
        $("#loginandreg").show();
        document.getElementById("newEventForm").reset();
        document.getElementById("edit_Event").reset();
        var eventsForDay = document.getElementsByClassName("eventList")[0];
        while (eventsForDay.firstChild) {
            eventsForDay.removeChild(eventsForDay.firstChild);
        }
    }, false); // Bind the callback to the load event
    xmlHttp.send(null);
}