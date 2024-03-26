(function ($) {

    "use strict";

    // Setup the calendar with the current date
    $(document).ready(function () {
        var date = new Date();
        var today = date.getDate();
        // Set click handlers for DOM elements
        $(".right-button").click({ date: date }, next_year);
        $(".left-button").click({ date: date }, prev_year);
        $(".month").click({ date: date }, month_click);
        // $("#add-button").click({ date: date }, new_event);
        // Set current month as active
        $(".months-row").children().eq(date.getMonth()).addClass("active-month");
        init_calendar(date);
    
        $.ajax({
            url: '../pages/getEventCalendar.php',
            method: 'GET',
            success: function (response) {
                // แปลงข้อมูล JSON เป็นอาร์เรย์ JavaScript
                var eventsArray = JSON.parse(response);
                // เรียกใช้งาน init_calendar() ด้วยอาร์เรย์ของอ็อบเจ็กต์เหล่านี้
                init_calendar(eventsArray);
                // ตรวจสอบข้อมูลที่ได้รับ
                checkResponse(eventsArray);
            },
            error: function (xhr, status, error) {
                console.log("Error:", error);
            }
        });
    });
    
    // สร้างฟังก์ชันเพื่อตรวจสอบข้อมูลที่ได้รับ
    function checkResponse(response) {
        // พิมพ์ข้อมูลที่ได้รับในรูปแบบออบเจกต์
        console.log(response);
    
        // ตรวจสอบว่า response เป็นอาร์เรย์ของออบเจกต์หรือไม่
        if (Array.isArray(response)) {
            // ทำสิ่งที่ต้องการเมื่อข้อมูลถูกต้อง
        } else {
            // ทำสิ่งที่ต้องการเมื่อข้อมูลไม่ถูกต้อง
        }
    }
    

    // Initialize the calendar by appending the HTML dates
    function init_calendar(events) {
        $(".tbody").empty();
        $(".events-container").empty();
        var calendar_days = $(".tbody");
        var date = new Date();
        var month = date.getMonth();
        var year = date.getFullYear();
        var day_count = days_in_month(month, year);
        var row = $("<tr class='table-row'></tr>");
        var today = date.getDate();
        date.setDate(1);
        var first_day = date.getDay();

        for (var i = 0; i < 35 + first_day; i++) {
            var day = i - first_day + 1;
            if (i % 7 === 0) {
                calendar_days.append(row);
                row = $("<tr class='table-row'></tr>");
            }

            if (i < first_day || day > day_count) {
                var curr_date = $("<td class='table-date nil'>" + "</td>");
                row.append(curr_date);
            } else {
                var curr_date = $("<td class='table-date'>" + day + "</td>");
                var eventsForDay = check_events(day, month + 1, year, events);
                if (today === day && $(".active-date").length === 0) {
                    curr_date.addClass("active-date");
                    show_events(eventsForDay, months[month], day);
                }

                if (eventsForDay.length !== 0) {
                    curr_date.addClass("event-date");
                }
                curr_date.click({ events: eventsForDay, month: months[month], day: day }, date_click);
                row.append(curr_date);
            }
        }

        calendar_days.append(row);
        $(".year").text(year);
    }

    // Get the number of days in a given month/year
    function days_in_month(month, year) {
        var monthStart = new Date(year, month, 1);
        var monthEnd = new Date(year, month + 1, 1);
        return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);
    }

    // Event handler for when a date is clicked
    function date_click(event) {
        $(".events-container").show(250);
        $("#dialog").hide(250);
        $(".active-date").removeClass("active-date");
        $(this).addClass("active-date");
        show_events(event.data.events, event.data.month, event.data.day);
    };

    // Event handler for when a month is clicked
    function month_click(event) {
        $(".events-container").show(250);
        $("#dialog").hide(250);
        var date = event.data.date;
        $(".active-month").removeClass("active-month");
        $(this).addClass("active-month");
        var new_month = $(".month").index(this);
        date.setMonth(new_month);
        init_calendar(date);
    }

    // Event handler for when the year right-button is clicked
    function next_year(event) {
        $("#dialog").hide(250);
        var date = event.data.date;
        var new_year = date.getFullYear() + 1;
        $(".year").html(new_year);
        date.setFullYear(new_year);
        init_calendar(date);
    }
    // Event handler for when the year left-button is clicked
    function prev_year(event) {
        $("#dialog").hide(250);
        var date = event.data.date;
        var new_year = date.getFullYear() - 1;
        $(".year").html(new_year);
        date.setFullYear(new_year);
        init_calendar(date);
    }

    // Display all events of the selected date in card views
    function show_events(events, month, day) {
        $(".events-container").empty();
        $(".events-container").show(250);

        if (events && events.length > 0) {
            for (var i = 0; i < events.length; i++) {
                var event_card = $("<div class='event-card'></div>");
                var event_dates = $("<div class='event-dates'>From: " + events[i]["start_date"] + " To: " + events[i]["end_date"] + "</div>");
                $(event_card).append(event_dates);
                $(".events-container").append(event_card);
            }
        } else {
            var event_card = $("<div class='event-card'></div>");
            var event_name = $("<div class='event-name'>There are no events planned for " + month + " " + day + ".</div>");
            $(event_card).css({ "border-left": "10px solid #FF1744" });
            $(event_card).append(event_name);
            $(".events-container").append(event_card);
        }
    }

    // Checks if a specific date has any events
    function check_events(day, month, year, events) {
        if (Array.isArray(events)) {
            var eventsForDay = events.filter(function (event) {
                // console.log("Start Date:", event["start_date"]);
                return event["start_date"] <= year + "-" + pad(month, 2) + "-" + pad(day, 2) && event["end_date"] >= year + "-" + pad(month, 2) + "-" + pad(day, 2);
            });
            return eventsForDay;
        } else {
            // console.error("Events is not an array.");
            return [];
        }
    }

    // Given data for events in JSON format
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];

    function pad(num, size) {
        var s = num + "";
        while (s.length < size) s = "0" + s;
        return s;
    }


})(jQuery);