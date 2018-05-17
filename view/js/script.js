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
            "<td width='75%'>" +
            pageName +
            "</td>" +
            "<td width='500'>" +
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
            "<td width='50%'>" +
            pageName +
            "</td>" +
            "<td width='25%'>" +
            formatFloat(data.authority) +
            "</td>" +
            "<td width='500'>" +
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