export default function (data) {

	if (typeof (data) === 'string') return data;

	let query = [];

	for (let key in data) {
		if (data.hasOwnProperty(key)) {
			if (data[key] !== NaN && data[key] !== null && data[key] && data[key] !== '' ) {
				let param = data[key]
					
				query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
			}
		}
	}

	return query.join('&');
};