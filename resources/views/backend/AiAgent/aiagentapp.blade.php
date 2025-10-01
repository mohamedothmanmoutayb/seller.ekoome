@extends('backend.layouts.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">



<!-- Content wrapper -->
    
        <!-- Content -->
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Ai Agent app</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex" href="../horizontal/index.html">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                            
   Ai Agent
                                    </span>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            
        </div>
                    <button type="button" class="btn rounded-pill waves-effect waves-light btn-dark px-4 fs-4" data-bs-toggle="modal" data-bs-target="#dark-header-modal">
                     <i class="bi bi-plus-circle"> </i>
    &nbsp; New AI Agent 
                      </button>
                    <div id="dark-header-modal" class="modal fade" tabindex="-1" aria-labelledby="dark-header-modalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                          <div class="modal-header modal-colored-header bg-dark">
                            <h4 class="modal-title text-white" id="dark-header-modalLabel">
   &nbsp; &nbsp;  &nbsp;  &nbsp; <i class="fa fa-user"></i>   &nbsp; AI Agent
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>


            <div class="modal-body">

              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">AI Agent Form</h4>
                  <p class="card-subtitle mb-3">
                    Create your AI Agent with the following form. Fill in the details below to set up your AI Agent profile.
                  </p>
                  <form id="ai-agent-form" >
                    @csrf
                    <div class="form-floating mb-3">
                      <input type="text" name="name" class="form-control" placeholder="Agent name" required />
                      <label>
                        <i class="ti ti-user me-2 fs-4"></i>Agent name
                      </label>
                    </div>
                    <div class="form-floating mb-3">
                    <select class="form-select" name="sexe" id="floatingSelect" aria-label="Sexe" required>
                    
                               <option value="male">Male</option>
                                <option value="female">Female</option>

                    </select>
                    <label for="floatingSelect">
                        <i class="ti ti-language me-2 fs-4"></i>Sexe
                    </label>
                    </div>

                    <div class="form-floating mb-3">
                      <input type="text" name="language" class="form-control" placeholder="Agent language" required/>
                      <label>
                        <i class="fas fa-language"></i>
                       &nbsp; Agent language
                      </label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" name="product_languages" class="form-control" placeholder="products languages" required/>
                      <label>
                        <i class="fas fa-box"></i>
                          &nbsp;  Your products languages
                      </label>
                    </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                              Close
                            </button>
                            <button type="submit" class="btn btn-dark">
                              Save changes
                            </button>
                          </div>
                </form>

              </div>
                 </div>
                    </div>


    
    
    
                        </div>
                        </div>
                    </div>
                                    
                    <hr>
 

            
  <div class="table-responsive mb-4 border rounded-1">
        @if($agents->isEmpty())
        <p>No AI agents found.</p>
    @else
                <table class="table text-nowrap mb-0 align-middle  table-hover">
                  <thead class="text-dark fs-4">
                    <tr>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Name</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Sexe</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Language</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Product Languages</h6>
                      </th>
                     
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach ($agents as $agent)
                    <tr class="clickable-row" style="cursor: pointer;" data-href="{{ route('aiagents.show', $agent->id) }}">
                      <td>
                        <div class="d-flex align-items-center">
                          <div>
                            <h6 class="fs-4 fw-semibold mb-0"><img src="../../public/assistant.png" class="me-1" width="40" height="40"> {{ $agent->name }}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal">{{ ucfirst($agent->sexe) }}</p>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                           <span class="badge bg-primary-subtle text-primary">{{ $agent->language }}</span>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-primary-subtle text-primary"> {{ $agent->product_languages }}</span>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                           
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3 edit-btn" data-id="{{ $agent->id }}" href="javascript:void(0)">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>

                   

                            </li>
                           <li>
                            <a href="javascript:void(0)" 
                                class="dropdown-item d-flex align-items-center gap-3 delete-agent" 
                                data-id="{{ $agent->id }}">
                                <i class="fs-4 ti ti-trash"></i>Delete
                            </a>
                            </li>

                          </ul>
                        </div>
                      </td>
                    </tr>
                        @endforeach
                  </tbody>
                </table>
                   @endif
              </div>

                         <!-- Edit Modal -->
<div class="modal fade" id="editAgentModal" tabindex="-1" aria-labelledby="editAgentLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="edit-agent-form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editAgentLabel">Edit AI Agent</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            @csrf
            <input type="hidden" id="edit-agent-id">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" id="edit-name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Sexe</label>
                <select name="sexe" id="edit-sexe" class="form-control" required>
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Language</label>
                <input type="text" name="language" id="edit-language" class="form-control">
            </div>
            <div class="mb-3">
                <label>Product Languages</label>
                <input type="text" name="product_languages" id="edit-product-languages" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
                   </div>
              
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$('#ai-agent-form').on('submit', function(e) {
    e.preventDefault();

    let formDataArray = $(this).serializeArray();
    let name = '';
    let sexe = '';
    let language = '';
    let product_languages = '';


    $.each(formDataArray, function (_, field) {
        switch (field.name) {
            case 'name':
                name = field.value;
                break;
            case 'sexe':
                sexe = field.value;
                break;
            case 'language':
                language = field.value;
                break;
            case 'product_languages':
                product_languages = field.value;
                break;
        }
    });

  
    let dataObject = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        name: name,
        sexe: sexe,
        language: language,
        product_languages: product_languages
    };
    dataObject._token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '{{ route("aiagents.store") }}',
        method: 'POST',
        data: dataObject,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'AI Agent created successfully.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Failed to Save',
                text: 'Error: ' + error,
                footer: '<code>' + xhr.responseText + '</code>'
            });
        }
    });
});


