function rank() {
    $('#results').addClass('hiddendiv');
    showLoader();
    $.post('controller/rank.php', function(data) {
        data = JSON.parse(data);

        $("#page-rank-result").empty();
        $("#hits-result").empty();

        // pageRank
        $.each(data.pageRank, function(pageName, data) {
            $("#page-rank-result").append(
                "<tr>" +
                    "<td>" +
                        pageName +
                    "</td>" +
                    "<td>" +
                        data +
                    "</td>" +
                "</tr>"
            );
        });

        // hits
        $.each(data.hits, function(pageName, data) {
            $("#hits-result").append(
                "<tr>" +
                    "<td>" +
                        pageName +
                    "</td>" +
                    "<td>" +
                        data.authority +
                    "</td>" +
                    "<td>" +
                        data.hub +
                    "</td>" +
                "</tr>"
            );
        });

        hideLoader();
        $('#results').removeClass('hiddendiv');
    });
}

function showLoader() {
    $('#loader').removeClass('hiddendiv');
}

function hideLoader() {
    $('#loader').addClass('hiddendiv');
}