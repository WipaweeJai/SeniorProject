(function ($) {

    "use strict";

    // กำหนดตัวแปรระดับโปรแกรมเพื่อเก็บข้อมูลกิจกรรม
    var savedEvents = [];

    // Setup the calendar with the current date
    $(document).ready(function () {
        var date = new Date();
        var today = date.getDate();
        // Set click handlers for DOM elements
        $(".right-button").click({ date: date }, next_year);
        $(".left-button").click({ date: date }, prev_year);
        $(".month").click({ date: date }, month_click);
        // Set current month as active
        $(".months-row").children().eq(date.getMonth()).addClass("active-month");

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

        // Initialize the calendar by appending the HTML dates
        $.ajax({
            url: '../pages/getEventCalendar.php',
            method: 'GET',
            success: function (response) {
                try {
                    var eventsArray = JSON.parse(response);
                    init_calendar(eventsArray);
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                    init_calendar([]);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                init_calendar([]);
            }
        });

        // Initialize the calendar by appending the HTML dates
        function init_calendar(events) {
            console.log("init_calendar :", events);
            $(".tbody").empty();
            $(".events-container").empty();
            var calendar_days = $(".tbody");
            var month = date.getMonth();
            var year = date.getFullYear();
            var day_count = days_in_month(month, year);
            var row = $("<tr class='table-row'></tr>");
            var today = date.getDate();
            date.setDate(1);
            var first_day = date.getDay();

            // Create calendar
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

        // ฟังก์ชันดึงข้อมูลกิจกรรมจาก Server
        function fetchEvents(callback) {
            $.ajax({
                url: '../pages/getEventCalendar.php',
                method: 'GET',
                success: function (response) {
                    try {
                        var events = JSON.parse(response);
                        callback(events);
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                        callback([]);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                    callback([]);
                }
            });
        }
        
        // Event handler for when a date is clicked
        function date_click(event) {
            
            $(".events-container").show(250);
            $("#dialog").hide(250);
            $(".active-date").removeClass("active-date");
            $(this).addClass("active-date");
            show_events(event.data.events, event.data.month, event.data.day);
        }

        // Event handler for when a month is clicked
        function month_click(event) {
            $(".events-container").show(250);
            $("#dialog").hide(250);
            $(".active-month").removeClass("active-month");
            $(this).addClass("active-month");
            var date = event.data.date;
            var new_month = $(".month").index(this);
            date.setMonth(new_month);

            // ดึงข้อมูลกิจกรรมใหม่จาก Server
            fetchEvents(function (events) {
                savedEvents = events;
                init_calendar(events);
            });
        }

        // Event handler for when the year right-button is clicked
        function next_year(event) {
            $("#dialog").hide(250);
            var date = event.data.date;
            var new_year = date.getFullYear() + 1;
            $(".year").html(new_year);
            date.setFullYear(new_year);
            
            // ดึงข้อมูลกิจกรรมใหม่จาก Server
            fetchEvents(function (events) {
                savedEvents = events;
                init_calendar(events);
            });
        }
        // Event handler for when the year left-button is clicked
        function prev_year(event) {
            $("#dialog").hide(250);
            var date = event.data.date;
            var new_year = date.getFullYear() - 1;
            $(".year").html(new_year);
            date.setFullYear(new_year);
            
            // ดึงข้อมูลกิจกรรมใหม่จาก Server
            fetchEvents(function (events) {
                savedEvents = events;
                init_calendar(events);
            });
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
                    return event["start_date"] <= year + "-" + pad(month, 2) + "-" + pad(day, 2) && event["end_date"] >= year + "-" + pad(month, 2) + "-" + pad(day, 2);
                });
                return eventsForDay;
            } else {
                console.error("Invalid events data:", events);
                return [];
            }
        }

        // Pad number with leading zeros
        function pad(num, size) {
            var s = num + "";
            while (s.length < size) s = "0" + s;
            return s;
        }

    });
})(jQuery);
