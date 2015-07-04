$(function(){
	$.extend({
	  getUrlVars: function(){
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
		  hash = hashes[i].split('=');
		  vars.push(hash[0]);
		  vars[hash[0]] = hash[1];
		}
		return vars;
	  },
	  getUrlVar: function(name){
		return $.getUrlVars()[name];
	  },
      addUrlVar: function(name,value,dontRedirect){
        var queryString=window.location.search;
        var newParam=name+"="+value;
        queryString+=(queryString?"&":"?")+newParam;
		if(typeof dontRedirect == 'undefined')
			window.location.search=queryString;
		else
			return queryString;
      },
	  changeUrlVar: function(name,value,QS){
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		if(typeof QS != 'undefined')
			hashes = QS.substr(1).split('&');
		//alert(hashes);
        var i;
		for(i = 0; i < hashes.length; i++)
		{
		  hash = hashes[i].split('=');
		  vars.push(hash[0]);
		  vars[hash[0]] = hash[1];
		}
		vars[name]=value;
		//alert(vars[name]);
		var newQS = "?";
        i = 0;
		$.each(vars,function(k,v){
			if(i)
				newQS += "&";
			newQS += v + "=" + vars[v];
			i++;
		});
		window.location.search = newQS;
	  }
	});
});