$(document).ready(function() {
    $('.edit-btn').on('click', function() {
        const id = $(this).data('id');
        $.get(`/aiagent/${id}/edit`, function(data) {
            $('#edit-agent-id').val(data.id);
            $('#edit-name').val(data.name);
            $('#edit-sexe').val(data.sexe);
            $('#edit-language').val(data.language);
            $('#edit-product-languages').val(data.product_languages);
            $('#editAgentModal').modal('show');
        });
    });

    $('#edit-agent-form').on('submit', function(e) {
        e.preventDefault();
        const id = $('#edit-agent-id').val();
        const url = `/aiagent/${id}`;

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                _method: 'PUT',
                name: $('#edit-name').val(),
                sexe: $('#edit-sexe').val(),
                language: $('#edit-language').val(),
                product_languages: $('#edit-product-languages').val()
            },
            success: function(response) {
                Swal.fire('Updated!', 'Agent updated successfully.', 'success');
                $('#editAgentModal').modal('hide');
                setTimeout(() => window.location.reload(), 1000);
            },
        error: function(xhr) {
    Swal.fire({
        icon: 'error',
        title: 'Update failed',
        text: xhr.responseJSON?.message || 'Could not update agent.',
        footer: Object.values(xhr.responseJSON?.errors || {}).flat().join('<br>') || xhr.responseText
    });
}

        });
    });
});

$(document).on('click', '.delete-agent', function () {
    let agentId = $(this).data('id');
    let url = `/aiagent/${agentId}`;
    let token = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        imageUrl: '../../public/sad.png', 
        imageWidth: 100,
        imageHeight: 100,
        imageAlt: 'Sad AI Robot',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: token
                },
                success: function (response) {
                    Swal.fire('Deleted!', 'Agent has been deleted.', 'success');
                    setTimeout(() => window.location.reload(), 1000);
                },
                error: function (xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.message || 'Could not delete.', 'error');
                }
            });
        }
    });
});



  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.clickable-row').forEach(function (row) {
      row.addEventListener('click', function (e) {
        if (!e.target.closest('.dropdown')) {
          window.location = this.dataset.href;
        }
      });
    });
  });




</script>


   @endsection 
@endsection


