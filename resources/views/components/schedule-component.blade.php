<div class="container-lg clearfix schedule-tabs">
    <div class="schedule-nav mb-sm-4">
        <h4 class="px-18 text-sb pb-2 d-sm-none d-block">{{ __('Classes') }}</h4>

        <ul class="nav top-navs justify-content-sm-start justify-content-center mb-3" id="myTab" role="tablist">
            <li class="nav-item bg-sec active flex-sm-grow-0 border text-center" role="presentation">
                <a class="nav-link active py-2 text-center" id="upcoming-tab" data-bs-toggle="tab"
                    data-bs-target="#upcoming" role="tab" aria-controls="upcoming" aria-selected="true">Upcoming
                    <span class="d-sm-inline d-none">Classes</span></a>
            </li>
            <li class="nav-item bg-sec flex-sm-grow-0 border text-center" role="presentation">
                <a class="nav-link py-2 text-center" id="previous-tab" data-bs-toggle="tab" data-bs-target="#previous"
                    role="tab" aria-controls="previous" aria-selected="true"><span>Previous </span> <span
                        class="d-sm-inline d-none">Classes</span></a>
            </li>
            </li>
            <li class="nav-item bg-sec flex-sm-grow-0 border text-center" role="presentation">
                <a class="nav-link py-2 text-center" id="live-tab" data-bs-toggle="tab" data-bs-target="#live"
                    role="tab" aria-controls="live" aria-selected="true"><span>Today's
                    </span><span class="d-sm-inline d-none">Classes</span> </a>
            </li>
        </ul>
    </div>
    @if ($model->reschedule__requests_count >= 3)
        <div class="alert alert-info p-3 px-14" role="alert">
            You have consumed your all makeup requests.
        </div>
    @endif
    <div class="tab-content" id="tab-content">
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            <table class="vertical-table table-borderless Action" id="upcomingClasses-table">
                <thead class="table-header">
                    <tr>
                        <th scope="col" class="ps-2 ">Day & Time</th>
                        <th scope="col">Course</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Reg NO</th>

                        <th scope="col" class="">Status</th>
                        <th scope="col" class="pe-2 ">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @isset($nextClasses)
                        @foreach ($nextClasses as $class)
                            <tr>
                                <td data-label="Day & Time">
                                    <div class="d-flex d-sm-block justify-content-end">
                                        <div class="text-sb me-2">{{ $class->class_time->format('D d M') }}</div>
                                        <div>{{ $class->class_time->format('h:i A') }}</div>
                                    </div>
                                </td>
                                <td data-label="Course">{{ $class->Student->course->title }} </td>
                                <td data-label="Student">{{ $class->Student->name }} </td>
                                <td data-label="Reg #">{{ $class->Student->reg_no }} </td>

                                <td data-label="Status"><span
                                        class="badge status-pill status-{{ \App\Classes\Enums\StatusEnum::$Classes_status_color[$class->status] ?? 'primary' }}">{{ beautify_slug($class->status) }}</span>
                                </td>
                                <td data-label="Action">
                                    <span class="makeup-request-tooltip"
                                        @if ($model->reschedule__requests_count >= 3) data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="No Requests left" @endif>
                                        <button
                                            class="btn btn-outline-primary px-0 py-2 action-btn @if ($model->reschedule__requests_count >= 3) disabled @endif"
                                            data-weeklyclassid="{{ $class->id }}"
                                            data-studentid="{{ $class->student_id }}"
                                            data-teacherid={{ $class->teacher_id }} data-bs-toggle="modal"
                                            data-bs-target="#change_schedule_modal" data-action="reschedule"
                                            data-id="{{ $class->id }}"><span class="request-makeup-text">Request for
                                                MakeUp</span><span class="makeup-text">Makeup</span></button>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endisset

                </tbody>
            </table>
            {{-- @if (!isset($nextClasses))
            <div class="px-3 py-2 text-center">
                <div class="py-1 text-bold">{{ __('No Upcoming Classes!') }}</div>
            </div>
            @endif --}}
            <!-- this condition is already catered by data table -->
        </div>
        <div class="tab-pane fade" id="previous" role="tabpanel" aria-labelledby="previous-tab">
            <table class="vertical-table table-borderless Action" id="previousClasses-table">
                <thead class="table-header">
                    <tr>
                        <th scope="col" class="ps-2 ">Day & Time</th>
                        <th scope="col">Course</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Reg NO</th>

                        <th scope="col" class="">Status</th>
                        <th scope="col" class="pe-2 ">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($previousClasses)

                        @foreach ($previousClasses as $key => $class)
                            <tr>
                                <td data-label="Day & Time">
                                    <div class="d-flex d-sm-block justify-content-end">

                                        <div class="text-sb me-2">{{ $class->class_time->format('D d M') }}</div>
                                        <div>{{ $class->class_time->format('h:i A') }}</div>
                                    </div>
                                </td>
                                <td data-label="Course">{{ $class->Student->course->title ?? ' ' }}</td>
                                <td data-label="Student">{{ $class->Student->name }} </td>
                                <td data-label="Reg #">{{ $class->Student->reg_no }} </td>

                                <td data-label="Status"><span
                                        class="badge status-pill status-{{ \App\Classes\Enums\StatusEnum::$Classes_status_color[$class->status] ?? 'primary' }}">{{ beautify_slug($class->status) }}</span>
                                </td>
                                <td data-label="Action">
                                    @if ($class->status == \App\Classes\Enums\StatusEnum::UNATTENDED)
                                        <span class="makeup-request-tooltip"
                                            @if ($model->reschedule__requests_count >= 3) data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="No Requests left" @endif>
                                            <button
                                                class="btn btn-outline-primary px-0 py-2 action-btn @if ($model->reschedule__requests_count >= 3) disabled @endif"
                                                data-bs-target="#change_schedule_modal"
                                                data-weeklyclassid="{{ $class->id }}"
                                                data-studentid="{{ $class->student_id }}"
                                                data-teacherid={{ $class->teacher_id }} data-action="reschedule"
                                                data-bs-toggle="modal"><span class="request-makeup-text">Request for
                                                    MakeUp</span><span class="makeup-text">Makeup</span></button>
                                        </span>
                                    @else
                                        <span>--</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endisset

                </tbody>
            </table>
            {{-- @if (!isset($previousClasses))
            <div class="px-3 py-2 text-center">
                <div class="py-1 text-bold">{{ __('No Previous Classes!') }}</div>
            </div>
            @endif --}}
        </div>
        <div class="tab-pane fade" id="live" role="tabpanel" aria-labelledby="live-tab">
            <table class="vertical-table table-borderless Action" id="todayClasses-table">
                <thead class="table-header">
                    <tr>
                        <th scope="col" class="ps-2 ">Day & Time</th>
                        <th scope="col">Course</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Reg NO</th>

                        <th scope="col" class="">Status</th>
                        <th scope="col" class="pe-2 ">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @isset($todayClasses)
                        @if (!empty($todayClasses))
                            @foreach ($todayClasses as $class)
                                <tr>
                                    <td data-label="Day & Time">
                                        <div>
                                            <div class="d-flex d-sm-block justify-content-end">
                                                <div class="text-sb me-2">{{ $class->class_time->format('D d M') }}
                                                </div>
                                                <div>{{ $class->class_time->format('h:i A') }}</div>

                                            </div>
                                            @if (!$class->live_status)
                                                <div>
                                                    Starting in: <span class="class-countdown"
                                                        data-time="{{ $class->class_time->format('M d, Y h:i A') }}"></span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td data-label="Course">{{ $class->Student->course->title }}</td>
                                    <td data-label="Student">{{ $class->Student->name }} </td>
                                    <td data-label="Reg #">{{ $class->Student->reg_no }} </td>

                                    <td data-label="Status"><span
                                            class="badge status-pill status-{{ \App\Classes\Enums\StatusEnum::$Classes_status_color[$class->status] ?? 'success' }}">{{ beautify_slug($class->status) }}</span>
                                    </td>
                                    <td data-label="Action">
                                        @if ($class->live_status)
                                            <a href="{{ route('joinClass', [app()->getLocale(), 'user' => $model, 'WeeklyClass' => $class->session_key]) }}"
                                                target="_blank" class="btn btn-outline-primary px-0 py-2 action-btn ">Join
                                                Class</a>
                                        @else
                                            <span class="makeup-request-tooltip"
                                                @if ($model->reschedule__requests_count >= 3) data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="No Requests left" @endif>
                                                <button
                                                    class="btn btn-outline-primary px-0 py-2 action-btn @if ($model->reschedule__requests_count >= 3) disabled @endif"
                                                    data-bs-target="#change_schedule_modal"
                                                    data-weeklyclassid="{{ $class->id }}"
                                                    data-studentid="{{ $class->student_id }}"
                                                    data-teacherid={{ $class->teacher_id }} data-action="reschedule"
                                                    data-bs-toggle="modal"><span class="request-makeup-text">Request for
                                                        MakeUp</span><span class="makeup-text">Makeup</span></button>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endisset

                </tbody>
            </table>
            {{-- @if (empty($todayClasses))
            <div class="px-3 py-2 text-center">
                <div class="py-1 text-bold">{{ __('No Classes Today!') }}</div>
            </div>
            @endif --}}
        </div>
    </div>

    {{-- <button class="btn btn-outline-primary float-end px-5 py-2 mt-sm-5 my-3"
        onclick="location.href = '/en/customer/profile';"><i class="fa fa-arrow-left me-1"></i> Back</button> --}}
