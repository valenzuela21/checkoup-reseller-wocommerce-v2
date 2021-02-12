document.getElementById("billing_city").readOnly = true;
document.getElementById("billing_address").readOnly = true;
let city_address, city_info;

city_address = localStorage.getItem("city_address");
city_info = localStorage.getItem("city_info");

(city_info != undefined)? city_info : "";
(city_address != undefined)? city_address : "";

document.getElementById("billing_address").value = city_address;
document.getElementById("billing_city").value = city_info ;

document.getElementById("change_address").addEventListener("click", displayDate);

function displayDate() {
    localStorage.setItem("modal_address", "false");
    location.reload();
}