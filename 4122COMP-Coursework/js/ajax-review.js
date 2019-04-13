$(document).ready(function(){
	setupEventHandlers();
});

function setupEventHandlers()
{
	//We want to use AJAX instead of Server GET Request, so remove all links.
	$("#sq-nav a").removeAttr("href");
   
	//Three Types of Pagniation Control
	$("#sq-next a").click(function(){
		var tparams =[$("#ajax-page").text(),$("#ajax-sm").text(),$("#ajax-so").text()];
		tparams[0]++;
		handleAjaxPagination(tparams);
    });
    $("#sq-prev a").click(function(){
		var tparams =[$("#ajax-page").text(),$("#ajax-sm").text(),$("#ajax-so").text()];
		tparams[0]--;
		handleAjaxPagination(tparams);
    });
    $("#sq-page a").click(function(){
		var tparams =[$("#ajax-page").text(),$("#ajax-sm").text(),$("#ajax-so").text()];
		tparams[0]=Number(this.is.slice(3));
		handleAjaxPagination(tparams);
    });
    
    $("sort-ageno").click(function(){
        var tparams =[$("#ajax-page").text(),$("#ajax-sm").text(),$("#ajax-so").text()];
        tparams[1]= "agerating";
        handleAjaxPagination(tparams);
        )}
    
    $("sort-name").click(function(){
    var tparams =[$("#ajax-page").text(),$("#ajax-sm").text(),$("#ajax-so").text()];
    tparams[1]= "gamename";
    handleAjaxPagination(tparams);
    )}
}

function handleAjaxPagination(pparams)
{
    $.ajax({
        method: "GET",
        url: "ajax-review.php",
        dataType: 'html',
        data: {"page": pparams[0],"sortmode": pparams[1],"sortorder": pparams[2],"ajax": "true"}
    }).done(function (html){

    	$("#review-table").html(html);
    	setupEventHandlers();
    	
    }).fail(function (jqXHR, textStatus, error) {
        $("#review-table").text(error);
    });
}

