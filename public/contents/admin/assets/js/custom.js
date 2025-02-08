// soft delete modal 


$(document).ready(function() {
    
     //Soft Delete
     $(document).on("click", "#softDel", function() {
        let deleteID = $(this).data('id');
    //    alert(deleteID);
        $(".modal_body #modal_id").val(deleteID);
    });
    //    Restore Id
    $(document).on("click", "#restore", function () {
           let restoreID = $(this).data('id');
           //alert(restoreID);
           $(".modal_body #modal_id").val( restoreID );
      });
    //   Parmanent
     $(document).on("click", "#delete", function () {
           let deleteID = $(this).data('id');
           $(".modal_body #modal_id").val( deleteID );   
      });
});

!function(t) {
    "use strict";
    function e() {}
    e.prototype.init = function() {
        t("#basic-datepicker").flatpickr(),
        t("#datetime-datepicker").flatpickr({
            enableTime: !0,
            dateFormat: "Y-m-d H:i"
        }),
        t("#humanfd-datepicke").flatpickr({
            altInput: !0,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d"
        }),
        t("#minmax-datepicker").flatpickr({
            minDate: "2020-01",
            maxDate: "2020-03"
        }),
        t("#inline-datepicker").flatpickr({
            inline: !0
        }),
        t("#minmax-timepicker").flatpickr({
            enableTime: !0,
            noCalendar: !0,
            dateFormat: "H:i",
            minDate: "16:00",
            maxDate: "22:30"
        }),
        t("#check-minutes").click(function(e) {
            e.stopPropagation(),
            t("#single-input").clockpicker("show").clockpicker("toggleView", "minutes")
        })
    }
    ,
    t.FormPickers = new e,
    t.FormPickers.Constructor = e
}(window.jQuery),

function() {
    "use strict";
    window.jQuery.FormPickers.init()
}();