</div>
<!-- Reschedule Class Modal -->
<div class="modal fade change_schedule_modal" id="change_schedule_modal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="border-0 modal-content">
            <div class="modal-header pb-0 pt-sm-4 px-4">
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3 pb-sm-5 pb-3 px-4" id="change_schedule_body">
            </div>
        </div>
    </div>
</div>

{{-- Class Schedule CSS --}}
<style>
    .schedule-nav .bg-sec.active {
        background-color: var(--secondary-color) !important;
        font-weight: 500;
    }

    .action-btn {
        width: 184px;
        height: 44px;
        padding: 0;
        line-height: 1.8;
    }

    @media screen and (max-width: 400px) {
        .schedule-nav .bg-sec {
            margin: 0 !important;
        }
    }

    @media screen and (max-width: 350px) {
        .vertical-table .action-btn {
            max-width: 180px !important;
        }

        .vertical-table .badge {
            max-width: 180px;
        }
    }


    @media screen and (max-width:575px) {
        .schedule-nav a {
            font-size: var(--px-14) !important;
        }

        .teacher_dashboard li.nav-item {
            width: 33%;
        }

        .schedule-tabs .vertical-table tr:last-child>td:last-child {
            border-bottom: 2px dashed #d3d3d336;
        }

        .vertical-table .action-btn {
            width: 80%;
            max-width: 200px;
        }

        .vertical-table td {
            padding: 10px 0 10px 0 !important;
        }
    }

    @media screen and (min-width:576px) and (max-width:991px) {
        .action-btn {
            width: 100%;
        }

        .change_schedule_modal .modal-dialog {
            max-width: 90%;
        }
    }

    @media screen and (min-width:576px) and (max-width: 767px) {
        .action-btn {
            font-size: 10px;
        }
    }

    @media screen and (min-width:768px) and (max-width: 991px) {
        .action-btn {
            font-size: 12px;
        }
    }

    @media screen and (min-width:700px) {
        .teacher_dashboard li.nav-item {
            width: 217px;
        }
    }

    @media screen and (min-width:790px) {
        .makeup-text {
            display: none;
        }

        .request-makeup-text {
            display: inline;
        }
    }

    @media screen and (max-width:789px) {
        .makeup-text {
            display: inline;
        }

        .request-makeup-text {
            display: none;
        }
    }

    /* @media screen and (max-width:991px) {
        .teacher_dashboard .change_schedule_modal .modal-dialog {
            width: 95%;
            max-width: 650px;
        }
    } */

    /* @media screen and (min-width:576px) {
        .teacher_dashboard .change_schedule_modal .modal-content {
            height: 587px;
        }

    }

    @media screen and (max-width:575px) {
        .teacher_dashboard .change_schedule_modal .modal-content {
            height: 610px;
        }

    } */
