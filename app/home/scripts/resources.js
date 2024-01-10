$(document).ready(function () {
    
    $('#resourceSearchForm').submit(function(e) {

        e.preventDefault();
        var q = $('#searchQuery').val();
        var baseURL = $('#resource_base_url').val();        
        var url = window.location.href; 
        var redirectURL = baseURL;
        if(q!==null && q!==undefined && q!=="" ){
            redirectURL = baseURL+ "/p1/" + q;
        }
        console.log(redirectURL);
        window.location.replace(redirectURL);  
    });
   
});


