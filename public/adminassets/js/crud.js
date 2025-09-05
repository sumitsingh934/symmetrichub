$(".allowno").keypress(function (e) {
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      e.preventDefault(); 
  }
});


function addForm(url, modal = 'modal-lg') {
// alert(url);

    $('#modal-default .modal-content').html('');
    $.ajax({
  
      url: url,
      method: "GET",
      data: {},
      success: function (res) {
  
        $('#' + modal + ' .modal-content').html(res);
        $('#' + modal).modal('show');
  
      }
    });
  }

  function clientform_submit(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
  
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
          window.location.href = base_url+'/admin/client';
          dataTable.draw(false);

        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }


function form_submit(e) {
  toastr.clear();
  $(e).find('.st_loader').show();

  let formData = new FormData(e); // ✅ includes file inputs

  $.ajax({
    url: $(e).attr('action'),
    method: "POST",
    data: formData,
    dataType: "json",
    processData: false,   // ✅ must be false for file uploads
    contentType: false,   // ✅ must be false for file uploads
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (data) {
      if (data.status == 1) {
        toastr.success(data.message, 'Success');
        $(e).find('.st_loader').hide();
        $(e)[0].reset();
        $('#modal-lg').modal('hide');
        $('#modal-lg .modal-content').html('');

        if (data.tableView) {
          $('.expenses-Table').show();
          $('#expenses-Table tbody').append(data.tableView);
        }

        dataTable.draw(false);
      } else if (data.status == 0) {
        let $err = '';
        $.each(data.errors, function (key, value) {
          $err += value + "<br>";
        });
        toastr.error($err, 'Error');
      } else if (data.status == 2) {
        toastr.success(data.message, 'Success');
        window.setTimeout(function () {
          window.location.href = data.surl;
        }, 1000);
      }
    },
    error: function (data) {
      let $err = '';
      if (data.responseJSON?.errors) {
        $.each(data.responseJSON.errors, function (key, value) {
          $err += value + "<br>";
        });
      } else {
        $err = data.responseJSON?.message || 'Something went wrong';
      }
      toastr.error($err, 'Error');
      $(e).find('.st_loader').hide();
    }
  });
}

  function clientprofile_submit(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
  
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
        // location.reload();
        $(".clientName").removeClass("d-none"); 
        $(".clientEmail").removeClass("d-none"); 
        $(".clientUsername").removeClass("d-none"); 

        $(".clientName").html(data.name); 
        $(".clientEmail").html(data.email); 
        $(".clientUsername").html(data.username); 
   
        $(".client_name").addClass("d-none");
        $(".client_email").addClass("d-none");
        $(".client_username").addClass("d-none");
        $("#update").addClass("d-none");


        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }

  function adminProfile_submit(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
  
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
        location.reload();

        } else if (data.status == 0) {
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
        else if (data.status == 3){
          toastr.error(data.message, 'Error');
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }

  function edit_row(url, id, modal = 'modal-lg') {
    
    $('#modal-default .modal-content').html('');
    url = url.replace(':id', id);
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: url,
      method: "GET",
      data: {},
      success: function (res) {
        $('#' + modal + ' .modal-content').html(res);
        $('#' + modal).modal('show');
      }
    });
  }

  function showAppointments(url, id, modal = 'modal-lg') {

    $('#modal-default .modal-content').html('');
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: url,
      method: "POST",
      data: {
        id:id
      },
      success: function (res) {
        $('#' + modal + ' .modal-content').html(res);
        $('#' + modal).modal('show');
      }
    });
  }

