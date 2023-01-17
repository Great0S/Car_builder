var search_string = "";
var past_val = "";

function open_tab(evt, object, value) {
  console.log(object);
  if (value !== undefined) {
    past_val = value;
    search_string = search_string.concat(value + " " + object + " ");
  }

  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tab");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("nav-link");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(object).style.display = "block";
  evt.currentTarget.className += " active";
}

$(document).ready(function () {
  if (past_val !== undefined) {
    //we are sending information to saveTimeToDB.php
    $.ajax("cars_builder.php", {
      data: { values: past_val }, //this is an object containing all the information you want to send
    })
      .done(function () {
        //a function which gets called if the ajax call succeeded
        alert("Value has been saved");
      })
      .fail(function () {
        //a function which gets called if the ajax call failed
        alert("Uh-oh, something went wrong. We did not save the value");
      });
  }
});
