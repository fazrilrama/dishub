@extends('layouts/contentNavbarLayout')

@section('title', 'Data Expired')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Master /</span> Person Estimated
</h4>
<button class="btn btn-primary" id="showAdd">Tambah Person</button>
@csrf
<!-- Basic Bootstrap Table -->
<div class="card">
  <h5 class="card-header">Person Estimated</h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Full Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>No Polisi</th>
          <th>End Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($person as $prs)
        <tr>
          <td><i class="mdi mdi-account mdi-20px text-danger me-3"></i><span class="fw-medium">{{ $prs['fullname'] }}</span></td>
          <td>{{ $prs['email'] }}</td>
          <td>{{ $prs['phone'] }}</td>
          <td>{{ $prs['no_pol'] }}</td>
          <td>{{ $prs['end_date'] }}</td>
          <td>
            @if($prs['status'] == 0)
              <span class="badge rounded-pill bg-label-primary me-1">Active</span>
            @else 
              <span class="badge rounded-pill bg-label-danger me-1">Not Active</span>
            @endif
          </td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);" id="sendWa" data-id="{{ $prs['id'] }}"><i class="mdi mdi-send me-1"></i> Send (WA)</a>
                <a class="dropdown-item" href="javascript:void(0);" id="detailSended" data-id="{{ $prs['id'] }}" nopol="{{ $prs['no_pol'] }}"><i class="mdi mdi-eye me-1"></i> Detail Sended</a>
                <a class="dropdown-item" href="javascript:void(0);" id="showNotActive" data-id="{{ $prs['id'] }}"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a>
                <a class="dropdown-item" href="javascript:void(0);" id="deleteIn" data-id="{{ $prs['id'] }}"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a>
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modalAdd">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Person</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addForm">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" required name="fullname" placeholder="Full Name">
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" required name="email" placeholder="Email">
          </div>
          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="number" class="form-control" id="phone" required name="phone" placeholder="Phone">
          </div>
          <div class="mb-3">
            <label class="form-label">No Polisi</label>
            <input type="text" class="form-control" id="no_pol" required name="no_pol" placeholder="No Polisi">
          </div>
          <div class="mb-3">
            <label class="form-label">Expire</label>
            <input type="date" class="form-control" id="end_date" required name="end_date">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Edit --}}
<div class="modal fade" tabindex="-1" id="modalStatus">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Person</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editStatusForm">
        <div class="modal-body">
          <div class="mb-3">
            <input type="text" class="form-control" id="id" hidden readonly required name="id">
            <label class="form-label">Status</label>
            <select id="status" required class="form-select">
              <option value="0">Active</option>
              <option value="1">Not Active</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--/ Basic Bootstrap Table -->

{{-- Log Message --}}
<div class="modal fade" tabindex="-1" id="modalLogSended">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Log Message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editStatusForm">
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">SID</th>
                  <th scope="col">No Pol</th>
                  <th scope="col">Tanggal Dikirim</th>
                </tr>
              </thead>
              <tbody id="tbody">
              </tbody>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- End  --}}

