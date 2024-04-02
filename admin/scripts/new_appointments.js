function get_appointments(search=''){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_appointments.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        document.getElementById('appointments-data').innerHTML = this.responseText;
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
            }else{
                alert ('error', 'Failed to Accept Appointment! Server Down!');
            }
        }
        xhr.send(data);
    }

}
window.onload = function(){
    get_appointments();
}