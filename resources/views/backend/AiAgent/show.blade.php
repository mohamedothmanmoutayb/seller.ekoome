@extends('backend.layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">




<!-- Content wrapper -->
    
        <!-- Content -->
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">

                       <a href="{{ route('aiagents.index') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                        <i class="ti ti-arrow-left fs-5"></i> 
                    </a>
                    <h2 class="mb-4 mb-sm-0 fw-bold text-capitalize">
                      <img src="../../public/robot.png" class="me-1" width="40" height="40">
                        {{ $agent->name }}
                    </h2>
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
                   
            

   <div class="card">
           <ul class="nav nav-pills user-profile-tab justify-content-center" id="pills-tab" role="tablist">

  <!-- Data Source Tab -->
  <li class="nav-item" role="presentation">
    <button class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" 
            id="pills-data-tab" 
            data-bs-toggle="pill" 
            data-bs-target="#pills-data" 
            type="button" 
            role="tab" 
            aria-controls="pills-data" 
            aria-selected="true">
      <i class="ti ti-database me-2 fs-6"></i>
      <span class="d-none d-md-block">Data Source</span>
    </button>
  </li>

  <!-- Actions Tab -->
  <li class="nav-item" role="presentation">
    <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" 
            id="pills-actions-tab" 
            data-bs-toggle="pill" 
            data-bs-target="#pills-actions" 
            type="button" 
            role="tab" 
            aria-controls="pills-actions" 
            aria-selected="false">
     <img src="../../public/actionable.png" class="me-2" width="30" height="30">
      <span class="d-none d-md-block">Actions</span>
    </button>
  </li>

  <!-- Settings Tab -->
  <li class="nav-item" role="presentation">
    <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" 
            id="pills-settings-tab" 
            data-bs-toggle="pill" 
            data-bs-target="#pills-settings" 
            type="button" 
            role="tab" 
            aria-controls="pills-settings" 
            aria-selected="false">
      <i class="fas fa-cog me-2 fs-6"></i>
      <span class="d-none d-md-block">Settings</span>
    </button>
  </li>
</ul>
<d class="tab-content" id="pills-tabContent">
  <!-- Data Source Content -->
  <div class="tab-pane fade show active" id="pills-data" role="tabpanel" aria-labelledby="pills-data-tab">
    <br>
@if($agent->knowledgeEntries->isEmpty())
  <div class="col-lg-4 mx-auto"> 
    <div class="card">
      <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">AI Agent {{ $agent->name }}'s Data source</h4>
      </div>

      <form id="data-source-form">
        @csrf
        <input type="hidden" id="edit-agent-id" value="{{ $agent->id }}">
        <div class="card-body p-4">
          <div class="mb-4">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
          </div>

          <div class="mb-4">
            <label for="body" class="form-label">Body</label>
            <textarea class="form-control p-7" name="body" id="body" cols="20" rows="1" placeholder="Share the knowledge your AI Agent should use."></textarea>
          </div>

          <div class="mb-4">
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </div>
      </form>
    </div>
  </div>
{{-- ELSE --}}
@else
  <div class="col-lg-8 mx-auto">
    <div class="card">
      <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">AI Agent {{ $agent->name }}'s Data sources</h4>
      </div>


      

        <button type="button" class="btn rounded-pill waves-effect waves-light btn-dark px-4 fs-4 ms-4 mt-3" style="width: 25%" data-bs-toggle="modal" data-bs-target="#dark-header-modal">
                     <i class="bi bi-plus-circle"> </i>
    &nbsp; Add data source
                      </button>
                    <div id="dark-header-modal" class="modal fade" tabindex="-1" aria-labelledby="dark-header-modalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                          <div class="modal-header modal-colored-header bg-dark">
                            <h4 class="modal-title text-white" id="dark-header-modalLabel">
   &nbsp; &nbsp;  &nbsp;  &nbsp; <i class="fa fa-user"></i>   &nbsp; AI Agent : {{ $agent->name }} 
                            </h4> 
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>


            <div class="modal-body">

                     <div class="card">
      <div class="px-4 py-3 ">
        <h4 class="card-title mb-0">AI Agent {{ $agent->name }}'s Data source</h4>
      </div>

      <form id="data-source-form">
        @csrf
        <input type="hidden" id="edit-agent-id" value="{{ $agent->id }}">
        <div class="card-body p-4">
          <div class="mb-4">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
          </div>

          <div class="mb-4">
            <label for="body" class="form-label">Body</label>
            <textarea class="form-control p-7" name="body" id="body" cols="20" rows="1" placeholder="Share the knowledge your AI Agent should use."></textarea>
          </div>

        
             <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Create</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal"> Close </button>
            </div>
        </div>
      </form>
    </div>
                    </div>


    
    
    
                        </div>
                        </div>
                    </div>
      <div class="card-body p-4">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Title</th>
              <th>Body</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($agent->knowledgeEntries as $knowledge)
            <tr>
              <td>{{ $knowledge->title }}</td>
              <td>{{ $knowledge->body }}</td>
              <td class="text-center">
                <!--  action buttons -->
                <button class="btn btn-sm btn-dark edit-btn"  data-id="{{ $knowledge->id }}"><i class="fs-4 ti ti-edit"></i></button>

              <!-- Modal to Edit Knowledge Entry -->
              <div class="modal fade" id="editKnowledgeModal" tabindex="-1" aria-labelledby="editKnowledgeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <form id="edit-knowledge-form">
                    @csrf
                    <input type="hidden" name="id" id="knowledge-id">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="editKnowledgeModalLabel">Edit Data Source</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3">
                          <label for="edit-title" class="form-label">Title</label>
                          <input type="text" class="form-control" id="edit-title" name="title" required>
                        </div>
                        <div class="mb-3">
                          <label for="edit-body" class="form-label">Body</label>
                          <textarea class="form-control" id="edit-body" name="body" rows="3" required></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Update</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
                
                <button class="btn btn-sm btn-light" onclick="deleteKnowledge({{ $knowledge->id }})">     <i class="fs-5 ti ti-trash"></i>  </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endif


  </div>

  <!-- Actions Content -->
  <div class="tab-pane fade" id="pills-actions" role="tabpanel" aria-labelledby="pills-actions-tab">

      @include('backend.AiAgent.actions', ['agent' => $agent])

  </div>

  <!-- Settings Content -->
 <!-- Settings Content -->

  <div class="tab-pane fade" id="pills-settings" role="tabpanel" aria-labelledby="pills-settings-tab">
    <br>
    <div class="col-lg-6 mx-auto" >
      <div class="card">
        <div class="px-4 py-3 border-bottom">
          <h4 class="card-title mb-0">AI Agent {{ $agent->name }}'s Settings</h4>
        </div>

        <form id="edit-agent-form">
          @csrf
          <input type="hidden" id="edit-agent-id" value="{{ $agent->id }}">
          <div class="card-body p-4">
            <div class="mb-4">
              <label for="edit-name" class="form-label">Name</label>
              <input type="text" name="name" id="edit-name" class="form-control" required value="{{ old('name', $agent->name) }}">
            </div>

            <div class="mb-4">
              <label for="edit-sexe" class="form-label">Sexe</label>
              <select name="sexe" id="edit-sexe" class="form-control" required>
                <option value="">Select</option>
                <option value="male" {{ old('sexe', $agent->sexe) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('sexe', $agent->sexe) == 'female' ? 'selected' : '' }}>Female</option>
              </select>
            </div>

            <div class="mb-4">
              <label for="edit-language" class="form-label">Language</label>
              <div class="input-group">
                <input type="text" name="language" id="edit-language" class="form-control" value="{{ old('language', $agent->language) }}">
                <span class="input-group-text px-6" id="basic-addon1">Ex. Arabic</span>
              </div>
            </div>

            <div class="mb-4">
              <label for="edit-product-languages" class="form-label">Product Languages</label>
              <input type="text" name="product_languages" id="edit-product-languages" class="form-control" value="{{ old('product_languages', $agent->product_languages) }}">
            </div>

             <div class="mb-4">
                    <label class="form-label">Prompt</label>
              <textarea class="form-control p-7"
          name="custom_prompt"
          id="edit-prompt"
          cols="20"
          rows="1"
          placeholder="Create your custom Ai prompt">{{ old('custom_prompt', $agent->custom_prompt) }}</textarea>

                  </div>

            <div class="mb-4">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


<script>
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
            product_languages: $('#edit-product-languages').val(),
            custom_prompt: $('#edit-prompt').val()
        },
        success: function(response) {
            Swal.fire('Updated!', 'Agent updated successfully.', 'success');
            alert(data);
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


  $('#data-source-form').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
      url: '{{ route("ai-agent.addKnowledge") }}',
      type: 'POST',
      data: {
        _token: $('input[name="_token"]').val(),
        agent_id: $('#edit-agent-id').val(),
        title: $('#title').val(),
        body: $('#body').val()
      },
      success: function (response) {
        Swal.fire('Success!', 'Agent updated successfully.', 'success');
            setTimeout(() => window.location.reload(), 1000);
      },
      error: function (xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Update failed',
                text: xhr.responseJSON?.message || 'Could not update agent.',
                footer: Object.values(xhr.responseJSON?.errors || {}).flat().join('<br>') || xhr.responseText
            });
      }
    });
  });

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function () {
      const knowledgeId = this.dataset.id;

      fetch(`/aiagents/knowledge/${knowledgeId}`)
        .then(res => res.json())
        .then(data => {
          document.getElementById('knowledge-id').value = data.id;
          document.getElementById('edit-title').value = data.title;
          document.getElementById('edit-body').value = data.body;
          new bootstrap.Modal(document.getElementById('editKnowledgeModal')).show();
        })
        .catch(err => {
          console.error("Failed to load data source:", err);
        });
    });
  });

  document.getElementById('edit-knowledge-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = document.getElementById('knowledge-id').value;
    const formData = new FormData(this);

    fetch(`/aiagents/knowledge/${id}`, {
      method: 'POST', 
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
      },
      body: formData
    })
    .then(res => res.json())
    .then(response => {
      if (response.success) {
        Swal.fire('Success!', 'Agent updated successfully.', 'success');
          setTimeout(() => window.location.reload(), 1000);
      } else {
        alert("Update failed");
      }
    })
    .catch(err => {
      console.error("Update error:", err);
    });
  });
});



function deleteKnowledge(id) {
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
        url: `/aiagent/knowledge/${id}`,
        type: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
          Swal.fire({
            title: 'Deleted!',
            text: response.message,
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
          });
           setTimeout(() => window.location.reload(), 1000);
        },
        error: function(xhr) {
          Swal.fire('Error', 'Failed to delete the knowledge entry.', 'error');
        }
      });
    }
  });
}


</script>


@endsection
