function get_appointments(search=''){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_appointments.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        document.getElementById('appointmentData').innerHTML = this.responseText;
    }
    xhr.send('get_appointments&search='+search);
}
// done
function accept_appointment(id,patient_email,order_id,date,time,phone_num){
    if(confirm("Accept Appointment?")){
        let data = new FormData();
        data.append('id',id);
        data.append('patient_email',patient_email);
        data.append('order_id',order_id);
        data.append('date',date);
        data.append('time',time);
        data.append('phone_num',phone_num);
        data.append('accept_appointment', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/new_appointments.php", true);
    
        xhr.onload = function(){
    
            if(this.responseText == 1){
                alert('success', 'Appointment Accepted!');
                get_appointments();
            }
            // else if(this.responseText == 'mail_failed'){
            //     alert('error', 'Email confirmation did not go through!');
            //     get_appointments();
            // }
            else{
                alert ('error', 'Failed to Accept Appointment! Server Down!');
            }
        }
        xhr.send(data);
    }

}

function cancel_appointment(id,patient_email,order_id,date,time,phone_num){
    if(confirm("Cancel Appointment?")){
        let data = new FormData();
        data.append('id',id);
        data.append('patient_email',patient_email);
        data.append('order_id',order_id);
        data.append('date',date);
        data.append('time',time);
        data.append('phone_num',phone_num);
        data.append('cancel_appointment', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/new_appointments.php", true);

        xhr.onload = function(){
            if(this.responseText == 1){
                alert('success', 'Appointment Cancelled');
                get_appointments();
            }else{
                alert ('error', 'Failed to Cancel Appointment! Server Down!');
                get_appointments();
            }
        }
        xhr.send(data);
    }
}

let reschedule_form = document.getElementById('reschedule_date');

function reschedule_date(id){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_appointments.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        reschedule_form.elements['date'].value = data.appointmentData.date;
        reschedule_form.elements['time'].value = data.appointmentData.time;
        reschedule_form.elements['patient_email'].value = data.appointmentData.patient_email;
        reschedule_form.elements['appointment_ticket'].value = data.appointmentData.appointment_ticket;
        reschedule_form.elements['order_id'].value = data.appointmentData.order_id;
        reschedule_form.elements['phone_num'].value = data.appointmentData.phone_num;
    }
    xhr.send('get_appointments='+id);
}
//pending
reschedule_form.addEventListener('submit', function(e){
    e.preventDefault();
    submit_rescheduled_appointment();
});
//pending
function submit_rescheduled_appointment(){
    let data = new FormData();
    data.append('reschedule_appointment', '');
    data.append('appointment_id',reschedule_form.elements['appointment_id'].value);
    data.append('reschedule_date',reschedule_form.elements['reschedule_date'].value);
    data.append('reschedule_time',reschedule_form.elements['reschedule_time'].value);
    data.append('email',reschedule_form.elements['email'].value);
    data.append('name',reschedule_form.elements['name'].value);
    data.append('appointment_ticket',reschedule_form.elements['appointment_ticket'].value);
    data.append('contact_number',reschedule_form.elements['contact_number'].value);


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_appointments.php", true);

    xhr.onload = function(){
        var myModal = document.getElementById('reschedule_date');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(this.responseText == 1){
            alert('success', 'Appointment Rescheduled, Waiting for the confirmation from the patient!');
            reschedule_form.reset();
            get_appointments();
        }else{
            alert ('error', 'Server Down!');
        }
    }
    xhr.send(data);
}

window.onload = function(){
    get_appointments();
}