$(document).ready(function() {
  $(".btnModal").click(function(e) {
    e.preventDefault();
    url = $(this).data("url");
    $.ajax({
      url,
      type: 'GET',
      dataType: 'html',
      success: function(data) {
        $('#content-data-msj').html(data);
        $('#modalDefault').modal({ show: true });
      },
      error: function(data) {
        if (data.status == 500) {
          try {
            data = JSON.parse(data.responseText);
            toastr["error"](data.message, "Error!");
          } catch (error) {
            toastr["error"]("Error en el servidor", "Error!");
            console.log(data);
          }
        } else if (data.status == 401) {
          location.reload();
        } else {
          toastr["error"]("Error en el servidor", "Error!");
          console.log(data);
        }
      }
    });
  });

  

  $('#resetSearch').click(function() {
    var url = window.location.href;
    var path = url.split("?");
    window.location.href = path[0];
  });

  $('.btnHref').click(function() {
    $(location).attr('href', $(this).data("url"));
  });

  toastr.options.onShown = function() {  }
  toastr.options.onHidden = function() {  }
  toastr.options.onclick = function() {  }
  toastr.options.onCloseClick = function() {  }
});

