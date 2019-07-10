calendarDay();
function calendarDay() {
    $.ajax({
        url: '/calendari/day/',
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        data: {
            day: new Date().toISOString().slice(0, 10)
        },
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.error(error);
            alert("No s'ha pogut esborrar l'event :(");
        }
    });
}