function delete_row(url, id) {
    url = url.replace(':id', id);

    if (confirm('Are you sure you want to delete this?')) {
        $.ajax({
            url: url,
            method: "DELETE",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                toastr.success(data.message, 'Success');
                setTimeout(function () {
                    window.location.href = data.surl;
                }, 1000);
            },
            error: function () {
                toastr.error("Delete failed", "Error");
            }
        });
    }
}

  function addservices(url, id, modal = 'modal-lg') {
    $('#modal-default .modal-content').html('');
    url = url.replace(':id', id);
    $.ajax({

      url: url,
      method: "GET",
      data: {},
      success: function (res) {
  
        $('#' + modal + ' .modal-content').html(res);
        $('#' + modal).modal('show');
  
      }
    });
  }


  function addholidays(url, id, modal = 'modal-lg') {
    $('#modal-default .modal-content').html('');
    url = url.replace(':id', id);
    $.ajax({

      url: url,
      method: "GET",
      data: {},
      success: function (res) {
  
        $('#' + modal + ' .modal-content').html(res);
        $('#' + modal).modal('show');
  
      }
    });
  }


  function addslot(url, id, modal = 'modal-lg') {
    $('#modal-default .modal-content').html('');
    url = url.replace(':id', id);
    $.ajax({

      url: url,
      method: "GET",
      data: {},
      success: function (res) {
  
        $('#' + modal + ' .modal-content').html(res);
        $('#' + modal).modal('show');
  
      }
    });
  }


  function storeservices(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
          // $(e).find('.st_loader').hide();
          // $(e)[0].reset();
          // $('#modal-lg').modal('hide');
          // $('#modal-lg .modal-content').html('');
        
          dataTable.draw(false);
        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }

  function storeholiday(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
         
          dataTable.draw(false);
        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }

  function editservices(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
          var id = data.id;
          var url =  base_url+"/admin/client/add-services/"+id;
          addservices(url,id)
          
          dataTable.draw(false);
        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }

  function editholiday(e) {
    toastr.clear();
    $(e).find('.st_loader').show();
    $.ajax({
      url: $(e).attr('action'),
      method: "POST",
      dataType: "json",
      data: $(e).serialize(),
      success: function (data) {
        if (data.status == 1) {
          toastr.success(data.message, 'Success');
          var id = data.id;
          var url =  base_url+"/admin/client/add-holidays/"+id;
          addservices(url,id)
          
          dataTable.draw(false);
        } else if (data.status == 0) {
  
          var $err = '';
          $.each(data.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        else if (data.status == 2) {
          toastr.success(data.message, 'Success');
          window.setTimeout(function () {
            window.location.href = data.surl;
          }, 1000);
        }
      },
      error: function (data) {
        if (typeof data.responseJSON.status !== 'undefined') {
          toastr.error(data.responseJSON.error, 'Error');
        } else {
          var $err = '';
          $.each(data.responseJSON.errors, function (key, value) {
            $err = $err + value + "<br>";
          });
          toastr.error($err, 'Error');
        }
        $(e).find('.st_loader').hide();
      }
    });
  }



 function clientServiceList(){
  $.ajax({
    'headers': {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: base_url+"/admin/client/services-list",
    method: "POST",
    dataType: "JSON",
    data: {},
    success: function (res) {
        
    }
});
 }

//   function status_change(url,newStatus, id,type) {
//    // alert('vake');
//     $('#st_loader_' + id).show();
    
//     if(type){
//       var statusText = type;
//     }else{
//       var statusText = newStatus === 1 ? 'Active' : 'Inactive';
//     }

//     if (confirm("Are you sure you want to set the status to " + statusText + "?")) {
//         $.ajax({
//             'headers': {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             url: url,
//             method: "POST",
//             dataType: "JSON",
//             data: { id: id, is_active: newStatus },
//             success: function (res) {
//                 $('#st_loader_' + id).hide();

//                 toastr.success('Status changed successfully', 'Success');
//                 dataTable.draw(false);
//             }
//         });
//     } else {
//         // Optionally handle the case when the user cancels the confirmation
//     }
// }
function plan_status_change(url, newStatus, id, type) {
    $('#st_loader_' + id).show();

    let statusText = type || (newStatus === 1 ? 'Active' : 'Inactive');

    if (confirm("Are you sure you want to set the status to " + statusText + "?")) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: "POST",
            dataType: "JSON",
            data: { status: newStatus },
            success: function (res) {
                $('#st_loader_' + id).hide();

                if (res.success) {
                    toastr.success(res.message, 'Success');

                    // Refresh the page after a short delay to let the user see the success message
                    setTimeout(function () {
                        location.reload();
                    }, 1000); // Adjust the delay (ms) as needed
                }
            },
            error: function () {
                $('#st_loader_' + id).hide();
                toastr.error("Something went wrong.", 'Error');
            }
        });
    } else {
        $('#st_loader_' + id).hide(); // hide loader if cancelled
    }
}
 

