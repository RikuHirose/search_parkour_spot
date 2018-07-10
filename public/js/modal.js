(function() {
  'use strict';


	$("#modal").iziModal({
		headerColor: "#4da9b7",
		width: "80%",
		overlayColor: "rgba(0, 0, 0, 0.4)",
		transitionIn: "fadeInUp",
		transitionOut: "fadeOutDown",
	});
	$(document).on("click", ".modal-open", function(e) {
		e.preventDefault();
		$("#modal").iziModal("open");
	});



})();