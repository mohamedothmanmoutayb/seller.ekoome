<style>


  .form-check-input:checked {
    background-color: #28a745;  /* Green */
    border-color: #28a745;
  }

  .form-check-input:not(:checked) { /* Gray */
    border-color: #6c757d;
  }
</style>

@php
  $actions = $agent->actions ?? [];
@endphp

   <div class="mx-5 mt-5">

   <div class="row">
            <div class="col-lg-4 col-md-6">
              <div class="card  border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                    <span class="text-dark display-8">
                      <img src="../../public/seo.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Search Product</h5>
                        <p>Receives names and outputs the related products</p>
                    </span>
                  
                    <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
                 <input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Search Product" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
  {{ in_array('Search Product', $actions) ? 'checked' : '' }}
>                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-lg-4 col-md-6">
              <div class="card  border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/order.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Create new order</h5>
                        <p>Receives names and outputs the related products</p>
                    </span>
                      <div class="position-relative" style="height: 80px;">
                      <div class="position-absolute top-0 end-0 d-flex align-items-center" style="gap: 10px; margin-top: -25px; ">
                        <div class="form-check form-switch m-0">
                    <input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Create new order" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
  {{ in_array('Create new order', $actions) ? 'checked' : '' }}
>

                        </div>

                        <button class="border-0 bg-transparent p-0" style="color: black;">
                          <i class="fas fa-cog fs-6"></i>
                        </button>
                      </div>
                    </div>
                        </div>
                  </div>
                </div>
              </div>
           



            <div class="col-lg-4 col-md-6">
              <div class="card  border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/orderbox.png" alt="png" class="img-fluid" width="40" style="margin-bottom: 10px;">
                      
                        <h5 class="fw-bold">Available products</h5>
                        <p>Receives available products</p>
                    </span>
                    <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
            <input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Available products" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
    {{ in_array('Available products', $actions) ? 'checked' : '' }}
>

                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>




            
        <div class="col-lg-4 col-md-6">
              <div class="card   border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/shipping.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Update order info</h5>
                        <p>Update order information</p>
                    </span>
                  <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
<input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Update order info" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
    {{ in_array('Update order info', $actions) ? 'checked' : '' }}
>
                </div>
                    </div>
                </div>
              </div>
            </div>
        </div>  

           


                           
        <div class="col-lg-4 col-md-6">
               <div class="card border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/add-to-cart.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Add products to order</h5>
                        <p>Add new products to an order</p>
                    </span>
                   <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
<input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Add products to order" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
    {{ in_array('Add products to order', $actions) ? 'checked' : '' }}
>
                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>




          

        <div class="col-lg-4 col-md-6">
              <div class="card border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/track-order.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold"> Track order</h5>
                        <p style="width: 115%;" >Enter order number for fulfillment courier tracking details</p>
                    </span>
                     <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
<input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Track order" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
    {{ in_array('Track order', $actions) ? 'checked' : '' }}
>
                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    
             
                
                

        <div class="col-lg-4 col-md-6">
                      <div class="card  border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/info.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Get product information</h5>
                        <p>Retrieve product details including stock availability, pricing, and more</p>
                    </span>
                   <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
<input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Get product information" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
      {{ in_array('Get product information', $actions) ? 'checked' : '' }}


>
                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>










        <div class="col-lg-4 col-md-6">
                         <div class="card  border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/order-history.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Get customer orders history</h5>
                        <p>Get customer history of the last 10 orders by providing their phone number</p>
                    </span>
                   <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
<input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Get customer orders history" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
      {{ in_array('Get customer orders history', $actions) ? 'checked' : '' }}

>
                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



        
        

        <div class="col-lg-4 col-md-6">
                  <div class="card  border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/menu.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Get customer last order</h5>
                        <p>Get the last order of a customer by providing their phone number</p>
                    </span>
                   <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
<input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Get customer last order" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
      {{ in_array('Get customer last order', $actions) ? 'checked' : '' }}

>
                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>




        
        <div class="col-lg-4 col-md-6">
                      <div class="card  border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/order-fulfillment.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Search customer orders</h5>
                        <p>Search for an order get the order list by providing the customer phone number </p>
                    </span>
                   <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
