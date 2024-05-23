let add_service_form = document.getElementById('add_service_form');

add_service_form.addEventListener('submit', function(e){
    e.preventDefault();
    add_announcements();
});

function add_announcements(){
        let data = new FormData();
        data.append('add_announcements', '');
        data.append('name',add_service_form.elements['name'].value);
        data.append('description',add_service_form.elements['description'].value);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/announcements.php", true);

        xhr.onload = function(){
            var myModal = document.getElementById('add-service');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            if(this.responseText == 1){
                alert('success', 'New Announcement Added!');
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
        xhr.open("POST", "ajax/announcements.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
            document.getElementById('serviceData').innerHTML = this.responseText;
        }
        xhr.send('get_all_services');
}

let edit_service_form = document.getElementById('edit_service_form');

function edit_details(id){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/announcements.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        edit_service_form.elements['name'].value = data.serviceData.title;
        edit_service_form.elements['description'].value = data.serviceData.description;
        edit_service_form.elements['announcement_id'].value = data.serviceData.id;
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
    data.append('announcement_id',edit_service_form.elements['announcement_id'].value);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/announcements.php", true);
    xhr.onload = function(){
        var myModal = document.getElementById('edit-service');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == 1){
            alert('success', 'Announcement Data Updated!');
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
    xhr.open("POST", "ajax/announcements.php", true);
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

function remove_service(announcement_id){
    if(confirm("Delete this annoucement?")){
        let data = new FormData();
        data.append('announcement_id',announcement_id);
        data.append('remove_service', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/announcements.php", true);
    
        xhr.onload = function(){
    
            if(this.responseText == 1){
                alert('success', 'Announcement removed!');
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