function status_change(url, newStatus, id, type) {
    $('#st_loader_' + id).show();

    let statusText = type || (newStatus === 1 ? 'Active' : 'Inactive');

    if (confirm("Are you sure you want to set the status to " + statusText + "?")) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: "POST",
            dataType: "JSON",
            data: { status: newStatus },
            success: function (res) {
                $('#st_loader_' + id).hide();

                if (res.success) {
                    const btn = $('#status-btn-' + id);
                    const newStatus = res.new_status;
                    const newText = newStatus == 1 ? 'Active' : 'Inactive';
                    const newClass = newStatus == 1 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800';
                    const nextStatus = newStatus == 1 ? 0 : 1;
                    const nextText = newStatus == 1 ? 'Active' : 'Inactive';

                    btn
                        .removeClass('bg-green-200 text-green-800 bg-red-200 text-red-800')
                        .addClass(newClass)
                        .text(newText)
                        .attr('onclick', `status_change('${url}', ${nextStatus}, ${id}, '${nextText}')`);

                    toastr.success(res.message, 'Success');
                }
            },
            error: function () {
                $('#st_loader_' + id).hide();
                toastr.error("Something went wrong.", 'Error');
            }
        });
    } else {
        $('#st_loader_' + id).hide(); // hide loader if cancelled
    }
}

function position_change(url, newPosition, id, type) {
    $('#st_loader_' + id).show();

    let statusText = type || (newPosition === 'right' ? 'Right' : 'Left');

    if (confirm("Are you sure you want to set the position to " + statusText + "?")) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: "POST",
            dataType: "JSON",
            data: { position: newPosition },
            success: function (res) {
                $('#st_loader_' + id).hide();

                if (res.success) {
                    const btn = $('#position-btn-' + id);
                    const newPosition = res.new_position;
                    const newText = newPosition === 'right' ? 'Right' : 'Left';
                    const newClass = newPosition === 'right' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800';
                    const nextStatus = newPosition === 'right' ? 'left' : 'right';
                    const nextText = newPosition ==='right' ? 'Left' : 'Right';

                    btn
                        .removeClass('bg-green-200 text-green-800 bg-red-200 text-red-800')
                        .addClass(newClass)
                        .text(newText)
                        .attr(
                              'onclick',
                              `position_change('${url}', '${nextStatus}', ${id}, '${nextText}')`
                        );

                    toastr.success(res.message, 'Success');
                }
            },
            error: function () {
                $('#st_loader_' + id).hide();
                toastr.error("Something went wrong.", 'Error');
            }
        });
    } else {
        $('#st_loader_' + id).hide(); // hide loader if cancelled
    }
}


function trend_change(url, newTrend, id, type) {
    $('#st_loader_' + id).show();

    let statusText = type || (newTrend === 1 ? 'Enable' : 'Disable');

    if (confirm("Are you sure you want to set the status to " + statusText + "?")) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: "POST",
            dataType: "JSON",
            data: { is_trending: newTrend }, // ✅ Corrected key
            success: function (res) {
                $('#st_loader_' + id).hide();

                if (res.success) {
                    const btn = $('#trend-btn-' + id);
                    const newTrend = res.new_trend;
                    const newText = newTrend == 1 ? 'Enable' : 'Disable';
                    const newClass = newTrend == 1 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800';
                    const nextStatus = newTrend == 1 ? 0 : 1;
                    const nextText = newTrend == 1 ? 'Enable' : 'Disabled';

                    btn
                        .removeClass('bg-green-200 text-green-800 bg-red-200 text-red-800')
                        .addClass(newClass)
                        .text(newText)
                        .attr('onclick', `trend_change('${url}', ${nextStatus}, ${id}, '${nextText}')`);

                    toastr.success(res.message, 'Success');
                }
            },
            error: function () {
                $('#st_loader_' + id).hide();
                toastr.error("Something went wrong.", 'Error');
            }
        });
    } else {
        $('#st_loader_' + id).hide(); // hide loader if cancelled
    }
}

