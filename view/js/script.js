function rank() {
    $('#rank-button').addClass('scale-out');
    setTimeout(function(){
        $('#rank-button-wrapper').css('display', 'none');
        showLoader();
        $.post('controller/rank.php', function (data) {
            data = JSON.parse(data);

            $("#page-rank-result").empty();
            $("#hits-result").empty();

            // pageRank
            displayPageRank(data.pageRank);

            // hits
            displayHits(data.hits);

            hideLoader();
            $('#results').show(1000);
        });
    }, 400);
}

function displayPageRank(pageRank) {
    $.each(pageRank, function (pageName, data) {
        $("#page-rank-result").append(
            "<tr>" +
            "<td>" +
            pageName +
            "</td>" +
            "<td>" +
            formatFloat(data.score) +
            "</td>" +
            "</tr>"
        );
    });
}

function displayHits(hits) {
    $.each(hits, function (pageName, data) {
        $("#hits-result").append(
            "<tr>" +
            "<td>" +
            pageName +
            "</td>" +
            "<td>" +
            formatFloat(data.authority) +
            "</td>" +
            "<td>" +
            formatFloat(data.hub) +
            "</td>" +
            "</tr>"
        );
    });
}

function formatFloat(x) {
    return Number.parseFloat(x).toFixed(2);
}

function showLoader() {
    $('#loader').removeClass('hiddendiv');
}

function hideLoader() {
    $('#loader').addClass('hiddendiv');
}