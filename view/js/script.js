function rank() {
    $('#results').addClass('hiddendiv');
    showLoader();
    $.post('controller/rank.php', function(data) {
        data = JSON.parse(data);

        $("#page-rank-result").empty();
        $("#hits-result").empty();

        let precision = 1000;

        // pageRank
        $.each(data.pageRank, function(pageName, data) {
            $("#page-rank-result").append(
                "<tr>" +
                    "<td>" +
                        pageName +
                    "</td>" +
                    "<td>" +
                        Math.round(data.score*precision)/precision +
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
                        Math.round(data.authority*precision)/precision +
                    "</td>" +
                    "<td>" +
                            Math.round(data.hub*precision)/precision +
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