function featured_change(url, newFeatured, id, type) {
    $('#st_loader_' + id).show();

    let statusText = type || (newFeatured === 1 ? 'Enable' : 'Disable');

    if (confirm("Are you sure you want to set the status to " + statusText + "?")) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: "POST",
            dataType: "JSON",
            data: { is_featured: newFeatured }, // ✅ Corrected key
            success: function (res) {
                $('#st_loader_' + id).hide();

                if (res.success) {
                    const btn = $('#featured-btn-' + id);
                    const newFeatured = res.new_featured;
                    const newText = newFeatured == 1 ? 'Enable' : 'Disable';
                    const newClass = newFeatured == 1 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800';
                    const nextStatus = newFeatured == 1 ? 0 : 1;
                    const nextText = newFeatured == 1 ? 'Enable' : 'Disabled';

                    btn
                        .removeClass('bg-green-200 text-green-800 bg-red-200 text-red-800')
                        .addClass(newClass)
                        .text(newText)
                        .attr('onclick', `featured_change('${url}', ${nextStatus}, ${id}, '${nextText}')`);

                    toastr.success(res.message, 'Success');
                }
            },
            error: function () {
                $('#st_loader_' + id).hide();
                toastr.error("Something went wrong.", 'Error');
            }
        });
    } else {
        $('#st_loader_' + id).hide(); // hide loader if cancelled
    }
}

function latest_change(url, newLatest, id, type) {
    $('#st_loader_' + id).show();

    let statusText = type || (newLatest === 1 ? 'Enable' : 'Disable');

    if (confirm("Are you sure you want to set the status to " + statusText + "?")) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: "POST",
            dataType: "JSON",
            data: { is_latest: newLatest}, // ✅ Corrected key
            success: function (res) {
                $('#st_loader_' + id).hide();

                if (res.success) {
                    const btn = $('#latest-btn-' + id);
                    const newLatest = res.new_latest;
                    const newText = newLatest == 1 ? 'Enable' : 'Disable';
                    const newClass = newLatest == 1 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800';
                    const nextStatus = newLatest == 1 ? 0 : 1;
                    const nextText = newLatest == 1 ? 'Enable' : 'Disabled';

                    btn
                        .removeClass('bg-green-200 text-green-800 bg-red-200 text-red-800')
                        .addClass(newClass)
                        .text(newText)
                        .attr('onclick', `latest_change('${url}', ${nextStatus}, ${id}, '${nextText}')`);

                    toastr.success(res.message, 'Success');
                }
            },
            error: function () {
                $('#st_loader_' + id).hide();
                toastr.error("Something went wrong.", 'Error');
            }
        });
    } else {
        $('#st_loader_' + id).hide(); // hide loader if cancelled
    }
}

function popular_change(url, newPopular, id, type) {
    $('#st_loader_' + id).show();

    let statusText = type || (newPopular === 1 ? 'Enable' : 'Disable');

    if (confirm("Are you sure you want to set the status to " + statusText + "?")) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: "POST",
            dataType: "JSON",
            data: { is_popular: newPopular}, // ✅ Corrected key
            success: function (res) {
                $('#st_loader_' + id).hide();

                if (res.success) {
                    const btn = $('#popular-btn-' + id);
                    const newPopular = res.new_popular;
                    const newText = newPopular == 1 ? 'Enable' : 'Disable';
                    const newClass = newPopular == 1 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800';
                    const nextStatus = newPopular == 1 ? 0 : 1;
                    const nextText = newPopular == 1 ? 'Enable' : 'Disabled';

                    btn
                        .removeClass('bg-green-200 text-green-800 bg-red-200 text-red-800')
                        .addClass(newClass)
                        .text(newText)
                        .attr('onclick', `popular_change('${url}', ${nextStatus}, ${id}, '${nextText}')`);

                    toastr.success(res.message, 'Success');
                }
            },
            error: function () {
                $('#st_loader_' + id).hide();
                toastr.error("Something went wrong.", 'Error');
            }
        });
    } else {
        $('#st_loader_' + id).hide(); // hide loader if cancelled
    }
}

function end_auction(url,newStatus, id,type) {
  //  alert('vake');
    $('#st_loader_' + id).show();
    
    if(type){
      var statusText = type;
    }else{
      var statusText = newStatus === 1 ? 'Active' : 'Inactive';
    }

    if (confirm("Are you sure you want to end this auction " + "?")) {
        $.ajax({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: "POST",
            dataType: "JSON",
            data: { id: id, status: newStatus },
            success: function (res) {
                $('#st_loader_' + id).hide();

                toastr.success('Status changed successfully', 'Success');
                dataTable.draw(false);
            }
        });
    } else {
        // Optionally handle the case when the user cancels the confirmation
    }
}

