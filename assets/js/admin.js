

document.addEventListener('DOMContentLoaded', function () {
	const tabs = document.querySelectorAll('.nav-tab');
	const sections = document.querySelectorAll('.tab-section');
	tabs.forEach(tab => {
		tab.addEventListener('click', function (e) {
			e.preventDefault();
			tabs.forEach(t => t.classList.remove('nav-tab-active'));
			tab.classList.add('nav-tab-active');
			const tabId = tab.dataset.tab;
			sections.forEach(section => section.classList.remove('active'));
			document.getElementById('tab-' + tabId).classList.add('active');
		});
	});
});