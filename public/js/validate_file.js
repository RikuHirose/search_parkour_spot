
(function() {
  'use strict';

	$("#upload").on("change", function() {
	if($("#upload")[0].files.length > 4) {
	  alert("You can select only 4 files");
	  location.href='/content/create';

	} else {
	  $("fileupload").submit();
	}
	});


})();