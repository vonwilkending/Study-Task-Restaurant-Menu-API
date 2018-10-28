   
     var dynamicContent = getParameterByName('page');
    
    // Parse URL parameter
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    $(document).ready(function() {
        
        if (dynamicContent == 'fellini') {
            $('.fellini').show();
            requestFellini();
        } 
        else if (dynamicContent == 'roma') {
            $('.roma').show();
            requestRoma();
        }
        else if (dynamicContent == 'montraw') {
            $('.montraw').show();
            requestMontraw();
        } 
        else {
            $('.default').show();
        }
    });

    //Filter Table
    function doSearch(table) {

        // Check if the URL parameters
        if (dynamicContent == 'fellini') { 
            var input = document.getElementById("fellini-input");
            var table = document.getElementById("fellini-food");
        }
        else if (dynamicContent == 'roma') { 
            var input = document.getElementById("roma-input");
            var table = document.getElementById("roma-food");
        }
        else if (dynamicContent == 'montraw') { 
            var input = document.getElementById("montraw-input");
            var table = document.getElementById("montraw-food");
        }
        else {
            var input = document.getElementById("SearchInput");
            var table = document.getElementById("food");
        }

        var select = document.getElementById("Searchsettings");
        var option = select.options[select.selectedIndex].value;
        var filter = input.value.toUpperCase();
        var tr = table.getElementsByTagName("tr");

        for (var i = 0; i < tr.length; i++) {

            if(option == 1){ //'Search for food' selected
                var td = tr[i].getElementsByTagName("td")[0];
            }
            else{ //'Search for Ingredients' selected
                var td = tr[i].getElementsByTagName("td")[1];
            }
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                    
                }
            }
        }
    }

    //show Accordion Items
    function AccFunc(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
            x.previousElementSibling.className += " w3-black";
        } else { 
            x.className = x.className.replace(" w3-show", "");
            x.previousElementSibling.className = 
            x.previousElementSibling.className.replace(" w3-black", "");
        }
    }

    function requestData(filter){

        document.getElementById("background").style.display = "none";
        document.getElementById("food").style.display = "";
        document.getElementById("SearchInput").style.display = "";
        document.getElementById("Searchsettings").style.display = "";

        $('#food tr').slice(1).remove();
        var xhttp = new XMLHttpRequest();
                    xhttp.responseType = 'json';
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            for(var i = 0; i < this.response.length; i++){
                                addItem(this.response[i])
                            }
                        }
                    }
        xhttp.open('GET', 'http://foodscout/api/food/'+ filter, true);
        xhttp.send();
    }

    function requestFellini(){
        document.getElementById("fellini-food").style.display = "";
        document.getElementById("fellini-input").style.display = "";
        document.getElementById("Searchsettings").style.display = "";

        var xhttp = new XMLHttpRequest();
                    xhttp.responseType = 'json';
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            for(var i = 0; i < this.response.length; i++){
                                addItem(this.response[i])
                            }
                        }
                    }
        xhttp.open('GET', 'http://foodscout/api/fellini/all', true);
        xhttp.send();
    }

    function requestRoma(){
        document.getElementById("roma-food").style.display = "";
        document.getElementById("roma-input").style.display = "";
        document.getElementById("Searchsettings").style.display = "";

        var xhttp = new XMLHttpRequest();
                    xhttp.responseType = 'json';
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            for(var i = 0; i < this.response.length; i++){
                                addItem(this.response[i])
                            }
                        }
                    }
        xhttp.open('GET', 'http://foodscout/api/roma/all', true);
        xhttp.send();
    }

    function requestMontraw(){
        document.getElementById("fellini-food").style.display = "";
        document.getElementById("fellini-input").style.display = "";
        document.getElementById("Searchsettings").style.display = "";

        var xhttp = new XMLHttpRequest();
                    xhttp.responseType = 'json';
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            for(var i = 0; i < this.response.length; i++){
                                addItem(this.response[i])
                            }
                        }
                    }
        xhttp.open('GET', 'http://foodscout/api/montraw/all', true);
        xhttp.send();
    }

    function addItem(item){

        var tr = document.createElement("tr");
        var food = document.createElement("td")
        var ingredients = document.createElement("td")
        var price = document.createElement("td")
        var restaurant = document.createElement("td")

        if (dynamicContent != null) { 

            if(dynamicContent == 'fellini') { var table = document.getElementById("fellini-food"); }
            else if (dynamicContent == 'roma') { var table = document.getElementById("roma-food"); }
            else { var table = document.getElementById("montraw-food"); }

            food.setAttribute("nowrap","nowrap");
            food.innerHTML = item["name"];
            ingredients.innerHTML = item["ingredients"];
            price.setAttribute("nowrap","nowrap");
            price.innerHTML = item["price"] + ' €';

            tr.appendChild(food);
            tr.appendChild(ingredients);
            tr.appendChild(price);
            table.appendChild(tr);
        }
        else{
            var table = document.getElementById("food");
            food.setAttribute("nowrap","nowrap");
            food.innerHTML = item["food"];
            ingredients.innerHTML = item["ingredients"];
            price.setAttribute("nowrap","nowrap");
            price.innerHTML = item["price"] + ' €';
            restaurant.setAttribute("nowrap","nowrap");
            restaurant.innerHTML = item["restaurant"]

            if(restaurant.innerHTML.toUpperCase().indexOf('ROMA') > -1){
                restaurant.innerHTML = restaurant.innerHTML.substr(0, 15);
            }

            tr.appendChild(food);
            tr.appendChild(ingredients);
            tr.appendChild(price);
            tr.appendChild(restaurant);
            table.appendChild(tr);
        }
    }