{{-- Modal Spinner --}}
<div class="modal fade" tabindex="-1" id="modalLoading">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Loading ....</h5>
        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
      </div>
      <div class="modal-body d-flex justify-content-center align-items-center" style="min-height: 200px;">
        <div class="spinner-border spinner-border-lg text-primary text-center" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- End Modal Spinner --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $(document).ready(function() {

    $('body').on('click', '#showNotActive', function() {
      let id = $(this).attr('data-id');
      $('input[name="id"]').val(id);
      $('#modalStatus').modal('show');
    });

    $('body').on('click', '#detailSended', function() {
      const id = $(this).attr('data-id');
      const nopol = $(this).attr('nopol');
      let token = '{{ csrf_token() }}';
      $('#modalLoading').modal('show');

      $.ajax({
        url: '{{ url("log-sended") }}',
        method: "POST",
        data: {
          '_token': token,
          'id': id
        },
        dataType: 'json',
        success: function(data) {
          let templateHtml = [];

          for (let i = 0; i < data.data.length; i++) {
            const element = data.data[i];

            const tanggalSended = getFormatDate(element.created_at);
            // const tanggalSended = new Date(element.created_at);
            
            let res = `
              <tr>
                <th scope="row">${i + 1}</th>
                <td>${ element.SID }</td>
                <td>${ nopol ?? '-' }</td>
                <td>${ tanggalSended }</td>
              </tr>
            `;

            templateHtml.push(res);
          }

          $('#tbody').html(templateHtml);

          setTimeout(() => {
            $('#modalLoading').modal('hide');
            $('#modalLogSended').modal('show');
          }, 1500);
        },
        error: function(err) {
          console.log(err);
        }
      });
    });

    $('body').on('click', '#deleteIn', function() {
      let id = $(this).attr('data-id');
      let token = '{{ csrf_token() }}';

      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '{{ url("delete-person") }}',
            method: "POST",
            data: {
              '_token': token, // pastikan CSRF token sudah benar
              'id': id
            },
            dataType: 'json', // ini harusnya 'dataType' bukan 'typeData'
            success: function(data) {
              Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success",
                confirmButtonText: "OK"
              }).then((result) => {
                if (result.isConfirmed) {
                  location.reload(); // Reload halaman setelah konfirmasi
                }
              });
            },
            error: function(err) {
              console.log(err);
            }
          });
        }
      });
    });

    $('#showAdd').on('click', function() {
      $('#modalAdd').modal('show');
    });

    $('#editStatusForm').submit(function(e) {
      e.preventDefault();
      $('#modalStatus').modal('hide');

      var formData = {
        status: $('#status').val(),
        id: $('#id').val(),
        _token: '{{ csrf_token() }}' // Menambahkan CSRF token
      };

      $.ajax({
        url: '{{ url("edit-status") }}', // Ganti dengan URL endpoint yang benar
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
          Swal.fire({
            title: "Success!",
            text: "Data has been edited successfully.",
            icon: "success",
            confirmButtonText: "OK"
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload(); // Reload halaman setelah konfirmasi
            }
          });
        },
        error: function(err) {
          console.log(err);
          Swal.fire({
            title: "Error!",
            text: "Something went wrong.",
            icon: "error",
            confirmButtonText: "OK"
          });
        }
      });
    });

    $('#addForm').submit(function(e) {
      e.preventDefault();
      $('#modalAdd').modal('hide');

      var formData = {
        fullname: $('#fullname').val(),
        email: $('#email').val(),
        phone: $('#phone').val(),
        no_pol: $('#no_pol').val(),
        end_date: $('#end_date').val(),
        _token: '{{ csrf_token() }}' // Menambahkan CSRF token
      };

      $.ajax({
        url: '{{ url("add-person") }}', // Ganti dengan URL endpoint yang benar
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
          Swal.fire({
            title: "Success!",
            text: "Data has been added successfully.",
            icon: "success",
            confirmButtonText: "OK"
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload(); // Reload halaman setelah konfirmasi
            }
          });
        },
        error: function(err) {
          console.log(err);
          Swal.fire({
            title: "Error!",
            text: "Something went wrong.",
            icon: "error",
            confirmButtonText: "OK"
          });
        }
      });
    });

    $('body').on('click', '#sendWa', function(e) {
      e.preventDefault();

      let id = $(this).attr('data-id');

      var settings = {
        "url": `http://localhost:3030/api/login/sendTwillio?id=${id}`,
        "method": "POST",
        "timeout": 0,
      };

      $.ajax(settings).done(function (response) {
        Swal.fire({
          title: "Success!",
          text: "Data has been sended successfully.",
          icon: "success",
          confirmButtonText: "OK"
        }).then((result) => {
          if (result.isConfirmed) {
            console.log(response);
          }
        });
      });
    });
  })
</script>

@endsection