<input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Search customer orders" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
      {{ in_array('Search customer orders', $actions) ? 'checked' : '' }}

>
                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



       
                      
        <div class="col-lg-4 col-md-6">
                     <div class="card  border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/customer-care.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Handle customer request</h5>
                        <p>Handles customer request for unavailable functions</p>
                    </span>
                    <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
<input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Handle customer request" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
      {{ in_array('Handle customer request', $actions) ? 'checked' : '' }}

>
                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


                      
        <div class="col-lg-4 col-md-6">
                    <div class="card  border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/cancelled.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Cancel order</h5>
                        <p>Cancels an order given the order number and an optional reason</p>
                    </span>
                  <div class="position-relative" style="height: 80px;">
                      <div class="position-absolute top-0 end-0 d-flex align-items-center" style="gap: 10px; margin-top: -25px; ">
                        <div class="form-check form-switch m-0">
                    <input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Cancel order" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
      {{ in_array('Cancel order', $actions) ? 'checked' : '' }}

>

                        </div>

                        <button class="border-0 bg-transparent p-0" style="color: black;">
                          <i class="fas fa-cog fs-6"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


                           
        <div class="col-lg-4 col-md-6">
                    <div class="card  border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/shopping-bag.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Confirm orders</h5>
                        <p>Order confirmation required to start fulfillment after creating new order</p>
                    </span>
                    <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
<input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Confirm orders" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
      {{ in_array('Confirm orders', $actions) ? 'checked' : '' }}

>
                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


                           
        <div class="col-lg-4 col-md-6">
                    <div class="card  border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/replacement.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Replace order products</h5>
                        <p>Remove current products from an order and add new products</p>
                    </span>
                    <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
<input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Replace order products" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
  {{ in_array('', $agent->actions ?? []) ? 'checked' : '' }}
      {{ in_array('Replace order products', $actions) ? 'checked' : '' }}

>
                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>




         <div class="col-lg-4 col-md-6">
             <div class="card  border border-dark">
                <div class="card-body" style="padding-bottom: 10px;">
                  <div class="d-flex align-items-center justify-content-between">
                      <span class="text-dark display-8">
                      <img src="../../public/product-description.png" alt="png" class="img-fluid" width="30" style="margin-bottom: 10px;">
                        <h5 class="fw-bold">Get order information</h5>
                        <p style="width: 115%;">Enter the order number to view customer details and purchased items</p>
                    </span>
                 <div>
                <div class="form-check form-switch" style="margin-top: -65px; ">
<input 
  type="checkbox" 
  class="form-check-input action-toggle" 
  data-title="Get order information" 
  data-agent-id="{{ $agent->id }}"
  style="width: 50px; height: 25px;"
      {{ in_array('Get order information', $actions) ? 'checked' : '' }}

>
                </div>
                    </div>
                </div>
              </div>
            </div>
        </div>




        </div>
    </div>



<script>
document.querySelectorAll('.action-toggle').forEach(function(toggle) {
  toggle.addEventListener('change', function () {
    const agentId = this.dataset.agentId;
    const title = this.dataset.title;
    const enabled = this.checked && !this.disabled;

    fetch(`/ai-agent/${agentId}/save-enabled-actions`, { 
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({
        action: title,
        enabled: enabled
      })
    })
    .then(res => res.json())
    .then(data => {
      if(data.success) {
      if (enabled) {
          showSuccessNotification(`Ajouté avec succès !`);
        }
      } else {
        showErrorNotification(`❌ Erreur lors de la mise à jour de "${title}".`);
      }
    })
    .catch(err => {
      console.error('Error:', err);
      showErrorNotification(`❌ Erreur réseau lors de la mise à jour de "${title}".`);
    });
  });
});

// Success toast
function showSuccessNotification(message) {
  const toast = document.createElement('div');
  toast.textContent = message;
  toast.style.cssText = `
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #28a745;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
    z-index: 9999;
  `;
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}

// Error toast
function showErrorNotification(message) {
  const toast = document.createElement('div');
  toast.textContent = message;
  toast.style.cssText = `
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #dc3545;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
    z-index: 9999;
  `;
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}
</script>
