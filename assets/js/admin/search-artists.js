document.addEventListener("DOMContentLoaded", function () {
	const form = document.getElementById("tunebridge-search-artists-form");
	const resultsContainer = document.getElementById("tunebridge-search-artists-results");

	if (!form || !resultsContainer) return;

	form.addEventListener("submit", function (e) {
		e.preventDefault();

		const name = form.artist_name.value.trim();
		if (!name) return;

		resultsContainer.innerHTML = "<p>Searching...</p>";

		fetch(tunebridge.ajax_url, {
			method: "POST",
			headers: { "Content-Type": "application/x-www-form-urlencoded" },
			body: new URLSearchParams({
				action: "tunebridge_search_artists",
				nonce: tunebridge.nonce,
				name,
			}),
		})
			.then((res) => res.json())
			.then((data) => {
				if (data.success) {
					if (data.data.length === 0) {
						resultsContainer.innerHTML = "<p>No artists found.</p>";
					} else {
						resultsContainer.innerHTML = data.data
							.map((artist) => {
								return `
									<div class="artist-card card mb-2 p-3">
										<strong>${artist.name}</strong><br/>
										<span>${artist.genre || 'Unknown Genre'} — ${artist.country || 'Unknown Country'}</span><br/>
										<a href="${artist.spotify}" target="_blank">Open in Spotify</a>
									</div>
								`;
							})
							.join("");
					}
				} else {
					resultsContainer.innerHTML = `<p class="text-danger">${data.data.message || "Search failed"}</p>`;
				}
			})
			.catch(() => {
				resultsContainer.innerHTML = `<p class="text-danger">An error occurred.</p>`;
			});
	});
});