</style>

<script>
    function addNoSlotColumn() {
        let max = 0;
        $('.timetable-wrapper .slots-col').each(function(item) {
            let length = $(this).children('div').length;
            if (length > max) {
                max = length;
            }
        });
        if (max > 1 && max < 5) {
            $('.timetable-slots .empty').append('<span>No Slots</span>')
        } else if (max > 4) {
            $('.timetable-slots .empty').append('<span>No Slots</span><span>No Slots</span>')
        }
    }
    $('#change_schedule_modal').on('shown.bs.modal', function() {
        addNoSlotColumn()
    })
    var current_time =
        '{{ \Carbon\Carbon::now($timezone) }}'; //it will give us the current time of teacher's timezone

    var user_time = new Date(current_time).getTime();
    var StudentChoosenForClassChange;
    var WeeklyClassChoosenForClassChange;
    $('.schedule-nav .nav-link').click(function() {
        $('.schedule-nav .bg-sec').removeClass('active');
        $(this).parent().addClass('active');
    })
    let totalClasses = $('.class-countdown').length;
    // Set the date we're counting down to
    $('.class-countdown').each(function() {
        let _this = this;
        var countDownDate = new Date($(_this).data('time')).getTime();
        // Update the count down every 1 second
        setInterval(function() {
            // Get today's date and time
            // var now = new Date().getTime();
            user_time = user_time +
                1000; // we add 1 seacond to  teacher time as class time is greater than teacher time so to to decrease time we are doing it
            // Find the distance between now and the count down date
            var distance = countDownDate - user_time;
            // distance =(( Math.abs(distance))/2 ) - 15;
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="trial"
            $(_this).html(hours + "h " +
                minutes + "m " + seconds + "s ")

            //  If the count down is over, write some text
            if (distance < 0) {
                location.reload();
            }
        }, totalClasses * 1000);
    })
    initTooltip();
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#upcomingClasses-table')) {
            $('#upcomingClasses-table').on('order.dt', function() {
                    editArrows()
                })
                .on('search.dt', function() {
                    editArrows()
                }).DataTable({
                    "language": {
                        "emptyTable": "No Classes Found"
                    },
                    "aaSorting": [],

                    "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 5]
                    }, ],
                });
            styleSearchField();
        }
        $(document).on('click', '#previous-tab', function() {
            // console.log('running 1');
            if (!$.fn.DataTable.isDataTable('#previousClasses-table')) {
                $('#previousClasses-table').on('order.dt', function() {
                        editArrows()
                    })
                    .on('search.dt', function() {
                        editArrows()
                    }).DataTable({
                        "language": {
                            "emptyTable": "No Classes Found"
                        },
                        "aaSorting": [],

                        "columnDefs": [{
                            "orderable": false,
                            "targets": [0, 5]
                        }, ],
                    });
                styleSearchField();
            }
            initTooltip();
        })
        $(document).on('click', '#live-tab', function() {
            console.log('running 2');
            if (!$.fn.DataTable.isDataTable('#todayClasses-table')) {
                $('#todayClasses-table').on('order.dt', function() {
                        editArrows()
                    })
                    .on('search.dt', function() {
                        editArrows()
                    }).DataTable({
                        "language": {
                            "emptyTable": "No Classes Found"
                        },
                        "aaSorting": [],

                        "columnDefs": [{
                            "orderable": false,
                            "targets": [0, 5]
                        }, ],
                    });
                styleSearchField();
            }
            initTooltip();
        })

        editArrows();
        $(document).on('click', '.paginate_button', function() {
            editArrows()
        });
        $('.dataTables_length select').on('change', function() {
            editArrows()
        })

        $(document).on('click', 'button[data-action="reschedule"]', function() {

            StudentChoosenForClassChange = $(this).data(
                'studentid'); // which student's class is going to be rescheduled
            WeeklyClassChoosenForClassChange = $(this).data(
                'weeklyclassid'); // which student's class is going to be rescheduled

            // get the latest schedule of the teacher and paste it in the modal 
            var formdata = new FormData();
            formdata.append('teacherid', $(this).data('teacherid'));
            Ajax_Call_Dynamic('{{ route('teacher.RescheduleRequest', [app()->getLocale()]) }}',
                "POST", formdata, "TeacherRescheduleSuccess",
                'FailedToasterResponse', '#change_schedule_body');
        });



    })

    function TeacherRescheduleSuccess(response) {
        // console.log("TeacherRescheduleSuccess",response);
        // $('#change_schedule_modal').modal('show');
        $('#change_schedule_body').html(response.response);
    }

    function initTooltip() {
        $('.makeup-request-tooltip').tooltip();
    }
</script>
