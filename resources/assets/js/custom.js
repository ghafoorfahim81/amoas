$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){

    var URL_CONCAT = $('meta[name="index"]').attr('content');
    //get packages on click of div.category_box

    $(".owl-carousel").owlCarousel({
        margin:20,
        dots:false,
        nav:true,
        navText: [
            '<img src="'+ URL_CONCAT + '/images/left.png">',
            '<img src="'+ URL_CONCAT + '/images/right.png">'
        ],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 2
            },
            769: {
                items: 4
            }
        }
    });

    //append form with selected package_id

    //handle form submission of step 1
    $('#booking_step_1').submit(function(e){

        var check = true;
        var package_id = $('input[name=package_id]').val();

        if (package_id === undefined) {
            
            $('#package_error').removeClass('d-none');
            $("html, body").animate({
                scrollTop: $(document).height() - $(window).height()
            });
            return false;
        }
        this.submit();
    });

    //remove address field error
    $('#autocomplete').keyup(function () {
        $(this).removeClass('is-invalid').addClass('is-valid');
        $('#address_error_holder').addClass('d-none');
    });

    //remove date error
    $('#event_date').click(function () {
        $(this).removeClass('is-invalid').addClass('is-valid');
        $('#date_error_holder').addClass('d-none');
    });

    //populate timing slots

    $('input[id="event_date"]').change(function () {
        //populate timing slots
        var selected_date;
        selected_date = $(this).val();

        var URL_CONCAT = $('meta[name="index"]').attr('content');

        //prepare to send ajax request
        $.ajax({
            type: 'POST',
            url: URL_CONCAT + '/get_timing_slots',
            data: {event_date:selected_date},
            beforeSend: function() {
                $('#slots_loader').removeClass('d-none');
            },
            success: function(response) {
                $('#slots_holder').html(response);

            },
            complete: function () {
                $('#slots_loader').addClass('d-none');
            }
        });
    });

    //append selected slot to booking_step_2 form

    $('#slots_holder').on('click', 'a.btn-slot', function () {
        var slot_time = $(this).attr('data-slot-time');
        var type = $(this).attr('type');
        $('#slots_holder').find('.btn-slot').removeClass('slot-picked');
        $('#booking_slot').remove();
        $('#booking_step_2').append('<input type="hidden" name="booking_slot" id="booking_slot" value="' + slot_time + '">');
        if (type !== undefined && type ==='urgent'){
            $('#emergency_holder').html('<input type="hidden" name="booking_type" value="emergency">');
        } else{
            $('#emergency_holder').html('<span></span>');
        }
        $(this).addClass('slot-picked');
    });

});