
function get_all_cancel_appointments(search=''){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/refund_appointments.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        document.getElementById('appointmentData').innerHTML = this.responseText;
    }
    xhr.send('get_all_cancel_appointments&search='+search);
}

function refund_appointment(id,patient_email,order_id,date,time,phone_num){
    if(confirm("Refund Appointment?")){
        let data = new FormData();
        data.append('id',id);
        data.append('patient_email',patient_email);
        data.append('order_id',order_id);
        data.append('date',date);
        data.append('time',time);
        data.append('phone_num',phone_num);
        data.append('accept_appointment', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/refund_appointments.php", true);
    
        xhr.onload = function(){
    
            if(this.responseText == 1){
                alert('success', 'Appointment Refund!');
                get_all_cancel_appointments();
            }
            // else if(this.responseText == 'mail_failed'){
            //     alert('error', 'Email confirmation did not go through!');
            //     get_all_appointments();
            // }
            else{
                alert ('error', 'Failed to Accept Appointment! Server Down!');
                // get_all_cancel_appointments();
            }
        }
        xhr.send(data);
    }

}

window.onload = function(){
    get_all_cancel_appointments();
}