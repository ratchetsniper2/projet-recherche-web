function rank() {
    showLoader();
    $.post('controller/rank.php', function(data){
        const pageRankData = data['pageRank'];
        const hitsData = data['hits'];
        displayResult(pageRankData, 'page-rank-result');
        displayResult(hitsData, 'hits-result');
        hideLoader();
        $('#results').removeClass('hiddendiv');
    });
}

function displayResult(data, id) {
    $('#' + id).html(data);
}

function showLoader() {
    $('#loader').removeClass('hiddendiv');
}

function hideLoader() {
    $('#loader').addClass('hiddendiv');
}