'use strict';
var checkAuth = function(){
  $.ajax({
    type: "POST",
    url: "api/protected.php",
    accepts: "application/json; charset=UTF-8",
    beforeSend: function (xhr) {
      xhr.setRequestHeader ("Authorization", "Bearer " + queryString['t']);
    }
})
    .done(function (data) {
        var msg = data.message;
        console.log(msg);
    })
    .fail(function (data) {
        alert(data.message);
        window.location.href = "login.html";
    }).always(function () {
        console.log("always");
    });
}

var queryString = new Array();
$(document).ready(function () {
  // fetch query string from parameter
  if (queryString.length == 0) {
    if (window.location.search.split('?').length > 1) {
        var params = window.location.search.split('?')[1].split('&');
        for (var i = 0; i < params.length; i++) {
            var key = params[i].split('=')[0];
            var value = decodeURIComponent(params[i].split('=')[1]);
            queryString[key] = value;
        }
    }
}
 
if(queryString['t']==null){
  window.location.href = "login.html";
}else{
  checkAuth();
}
  $("#contactUsDetails").hide();
  $("#applyjobDetails").hide();
  $("#contactUsFetch").click(function () {
    checkAuth();
    $("#applyjobDetails").hide();
    $("#contactUsDetails").show();
    // show that something is loading
    $("#LoadingStatus").html("<b>Loading response...</b>");

    // Call ajax for fetch all contact
    $.ajax({
      type: "GET",
      url: "api/readAllContactUs.php",
      accepts: "application/json; charset=UTF-8"
    })
      .done(function (data) {
        data.body[0].email
        var tblData = $("#contackustbl");
        data.body.forEach(element => {
          var Data = "<tr class='row_" + element.id + "'>" +
            "<td>" + element.id + "</td>" +
            "<td>" + element.name + "</td>" +
            "<td>" + element.email + "</td>" +
            "<td>" + element.phone + "</td>" +
            "<td>" + element.message + "</td>" +
            "<td>" + element.created_date + "</td>"
          "</tr>";
          tblData.append(Data);
        });
        $("#LoadingStatus").html(" ");
        console.log(data);
      })
      .fail(function (data) {
        console.log(data.responseText);
        // just in case posting your form failed
        $("#LoadingStatus").html("Some problem try again");
      }).always(function () {
        console.log("always");
      });
    // to prevent refreshing the whole page page
    return false;
  });

  $("#applyJobFetch").click(function () {
    checkAuth();
    $("#applyjobDetails").show();
    $("#contactUsDetails").hide();
    // show that something is loading
    $("#applyjobLoadingStatus").html("<b>Loading response...</b>");

    // Call ajax to fetch all jobs
    $.ajax({
      type: "GET",
      url: "api/readAllApplyJob.php",
      accepts: "application/json; charset=UTF-8"
    })
      .done(function (data) {
        data.body[0].email
        var tblData = $("#applyjobtbl");
        data.body.forEach(element => {
          var Data = "<tr class='row_" + element.id + "'>" +
            "<td>" + element.id + "</td>" +
            "<td>" + element.fname + "</td>" +
            "<td>" + element.dob + "</td>" +
            "<td>" + element.experience + "</td>" +
            "<td>" + element.location + "</td>" +
            "<td>" + element.email + "</td>" +
            "<td>" + element.phone + "</td>" +
            "<td>" + element.designation + "</td>" +
            "<td>" + element.applyDesc + "</td>" +
            "<td>" + element.cv + "</td>" +
            "<td>" + element.created_date + "</td>"
          "</tr>";
          tblData.append(Data);
        });
        $("#applyjobLoadingStatus").html(" ");
        console.log(data);
      })
      .fail(function (data) {
        console.log(data.responseText);
        // just in case posting your form failed
        $("#applyjobLoadingStatus").html("Some problem try again");
      }).always(function () {
        console.log("always");
      });
    // to prevent refreshing the whole page page
    return false;
  });
});
