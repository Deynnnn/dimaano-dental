    let generalData;
    function get_general()
    {
        let shutdown_toggle = document.getElementById('shutdown_toggle');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/settings_crud.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
            generalData = JSON.parse(this.responseText);

            if(generalData.shutdown == 0){
                shutdown_toggle.checked = false;
                shutdown_toggle.value = 0;
            }else{
                shutdown_toggle.checked = true;
                shutdown_toggle.value = 1;
            }
        }
        
        xhr.send('get_general');
    }

    function upd_shutdown(val){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/settings_crud.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function(){
            if(this.responseText == 1 && generalData.shutdown == 0){
                alert('success', 'SHUTDOWN MODE IS ON');
            }else{
                alert('success', 'SHUTDOWN MODE IS OFF'); 
            }
            get_general();
        }
        

        xhr.send('upd_shutdown='+val);
    }

    window.onload = function(){
        get_general();
    }
