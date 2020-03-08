
function open_mailto(mail)
{
	mail = mail.replace('[ät-zeichen]', '@');
	window.location.href="mailto:"+mail;
}

function open_tel(tel)
{
	window.location.href="tel:"+tel;
}

jQuery(document).ready(function($) {
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});
});

