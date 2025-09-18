document.addEventListener('DOMContentLoaded', () => {
	const form = document.getElementById('tunebridge-playlist-search-form');
	const resultsTable = document.getElementById('tunebridge-playlist-search-results');

	if (!form || !resultsTable) return;

	form.addEventListener('submit', (e) => {
		e.preventDefault();

		const query = form.querySelector('input[name="playlist_query"]').value;

		resultsTable.innerHTML = '<tr><td colspan="5">Searching...</td></tr>';

		fetch(tunebridge.ajax_url, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			body: new URLSearchParams({
				action: 'tunebridge_search_playlists',
				security: tunebridge.nonce,
				query: query
			})
		})
		.then(res => res.json())
		.then(data => {
			if (!data.success || data.data.length === 0) {
				resultsTable.innerHTML = '<tr><td colspan="5">No results found.</td></tr>';
				return;
			}

			resultsTable.innerHTML = data.data.map(p => `
				<tr>
					<td>${p.name}</td>
					<td>${p.curator}</td>
					<td>${p.tracks}</td>
					<td>${p.followers}</td>
					<td><a href="${p.url}" target="_blank">Open</a></td>
				</tr>
			`).join('');
		})
		.catch(err => {
			console.error(err);
			resultsTable.innerHTML = '<tr><td colspan="5">Error searching playlists.</td></tr>';
		});
	});
});
