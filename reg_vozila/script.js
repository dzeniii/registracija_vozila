function calculateRegistration() {
    var power = parseFloat(document.getElementById('power').value);
    var vehicleType = document.getElementById('vehicle-type').value;
    var year = parseInt(document.getElementById('year').value);
    var color = document.getElementById('color').value;

    

    var result = "Registracija za " + color + " " + vehicleType + " vozilo iznosi: ..."; 

    document.getElementById('result').innerText = result;
}

document.getElementById("registrationButton").addEventListener("click", function () {
    window.open("index.html", "Login", "width=400,height=400");
});

