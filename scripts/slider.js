function update_value(){
    var x = document.getElementById("text_size").value;
    document.getElementById("preferred_size").value = x;
}
function default_text_size(){

    document.getElementById("preferred_size").value = 15;
    document.getElementById("text_size").value = 15;
    alert("working");
}
document.getElementsByName("submit_text")[0].addEventListener("mouseover",update_value);