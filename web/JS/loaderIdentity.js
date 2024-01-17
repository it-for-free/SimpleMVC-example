// выводим идентификатор
function showLoaderIdentity(articleId)
{
    var loaderId = "#loader-identity-" + articleId;
    $(loaderId).show("slow");
}

// скрываем идентификатор
function hideLoaderIdentity()
{
    $(".loader-identity").hide();
}
