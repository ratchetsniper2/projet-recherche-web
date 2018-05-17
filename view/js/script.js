function rank() {
    $.post("demo_test.asp", function(data, status){
        alert("Data: " + data + "\nStatus: " + status);
    });
    $.post("demo_test.asp", function(data, status){
        alert("Data: " + data + "\nStatus: " + status);
    });
    $('#results').removeClass('hiddendiv');
}