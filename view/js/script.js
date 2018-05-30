function rank() {
    $('#rank-button').addClass('scale-out');
    setTimeout(function(){
        let mode = $('#mode').prop('checked') === true ? 1 : 0;
        $('#rank-button-wrapper').css('display', 'none');
        showLoader();
        $.post('controller/rank.php?mode=' + mode, function (data) {
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
    let nbItemsAtBegin = 15;
    let nbItems = $("#page-rank-result").children().length;

    let loopIndex = 1;
    $.each(pageRank, function (pageName, data) {
        if (loopIndex > nbItems) {
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
        }

        if (loopIndex === nbItemsAtBegin && nbItems < nbItemsAtBegin) {
            setTimeout(function () {
                displayPageRank(pageRank)
            }, 1000);
            return false;
        }

        loopIndex ++;
    });
}

function displayHits(hits) {
    let nbItemsAtBegin = 15;
    let nbItems = $("#hits-result").children().length;

    let loopIndex = 1;
    $.each(hits, function (pageName, data) {
        if (loopIndex > nbItems) {
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
        }

        if (loopIndex === nbItemsAtBegin && nbItems < nbItemsAtBegin) {
            setTimeout(function () {
                displayHits(hits);
            }, 1000);
            return false;
        }

        loopIndex ++;
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