$(document).ready(function () {
    
//START Contact
  $("#contact_form").on("submit", function (e) {
    e.preventDefault();
    $("#contact_form span.text-danger").text("")
    let form = $("#contact_form")[0];

    let data = new FormData(this);

    let formDataObject = Object.fromEntries(data.entries());

    $.ajax({
      url: this.action,
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      dataType: "json",
      data: JSON.stringify(formDataObject),
      contentType: "application/json",
      success: function (response) {
        if (response.Success) {
          Swal.fire({
            icon: "success",
            title: response.message,
          });
          form.reset();
        } else if (response.errors) {
          for (let key in response.errors) {
            if (response.errors.hasOwnProperty(key)) {
              $("#" + key + "_error").text(response.errors[key].join(", "));
            }
          }
        } else {
          Swal.fire({
            icon: "error",
            title: response.message,
          });
          form.reset();
        }
      },
      error: function (xhr) {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong. Please try again later.",
        });
      },
    });
  });
  
});