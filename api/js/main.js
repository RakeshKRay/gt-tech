'use strict';
$(document).ready(function () {
    $("#contactUsDetails").hide();
    $("#applyjobDetails").hide();
    $("#contactUsFetch").click(function () {
        $("#applyjobDetails").hide();
        $("#contactUsDetails").show();
      // show that something is loading
      $("#LoadingStatus").html("<b>Loading response...</b>");
      
      // Call ajax for pass data to other place
      $.ajax({
          type: "GET",
          url: "api/readAllContactUs.php",
          accepts: "application/json; charset=UTF-8"
        })
        .done(function (data) {data.body[0].email
            var tblData = $("#contackustbl");
            data.body.forEach(element => {
                var Data = "<tr class='row_" + element.id + "'>" +
             "<td>" + element.id  + "</td>" +
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
        }).always(function() {
              console.log("always");
          });
      // to prevent refreshing the whole page page
      return false;
    });

    $("#applyJobFetch").click(function () {
        $("#applyjobDetails").show();
        $("#contactUsDetails").hide();
      // show that something is loading
      $("#applyjobLoadingStatus").html("<b>Loading response...</b>");
      
      // Call ajax for pass data to other place
      $.ajax({
          type: "GET",
          url: "api/readAllApplyJob.php",
          accepts: "application/json; charset=UTF-8"
        })
        .done(function (data) {data.body[0].email
            var tblData = $("#applyjobtbl");
            data.body.forEach(element => {
                var Data = "<tr class='row_" + element.id + "'>" +
             "<td>" + element.id  + "</td>" +
             "<td>" + element.fname + "</td>" +
             "<td>" + element.dob + "</td>" +
             "<td>" + element.experience + "</td>" +
             "<td>" + element.location + "</td>" +
             "<td>" + element.email + "</td>"+
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
        }).always(function() {
              console.log("always");
          });
      // to prevent refreshing the whole page page
      return false;
    });
  });
  