$(function () {
	$('#refreshProgressbar').progressbar({
		maximum: 1,
		warningMarker: 0,
		dangerMarker: 0,
		onComplete: function () {
			if ($('#refreshErrors').html() == '') {
				location.reload();
			}
		},
		step: 1
	});
});

function goHost(id) {
	$.ajax({
		url: '/miners/switchHost',
		data: {id: id},
		type: 'get',
		dataType: 'json',
		success: function (d) {
			window.open(d.url,'hostTab');
		}
	})
}

function refreshData() {
	var $activeHosts = $('[data-id]:not(.danger)');

	$('#refreshErrors').html('');
	$('#refreshProgressbar').progressbar('setPosition', 0).progressbar('setMaximum', $activeHosts.length);

	$('#refreshModal').modal('show');
	$activeHosts.each(function () {
		var $this = $(this);
		$.ajaxQueue({
			url: '/miners/refreshInfo',
			data: {
				id: $this.data('id')
			},
			type: 'POST',
			dataType: 'json',
			success: function (d) {
				if (!d || !d['ok'] || d['error']) {
					$('#refreshErrors').append('<br>' + d['error']).slideDown();
				}

				$('#refreshProgressbar').progressbar('stepIt');
			},
			error: function () {
				$('#refreshErrors').append('<br>Не получен ответ').slideDown();
				$('#refreshProgressbar').progressbar('stepIt');
			}
		});
	});
}