function upload_image(form, url, id, input) 
{
  $(form).find('.' + id + '_loader').show();
  $.ajax({
    type: "POST",
    url: url + '?type=' + id,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    contentType: false,
    cache: false,
    processData: false,
    dataType: "json",
    data: new FormData(form[0]),
    success: function (res) {
      if (res.status == 0) {
        $(form).find('.' + id + '_loader').hide();
        toastr.error(res.msg, 'Error');
      } else {
        $(form).find('.' + id + '_loader').hide();
        $('#' + id + '_prev').attr('src', res.file_path);
        $('#' + id + '_prev').addClass('form-image');
        $('#' + id + '_prev').show();
        $('#' + input).val(res.file_id);
      }

    }
  });
}

function upload_multipleimage(form, url, id, input) 
{
  $(form).find('.' + id + '_loader').show();
  $.ajax({
    type: "POST",
    url: url + '?type=' + id,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    contentType: false,
    cache: false,
    processData: false,
    dataType: "json",
    data: new FormData(form[0]),
    success: function (res) {
      if (res.status == 0) {
        $(form).find('.' + id + '_loader').hide();
        toastr.error(res.msg, 'Error');
      } else {
        $(form).find('.' + id + '_loader').hide();
        // $('#' + id + '_prev').attr('src', res.file_path);
        $('#outlet_images_prev').html(res.file_path);
        $('#' + id + '_prev').addClass('form-image');
        $('#' + id + '_prev').show();
        $('#' + input).val(res.file_id);
      }

    }
  });
}

function delete_multiple_image(url,e){  
  var id = $(e).attr('data-id');
  var ids = $('#outlet_images_id').val();
  
   if(confirm('Are you sure you want to delete this?')){
      $.ajax({     
              url :url, 
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },  
       method:"POST",  
       data:{id:id,ids:ids},
       success: function(data){ 
            $(e).parent().remove();
            $('#outlet_images_id').val(data);
       },
       
     }); 
   }else{ 
     return false; 
   }
}

function clientdetails(url ,id,e)
{
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: url,
    method: "POST",
    data: {
      cId:id,
      dataId:e,

    },
    success: function (res) {
      $('#clientalldetails').html('');
      $('#clientalldetails').html(res);
    }
  });
}


function adminProfile(url ,id,e)
{
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: url,
    method: "POST",
    data: {
      adminId:id,
      dataId:e,

    },
    success: function (res) {
      $('#editprofile').html('');
      $('#editprofile').html(res);
    }
  });
}

function busySlot(url ,clntId,id)
{
  var date = $('#slotdate').val()

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: url,
    method: "POST",
    data: {
      cId:clntId,
      slot:id,
      date:date,

    },
    success: function (res) {
      if(res.status == 0){
        toastr.success(res.message, 'Success');
        $('.'+res.slot_id).removeClass('btn-light');
        $('.'+res.slot_id).addClass("btn-success");
        var a = $('#'+res.slot_id).html();
        $('#'+res.slot_id).remove();
        $('.'+res.slot_id).find('div').html(a);
      }
      if(res.status == 1){
        toastr.success(res.message, 'Success');
        var a = $('.'+res.slot_id).html();
        $('#slotData'+id).html(res.pageslot)
        $('.'+res.slot_id).removeClass('btn-success');
        $('.'+res.slot_id).addClass("btn-light");
      }
    }
  });
}

function pagesform_submit(e) {
  toastr.clear();
  $(e).find('.st_loader').show();
  $.ajax({
    url: $(e).attr('action'),
    method: "POST",
    dataType: "json",
    data: $(e).serialize(),
    success: function (data) {

      if (data.status == 1) {
        toastr.success(data.message, 'Success');
        window.location.href = base_url+'/admin/pages';
        dataTable.draw(false);

      } else if (data.status == 0) {

        var $err = '';
        $.each(data.errors, function (key, value) {
          $err = $err + value + "<br>";
        });
        toastr.error($err, 'Error');
      }
      else if (data.status == 2) {
        toastr.success(data.message, 'Success');
        window.setTimeout(function () {
          window.location.href = data.surl;
        }, 1000);
      }
    },
    error: function (data) {
      if (typeof data.responseJSON.status !== 'undefined') {
        toastr.error(data.responseJSON.error, 'Error');
      } else {
        var $err = '';
        $.each(data.responseJSON.errors, function (key, value) {
          $err = $err + value + "<br>";
        });
        toastr.error($err, 'Error');
      }
      $(e).find('.st_loader').hide();
    }
  });
}

