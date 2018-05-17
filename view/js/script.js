function rank() {
    $('#results').addClass('hiddendiv');
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
    for (let i = 0; i < data.length; i++) {
        let rank = $('<td></td>');
        rank.html(i);
        let page = $('<td></td>');
        page.html(data[i].page);
        let score = $('<td></td>');
        score.html(data[i].score);
        let row = $('<tr></tr>');
        row.appendChild(rank).appendChild(page).appendChild(row);
        $('#' + id).appendChild(row);
    }
}

function showLoader() {
    $('#loader').removeClass('hiddendiv');
}

function hideLoader() {
    $('#loader').addClass('hiddendiv');
}