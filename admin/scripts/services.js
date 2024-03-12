let add_service_form = document.getElementById('add_service_form');

add_service_form.addEventListener('submit', function(e){
    e.preventDefault();
    add_services();
});

function add_services(){
        let data = new FormData();
        data.append('add_service', '');
        data.append('name',add_service_form.elements['name'].value);
        data.append('price',add_service_form.elements['price'].value);
        data.append('description',add_service_form.elements['description'].value);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/services.php", true);

        xhr.onload = function(){
            var myModal = document.getElementById('add-service');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            if(this.responseText == 1){
                alert('success', 'New Service Added!');
                add_service_form.reset();
                get_all_services();
            }else{
                alert ('error', 'Server Down!');
            }
        }
        xhr.send(data);
}

function get_all_services(){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/services.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
            document.getElementById('serviceData').innerHTML = this.responseText;
        }
        xhr.send('get_all_services');
}

let edit_service_form = document.getElementById('edit_service_form');

function edit_details(id){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/services.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        edit_service_form.elements['name'].value = data.serviceData.name;
        edit_service_form.elements['price'].value = data.serviceData.price;
        edit_service_form.elements['description'].value = data.serviceData.description;
        edit_service_form.elements['service_id'].value = data.serviceData.id;
    }
    xhr.send('get_service='+id);
}

edit_service_form.addEventListener('submit', function(e){
    e.preventDefault();
    submit_edit_services();
});

function submit_edit_services(){
    let data = new FormData();
    data.append('edit_service', '');
    data.append('name',edit_service_form.elements['name'].value);
    data.append('description',edit_service_form.elements['description'].value);
    data.append('price',edit_service_form.elements['price'].value);
    data.append('service_id',edit_service_form.elements['service_id'].value);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/services.php", true);
    xhr.onload = function(){
        var myModal = document.getElementById('edit-service');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == 1){
            alert('success', 'Service Data Updated!');
            edit_service_form.reset();
            get_all_services();
            
        }else{
            alert ('error', 'Server Down!');
        }
    }
    xhr.send(data);
}
// 
function toggle_status(id,val){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/services.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        if(this.responseText == 1){
            alert('success', 'Status Toggled');
            get_all_services();
        }else{
            alert('error', 'Server Down!');
        }
    }
    xhr.send('toggle_status='+id+'&value='+val);
}

let add_image_form = document.getElementById('add_image_form');
add_image_form.addEventListener('submit', function(e){
    e.preventDefault();
    add_image();
});

function add_image()
{
    let data = new FormData();
    data.append('image',add_image_form.elements['image'].files[0]);
    data.append('service_id',add_image_form.elements['service_id'].value);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/services.php", true);

    xhr.onload = function(){

        if(this.responseText == 'inv_img'){
            alert ('error', 'Only JPG, WEBP and PNG files are allowed!','image-alert');
        }else if(this.responseText == 'inv_size'){
            alert ('error', 'The file exceeded the required 2mb','image-alert');
        }else if(this.responseText == 'upd_failed'){
            alert ('error', 'Upload failed. Server Down!','image-alert');
        }else{
            alert('success', 'New image added!','image-alert');
            add_image_form.reset();
            service_images(add_image_form.elements['service_id'].value,document.querySelector("#service-image .modal-title").innerText);
        }
    }
    xhr.send(data);
}

function service_images(id,rname){
    document.querySelector("#service-image .modal-title").innerText = rname;
    add_image_form.elements['service_id'].value = id;
    add_image_form.elements['image'].value = '';

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/services.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        document.getElementById('service-image-data').innerHTML = this.responseText;
    }
    xhr.send('get_service_images='+id);
}
function rem_image(img_id,service_id){
    let data = new FormData();
    data.append('image_id',img_id);
    data.append('service_id',service_id);
    data.append('rem_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/services.php", true);

    xhr.onload = function(){

        if(this.responseText == 1){
            alert('success', 'Image Removed!','image-alert');
            service_images(room_id,document.querySelector("#service-image .modal-title").innerText);
        }else{
            alert ('error', 'Image Removal Failed!','image-alert');
        }
    }
    xhr.send(data);
}
function thumb_image(img_id,service_id){
    let data = new FormData();
    data.append('image_id',img_id);
    data.append('service_id',service_id);
    data.append('thumb_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/services.php", true);

    xhr.onload = function(){

        if(this.responseText == 1){
            alert('success', 'Image Thumbnail Changed!','image-alert');
            service_images(room_id,document.querySelector("#service-image .modal-title").innerText);
        }else{
            alert ('error', 'Thumbnail Update Failed!','image-alert');
        }
    }
    xhr.send(data);
}
function remove_service(service_id){
    if(confirm("Are you sure, you want to delete this service?")){
        let data = new FormData();
        data.append('service_id',service_id);
        data.append('remove_service', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/services.php", true);
    
        xhr.onload = function(){
    
            if(this.responseText == 1){
                alert('success', 'Service Removed!');
                get_all_services();
            }else{
                alert ('error', 'Failed to remove service!');
            }
        }
        xhr.send(data);
    }

}
window.onload = function(){
    get_all_services();
}