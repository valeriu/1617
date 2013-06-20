window.addEventListener('load', function(){
    var select = document.getElementById('paysList');

    select.addEventListener('change', function(){
        window.location = 'meteo.php?pays=' + this.value;
    }, false);
}, false);