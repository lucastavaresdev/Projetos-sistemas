// Unload Page: Firefox Fix
window.onunload = function(){};
window.addEventListener("click", click, false);

function click(e) {

	if (e.target.getAttribute("data-animation")) {

		e.target.classList.toggle(e.target.getAttribute("data-animation"));
	}

}

// Page Load: Complete
document.onreadystatechange = function () {

  if (document.readyState == "complete") {

    init();

  }

}

// Init Page
function init() {

	pageIn();

	console.log("Page Loaded");

}

// PageIn
function pageIn() {

	var searchText = document.getElementById("search-text");
	var startDate = document.getElementById("search-date1");
	var endDate = document.getElementById("search-date2");
	var loading	= document.getElementById("loading");
	var header	= document.getElementById("header");
	var page	= document.getElementById("page");

	if (searchText) {

		searchText.addEventListener("keydown", searchEngine, false);

	}

	if (startDate && endDate) {

		startDate.addEventListener("keydown", searchEngine, false);
		endDate.addEventListener("keydown", searchEngine, false);

	}

	if (loading) {

		loading.classList.add("hidden");

	}

	if (header) {

		header.classList.remove("hidden");

		setTimeout(function() {

			header.classList.add("header-in");

		}, 1);

	}

	if (page) {

		page.classList.remove("hidden");

		setTimeout(function() {

			page.classList.add("page-in");

		}, 1);

	}

}

// PageOut
function pageOut() {

	var loading	= document.getElementById("loading");
	var header	= document.getElementById("header");
	var page	= document.getElementById("page");

	if (page) {

		page.classList.remove("page-in");
		page.classList.add("page-out");

	}

	if (header) {

		header.classList.remove("header-in");
		header.classList.add("header-out");

	}
	
	if (loading) {

		setTimeout(function() {

			loading.classList.remove("hidden");

		}, 300);

	}

}

// Search Engine
function searchEngine(e) {

	if (
		e.key == "ArrowLeft" ||
		e.key == "ArrowRight" ||
		e.key == "CapsLock" ||
		e.key == "Control" ||
		e.key == "Shift"
	) return;

	var searchText = document.getElementById("search-text");
	var searchDate1 = document.getElementById("search-date1");
	var searchDate2 = document.getElementById("search-date2");

	setTimeout(function() {

		var text = searchText.value;
		var startDate = searchDate1.value;
		var endDate = searchDate2.value;

		if (text.length == 0 || text.length > 2 ) {

			searchReturn(text || "", startDate || "", endDate || "");

		}

	}, 1);

}

// Search Return
function searchReturn(text, startDate, endDate) {

	console.log("text: " + text);
	console.log("startDate: " + startDate);
	console.log("EndDate: " + endDate);

}

// Search Bar Toggle
function searchBar() {
	
	setTimeout(function() {

		var searchBar = document.getElementById("search-bar");
			searchBar.classList.toggle("search-bar-in");

	}, 200);

}

// Search Type Toggle
function searchType() {

	var searchText = document.getElementById("search-text");
	var searchTextIcon = document.getElementById("search-text-icon");
	var searchDate1 = document.getElementById("search-date1");
	var searchDate2 = document.getElementById("search-date2");
	var searchDateIcon = document.getElementById("search-date-icon");

	if (searchDate1.classList.contains("hidden")) {

		searchText.classList.add("hidden");
		searchTextIcon.classList.add("hidden");

		searchDate1.classList.remove("hidden");
		searchDate2.classList.remove("hidden");
		searchDateIcon.classList.remove("hidden");

	} else {

		searchDate1.classList.add("hidden");
		searchDate2.classList.add("hidden");
		searchDateIcon.classList.add("hidden");

		searchText.classList.remove("hidden");
		searchTextIcon.classList.remove("hidden");

	}

}

// Logout
function logout() {

	pageOut();

	setTimeout(function() {

		window.location.href = "?logout=1";

	}, 300);

}

// Open Popup Menu
function openPopupMenu(id) {

	var menu = document.getElementById(id);
		menu.classList.remove("hidden");

}

// Close Popup Menu
function closePopupMenu(id) {

	var menu = document.getElementById(id);
		menu.classList.add("hidden");

}

// Link
function link(s,g,p) {

	s = "?s=" + s;
	g = "&g=" + g;
	p = (p ? ("&p=" + p) : '');

	setTimeout(function() {

		pageOut();

		setTimeout(function() {

			window.location.href = (s + g + p);

		}, 300);

	}, 300);

}


// Open Ajax Loading Modal
function openAjaxLoading(msg) {

	var ajaxModal = document.getElementById("ajax-modal");
	var ajaxLoading = document.getElementById("ajax-loading");
	var ajaxLoadingMsg = document.getElementById("ajax-loading-msg");
	var ajaxError = document.getElementById("ajax-error");

	ajaxLoadingMsg.innerText = msg || "Por favor, aguarde um instante";
	ajaxError.classList.add("hidden");
	ajaxLoading.classList.remove("hidden");
	ajaxModal.removeAttribute("onclick");
	ajaxModal.classList.remove("hidden");

}

// Open Ajax Error Modal
function openAjaxError(msg) {

	var ajaxModal = document.getElementById("ajax-modal");
	var ajaxLoading = document.getElementById("ajax-loading");
	var ajaxError = document.getElementById("ajax-error");
	var ajaxErrorMsg = document.getElementById("ajax-error-msg");

	if (msg.responseText && msg.status) {

		msg = "Status: " + msg.status + msg.responseText;

	}

	ajaxErrorMsg.innerHTML = msg || "Falha na solicitação";
	ajaxLoading.classList.add("hidden");
	ajaxError.classList.remove("hidden");
	ajaxModal.setAttribute("onclick", "closeAjaxModal()");
	ajaxModal.classList.remove("hidden");

}

// Close Ajax Modal
function closeAjaxModal(timeout) {

	setTimeout( function() {

		var ajaxModal = document.getElementById("ajax-modal");
			ajaxModal.classList.add("hidden");

	}, timeout || 300);

}

// Options Menu
function optionsMenu(i, title, subtitle) {

	var optionsMenu = document.getElementById("options-menu");
	var optionsTitle = document.getElementById("options-title");
	var optionsSubTitle = document.getElementById("options-subtitle");

	optionsTitle.innerHTML = title;
	optionsSubTitle.innerHTML = subtitle;
	optionsMenu.setAttribute("data-i", i);
	optionsMenu.classList.remove("hidden");

}

// Close Options Menu
function closeOptionsMenu() {

	var optionsMenu = document.getElementById("options-menu");
		optionsMenu.classList.add("hidden");

}

// Tab Swap
function tab(tabid) {

	var tabs = document.getElementsByClassName("tab");

	for (var i=0; i < tabs.length; i++) {

		tabs[i].classList.add("hidden");

	}

	document.getElementById(tabid).classList.remove("hidden");
	
}

// Popup Menu
function popupMenu(id) {

	var menu = document.getElementById(id);
	
	event.stopPropagation();
	
	if (menu.classList.contains('hidden')) {
		
		menu.classList.remove('hidden');

	} else {

		menu.classList.add('hidden');

	}

}